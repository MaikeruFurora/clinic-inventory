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
<h5 class="page-title">Patient Record</h5>
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">List of Patient</h4>
                <p class="text-muted m-b-30 font-14">DataTables has most features enabled by
                    default, so all you need to do to use it with your own tables is to call
                    the construction function: <code>$().DataTable();</code>.
                </p>

                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;font-size:12px">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Address</th>
                        <th>Contact No.</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                     <tbody></tbody>
                </table>

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
       $("#datatable").DataTable({
            pageLength: 7,
            lengthMenu: [ 7,10, 25, 50, 75, 100 ],
            ajax: "patient/list",
            columns: [
                { data:"id" },
                {
                     data: null,
                     render:function(data){
                         return data.first_name +' '+data.last_name
                     }
                },
                { data:"date_of_birth" },
                {
                     data: null,
                     render:function(data){
                         return computeAge(data.date_of_birth)
                     }
                },
                { data:"sex" },
                { data:"address" },
                { data:"contact_no" },
                {
                     data: null,
                     render:function(data){
                         return `
                         <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" 
                            style="font-size:12px"
                            class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="#">Medical Record</a>
                            <a class="dropdown-item" href="#">Dropdown link</a>
                            </div>
                        </div>
                         `
                     }
                },
            ]
       });

       let computeAge = (data) =>{
        let dob = new Date(data);  
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
   </script>
@endsection