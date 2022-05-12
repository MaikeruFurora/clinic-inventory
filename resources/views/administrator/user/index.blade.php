@extends('layout.app')
@section('title','Manage User')
@section('content')
@include('administrator.component.modal')
@include('administrator.user.modalForm')
<section class="section">
    <h2 class="section-title">Manage User</h2>

    <div class="section-body">
        <div class="row">
           <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-users" style="font-size: 20px"></i>&nbsp;&nbsp;User list</h4>
                    <div class="card-header-action">
                    <button class="btn btn-info btnCreate"><span class="mdi mdi-account-plus"></span> Create User</button>    
                    </div>
                </div>
                <div class="card-body">
    
                    {{-- <p class="text-muted m-b-30 font-14">Use the tab JavaScript plugin—include
                        it individually or through the compiled</p> --}}
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills mt-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab"> <i class="mdi mdi-account-check"></i> Nurse</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab"> <i class="mdi mdi-account-star-variant"></i> Administrator</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#messages" role="tab"> <i class="mdi mdi-account-convert"></i> Archive User</a>
                        </li>
                    </ul>
    
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active mt-3" id="home" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NAME</th>
                                            <th>USERNAME</th>
                                            <th>CONTACT NO.</th>
                                            <th>EMAIL</th>
                                            <th>ADDRESS</th>
                                            <th>PRIVILEGE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableNurse"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane mt-3" id="profile" role="tabpanel">
                             <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Contact No.</th>
                                            <th>Privilege</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableAdmin"></tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="tab-pane mt-3" id="messages" role="tabpanel">
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>User Type</th>
                                            {{-- <th>Privilege</th> --}}
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
    </div>
</section>
@endsection


@section('moreJs')
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
                            <td>${privilegeDesign(val.privilege)}</td>
                            <td>
                                ${buttonPrevilege(val.id,val.user_type)}
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
                            <td>${privilegeDesign(val.privilege)}</td>
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
                            // <td>${privilegeDesign(val.privilege)}</td>
                $("#tableArchive").html(archiveHTML)
            }).fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
               
            });
        }
        getUser()

        $('select[name="user_type"]').on('change',function(){
            if ($(this).val()=="administrator") {
                $('input[name="privilege[]"]').prop('checked',true).prop('disabled',true)
            } else {
                $('input[name="privilege[]"]').prop('checked',false).prop('disabled',false)
            }
        })
       

        let buttonPrevilege=(id,type=null)=>{
            if(id==userID){
                return `<button style="font-size:13px" class="btn btn-primary btnUpdate" value="${id}"><span class="mdi mdi-table-edit"></span> Update Profile</button>
                        <button style="font-size:13px" class="btn btn-secondary btnChange" value="${id}"><span class="mdi mdi-key"></span> Change Password</button>`;
            }else{
                return `
                
                ${type=='nurse'?`<button name="privilegeButton" style="font-size:11px" class="btn btn-success" value="${id}"><i class="fas fa-check"></i> Update Privilege</button>`:''}
                <button name="status" style="font-size:13px" class="btn btn-danger" value="${id}"><span class="mdi mdi-window-close"></span> Deactivate</button>
                
                `
            }
        }

        $(document).on('click',"button[name='privilegeButton']",function(){
            $("#privilegeForm input[id='privilege-update-1']").prop('checked', false)
            $("#privilegeForm input[id='privilege-update-2']").prop('checked',false)
            $("#privilegeForm input[id='privilege-update-3']").prop('checked',false)
            $.ajax({
                url:'user/privilege/'+$(this).val(),
                type:'GET',
            }).done(function(data){
                $("#privilegeForm input[name='id']").val(data.id)
                $(".modal-dialog").addClass("modal-sm")
                $(".privilegeModal").modal("show")
                $("#privilegeForm input[id='privilege-update-1']").prop('checked', data.privilege.some(i=>'Create'==i))
                $("#privilegeForm input[id='privilege-update-2']").prop('checked',data.privilege.some(i=>'Edit'==i))
                $("#privilegeForm input[id='privilege-update-3']").prop('checked',data.privilege.some(i=>'Delete'==i))
            }).fail(function (jqxHR, textStatus, errorThrown) {
                alert('sas')
                getToast("error", "Eror", errorThrown);
            });
        })

        $("#privilegeForm").on('submit',function(e){
            e.preventDefault()
            $.ajax({
                url:'user/privilege-update',
                type:'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
            }).done(function(data){
                $(".privilegeModal").modal("hide")
                getUser()
                getToast("info", "Update", "Successful update user privilege");
            }).fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                alert('getuupdateeeeeser')
            });  
        })

        let changeStatus=(id,status)=>{
            $.ajax({
                url:'user/change-status/'+id+'/'+status,
                type:'POST',
                data: { _token: $('input[name="_token"]').val() },
            }).done(function(data){
                getToast("success", "Success", "Successfully "+status+" one record");
                getUser();
                $(".confirmModal").modal("hide")
            }).fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
            });
        }

        $(".btnSave").on('click',function(){
            isNull($(this).val()) ? changeStatus($(this).val(),$('.confirmTitle').text().toLowerCase()) : getToast("error", "Eror", "No user id found");
        })

        $(document).on('click',"button[name='status']",function(){
            $(".confirmTitle").text($(this).text());
            $(".showMessage").text(`Are you sure you want to ${$(this).text().toLowerCase()} this user?`)
            $(".modal-dialog").addClass("modal-sm")
            $(".btnSave").val($(this).val())
            $(".confirmModal").modal("show")
        })

        let privilegeDesign = (data) =>{
            let pdhtml='';
            if (isNull(data)) {
                data.map((val,i)=>{
                    pdhtml+=`<span class="badge badge-${(val=='Create'?'primary':(val=='Edit'?'warning':(val=='Delete'?'danger':'')))}
                    " style="font-size:11px">${val}</span>`
                })
                return pdhtml;
            } else {
                return ''
            }
        }

        

        $(".btnCreate").on('click',function(){
            $('select[name="user_type"]').prop('disabled',false)
            $(".modalFormTitle").text('Create User')
            $(".modal-dialog").removeClass("modal-sm")
            $(".ifshow").show()
            $("input[name='id']").val('')
            $("#userForm")[0].reset()
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
                getToast("success", "Success","Saved data successfully");
                $(".btnUserSave").html("Save").attr("disabled", false);
                getUser()
                $("#userForm")[0].reset()
                $(".modalForm").modal("hide")
            })
            .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $(".btnUserSave").html("Save").attr("disabled", false);
            });
       })


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
                if (data.user_type=="administrator") {
                    $('select[name="user_type"]').prop('disabled',true)
                    $('input[name="privilege[]"]').prop('checked',true).prop('disabled',true)
                } else {
                    $('input[name="privilege[]"]').prop('checked',false).prop('disabled',false)
                }
                // $("input[id='privilege-1']").prop('checked',data.privilege.some(i=>'Create'==i))
                // $("input[id='privilege-2']").prop('checked',data.privilege.some(i=>'Edit'==i))
                // $("input[id='privilege-3']").prop('checked',data.privilege.some(i=>'Delete'==i))
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