<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class AttendanceController extends Controller
{
    public $parentModel = Attendance::class;
    public $childModel  = Employee::class;
    public function checkin(Request $request)
    {
        try {
            $data = $request->except('_token');
            $data['employee_id'] = Auth::user()->id;
            $data['date']        = Carbon::now()->format('Y-m-d');

            $data['check_in']    = Carbon::parse($data['check_in'])->format('h:i A');
            $data['attendance_status']  = "present";
            $employee        = $this->childModel::where('user_id', $data['employee_id'])->with('shifts')->first();
            $checkAttendance = $this->parentModel::where(['employee_id' => $data['employee_id'], 'date' => $data['date']])->first();
            if (empty($employee)) {
                return response()->json(['empty' => true]);
            }
            if (empty($checkAttendance)) {
                $shiftIn          = Carbon::parse($employee->shifts->start_time);
                $checkInTime      = Carbon::parse($data['check_in']);
                if ($checkInTime->lessThan($shiftIn)) {
                    $data['working_status'] = 'early-in';
                }
                $storeAttendance = $this->parentModel::create($data);
                if ($storeAttendance) {
                    return response()->json(['success' => true, 'attendance_id' => $storeAttendance->id]);
                } else {
                    return response()->json(['error' => true]);
                }
            } else {
                return response()->json(['marked' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function checkout(Request $request)
    {
        try {
            $emp_id         =  Auth::user()->id;
            $date           =  Carbon::now()->format('Y-m-d');
            $ShiftHours     =  9 * 60 * 60 * 1000;
            $data           =  $request->except('_token');
            $attendanceData =  $this->parentModel::where(['employee_id' => $emp_id, 'date' => $date])->first();
            $checkIn        =  $attendanceData->check_in;
            $checkIn        =  Carbon::parse($checkIn);
            $checkout       =  Carbon::parse($data['check_out']);
            $data['timeElapsed']  =  $checkout->diffInMilliseconds($checkIn);

            if ($attendanceData->count() > 0) {
                // checking Total Hours
                $data['working_hours']  = round($data['timeElapsed'] / (1000 * 60 * 60), 1); // to get the total hours
                $data['working_status'] = $ShiftHours == $data['timeElapsed'] && !$ShiftHours < $data['timeElapsed'] ? 'on-time' : 'late'; //  If ShiftHours is the same as Employee's Working hours
                if ($data['working_hours'] < $ShiftHours) {
                    // Check the Time of shift and checkin Both
                    $shiftData        = Employee::where('user_id', $emp_id)->with('shifts')->first();
                    $shiftIn          = Carbon::parse($shiftData->shifts->start_time);
                    $shiftOut         = Carbon::parse($shiftData->shifts->start_out);
                    $timedifference   = $checkIn->diffInMinutes($shiftIn) > 30  ? 'late' : 'early-out';
                    $data['working_status'] = $timedifference;
                }
                if ($data['working_hours'] > 9) {
                    $data['working_status'] = 'overtime'; //  If shift hours is the same as Employee's Working hours
                    $data['extra_hours']    = round($data['working_hours'] - 9, 1);
                    $data['extra_hours']    = $data['extra_hours'] < 1 ? $data['extra_hours'] * 60 . " minutes" : $data['extra_hours'] . " hours";
                }
                $data['working_hours']  = $data['working_hours'] < 1 ? $data['working_hours'] * 60 . ' minutes' : $data['working_hours'] . " hours";
                $data['total_hours']    = $data['working_hours'];
                unset($data['timeElapsed']);
                $updateAttendance        = $attendanceData->update($data);
                if ($updateAttendance) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['error' => true]);
                }
            } else {
                return response()->json(['error' => "Failed to checkout no attendance found for the specified Employee"]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
