@extends('layout.app')
@section('title','Equipment Record')
@section('moreCss')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection
@include('administrator.equipment.modalForm')
@section('content')
<section class="section">
    <h2 class="section-title">Equipment Record</h2>

    <div class="section-body">
        <div class="row">
           <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fab fa-accessible-icon" style="font-size: 20px"></i>&nbsp;&nbsp;List of Equipment</h4>
                    <div class="card-header-action"><button class="btn btn-primary" name="btnAdd" style="font-size: 14px"><i class="fab fa-accessible-icon" style="font-size: 16px"></i> Create Equipment</button></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;font-size:12px">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>EQUIPMENT NAME</th>
                                <th>QUANTITY</th>
                                <th>DESCRIPTION</th>
                                <th>PRICE</th>
                                <th>CREATED AT</th>
                                <th>ADDED BY</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                             <tbody></tbody>
                        </table>
                    </div>
    
                </div>
            </div>
           </div>
        </div>
    </div>
</section>
@endsection
@section('moreJs')
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        "use strict"
        $('button[name="btnAdd"]').on('click',function(){
            $("#equipmentModalTitle").text('Create Equipment')
            $("#equipmentForm button[type='submit']").text("Create Equipment");
            $("#equipmentForm input[name='id']").val('')
            $("#equipmentModal").modal("show")
        })

        let datatableEquipment = $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url:'equipment/list',
                dataType: "json",
                type: "POST",
                data:{ _token: $('input[name="_token"]').val() }
            },
            columns: [
                { data:"id" },
                { data:"name" },
                { data:"quantity" },
                { data:"description" },
                { 
                    data:null,
                    render:function(data){
                        return `&#8369; `+data.price+ ` .00`
                    }
                },
                { data:"created_at" },
                { data:"added_by" },
                {
                     data: null,
                     render:function(data){
                         return `
                         <button class="btn btn-warning btn-sm" name="btnEdit" value="${data.id}"><i class="fas fa-edit"></i>Edit</button>
                         `
                     }
                },
            ]
       });

       $('#equipmentForm').on('submit',function(e){
            e.preventDefault()
            $.ajax({
                url:'equipment/store',
                type:'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: setPreload ($("#equipmentForm button[type='submit']"))
           }) .done(function (data) {
                datatableEquipment.ajax.reload()
                getToast("success", "Success","Successful save Equipment");
                $("#equipmentForm button[type='submit']").text("Create Equipment").attr("disabled", false);
                $("#equipmentModal").modal("hide")
                $("#equipmentForm")[0].reset()
            })
            .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $("#equipmentForm button[type='submit']").text("Create Equipment").attr("disabled", false);
            });
       })

       $(document).on('click','button[name="btnEdit"]',function(){
        $("#equipmentModalTitle").text('Edit Medicine')
        $("#equipmentForm button[type='submit']").text("Update Equipment");
        $.ajax({
                url:`equipment/edit/${$(this).val()}`,
                type:'GET'
            }).done(function(data){
                $('#equipmentForm input[name="id"]').val(data.id)
                $('input[name="name"]').val(data.name)
                $('input[name="quantity"]').val(data.quantity)
                $('input[name="price"]').val(data.price)
                $('textarea[name="description"]').val(data.description)
                $("#equipmentModal").modal("show")
            }) .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $("#equipmentForm button[type='submit']").text("Update Medicine").attr("disabled", false);
            });
       })
    </script>
@endsection