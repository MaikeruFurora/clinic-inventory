<!-- Modal -->
<form id="medicineForm">@csrf
    <div class="modal fade" id="medicineModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="medicineModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="medicineModalTitle"></h6>
              <div class="float-right">
                <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                    <input type="text" class="form-control" id="dateForFill" readonly value="{{ date("F d, Y") }}">
                  </div>
              </div>
            </div>
            <div class="modal-body pb-0">
                        
                <input type="hidden" name="id">
                <div class="form-group">
                    <label for="">Medicine Name</label>
                    <input type="text" class="form-control" required name="medicine_name">
                </div>
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Stock</label>
                         <select id="my-select" class="form-control" name="stock">
                                <option value="Medicine Cabinet">Medicine Cabinet</option>
                                <option value="Medicine Pharma">Medicine Pharma</option>
                            </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="">Unit Quantity</label>
                        <input type="number" class="form-control" required name="unit_qty">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Buy Price</label>
                        <input type="number" class="form-control" required name="buy_price">
                    </div>
                    <div class="form-group col-6">
                        <label for="">Sell Price</label>
                        <input type="number" class="form-control" required name="sell_price">
                    </div>
                </div>  
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="">Barcode</label>
                        <input type="text" class="form-control" readonly name="barcode">
                    </div>
                    <div class="form-group col-6">
                        <label for="">Expiration Date</label>
                        <input type="date" class="form-control" required name="expiration_date">
                    </div>
                </div>  

            </div>
            <div class="modal-footer">
              <button 
              type="button"
              class="btn btn-warning"
              data-dismiss="modal"
              onclick="$('#medicineForm')[0].reset()"
              ><i class="fas fa-times-circle"></i> Close</button>
              <button type="submit" class="btn btn-primary">Create Medicine</button>
            </div>
          </div>
        </div>
      </div>
</form>
