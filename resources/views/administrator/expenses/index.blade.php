@extends('layouts.app')
@section('title','Manage Patient')
@section('moreCss')
      <!-- DataTables -->
      <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
      <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
      <!-- Responsive datatable examples -->
      <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
{{-- @include('administrator.component.modal') --}}
<h5 class="page-title">Daily Expenses</h5>
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-12">
        <div class="card m-b-30">
            <div class="card-body">
             
                <h4 class="mt-0 header-title">List of Expenses</h4>
                <p class="text-muted m-b-30 font-14">DataTables has most features enabled by
                    default, so all you need to do to use it with your own tables is to call
                    the construction function: <code>$().DataTable();</code>.
                </p>

                <form>
                    <div class="form-row">
                      <div class="col">
                        <label for="">Date From</label>
                        <input type="text" class="form-control" placeholder="First name">
                      </div>
                      <div class="col">
                          <label for="">Date To</label>
                        <input type="text" class="form-control" placeholder="Last name">
                      </div>
                    </div>
                  </form>
                  <hr>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;font-size:12px">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>User</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                     <tbody></tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="form-group">
                    <label for="exampleInputEmail1">Amount</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                    <textarea class="form-control" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection

@section('morejs')
   <!-- Required datatable js -->
   <script src="{{  asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
   <script src="{{  asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
   <!-- Responsive examples -->
   <script src="{{  asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
   <script src="{{  asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

   <script>
       $("#datatable").DataTable();
   </script>
@endsection