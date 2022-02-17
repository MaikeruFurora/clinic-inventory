@extends('layouts.app')
@section('title','Manage Users')
@section('content')
@include('administrator.component.modal')
@include('administrator.user.modalForm')
<h5 class="page-title">Manage User</h5>
<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-30 mt-3">
            <div class="card-body">
                <div class="float-right">
                <button class="btn btn-info btnCreate"><span class="mdi mdi-account-plus"></span> Create User</button>    
                </div>

                <h4 class="mt-0 header-title">User list</h4>
                {{-- <p class="text-muted m-b-30 font-14">Use the tab JavaScript plugin—include
                    it individually or through the compiled</p> --}}
                <!-- Nav tabs -->
                <ul class="nav nav-tabs mt-4" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Nurse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Administrator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#messages" role="tab">Archive User</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="home" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped" style="font-size: 13px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Contact No</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableNurse"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane p-3" id="profile" role="tabpanel">
                         <div class="table-responsive">
                            <table class="table table-striped" style="font-size: 13px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Contact No.</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableAdmin"></tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane p-3" id="messages" role="tabpanel">
                          <div class="table-responsive">
                            <table class="table table-striped" style="font-size: 13px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>User Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableArchive"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('morejs')
    <script>
        let userID = $("input[name='userID']").val()
        let getUser=()=>{
            let adminHTML='';
            let nurseHTML='';
            let archiveHTML='';
            $.ajax({
                url:'user/list',
                type:'GET'
            }).done(function(data){
                data.nurse.forEach((val,i) => {
                    nurseHTML+=`
                        <tr>
                            <td>${++i}</td>
                            <td>${val.first_name+' '+val.last_name}</td>
                            <td>${val.username}</td>
                            <td>${isNull(val.contact_no)}</td>
                            <td>${val.email}</td>
                            <td>${isNull(val.address)}</td>
                            <td>
                                <button name="status" style="font-size:13px" class="btn btn-danger" value="${val.id}"><span class="mdi mdi-window-close"></span> Deactivate</button>
                            </td>
                        </tr>
                        `;
                });
                $("#tableNurse").html(nurseHTML);
                data.administrator.forEach((val,i) => {
                    adminHTML+=`
                        <tr>
                            <td>${++i}</td>
                            <td>${val.first_name+' '+val.last_name}</td>
                            <td>${val.username}</td>
                            <td>${val.email}</td>
                            <td>${isNull(val.contact_no)}</td>
                            <td>
                               ${buttonPrevilege(val.id)}
                            </td>
                        </tr>`;
                });
                $("#tableAdmin").html(adminHTML);
                data.archive.forEach((val,i) => {
                    archiveHTML+=`
                        <tr>
                            <td>${++i}</td>
                            <td>${val.first_name+' '+val.last_name}</td>
                            <td><span style="font-size:12px" class="badge badge-primary">${val.user_type.toUpperCase()}</span></td>
                            <td>
                                <button name="status" style="font-size:13px" class="btn btn-primary" value="${val.id}"><span class="mdi mdi-verified"></span> Activate</button>
                            </td>
                        </tr>`;
                });
                $("#tableArchive").html(archiveHTML)
            }).fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
            });
        }
        getUser()

        let isNull=(value)=>{
           return value!=null?value:'';
        }

        let buttonPrevilege=(id)=>{
            if(id==userID){
                return `<button style="font-size:13px" class="btn btn-primary btnUpdate" value="${id}"><span class="mdi mdi-table-edit"></span> Update Profile</button>
                        <button style="font-size:13px" class="btn btn-secondary btnChange" value="${id}"><span class="mdi mdi-key"></span> Change Password</button>`;
            }else{
                return ` <button name="status" style="font-size:13px" class="btn btn-danger" value="${id}"><span class="mdi mdi-window-close"></span> Deactivate</button>`
            }
        }


        let changeStatus=(id,status)=>{
            $.ajax({
                url:'user/change-status/'+id+'/'+status,
                type:'POST',
                data: { _token: $('input[name="_token"]').val() },
            }).done(function(data){
                getToast("success", "succss", "Successfully "+status+" one record");
                getUser();
                $(".confirmModal").modal("hide")
            }).fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
            });
        }

        $(document).on('click',"button[name='status']",function(){
            $(".confirmTitle").text($(this).text());
            $(".showMessage").text(`Are you sure you want to ${$(this).text().toLowerCase()} this user?`)
            $(".modal-dialog").addClass("modal-sm")
            $(".btnSave").val($(this).val())
            $(".confirmModal").modal("show")
        })

        $(".btnSave").on('click',function(){
            isNull($(this).val()) ? changeStatus($(this).val(),$(".confirmTitle").text().toLowerCase()) : getToast("error", "Eror", "No user id found");
        })

        $(".btnCreate").on('click',function(){
            $(".modalFormTitle").text('Create User')
            $(".modal-dialog").removeClass("modal-sm")
            $(".ifshow").show()
            $(".modalForm").modal("show")
        });

        $("#userForm").submit(function(e){
           e.preventDefault();
           $.ajax({
                url:'user/store',
                type:'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: setPreload ($(".btnUserSave"))
           }) .done(function (data) {
                getToast("success", "Success", "Save data successfully");
                $(".btnUserSave").html("Save").attr("disabled", false);
                getUser()
            })
            .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $(".btnUserSave").html("Save").attr("disabled", false);
            });
       })


       let setPreload=(selector)=>{
            selector.html(` Saving<div class="spinner-border spinner-border-sm" role="status"> <span class="sr-only">Loading...</span> </div>`).attr("disabled", true);
       }

       $(document).on('click',".btnUpdate",function(){
            $.ajax({
                url:'user/find/'+$(this).val(),
                type:'GET',
            }).done(function(data){
                $(".modalFormTitle").text('Update User')
                $(".modal-dialog").removeClass("modal-sm")
                $(".ifshow").hide()
                $(".modalForm").modal("show")
                $("select[name='user_type']").val(data.user_type)
                $("input[name='first_name']").val(data.first_name)
                $("input[name='last_name']").val(data.last_name)
                $("input[name='username']").val(data.username)
                $("input[name='email']").val(data.email)
                $("input[name='address']").val(data.address)
                $("input[name='contact_no']").val(data.contact_no)
                $("input[name='id']").val(data.id)
            }).fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
            });
        });
        
        $(document).on('click',".btnChange",function(){
            $(".modal-dialog").removeClass("modal-sm")
            $(".changeModal").modal("show")
        });

        $("#changeForm").submit(function(e){
           e.preventDefault();
           $.ajax({
                url:'user/change-password',
                type:'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: setPreload ($(".btnUserChange"))
           }) .done(function (data) {
                if (data.msg) {
                    getToast("warning", "Warning", data.msg);
                } else {
                    getToast("progress", "Success", "System account will automatic logout and try to login");
                    setTimeout(() => {
                        window.location.reload()
                    }, 3000);
                }
                $(".btnUserChange").html("Save").attr("disabled", false);
            })
            .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $(".btnUserChange").html("Save").attr("disabled", false);
            });
       })


       $("input[name='confirm_password']").on('keyup',function(){
           let np=$("input[name='new_password']").val();
           if (np==$(this).val()) {
               $(".showError").text("")
           } else {
               $(".showError").text("Confirm password didn't match!")
           }
       })
    </script>
@endsection