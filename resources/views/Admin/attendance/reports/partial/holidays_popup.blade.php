
<div class="modal fade" id="holidaysModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="holidaysModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Mark Holidays</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="markHolidayForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mt-2 mb-2">
                            <label for="">Start Date</label>
                            <input type="date" name="start_date"  class="form-control" data-type="required" data-name="Start Date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-2 mb-2">
                            <label for="">End Date</label>
                            <input type="date" name="end_date" class="form-control" data-type="required" data-name="End Date">
                        </div>

                    </div>
                </div><hr>
                <div class="d-flex justify-content-end">
                    <button type="submit" id="submitBtnHoliday" class="btn btn-primary">Mark Holidays</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
