<div class="modal fade modalForm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form id="userForm">@csrf
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h6 class="modal-title mt-0 modalFormTitle" id="myLargeModalLabel"></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">User Type</label>
                        <div class="col-sm-9">
                               <select id="my-select" class="form-control" name="user_type">
                                   <option value="nurse">Nurse</option>
                                   <option value="administrator">Administrator</option>
                               </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">First name</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" required name="first_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Last name</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" required name="last_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example9text-input" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="email" required name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Contact No.</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" onkeypress="return numberOnly(event)"  maxlength="11" required name="contact_no">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="address">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" required name="username">
                        </div>
                    </div>
                    <p class="ifshow">
                        <b>Note:</b>
                        Default password for new user are <b class="text-primary">passsword</b>
                    </p>
                    <div class="float-right">
                        <button class="btn btn-sm btn-primary btnUserSave" type="submit">Save</button>&nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning" data-dismiss="modal"
                        onclick="event.preventDefault(); document.getElementById('userForm').reset();">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->


<div class="modal fade changeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form id="changeForm">@csrf
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h6 class="modal-title mt-0" id="myLargeModalLabel">Change Password</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <div class="form-group row">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Current Password</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="password" required name="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-4 col-form-label">New password</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="password" required name="new_password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Confirm password</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="password" required name="confirm_password">
                            <span class="text-danger showError"></span>
                        </div>
                    </div>
                    <div class="float-right">
                        <button class="btn btn-sm btn-primary btnUserChange" type="submit">Save</button>&nbsp;&nbsp;
                        <button class="btn btn-sm btn-warning" data-dismiss="modal"
                        onclick="event.preventDefault(); document.getElementById('changeForm').reset();">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->