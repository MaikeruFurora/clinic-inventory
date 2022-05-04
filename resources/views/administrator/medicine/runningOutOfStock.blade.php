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
    <div class="float-right">
        <button class="btn-expired btn btn-danger"><i class="fa fa-print"></i> Expired</button>
        <button class="btn-running-out-of-stock btn btn-success"><i class="fa fa-print"></i> Running out of Stock</button>
    </div>
    <h2 class="section-title">Medicine Record</h2>

    <div class="section-body">
        <div class="row">
           <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-pills" style="font-size: 20px"></i>&nbsp;&nbsp;List of Medicine</h4>
                    {{-- <div class="card-header-action"><button class="btn btn-primary" name="btnAdd"><i class="fas fa-pills"></i> Create Medicine</button></div> --}}
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link " id="home-tab2" href="{{ route('authuser.medicine') }}">Stock Available</a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link " id="profile-tab2" href="{{ route('authuser.expired') }}">Expired&nbsp;&nbsp;<small class="badge badge-warning p-1">{{ $te }}</small></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" id="contact-tab2" href="{{ route('authuser.runningOutOfStock') }}">Running out of stock&nbsp;&nbsp;<small class="badge badge-warning p-1">{{ $tr }}</small></a>
                        </li>
                      </ul>
                      <div class="tab-content tab-bordered" id="myTab3Content">
                        <div class="tab-pane fade show active" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">
                            <div class="table-responsive">
                                <table id="runningOutOfStock" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;font-size:11px">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>MEDICINE NAME</th>
                                        <th>STOCK</th>
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
        </div>
    </div>
</section>
@endsection
@section('moreJs')
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>

   <script>
     

         /**
        * 
        * running out of stock javascript function
        * and configuration
        * 
        * 
        * */
        
        $("#runningOutOfStock").DataTable({
        processing: true,
            serverSide: true,
            ajax:{
                url:'running-out-of-stock/list',
                dataType: "json",
                type: "POST",
                data:{ _token: $('input[name="_token"]').val() }
            },
            columns: [
                { data:"barcode" },
                { data:"medicine_name" },
                { data:"stock" },
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
                { data:"id" },
               
            ]
       });

       
     $('.btn-expired').on('click',function(){
         console.log('sas')
        let myurl = `expired/print`
        popupCenter({
            url: myurl,
            title: "Expired Medicine",
            w: 1400,
            h: 800,
        });
     })

     $('.btn-running-out-of-stock').on('click',function(){
         console.log('sas')
        let myurl = `running-out-of-stock/print`
        popupCenter({
            url: myurl,
            title: "Running out of stock Medicine",
            w: 1400,
            h: 800,
        });
     })
   </script>
@endsection