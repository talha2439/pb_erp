
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loanStatusModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loanStatusModal">Loan Installment Edit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="updateForm">
                @csrf
               <div class="row">
                   <input type="hidden" class="id" name="id" value="">
                   <div class="col-md-12 mt-2 mb-2">
                       <label for="status">Loan Installment Amount <small class="text-danger">(*)</small></label>
                        <input type="number" name="amount" placeholder="Installment Amount" class="form-control" data-type="required" data-name="Installment Amount">
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
