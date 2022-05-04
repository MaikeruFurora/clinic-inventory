<!-- Start app top navbar -->
<nav class="navbar navbar-expand-lg navbar-fixed main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars" style=""></i></a>
            </li>
        </ul>
    </form>
  
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <span class="badge badge-info pb-1 pt-1" style="font-size: 13px">{{ ucfirst(auth()->user()->user_type) }}</span>
                &nbsp;&nbsp;
                <img alt="image" src="{{ asset('assets/img/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">
                    Hi, {{ auth()->user()->fullname }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
               
                <a href="{{ route('auth.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>
</nav>