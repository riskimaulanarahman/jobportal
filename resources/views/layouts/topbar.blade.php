<header id="page-topbar" class="isvertical-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/images/logo-dark-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('assets/images/logo-dark-sm.png') }}" alt="" height="22">
                    </span>
                </a>

                <a href="index" class="logo logo-light">
                    <span class="logo-lg">
                        <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/images/logo-light-sm.png') }}" alt="" height="22">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn topnav-hamburger">
                <span class="hamburger-icon open">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <div class="d-none d-sm-block ms-3 align-self-center">
                <h4 class="page-title">@yield('pagetitle')</h4>
            </div>

        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user" id="page-header-user-dropdown-v" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: flex; align-items: center;">
                    <p class="font-size-11 text-muted" style="margin: 0;">{{ Auth::user()->fullname }}</p>
                    {{-- <img class="rounded-circle header-profile-user" src="@if (Auth::user()->avatar != '') 
                                                    {{ env('APP_URL') . '/public/upload/profile/' . Auth::user()->avatar }} 
                                                @else 
                                                    {{ asset('upload/profile/unnamed.jpg') }} 
                                                @endif" 
                         alt="Header Avatar" style="margin-left: 10px;">  --}}
                         <!-- Adding some right margin -->
                    
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="px-3 pt-3">
                        <h6 class="mb-0"></h6>
                        <p class="mb-0 font-size-11 text-muted"><b>{{ Auth::user()->fullname }}</b></p>
                    </div>
                    <div class="px-3 pt-2 pb-3 border-bottom">
                        <h6 class="mb-0"></h6>
                        <p class="mb-0 font-size-11 text-muted">{{ Auth::user()->email }}</p>
                    </div>
                    <a class="dropdown-item" href="#"><i
                            class="mdi mdi-lifebuoy text-muted font-size-16 align-middle me-1"></i> <span
                            class="align-middle" data-bs-toggle="modal" data-bs-target=".bs-modal-panduan">Help</span></a>
                    <a class="dropdown-item " href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                            key="t-logout">@lang('translation.Logout')</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle" id="right-bar-toggle-v">
                    <i class="icon-sm" data-eva="settings-outline"></i>
                </button>
            </div>

            
        </div>
    </div>
</header>
