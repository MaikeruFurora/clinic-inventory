@extends('layout.app')
@section('title','Prescrition & Equipment Record')
@section('moreCss')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection
@include('administrator.medicine.modalForm')
@section('content')
<section class="section">
    <h2 class="section-title">Prescrition and Inventory</h2>
    <p>Patient <i class="fas fa-angle-double-right"></i> Medical Record <i class="fas fa-angle-double-right"></i> Prescription &Inventory</p>
    <div class="section-body">
        <div class="row">
           <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user-injured" style="font-size: 20px"></i>&nbsp;&nbsp;Record of <u class="text-dark">{{ $patientRecord->first_name.' '.$patientRecord->last_name }}</u></h4>
                    <div class="card-header-action">
                        <a href="{{ url()->previous() }}" style="font-size: 14px" class="btn btn-dark"><i class="fas fa-angle-double-left" style="font-size: 16px"></i> Back</a>
                        <button class="btn btn-primary" style="font-size: 14px"><i class="fas fa-pills" style="font-size: 16px"></i> Medicine</button>
                        <button class="btn btn-primary" style="font-size: 14px"><i class="fab fa-accessible-icon" style="font-size: 16px"></i> Equipment</button>
                    </div>
                </div>
              <div class="card-body">
                  <div class="row">
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <table class="table table-striped table-bordered" style="font-size: 12px">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>MEDICINE</th>
                                      <th>QUANTITY</th>
                                      <th>PRICE</th>
                                      <th>ACTION</th>
                                  </tr>
                              </thead>
                              <tbody></tbody>
                              <tfoot>
                                  <tr>
                                      <td colspan="3"></td>
                                  </tr>
                              </tfoot>
                          </table>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <table class="table table-striped table-bordered" style="font-size: 12px">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>EQUIPMENT</th>
                                      <th>PRICE</th>
                                      <th>ACTION</th>
                                  </tr>
                              </thead>
                          </table>
                          <tbody></tbody>
                          <tfoot>
                              <tr>
                                  <td colspan="2"></td>
                              </tr>
                          </tfoot>
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

  
@endsection