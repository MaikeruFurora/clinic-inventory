@extends('layout.app')
@section('title','Medicine Record')
@section('moreCss')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection
@include('administrator.medicine.modalForm')
@section('content')
<section class="section">
    <h2 class="section-title">Medicine Record</h2>

    <div class="section-body">
        <div class="row">
           <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-pills" style="font-size: 20px"></i>&nbsp;&nbsp;List of Medicine</h4>
                    <div class="card-header-action"><button class="btn btn-primary" name="btnAdd"><i class="fas fa-pills"></i> Create Medicine</button></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;font-size:12px">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>MEDICINE NAME</th>
                                <th>MEDICINE PHARMA</th>
                                <th>MEDICINE CABINET</th>
                                <th>UNIT QUANTITY</th>
                                <th>BUY PRICE</th>
                                <th>SELL PRICE</th>
                                <th>EXPIRATION DATE</th>
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
       let datatableMedicine = $("#datatable").DataTable({
        processing: true,
            serverSide: true,
            ajax:{
                url:'medicine/list',
                dataType: "json",
                type: "POST",
                data:{ _token: $('input[name="_token"]').val() }
            },
            columns: [
                { data:"barcode" },
                { data:"medicine_name" },
                { data:"medicine_pharma" },
                { data:"medicine_cabinet" },
                { data:"unit_qty" },
                { 
                    data:null,
                    render:function(data){
                        return `&#8369; `+data.buy_price+ ` .00`
                    }
                },
                { 
                    data:null,
                    render:function(data){
                        return `&#8369; `+data.sell_price+ ` .00`
                    }
                },
                { data:"expiration_date" },
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

       $('button[name="btnAdd"]').on('click',function(){
           $("#medicineModalTitle").html('<i class="fas fa-pills" style="font-size:15px"></i> Create Medicine')
           $("#medicineForm button[type='submit']").text("Create Medicine");
           $("#medicineModal").modal("show")
       })

       $('#medicineForm').on('submit',function(e){
            e.preventDefault()
            $.ajax({
                url:'medicine/store',
                type:'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: setPreload ($("#medicineForm button[type='submit']"))
           }) .done(function (data) {
                datatableMedicine.ajax.reload()
                getToast("success", "Success","Successful save medicine");
                $("#medicineForm button[type='submit']").text("Create Medicine").attr("disabled", false);
                $("#medicineModal").modal("hide")
                $("#medicineForm")[0].reset()
            })
            .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $("#medicineForm button[type='submit']").text("Create Medicine").attr("disabled", false);
            });
       })

       $(document).on('click','button[name="btnEdit"]',function(){
        $("#medicineModalTitle").html('<i class="fas fa-edit" style="font-size:15px"></i> Edit Medicine')
        $("#medicineForm button[type='submit']").text("Update Medicine");
        $.ajax({
                url:`medicine/edit/${$(this).val()}`,
                type:'GET'
            }).done(function(data){
                $('#medicineForm input[name="id"]').val(data.id)
                $('input[name="medicine_name"]').val(data.medicine_name)
                $('input[name="medicine_pharma"]').val(data.medicine_pharma)
                $('input[name="medicine_cabinet"]').val(data.medicine_cabinet)
                $('input[name="unit_qty"]').val(data.unit_qty)
                $('input[name="buy_price"]').val(data.buy_price)
                $('input[name="sell_price"]').val(data.sell_price)
                $('input[name="barcode"]').val(data.barcode)
                $('input[name="expiration_date"]').val(data.expiration_date)
                $("#medicineModal").modal("show")
            }) .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $("#medicineForm button[type='submit']").text("Update Medicine").attr("disabled", false);
            });
       })
   </script>
@endsection