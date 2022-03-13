{{-- seperation modal --}}

<!-- Modal -->
<form id="patientForm">@csrf
    <div class="modal fade" id="patientModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="patientModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="patientModalTitle"></h6>
            </div>
            <div class="modal-body pb-0">
                <input type="hidden" name="id">
                <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="">First name</label>
                      <input type="text" class="form-control" name="first_name">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="">Last name</label>
                      <input type="text" class="form-control" name="last_name">
                    </div>
                  </div>
                <div class="form-group">
                    <label for="">Date of Birth</label>
                    <input type="date" class="form-control" required name="date_of_birth">
                </div>
                <div class="form-group">
                    <label for="">Sex</label>
                    <select name="sex" id="" required class="custom-select">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Status</label>
                    <select name="status" id="" required class="custom-select">
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <textarea class="form-control" name="address" required id="" data-height="80"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Contact No.</label>
                    <input type="text" class="form-control" required name="contact_no">
                </div>
            </div>
            <div class="modal-footer">
              <button 
              type="button"
              class="btn btn-warning"
              data-dismiss="modal"
              onclick="$('#patientForm')[0].reset()"
              ><i class="fas fa-times-circle"></i> Close</button>
              <button type="submit" class="btn btn-primary">Create Record</button>
            </div>
          </div>
        </div>
      </div>
</form>