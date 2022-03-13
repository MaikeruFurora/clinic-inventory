<!-- Start app top navbar -->
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars" style=""></i></a>
            </li>
        </ul>
    </form>
  
    <ul class="navbar-nav navbar-right">
    <li class="dropdown dropdown-list-toggle">
        <a class="nav-link nav-link-lg message-toggle beep">
            <span class="badge badge-success">{{ ucwords(auth()->user()->user_type) }}</span>
        </a>
    </li>
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link  nav-link-lg nav-link-user">
        {{-- <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1"> --}}
        <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->fullname }}</div></a>
    </li>
    <li class="dropdown"><a  href="{{ route('auth.logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
         class="nav-link  nav-link-lg nav-link-user">
        {{-- <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1"> --}}
        <div class="d-sm-none d-lg-inline-block"><i class="fas fa-sign-out-alt text-danger"></i></div>
        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
            @csrf
        </form>   
    </a>
   
    </li>
    </ul>
</nav>