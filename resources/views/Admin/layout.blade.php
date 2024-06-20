@php
    $user = \App\Models\User::where(['id' => Auth::user()->id])->first();

    if ($user->role == 1) {
        $data['menu'] = \App\Models\Menu::with('submenu')->orderBy('created_at', 'asc')->get();
    } else {
        $data['menu'] = \App\Models\Menu::whereHas('submenu', function ($query) use ($user) {
            $query->whereHas('access', function ($query) use ($user) {
                $query->where(['user_id' => $user->id, 'view_status' => 1]);
            });
        })
            ->with([
                'submenu' => function ($query) use ($user) {
                    $query->whereHas('access', function ($query) use ($user) {
                        $query->where(['user_id' => $user->id, 'view_status' => 1]);
                    });
                },
            ])
            ->orderBy('created_at', 'asc')
            ->get();
    }
@endphp

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
    data-sidebar-image="none">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRM System - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/blinker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toatr.css') }}">
    <script src="{{ asset('assets/js/layout.js') }}" type="text/javascript"></script>
</head>

<body>
    <div class="main-wrapper">
        <div class="header header-one">
            <a href="index.html"
                class="d-inline-flex d-sm-inline-flex align-items-center d-md-inline-flex d-lg-none align-items-center device-logo">
                <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid logo2" alt="Logo">
            </a>
            <div class="main-logo d-inline float-start d-lg-flex align-items-center d-none d-sm-none d-md-none">
                <div class="logo-white">
                    <a href="index.html">
                        <img src="{{ asset('assets/img/logo-full-white.png') }}" class="img-fluid logo-blue"
                            alt="Logo">
                    </a>
                    <a href="index.html">
                        <img src="{{ asset('assets/img/logo-small-white.png') }}" class="img-fluid logo-small"
                            alt="Logo">
                    </a>
                </div>
                <div class="logo-color">
                    <a href="index.html">
                        <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid logo-blue" alt="Logo">
                    </a>
                    <a href="index.html">
                        <img src="{{ asset('assets/img/logo-small.png') }}" class="img-fluid logo-small"
                            alt="Logo">
                    </a>
                </div>
            </div>

            <a href="javascript:void(0);" id="toggle_btn">
                <span class="toggle-bars">
                    <span class="bar-icons"></span>
                    <span class="bar-icons"></span>
                    <span class="bar-icons"></span>
                    <span class="bar-icons"></span>
                </span>
            </a>


            <div class="top-nav-search">
                <form>
                    <input type="text" class="form-control" placeholder="Search here">
                    <button class="btn" type="submit"><img src="{{ asset('assets/img/icons/search.svg') }}"
                            alt="img"></button>
                </form>
            </div>


            <a class="mobile_btn" id="mobile_btn">
                <i class="fas fa-bars"></i>
            </a>


            <ul class="nav nav-tabs user-menu">

                <li class="nav-item dropdown has-arrow flag-nav">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button">
                        <img src="{{ asset('assets/img/flags/us1.png') }}" alt="flag"><span>English</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{ asset('assets/img/flags/us.png') }}" alt="flag"><span>English</span>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{ asset('assets/img/flags/fr.png') }}" alt="flag"><span>French</span>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{ asset('assets/img/flags/es.png') }}" alt="flag"><span>Spanish</span>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{ asset('assets/img/flags/de.png') }}" alt="flag"><span>German</span>
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown  flag-nav dropdown-heads">
                    <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button">
                        <i class="fe fe-bell"></i> <span class="badge rounded-pill"></span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <div class="notification-title">Notifications <a href="notifications.html">View all</a>
                            </div>
                            <a href="javascript:void(0)" class="clear-noti d-flex align-items-center">Mark all as read
                                <i class="fe fe-check-circle"></i></a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">


                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="#">Clear All</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item  has-arrow dropdown-heads ">
                    <a href="javascript:void(0);" class="win-maximize">
                        <i class="fe fe-maximize"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="user-link  nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <img src="{{ Auth::user()->image != null ? asset('images/UsersImages/' . Auth::user()->image) : asset('assets/img/profiles/avatar-07.jpg') }}"
                                alt="img" class="profilesidebar">
                            <span class="animate-circle"></span>
                        </span>
                        <span class="user-content">
                            <span
                                class="user-details">{{ strtoupper(Auth::user()->role == 1 ? 'Admin' : 'Employee') }}</span>
                            <span class="user-name">{{ ucfirst(Auth::user()->name) }}</span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilemenu">
                            <div class="subscription-menu">
                                <ul>

                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('profile_settings', encrypt(Auth::user()->id)) }}">Profile
                                            Settings</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="subscription-logout">
                                <ul>
                                    <li class="pb-0">
                                        <a class="dropdown-item" href="{{ route('auth.logout') }}">Log Out</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>

        </div>


        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    @include('Admin.partial.sidebar')
                </div>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>
        {{-- Main Wrapper ends --}}

    </div>
    {{-- Settings --}}
    @include('Admin.partial.settings')
    {{-- Settings --}}

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/theme-settings.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/script.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/pusher.js') }}"></script>
    <script src="{{ asset('assets/custom/badgetoastr.js') }}"></script>
    <script src="{{ asset('assets/custom/notification.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
</body>
@if (Session::has('success'))
    <script>
        toastr.success('{{ Session::get('success') }}');
        pushNotification();
    </script>
@endif
@if (Session::has('error'))
    <script>
        toastr.error('{{ Session::get('error') }}');
    </script>
@endif
<script>
    // end of pusher code
    let notificationURL = "{{ route('notifications') }}";
    let markedURL = "{{ route('notifications.marked') }}";
    let markedallURL = "{{ route('notifications.marked.all') }}";
    let baseURL = "{{ asset('') }}";
    let auth = "{{ Auth::user()->role }}";
    $(document).ready(function() {
        $('.loader-container').hide();
        var currentroute = "{{ Route::currentRouteName('') }}";
        $(".dynamic_sub_menu").each(function() {
            var subMenuRoute = $(this).data("route");
            if (subMenuRoute == currentroute) {
                $(this).closest('.dynamic_menu').find('ul').show();
                $(this).closest('.dynamic_menu').find('.active_link').addClass('subdrop active');
            }
        });
    });
</script>
@stack('js')

</html>
