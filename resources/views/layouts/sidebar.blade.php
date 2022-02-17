<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="ion-close"></i>
    </button>

    <div class="left-side-logo d-block d-lg-none">
        <div class="text-center">
            <a href="#" class="logo"><img src="{{ asset('assets/images/logos.png') }}" height="40" alt="logo"></a>
        </div>
    </div>

    <div class="sidebar-inner slimscrollleft">
        
        @php
        $list =[
            'Main' => array(
                'Dashboard' => array(
                    'href' => 'administrator.dashboard',
                    'icon' => 'dripicons-meter'
                )
            ),
            'Management' =>array(
                'Patient'=>array(
                    "href" => 'administrator.patient',
                    "icon" => 'dripicons-user',
                ),

                'Users'=>array(
                    "href" => 'administrator.user',
                    "icon" => 'dripicons-user-group',
                )
            ),
            'Inventory' =>array(
                'Medicine'=>array(
                    "href" => 'administrator.medicine',
                    "icon" => 'dripicons-medical',
                ),

                'Equipment'=>array(
                    "href" => 'administrator.expenses',
                    "icon" => 'mdi mdi-wheelchair-accessibility',
                ),
                'Daily Expenses'=>array(
                    "href" => 'administrator.expenses',
                    "icon" => 'mdi mdi-coin',
                )
            )
        ]
    @endphp
          

        
        
        <div id="sidebar-menu">
            <ul>
                @foreach ($list as $key => $item1)
                    <li class="menu-title">{{ $key }}</li>
                    @foreach ($item1 as $sub_key => $item2)
                       <li>
                        <a href="{{ route($item2['href']) }}" class="waves-effect">
                            <i class="{{ $item2['icon'] }}"></i>
                            <span> {{ $sub_key }}</span>
                        </a>
                    </li>
                    @endforeach
                @endforeach
                

             

                {{-- <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-graph-pie"></i><span> Charts </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="charts-morris.html">Morris Chart</a></li>
                        <li><a href="charts-chartist.html">Chartist Chart</a></li>
                        <li><a href="charts-chartjs.html">Chartjs Chart</a></li>
                        <li><a href="charts-flot.html">Flot Chart</a></li>
                        <li><a href="charts-c3.html">C3 Chart</a></li>
                        <li><a href="charts-other.html">Jquery Knob Chart</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-list"></i><span> Tables </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="tables-basic.html">Basic Tables</a></li>
                        <li><a href="tables-datatable.html">Data Table</a></li>
                        <li><a href="tables-responsive.html">Responsive Table</a></li>
                        <li><a href="tables-editable.html">Editable Table</a></li>
                    </ul>
                </li>

                <li class="menu-title">Extra</li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-location"></i><span> Maps </span> <span class="badge badge-danger badge-pill float-right">2</span></a>
                    <ul class="list-unstyled">
                        <li><a href="maps-google.html"> Google Map</a></li>
                        <li><a href="maps-vector.html"> Vector Map</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-brightness-max"></i> <span> Icons </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="icons-material.html">Material Design</a></li>
                        <li><a href="icons-ion.html">Ion Icons</a></li>
                        <li><a href="icons-fontawesome.html">Font Awesome</a></li>
                        <li><a href="icons-themify.html">Themify Icons</a></li>
                        <li><a href="icons-dripicons.html">Dripicons</a></li>
                        <li><a href="icons-typicons.html">Typicons Icons</a></li>
                    </ul>
                </li>

                <li>
                    <a href="calendar.html" class="waves-effect"><i class="dripicons-calendar"></i><span> Calendar </span></a>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-copy"></i><span> Pages </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="pages-blank.html">Blank Page</a></li>
                        <li><a href="pages-login.html">Login</a></li>
                        <li><a href="pages-register.html">Register</a></li>
                        <li><a href="pages-recoverpw.html">Recover Password</a></li>
                        <li><a href="pages-lock-screen.html">Lock Screen</a></li>
                        <li><a href="pages-404.html">Error 404</a></li>
                        <li><a href="pages-500.html">Error 500</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-jewel"></i><span> Extras </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="extras-pricing.html">Pricing</a></li>
                        <li><a href="extras-invoice.html">Invoice</a></li>
                        <li><a href="extras-timeline.html">Timeline</a></li>
                        <li><a href="extras-faqs.html">FAQs</a></li>
                        <li><a href="extras-maintenance.html">Maintenance</a></li>
                        <li><a href="extras-comingsoon.html">Coming Soon</a></li>
                    </ul>
                </li> --}}

            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>