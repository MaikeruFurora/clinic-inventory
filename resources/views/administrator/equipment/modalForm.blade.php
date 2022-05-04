<!-- Modal -->
<form id="equipmentForm">@csrf
    <div class="modal fade" id="equipmentModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="equipmentModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="equipmentModalTitle"></h6>
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
               <div class="row">
                   <div class="col-lg-6 col-md-6 col-sm-12">
                       <div class="form-group">
                           <label>Equipment Name</label>
                           <input id="" class="form-control" type="text" name="name">
                       </div>
                       <div class="form-group">
                            <label>Quantity</label>
                            <input id="" class="form-control" type="number" name="quantity">
                        </div>
                       
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="my-textarea">Description</label>
                            <textarea id="my-textarea" class="form-control" name="description" data-height="150"></textarea>
                        </div>
                   </div>
               </div>
            </div>
            <div class="modal-footer">
              <button 
              type="button"
              class="btn btn-warning"
              data-dismiss="modal"
              onclick="$('#equipmentForm')[0].reset()"
              ><i class="fas fa-times-circle"></i> Close</button>
              <button type="submit" class="btn btn-primary">Create Equipment</button>
            </div>
          </div>
        </div>
      </div>
</form>
