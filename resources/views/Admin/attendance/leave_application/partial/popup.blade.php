
<div class="modal fade" id="experienceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Application Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="changeStatus">
                @csrf
                <div class="row g-2">
                    <div class="col-md-12 status_container  mt-3 mb-2">
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="from_date" id="from_date">
                        <input type="hidden" name="to_date" id="to_date">
                        <div class="form-group">
                            <label for="status">Status <small class="text-danger">*</small></label>
                            <select data-name="Status" data-type="required" name="status" id="status" class="form-control select2">
                                <option value="">-- Select Status --</option>
                                <option value="approved">Approve</option>
                                <option value="rejected">Reject</option>
                            </select>
                        </div>
                    </div>
                    {{-- Approved Days --}}
                    <div class="col-md-6 mt-3 date_range_container mb-2" style="display:none">
                        <div class="form-group">
                            <label for="date_range">Approved Days <small class="text-danger">*</small></label>
                            <input type="text" data-name="Date Range" name="date_range" class="form-control datepicker " id="date_range">
                        </div>
                    </div>
                    <div class="col-md-12 remarks_container mt-3 mb-2" style="display:none">
                        <div class="form-group">
                            <label for="remarks">Remarks <small class="text-danger">*</small></label>
                            <textarea  name="remarks" data-name="Remarks" class="form-control " id="remarks" placeholder="Enter Remarks"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </div>
                </div>

            </form>
        </div>


      </div>
    </div>
  </div>
