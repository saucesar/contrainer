<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a  class="simple-text logo-normal">
      {{ __('Contrainer') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      @if(Auth::user()->isAdmin())
      <li class="nav-item{{ $activePage == 'admin-area' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.area') }}">
          <i class="material-icons">assessment</i>
            <p>{{ __('Admin Area') }}</p>
        </a>
      </li>
      @endif
      <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('profile.edit') }}">
          <i class="material-icons">account_circle</i>
            <span class="sidebar-normal">{{ __('User profile') }} </span>
        </a>
      </li><!--
      <li class="nav-item{{ $activePage == 'user-machines' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('user.machines') }}">
          <i class="material-icons">dvr</i>
            <span class="sidebar-normal"> {{ __('Machines') }} </span>
        </a>
      </li>-->
      <li class="nav-item{{ $activePage == 'images' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('images.index') }}">
            <i class="fab fa-docker"></i>
            <span class="sidebar-normal"> {{ __('Images') }} </span>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'my-containers' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('containers.index') }}">
            <i class="fas fa-server"></i>
            <span class="sidebar-normal"> {{ __('My Containers') }} </span>
        </a>
      </li>
      <!-- <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
          <p>{{ __('Laravel Examples') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
          </ul>
        </div>
      </li> -->
      <!-- <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('table') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Table List') }}</p>
        </a>
      </li> -->
    </ul>
  </div>
</div>
