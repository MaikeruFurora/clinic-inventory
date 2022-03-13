@extends('layout.app')
@section('title','Expenses')
@section('moreCss')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/css/select2.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/modules/select2/css/select2-bootstrap4.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/chocolat/dist/css/chocolat.css') }}">
@endsection
@section('content')
<section class="section">
    <h2 class="section-title">Expenses</h2>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 col-4  mb-4 text-center">
                                <select id="my-select" class="form-control" name="year">
                                    @foreach ($years as $item)
                                        <option value="{{ $item->year }}">{{ $item->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4 col-4 mb-md-0 mb-4 text-center">
                              <div class="mt-2 font-weight-bold text-nowrap"><h4 class="last_week"></h4></div>
                              <div class="text-small text-muted"></span>Last week</div>
                            </div>
                            <div class="col-sm-4 col-4 text-center">
                              <div class="mt-2 font-weight-bold text-nowrap"><h4 class="last_month"></h4></div>
                              <div class="text-small text-muted">Last Month</div>
                            </div>
                          </div>
                       
                        <canvas id="bar" height="130"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-6 mb-md-0 mb-4 text-center">
                              <div class="mt-2 font-weight-bold text-nowrap"><h4 class="what_year"></h4></div>
                              <div class="text-small text-muted"></span>Current Year</div>
                            </div>
                            <div class="col-sm-6 col-6 text-center">
                              <div class="mt-2 font-weight-bold text-nowrap"><h4 class="expense_in_a_year"></h4></div>
                              <div class="text-small text-muted">Yearly Amount</div>
                            </div>
                          </div>
                       
                        <canvas id="pie" height="10"></canvas>
                    </div>
                </div>
            </div>
        </div><!--end row-->
        <br>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="header-title py-2"><i class="fas fa-hand-holding-usd" style="font-size: 20px"></i>&nbsp;&nbsp;List of Expenses</h4>
                    </div>
                    <div class="card-body">
                        <p>Filter Data <i class="fas fa-filter"></i></p>
                        <div class="row mb-4">
                            <div class="col">
                                <select id="" class="form-control" name="month">
                                    <option value="null">Select Month</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">Mya</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                 </select>
                            </div>
                            <div class="col">
                                <select id="" class="form-control " name="table_year">
                                    @foreach ($years as $item)
                                        <option value="{{ $item->year }}">{{ $item->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;font-size:12px">
                                <thead>
                                <tr>
                                    <th>DESCRIPTION</th>
                                    <th>AMOUNT</th>
                                    <th>ADDED BY</th>
                                    <th>CREATED AT</th>
                                    <th>ACTION</th>
                                </tr>
                                </thead>
                                 <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Create Expenses</h4>
                    </div>
                    <div class="card-body">
                        <form id="formExpenses">@csrf
                            <input type="hidden" name="id">
                            <div class="form-group">
                            <label for="">Amount</label>
                            <input type="number" class="form-control" name="amount">
                            <span class="text-danger amount"></span>
                            </div>
                            <div class="form-group">
                            <label for="">Description</label>
                            <textarea class="form-control" data-height="150" name="description"></textarea>
                            <span class="text-danger description"></span>
                            </div>
                            <button type="submit" class="btn btn-primary btnSave">Submit</button>
                            <button type="button" class="btn btn-warning btnClear">Cancel</button>
                        </form>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                       <a href="javascript:;" class="btn btn-primary btn-block daterange-btn icon-left btn-icon"><i class="fas fa-calendar"></i> Choose date to generate report
                       </a>
                    </div>
                </div>
                <div class="card" id="mycard-dimiss">
                    <div class="card-header">
                      <h4><small>Generated Report</small> <span style="font-size: 10px" class="badge badge-primary p-1">Date: {{ date("Y-m-d") }}</span></h4>
                      <div class="card-header-action">
                        <button class="btn btn-icon btn-danger dismiss" href="#"><i class="fas fa-times"></i></button>
                      </div>
                    </div>
                    <div class="card-body">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Blanditiis, quisquam sapiente quasi quas ea quam rerum perspiciatis numquam</p>
                        <div class="row">
                            <div class="col-6">
                                <button value="print" class="btn btn-icon btn-block icon-left btn-info btnPrint"><i style="font-size: 15px" class="fas fa-print"></i> Print Now</button>
                            </div>
                            <div class="col-6">
                                <button value="pdf" class="btn btn-icon btn-block icon-left btn-dark btnPrint"><i style="font-size: 15px" class="far fa-file-pdf"></i> Export PDF</button>
                            </div>
                        </div>
                      
                    </div>
                  </div>
            </div> <!-- end col -->
        
        </div> <!-- end row -->
    </div>
</section>
@endsection



@section('moreJs')

   <!-- JS Libraies -->
   <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
   <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
   <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
   <script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
   <script src="{{ asset('assets/modules/select2/js/select2.min.js') }}"></script>
   <script src="{{ asset('assets/modules/chartjs/chart.min.js') }}"></script>
   <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
   <script>
       "use strict"
       $("#mycard-dimiss").hide()
       let currentYear= new Date().getFullYear(); 
       $(".btnClear").hide()

        let myBarGraph = (data) =>{
            let arrayAmount = [0,0,0,0,0,0,0,0,0,0,0,0];
            data.map((val,i)=>{
                arrayAmount[--val.month]=val.total
            })
            let barChart = document.getElementById('bar').getContext('2d');
            let chartStatus = Chart.getChart("bar");
            if (chartStatus != undefined) {
                chartStatus.destroy();
            }
            let myChart = new Chart(barChart, {
                    type: 'bar',
                    data: {
                        labels: month,
                        datasets: [{
                            // axis: 'y',
                            // fill: false,
                            label: 'Total amount by month ',
                            data:arrayAmount.map(val=>val),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            yAxis: {
                                stepSize:0,
                                beginAtZero: true,
                                ticks: {
                                    // Include a dollar sign in the ticks
                                    callback: function(value, index, ticks) {
                                        return '₱ ' + value.toLocaleString();
                                    }
                                }
                            },
                            
                        }
                    }
                });
        }

        let myPieGraph = (data) =>{
            let myIndex = data.map((val,i)=>(--val.month))
            let myMonth =month.filter((val,i)=>i==myIndex[i]?val:'')
            let pieChart = document.getElementById('pie').getContext('2d');
            let chartStatus = Chart.getChart("pie");
            if (chartStatus != undefined) {
                chartStatus.destroy();
            }
            let myChart = new Chart(pieChart, {
                type: 'doughnut',
                data : {
                    labels:myMonth,
                    datasets: [{
                        label: 'My First Dataset',
                        data:data.map(val=>val.total),
                        backgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        hoverOffset: data.length
                    }]

                }
            });
        }

        let myNumber = async (year)=>{
            await $.ajax({
                url:'expenses/bar-graph/'+year,
                type:'GET',
            }).done(function(data){
                $(".last_month").text(isNullPrice(data.lastmonth[0].total));
                $(".last_week").text(isNullPrice(data.lastweek[0].total));
                let expensesInYEar = data.graph.reduce((acc,val)=>{
                    return acc+=parseInt(val.total)
                },0)
                $(".what_year").text($("select[name='year']").find(':selected').text())
                $(".expense_in_a_year").text(isNullPrice(expensesInYEar))
                myBarGraph(data.graph)
                myPieGraph(data.graph)
            }).fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
           });
        }

    

        myNumber(currentYear);

        $("select[name='year']").on('change',function(){
            $("select[name='year']").attr('selected',true);
            myNumber($(this).val())
        })


       let exepenseTable = $("#datatable").DataTable({
            processing: true,
            language: {
                processing: `
                    <div class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>`,
            },
            ajax: `expenses/list/${currentYear}/null`,
            columns: [
                { data:"description" },
                { data:"amount" },
                { data:"fullname" },
                { data:"pdate" },
                { data:null,
                    render:function(data){
                        return `<button name="status" style="font-size:13px" class="btn btn-primary btnEdit pt-1 pb-1" value="${data.id}"><i class="far fa-edit"></i> Edit</button>`
                    }
                },
       ]
       });

       $("select[name='table_year']").on('change',function(){
           exepenseTable.ajax.url('expenses/list/'+$(this).val()+'/'+$("select[name='month']").val()).load()
       })

       $("select[name='month']").on('change',function(){
           exepenseTable.ajax.url('expenses/list/'+$("select[name='table_year']").val()+'/'+$(this).val()).load()
       })

       $("#formExpenses").on('submit',function(e){
           e.preventDefault();
           $.ajax({
                url:'expenses/store',
                type:'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: setPreload ($(".btnSave"))
           }).done(function(data){
                myNumber($('select[name="year"]').val());
                $(".btnClear").hide()
                $(".text-danger").text("");
                $("#formExpenses")[0].reset();
                $(".btnSave").html("Submit").attr("disabled", false);
                exepenseTable.ajax.reload()
           }) .fail(function (jqxHR, textStatus, errorThrown) {
               showMsg(jqxHR);
                getToast("error", "Eror", errorThrown);
                $(".btnSave").html("Submit").attr("disabled", false);
           });
      })



      $(document).on('click','.btnEdit',function(){
        $.ajax({
            url:'expenses/edit/'+$(this).val(),
            type:'GET',
        }).done(function(data){
            $("input[name='id']").val(data.id);
            $("input[name='amount']").val(data.amount);
            $("textarea[name='description']").val(data.description);
            getToast("success", "Success", "Get one record");
            $(".btnClear").show()
        }).fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $(".btnSave").html("Submit").attr("disabled", false);
        });
      })

      $(".btnClear").on('click',function(){
        $("input[name='id']").val('');
        $("#formExpenses")[0].reset();
        $(".btnClear").hide()
        getToast("info", "Cancel", "You click cancel button");
      })
   
      let startD;
      let endD;

      $('.daterange-btn').daterangepicker({
        ranges: {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
        }, function (start, end) {
            $('.daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            $("#mycard-dimiss").fadeIn(1000)
            startD=start.format('YYYY-MM-D')
            endD=end.format('YYYY-MM-D')
            // $.ajax({
            //     url:`expenses/generate-report/${start.format('YYYY-MM-D')}/${end.format('YYYY-MM-D')}`,
            //     type:'GET',
            // }).done(function(data){
            //     console.log(data);
            // }).fail(function (jqxHR, textStatus, errorThrown) {
            //     getToast("error", "Eror", errorThrown);
            // });
        });

        $(".dismiss").on('click',function(){
            $("#mycard-dimiss").fadeOut(1000)
            startD=null
            endD=null
        })

        $(".btnPrint").on('click',function(){
            let myurl = `expenses/generate-report/${startD}/${endD}/${$(this).val()}`
           if ($(this).val()=='print') {
                popupCenter({
                    url: myurl,
                    title: "Expenses",
                    w: 1400,
                    h: 800,
                });
           } else {
               window.open(myurl,'_blank')
           }
        })
       
   </script>
@endsection