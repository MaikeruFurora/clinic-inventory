<!-- Modal -->
<form id="medicalRecordForm">@csrf
    <div class="modal fade" id="medicalForm" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="medicalFormTitle" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="medicalFormTitle"></h6>
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
                <div class="row">
                    <input type="hidden" name="id">
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="">Blood Pressure</label>
                            <input type="text" class="form-control" required name="blood_pressure">
                        </div>
                        <div class="form-group">
                            <label for="">Temperature</label>
                            <input type="text" class="form-control" required name="temperature">
                        </div>
                        <div class="form-group">
                            <label for="">Pulse</label>
                            <input type="text" class="form-control" required name="pulse">
                        </div>
                        <div class="form-group">
                            <label for="">Respiratory Rate</label>
                            <input type="text" class="form-control" required name="respiratory_rate">
                        </div>
                        <div class="form-group">
                            <label for="">Height</label>
                            <input type="text" class="form-control" required name="height">
                        </div>
                        <div class="form-group">
                            <label for="">Weight</label>
                            <input type="text" class="form-control" required name="weight">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="">Symptom</label>
                            <textarea class="form-control" required name="symptom" data-height="90"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Details</label>
                            <textarea class="form-control" required name="details" data-height="90"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Treatment</label>
                            <textarea class="form-control" required name="treatment" data-height="90"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Remarks</label>
                            <textarea class="form-control" required name="remarks" data-height="90"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button 
              type="button"
              class="btn btn-warning"
              data-dismiss="modal"
              onclick="$('#medicalRecordForm')[0].reset()"
              ><i class="fas fa-times-circle"></i> Close</button>
              <button type="submit" class="btn btn-primary">Create Record</button>
            </div>
          </div>
        </div>
      </div>
</form>
