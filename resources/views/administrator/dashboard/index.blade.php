@extends('layout.app')
@section('title','Dashboard')
@section('moreCss')
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection
@section('content')
<section class="section">
    <h2 class="section-title">Dashboard</h2>

    <div class="row">
       <div class="col-lg-4 col-md-12 col-sm-12">
          <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i style="font-size: 30px" class="fas fa-user-shield"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4 style="font-size:12px">Admin</h4>
                  </div>
                  <div class="card-body" style="font-size: 15px">
                    {{ number_format($countAdmin->total) }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i style="font-size: 30px" class="fas fa-user-nurse"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4 style="font-size:12px">Nurse</h4>
                  </div>
                  <div class="card-body" style="font-size: 15px">
                    {{ number_format($countNurse->total) }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i style="font-size: 30px" class="fas fa-pills"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4 style="font-size:12px">Medicine</h4>
                  </div>
                  <div class="card-body" style="font-size: 15px">
                    {{ number_format($countMedicine->total) }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i style="font-size: 30px" class="fas fa-user-injured"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4 style="font-size:12px">Patient</h4>
                  </div>
                  <div class="card-body" style="font-size: 15px">
                    {{ number_format($countPatient->total) }} <br>
                    <span class="badge badge-primary p-1"  style="font-size: 9px">Year: {{ date("Y") }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              {{-- expenses --}}
              <div class="card ">
                <div class="card-header">
                  <h4>Expenses</h4>
                  <div class="card-header-action">
                    <a href="{{ route('authuser.expenses') }}" class="btn btn-primary">View All</a>
                  </div>
                </div>
                <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6 col-6 mb-md-0 mb-4 text-center">
                          <div class="mt-2 font-weight-bold text-nowrap"><h5>{{ date("Y") }}</h5></div>
                          <div class="text-small text-muted"></span>Current Year</div>
                        </div>
                        <div class="col-sm-6 col-6 text-center">
                          <div class="mt-2 font-weight-bold text-nowrap"><h5 class="expense_in_a_year"></h5></div>
                          <div class="text-small text-muted">Yearly Amount</div>
                        </div>
                      </div>
                   
                    <canvas id="pie" height="10"></canvas>
                </div>
              </div>
             
              {{-- calendar --}}
              <div class="card p-0">
                <div class="card-body pb-0">
                    <div class="container-calendar">
                        <h4 id="monthAndYear"></h4>
                        <div class="button-container-calendar">
                            <button id="previous" onclick="previous()"><i class="fas fa-angle-left"></i></button>
                            <button id="next" onclick="next()"><i class="fas fa-angle-right"></i></button>
                        </div>
              
                        <table class="table-calendar" id="calendar" data-lang="en">
                            <thead id="thead-month"></thead>
                            <tbody id="calendar-body"></tbody>
                        </table>
              
                        <div class="footer-container-calendar">
                            <label for="month">Jump To: </label>
                            <select id="month" onchange="jump()">
                                <option value=0>Jan</option>
                                <option value=1>Feb</option>
                                <option value=2>Mar</option>
                                <option value=3>Apr</option>
                                <option value=4>May</option>
                                <option value=5>Jun</option>
                                <option value=6>Jul</option>
                                <option value=7>Aug</option>
                                <option value=8>Sep</option>
                                <option value=9>Oct</option>
                                <option value=10>Nov</option>
                                <option value=11>Dec</option>
                            </select>
                            <select id="year" onchange="jump()"></select>
                        </div>
                    </div>
                </div>
            </div>
            </div>
          </div>
       </div>
       <div class="col-lg-8 col-md-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Patient Record Year of {{ date("Y") }}</h4>
            <div class="card-header-action">
              <a href="{{ route('authuser.patient') }}" class="btn btn-primary">View All</a>
            </div>
          </div>
          <div class="card-body">
            <canvas id="bar" height="110"></canvas>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h4>Expired Medicine</h4>
            <div class="card-header-action">
                    <a href="{{ route('authuser.medicine') }}" class="btn btn-primary">View All</a>
                  </div>
          </div>
          <div class="card-body">
              <table id="datatable" class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Medicine Name</th>
                    <th>Stock</th>
                    <th>Quantity</th>
                    <th>Expiration Date</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($expired as $key => $item)
                      <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->medicine_name }}</td>
                        <td>{{ $item->unit_type }}</td>
                        <td>{{ $item->unit_qty }}</td>
                        <td>{{ $item->expiration_date }}</td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h4>Running out of stock Medicine</h4>
            <div class="card-header-action">
                    <a href="{{ route('authuser.medicine') }}" class="btn btn-primary">View All</a>
                  </div>
          </div>
          <div class="card-body">
              <table id="RunningOutOfStock" class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Medicine Name</th>
                    <th>Stock</th>
                    <th>Quantity</th>
                    <th>Expiration Date</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($RunningOutOfStock as $key => $item)
                      <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->medicine_name }}</td>
                        <td>{{ $item->unit_type }}</td>
                        <td>{{ $item->unit_qty }}</td>
                        <td>{{ $item->expiration_date }}</td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
   
    
</section>
@endsection

@section('moreJs')
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/modules/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>

      $("#datatable").DataTable()
      $("#RunningOutOfStock").DataTable()
      let pieGraph = JSON.parse('<?=$pieGraph?>')
      let myIndex = pieGraph.map((val,i)=>(--val.month))
      let myMonth =month.filter((val,i)=>i==myIndex[i]?val:'')
      $(".expense_in_a_year").html(
      isNullPrice(pieGraph.reduce((acc,val)=>{
          return acc+=parseInt(val.total);
      },0)))
       let pieChart = document.getElementById('pie').getContext('2d');
            new Chart(pieChart, {
                type: 'doughnut',
                data : {
                    labels:myMonth,
                    datasets: [{
                        label: 'My First Dataset',
                        data:pieGraph.map(val=>val.total),
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
                        hoverOffset: pieGraph.length
                    }]

                }
            });

            /**
             * 
             * 
             * 
             * 
            */
            let lineGraph = JSON.parse(`<?=$lineGraph?>`)
            let barChart = document.getElementById('bar').getContext('2d');
            let chartStatus = Chart.getChart("bar");
            let arrayAmount = [0,0,0,0,0,0,0,0,0,0,0,0];
            lineGraph.map((val,i)=>{
                arrayAmount[--val.month]=val.total
            })
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
                    // options: {
                    //     scales: {
                    //         yAxis: {
                    //             stepSize:0,
                    //             beginAtZero: true,
                    //             ticks: {
                    //                 // Include a dollar sign in the ticks
                    //                 callback: function(value, index, ticks) {
                    //                     return '₱ ' + value.toLocaleString();
                    //                 }
                    //             }
                    //         },
                            
                    //     }
                    // }
                });
    </script>
@endsection