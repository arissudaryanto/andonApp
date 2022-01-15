  <!-- Topbar Start -->
  <div class="navbar-custom">
    <div class="container-fluid">

        <ul class="list-unstyled topnav-menu float-end mb-0">

            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>

            <li>
                <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
            </li>  

            <li class="dropdown notification-list topbar-dropdown" style="margin-right: 30px">
                <a class="nav-link dropdown-toggle  waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="fe-bell noti-icon"></i>
                    <span class="badge bg-danger rounded-circle noti-icon-badge"> {{ count(notify())}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="m-0">
                           Notification
                        </h5>
                    </div>

                    <div class="slimscroll noti-scroll">
                        @forelse(notify() as $notification)
                        <a href="{{ $notification->data['url'] }}" class="dropdown-item notify-item">
                            <p class="notify-details"> {{ $notification->data['body'] }}
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </p>
                        </a>
                        @empty
                            <a class="dropdown-item notify-item"><p class="notify-details"> There are no new notifications </p></a>
                        @endforelse
                    </div>

                </div>
            </li>

            <li class="dropdown notification-list topbar-dropdown"  style="margin-right: 30px">
                <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    @if (auth()->user()->image_url != null) 
                        <img style="width: 40px;height: 40px;padding: .1rem!important;"  class="rounded-circle" src="{{ asset('storage'.auth()->user()->image_url) }}" alt="">
                    @else
                        <img style="width: 40px;height: 40px;padding: .1rem!important;"  class="rounded-circle"  src="/images/avatar.png"  />
                    @endif
                    <span class="pro-user-name ms-1">
                        {{ ucwords(strtolower(auth()->user()->name)) }} <i class="mdi mdi-chevron-down"></i> 
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                    <!-- item-->
                    <div href="javascript:void(0);"  class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="{{ route('setting.profile.change_profile') }}" class="dropdown-item notify-item">
                        <i class="ri-account-circle-line"></i>
                        <span>Pengaturan Akun</span>
                    </a>

                    <a href="{{ route('setting.profile.change_password') }}" class="dropdown-item notify-item">
                        <i class="ri-account-circle-line"></i>
                        <span>Ganti Password</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                        <i class="ri-logout-box-line"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </li>
           
        </ul>

        <div class="clearfix"></div>
    </div>
</div>
<!-- end Topbar -->
