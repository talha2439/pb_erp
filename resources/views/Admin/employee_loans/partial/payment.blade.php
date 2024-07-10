

<div class="modal fade" id="loanPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loanPaymentModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loanStatusModal">Loan Installment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="loanInstallmentForm">
                <div class="row">
                    <div class="form-group">
                        <label for="">
                         Installment Amount <small class="text-danger">(*)</small>
                        </label>
                        <input type="hidden"name="id" class="payId">
                        <input type="text" class="form-control" name="paid_amount" placeholder="Loan Installment Amount" data-type="required" data-name="Loan Installment Amount">
                        <button type="submit" class="btn btn-primary mt-3" id="submitBtn">Save</button>
                    </div>
                </div>
            </form>

        </div>

      </div>
    </div>
  </div>
