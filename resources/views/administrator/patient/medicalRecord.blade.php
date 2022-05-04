@extends('layout.app')
@section('title','Medical Record')
@section('moreCss')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection
@section('content')
@include('administrator.patient.modalForm')
<section class="section">
    <h2 class="section-title">Medical Record</h2>
    <p>Patient <i class="fas fa-angle-double-right"></i> Medical Record </p>
    <div class="section-body">
        <div class="row">
           
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mt-0 header-title">Medical Record of <u class="text-dark">{{ $patient->first_name.' '.$patient->last_name }}</u></h4>
                        <div class="card-header-action">
                            <a href="{{ route('authuser.patient') }}" class="btn btn-dark"><i class="fas fa-angle-double-left"></i> Back</a>
                            <button class="btn btn-success createCMR"><i class="fas fa-file-medical-alt"></i> Create Medical Record</button>
                        </div>
                    </div>
                    <div class="card-body">
                 
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;font-size:12px">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>DAT</th>
                                <th>BLOOD PRESSURE</th>
                                <th>TEMPERATURE</th>
                                <th>PULSE</th>
                                <th>RESPIRATORY RATE</th>
                                <th>HEIGHT</th>
                                <th>WEIGHT</th>
                                <th>SYMPTOM</th>
                                <th>DETAILS</th>
                                <th>TREATMENT</th>
                                <th>REMARKS</th>
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
       let id = "<?php echo $patient->id?>"
       let datatable = $("#datatable").DataTable({
        ajax: `list/${id}`,
            columns: [
                { data:"no" },
                { data:"created_at" },
                { data:"blood_pressure" },
                { data:"temperature" },
                { data:"pulse" },
                { data:"respiratory_rate" },
                { data:"height" },
                { data:"weight" },
                { data:"symptom" },
                { data:"details" },
                { data:"treatment" },
                { data:"remarks" },
                {
                     data: null,
                     render:function(data){
                         return `<button class="btn btn-warning btn-sm editMR" value="${data.id}"><i class="far fa-edit"></i> Edit</button>
                                <a class="btn btn-danger btn-sm" href="prescription-inventory/${data.id}"><i class="fas fa-file-prescription"></i> Prescription & Equipment</a>`
                     }
                },
            ]
       });
       $(".createCMR").on('click',function(){
           $("#dateForFill").val(`<?=date('F d, Y')?>`);
           $("#medicalFormTitle").text("Create Medical Record")
           $('input[name="id"]').val('')
           $("#medicalForm").modal("show")
           $("#medicalRecordForm .btn-primary").html('<i class="fas fa-briefcase-medical"></i> Create Record');
       })

       $(document).on('click','button[name="prescription"]',function(){
            $("#prescriptionModal").modal("show")
       })

       $(document).on('click',".editMR",function(){
           $('input[name="id"]').val('')
            $.ajax({
                url:'record/'+$(this).val(),
                type:'GET',
            }).done(function(data){
                $(".created_at").val(data.created_at)
                $("input[name='id']").val(data.id);
                $("input[name='patient_id']").val(data.patient_id);
                $("input[name='blood_pressure']").val(data.blood_pressure);
                $("input[name='temperature']").val(data.temperature);
                $("input[name='pulse']").val(data.pulse);
                $("input[name='respiratory_rate']").val(data.respiratory_rate);
                $("input[name='height']").val(data.height);
                $("input[name='weight']").val(data.weight);
                $("textarea[name='symptom']").val(data.symptom);
                $("textarea[name='details']").val(data.details);
                $("textarea[name='treatment']").val(data.treatment);
                $("textarea[name='remarks']").val(data.remarks);
                $("#dateForFill").val(data.created_at);
                $("#medicalRecordForm .btn-primary").html('<i class="far fa-edit"></i> Update Record');
                $("#medicalFormTitle").text("Edit Medical Record")
           $("#medicalForm").modal("show")
            }).fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $(".btnUserSave").html("Save").attr("disabled", false);
            });

       })

       $("#medicalRecordForm").on('submit',function(e){
           e.preventDefault();
           $.ajax({
                url:'store',
                type:'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                berforeSend:function(data){
                    $("#medicalRecordForm .btn-primary").html(`
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    `)
                }
           }).done(function(data){
                 getToast("success", "Success","Save data successfully");
                datatable.ajax.reload()
                $("#medicalRecordForm")[0].reset();
           }).fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $(".btnUserSave").html("Save").attr("disabled", false);
            });
       })


   </script>
@endsection