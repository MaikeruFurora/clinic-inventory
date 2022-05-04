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
        <div class="invoice">
            <div class="invoice-print">
              <div class="row">
                <div class="col-lg-12">
                  <div class="invoice-title">
                    <h2>Medicine | {{ $type }}</h2>
                    <div class="invoice-number" style="font-size: 13px">
                      Date Generated: {{ date("F d, Y") }}
                    </div>
                  </div>
                  <hr>
               
                </div>
              </div>
        
              <div class="row">
                <div class="col-md-12">
                  <div class="section-title">Summary</div>
                  <p class="section-lead">Total: {{ $data->count() }}</p>
                  <div class="table-responsive">
                    <table class="table table-striped  table-bordered table-sm" style="font-size: 12px">
                      <tr>
                        <th data-width="40">#</th>
                        <th data-width="40">Medicine-Barcode</th>
                        <th>Medicine Name</th>
                        <th >Stock</th>
                        <th >Quantity</th>
                        <th >Buy Price</th>
                        <th >Sell Price</th>
                        <th >Expiration Date</th>
                      </tr>
                      @foreach ($data as $key =>$item)  
                    
                      <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->barcode }}</td>
                        <td>{{ $item->medicine_name }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>{{ $item->unit_qty }}</td>
                        <td>&#8369; {{ number_format($item->buy_price) }}</td>
                        <td>&#8369; {{ number_format($item->sell_price) }}</td>
                        <td>{{ $item->expiration_date }}</td>
                      </tr>
                      @endforeach
                     
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