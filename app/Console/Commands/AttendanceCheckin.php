<?php

namespace App\Console\Commands;


use App\Models\{LeaveApplication  ,Employee , Attendance as AttendanceModel};
use Carbon\Carbon;
use Illuminate\Console\Command;

class AttendanceCheckin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:attendance_checkin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to mark attendance of users at the start of the day.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $getEmployeesIds = Employee::latest()->with('shifts');
        $checkAttendance = AttendanceModel::whereIn('employee_id', $getEmployeesIds->pluck('id'))->where('date' , Carbon::now()->format('Y-m-d'))->get();
        if($checkAttendance->count() <= 0){
            $employeeOnLeaveIDS = LeaveApplication::whereIn('employee_id', $getEmployeesIds->pluck('id'))
            ->where('status' , 'approved')->whereDate('from_date', Carbon::now()->format('Y-m-d'))->orWhereDate('to_date', Carbon::now()->format('Y-m-d'))
            ->pluck('employee_id')
            ->toArray();

            $employeesData = $getEmployeesIds->get();
            foreach($employeesData as $employee){
                $status = in_array($employee->id , $employeeOnLeaveIDS) ? 'leave' : 'absent';
                if(Carbon::now()->format('l') == 'Sunday'){
                    $status = 'off';
                }
                $checkCheckin = AttendanceModel::where(['employee_id'=> $employee->user_id , 'date' => Carbon::now()->format('Y-m-d')])->first();

                $storeData = [
                    'attendance_status' => $status,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'employee_id' => $employee->user_id,
                    'working_status' => $status,
                ];
                // for Checkin
                if(empty($checkCheckin->check_in)){
                    $markAttendance = AttendanceModel::updateOrcreate(['employee_id' => $employee->user_id ,'date' => Carbon::now()->format('Y-m-d')] ,$storeData);
                }
                

            }
        }

    }
}
