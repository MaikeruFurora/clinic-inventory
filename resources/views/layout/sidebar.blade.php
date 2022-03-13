 <!-- Start main left sidebar menu -->
 <div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('administrator.dashboard') }}">INVENTORY</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('administrator.dashboard') }}">IN</a>
        </div>
        @php
        $list = [
            'Main' => array(
                'Dashboard' => array(
                    'href' => 'administrator.dashboard',
                    'icon' => 'fas fa-fire',
                    'name' => 'dashboard'
                )
            ),
            'Management' =>array(
                'Patient'=>array(
                    "href" => 'administrator.patient',
                    "icon" => 'fas fa-user-injured',
                    'name' => 'patient'
                ),

                'Users'=>array(
                    "href" => 'administrator.user',
                    "icon" => 'fas fa-users',
                    'name' => 'user'
                )
            ),
            'Inventory' =>array(
                'Medicine'=>array(
                    "href" => 'administrator.medicine',
                    "icon" => 'fas fa-pills',
                    'name' => 'medicine'
                ),

                'Equipment'=>array(
                    "href" => 'administrator.equipment',
                    "icon" => 'fab fa-accessible-icon',
                    'name' => 'equipment'
                ),
                'Expenses'=>array(
                    "href" => 'administrator.expenses',
                    "icon" => 'fas fa-hand-holding-usd',
                    'name' => 'expenses'
                )
            )
        ]
        @endphp
        <ul class="sidebar-menu">
            @foreach ($list as $key => $item1)
            <li class="menu-header text-primary">{{ $key }}</li>
            @foreach ($item1 as $sub_key => $item2)
                <li class="{{ Request::segment(2)==$item2['name'] ? 'active' : '' }}">
                    <a href="{{ route($item2['href']) }}" class="nav-link">
                        <i style="font-size: 15px" class="{{ $item2['icon'] }}"></i>
                        <span> {{ $sub_key }}</span>
                    </a>
                </li>
            @endforeach
        @endforeach 
        <li><a class="nav-link text-danger" href="{{ route('auth.logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                @csrf
            </form>   
            </ul>
      
    </aside>
</div>