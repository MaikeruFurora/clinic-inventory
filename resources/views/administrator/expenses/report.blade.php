<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>@yield('title')</title>
        {{-- <link rel="shortcut icon" href="{{ asset('assets/images/logos.png') }}"> --}}
        <!-- General CSS Files -->
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
        <!-- CSS Libraries -->
      
    </head>
    <body onload="window.print()">
        @php
            $total=0;
        @endphp
        <div class="invoice">
            <div class="invoice-print">
              <div class="row">
                <div class="col-lg-12">
                  <div class="invoice-title">
                    <h2>Expenses</h2>
                    <div class="invoice-number" style="font-size: 13px">
                      Date Generated: {{ date("F d, Y") }} <br>
                      Date from-to: {{ $startDate }} - {{ $endDate }}
                    </div>
                  </div>
                  <hr>
               
                </div>
              </div>
        
              <div class="row">
                <div class="col-md-12">
                  <div class="section-title">Summary</div>
                  <p class="section-lead">All items here cannot be deleted.</p>
                  <div class="table-responsive">
                    <table class="table table-striped  table-bordered table-sm" style="font-size: 10px">
                      <tr>
                        <th data-width="40">#</th>
                        <th>Description</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Added By</th>
                      </tr>
                      @foreach ($data as $key =>$item)  
                      @php
                          $total+=$item->amount
                      @endphp    
                      <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="text-center">&#8369; {{ $item->amount }}.00</td>
                        <td class="text-center">{{ $item->fullname }}</td>
                      </tr>
                      @endforeach
                      <tr>
                        <td colspan="2"><b>Total</b></td>
                        <td class="text-center"><b>&#8369; {{ $total }}.00</b></td>
                      </tr>
                    </table>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/bundles/lib.vendor.bundle.js') }}"></script>
    <script src="{{ asset('assets/modules/toast/iziToast.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/global.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    </body>

<!-- blank.html  Tue, 07 Jan 2020 03:35:42 GMT -->
</html>