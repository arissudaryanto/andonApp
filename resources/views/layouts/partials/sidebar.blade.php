<div class="left-side-menu">

    <!-- LOGO -->


    <div data-simplebar data-simplebar-auto-hide="true">

        <!--- Sidemenu -->
        <div id="sidebar-menu" >

            <ul id="side-menu" >

                <li>
                    <a href="{{ route('dashboard')}}" class="waves-effect">
                        <i class="fe-home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                @canany(['maintenance.self'])
                    <li>
                        <a href="{{ route('maintenance.index')}}" class="waves-effect">
                            <i class="fe-file"></i>
                            <span> Maintenance </span>
                        </a>
                    </li>
                @endcanany

                @canany(['hardware.self','area.self','category.self'])
                    <li>
                        <a href="#sidebarEmail" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarEmail">
                            <i class="fe-database"></i>
                            <span> Master </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEmail">
                            <ul class="nav-second-level">
                                @can('area.self')
                                    <li>
                                        <a href="{{ route('master.area.index')}}">Group Area</a>
                                    </li>
                                @endcan
                                @can('hardware.self')
                                    <li>
                                        <a href="{{ route('master.hardware.index')}}">Hardware</a>
                                    </li>
                                @endcan
                                @can('category.self')
                                    <li>
                                        <a href="{{ route('master.category.index')}}">Category</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['user.self','role.self','permission.self'])
                <li>
                    <a href="#sidebarForms" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="fe-settings"></i>
                        <span> Pengaturan </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarForms">
                        <ul class="nav-second-level">
                            @can('user.self')
                                <li>
                                    <a href="{{ route('setting.users.index')}}">Pengguna</a>
                                </li>
                            @endcan
                            @can('role.self')
                                <li>
                                    <a href="{{ route('setting.roles.index')}}">Group Akses</a>
                                </li>
                            @endcan
                            @can('permission.self')
                                <li>
                                    <a href="{{ route('setting.permissions.index')}}">Hak Akses</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>