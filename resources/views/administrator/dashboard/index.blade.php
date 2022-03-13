@extends('layout.app')
@section('title','Dashboard')
@section('moreCss')
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endsection
@section('content')
<section class="section">
    <h2 class="section-title">Dashboard</h2>

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i style="font-size: 30px" class="fas fa-user-shield"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Admin</h4>
              </div>
              <div class="card-body">
                {{ number_format($countAdmin->total) }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i style="font-size: 30px" class="fas fa-user-nurse"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Nurse</h4>
              </div>
              <div class="card-body">
                {{ number_format($countNurse->total) }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i style="font-size: 30px" class="fas fa-pills"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Medicine</h4>
              </div>
              <div class="card-body">
                {{ number_format($countMedicine->total) }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i style="font-size: 30px" class="fas fa-user-injured"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Patient</h4>
              </div>
              <div class="card-body">
                {{ number_format($countPatient->total) }}
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm 12">
        <div class="card ">
          <div class="card-header">
            <h4>Expenses</h4>
            <div class="card-header-action">
              <a href="{{ route('administrator.expenses') }}" class="btn btn-primary">View All</a>
            </div>
          </div>
          <div class="card-body">
                <div class="row">
                  <div class="col-sm-6 col-6 mb-md-0 mb-4 text-center">
                    <div class="mt-2 font-weight-bold text-nowrap"><h4>{{ date("Y") }}</h4></div>
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
      <div class="col-lg-8 col-md-8 col-sm 12">
          <div class="card">
            <div class="card-header">
              <h4>Patient Record Year of {{ date("Y") }}</h4>
              <div class="card-header-action">
                <a href="{{ route('administrator.patient') }}" class="btn btn-primary">View All</a>
              </div>
            </div>
            <div class="card-body">
              <canvas id="bar" height="150"></canvas>
            </div>
          </div>
      </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Latest Added Patient</h4>
                    <div class="card-header-action">
                      <a href="{{ route('administrator.patient') }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped mb-0">
                      <thead>
                        <tr>
                          <th>Patient Name</th>
                          <th>Address</th>
                        </tr>
                      </thead>
                      <tbody>
                       @foreach ($latestPatient as $item)
                            <tr>
                          <td>
                            {{ $item->firt_name. ' '. $item->last_name }}
                          </td>
                          <td>
                            {{ $item->address }}
                          </td>
                        </tr>
                       @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                  <h4>Latest Added Medicine</h4>
                  <div class="card-header-action">
                    <a href="{{ route('administrator.medicine') }}" class="btn btn-primary">View All</a>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped mb-0">
                      <thead>
                        <tr>
                          <th>Medicine</th>
                          <th>Sell Price</th>
                          <th>Expiration Date</th>
                        </tr>
                      </thead>
                      <tbody>
                       @foreach ($latestMedicine as $item)
                            <tr>
                          <td>
                            {{ $item->medicine_name }}
                          </td>
                          <td>
                            &#8369;{{ $item->sell_price }}.00
                          </td>
                          <td>
                            {{ date("F d, Y",strtotime($item->expiration_date)) }}
                          </td>
                        </tr>
                       @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card">
                <div class="card-body">
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
    
</section>
@endsection

@section('moreJs')
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/modules/chartjs/chart.min.js') }}"></script>
    <script>
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