
<div class="modal fade" id="loanStatusModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loanStatusModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loanStatusModal">Loan Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form id="loanStatusForm">
                @csrf
               <div class="row">
                   <input type="hidden" class="id" name="id" value="">
                   <div class="col-md-12 mt-2 mb-2">
                       <label for="status">Status <small class="text-danger">(*)</small></label>
                       <select name="status" id="status" class="form-control" data-type="required" data-name="Status">
                           <option value="">-- SELECT STATUS --</option>
                           <option value="approved">Approve</option>
                           <option value="rejected">Reject</option>
                       </select>
                   </div>
                   <div class="col-md-12 mt-2 mb-2 approved_amount" style="display: none">
                       <label for="approved_amount">Approved Amount</label>
                       <input type="number" id="approved_amount" name="approved_amount" data-type="" data-name="Approved Amount" class="form-control" placeholder="Approved Amount">
                   </div>
                   <div class="col-md-12 mt-2 mb-2">
                       <div class="form-group">
                           <label for="remarks">Remarks / Reason <small class="text-danger">(*)</small></label>
                           <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks / Reason" data-type="required" data-name="Reason / Remarks" cols="30" rows="10"></textarea>
                       </div>
                   </div>
                   <div class="col-md-12">
                       <button class="btn btn-primary shadow" type="submit">Save</button>
                   </div>
               </div>
       </form>

        </div>

      </div>
    </div>
  </div>
