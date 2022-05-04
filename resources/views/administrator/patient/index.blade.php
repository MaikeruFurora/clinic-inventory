@extends('layout.app')
@section('title','Manage Patient')
@section('moreCss')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection
@section('content')
@include('administrator.patient.patientModal')
<section class="section">
    <h2 class="section-title">Patient Record</h2>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-user-injured" style="font-size: 20px"></i>&nbsp;&nbsp;List of Patient</h4>
                        <div class="card-header-action">
                            <button class="btn btn-primary" name="btnAdd"><i class="fas fa-user-injured"></i> Create Patient</button>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <div class="form-row">
                            <div class="col-3">
                               <input type="text" class="form-control" name="search_fname" placeholder="Search first name">
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" name="search_lname" placeholder="Search last name">
                             </div>
                            <div class="col-3">
                                <select name="search_sex" id="" class="custom-select">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" name="search_address" placeholder="Search address">
                            </div>
                        </div> --}}
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;font-size:12px">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>NAME</th>
                                <th>DATE OF BIRTH</th>
                                <th>AGE</th>
                                <th>STATUS</th>
                                <th>SEX</th>
                                <th>ADDRESS</th>
                                <th>CONTACT NO.</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                             <tbody></tbody>
                        </table>
        
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</section>
@endsection

@section('moreJs')
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>

   <script>
       let datatablePatient = $("#datatable").DataTable({
            //searching:false,
            //lengthChange:false,
            //lengthMenu: [10,20,50]
            //processing: true,
           //serverSide:true,
            //paging:true,
            // ajax:"patient/list",
            processing: true,
            serverSide: true,
            ajax:{
                     url:'patient/list',
                     dataType: "json",
                     type: "POST",
                     data:{ _token: $('input[name="_token"]').val() }
                   },
            columns: [
                { data:"id" },
                { data:"fullname"},
                { data:"date_of_birth" },
                {
                     data: null,
                     render:function(data){
                         return computeAge(data.date_of_birth)
                     }
                },
                { data:"status" },
                { data:"sex" },
                { data:"address" },
                { data:"contact_no" },
                {
                     data: null,
                     render:function(data){
                         return `
                            <button class="btn btn-warning btn-sm" name="btnEdit" 
                            value="${data.id}"
                            style="font-size:13px"><i class="fas fa-edit"></i> Edit</button>
                            <a href="patient/medical-record/${data.id}" style="font-size:13px"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-file-medical-alt"></i>
                            Medical Record
                            </a>
                         `
                     }
                },
            ]
       });


       let computeAge = (data) =>{
            let dayt = data.split("/")
            let formalDate = dayt[1]+'/'+dayt[0]+'/'+dayt[2]
            let dob = new Date(formalDate);  
            //calculate month difference from current date in time  
            let month_diff = Date.now() - dob.getTime();  
            
            //convert the calculated difference in date format  
            let age_dt = new Date(month_diff);   
            
            //extract year from date      
            let year = age_dt.getUTCFullYear();  
            
            //now calculate the age of the user  
            let age = Math.abs(year - 1970);  

            return age + " years old";
       }

       $('button[name="btnAdd"]').on('click',function(){
            $("#patientModal").modal("show")
            $("#patientModalTitle").text('Create Patient')
            $('#patientForm input[name="id"]').val('')
       })

       $(document).on('click','button[name="btnEdit"]',function(){
            $("#patientModalTitle").text('Edit Patient')
            $('#patientForm input[name="id"]').val('')
            $("#patientForm button[type='submit']").text('Update Record')
            $.ajax({
                url:`patient/edit/${$(this).val()}`,
                type:'GET'
            }).done(function(data){
                $('#patientForm input[name="id"]').val(data.id)
                $('input[name="first_name"]').val(data.first_name)
                $('input[name="last_name"]').val(data.last_name)
                $('input[name="date_of_birth"]').val(data.date_of_birth)
                $('select[name="sex"]').val(data.sex)
                $('select[name="status"]').val(data.status)
                $('textarea[name="address"]').val(data.address)
                $('input[name="contact_no"]').val(data.contact_no)
              $("#patientModal").modal("show")
            }) .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $("#patientForm button[type='submit']").html("Update Patient").attr("disabled", false);
            });
       })

       $("#patientForm").on('submit',function(e){
           e.preventDefault();
           $.ajax({
                url:'patient/store',
                type:'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: setPreload ($("#patientForm button[type='submit']"))
           }) .done(function (data) {
                datatablePatient.ajax.reload()
                getToast("success", "Success","Successful save patient");
                $("#patientForm button[type='submit']").html("Create Patient").attr("disabled", false);
                $("#patientModal").modal("hide")
                $("#patientForm")[0].reset()
            })
            .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $("#patientForm button[type='submit']").html("Create Patient").attr("disabled", false);
            });
       })


   </script>
@endsection