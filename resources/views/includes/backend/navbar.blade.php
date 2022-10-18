<div class="page-header">
    <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper">
            <div class="logo-wrapper">
                <a href="index.html">
                    <img class="img-fluid" src="../assets/images/logo/logo.png" alt="">
                </a>
            </div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="sliders"></i>
            </div>
        </div>
        <div class="left-header col horizontal-wrapper pl-0">
            <ul class="horizontal-menu">
                <li class="mega-menu outside d-block d-md-none">
                    @if (Auth::guard('admin')->check())
                        <a class="nav-link" href="{{ route('logout') }}" onclick=" event.preventDefault();
                    document.getElementById('logout-form').submit();">
                            <i data-feather="log-out"></i>
                            <span>
                                Log out
                            </span>
                        </a>
                    @elseif(Auth::guard('dosen')->check())
                        <a class="nav-link" href="{{ route('logout_dosen') }}" onclick=" event.preventDefault();
                    document.getElementById('logout-form').submit();">
                            <i data-feather="log-out"></i>
                            <span>
                                Log out
                            </span>
                        </a>
                    @elseif(Auth::guard('mahasiswa')->check())
                        <a class="nav-link" href="{{ route('logout_mahasiswa') }}" onclick=" event.preventDefault();
                    document.getElementById('logout-form').submit();">
                            <i data-feather="log-out"></i>
                            <span>
                                Log out
                            </span>
                        </a>
                    @endif
                </li>
            </ul>
        </div>
        <div class="nav-right col-8 pull-right right-header p-0">
            <ul class="nav-menus">
                <li>
                    <div class="mode">
                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Dark Mode">
                            <i data-feather="moon"></i>
                        </a>
                    </div>
                </li>
                <li class="profile-nav onhover-dropdown p-0 ml-2 mr-0">
                    <div class="media profile-media">
                        @if (Auth::guard('admin')->check())
                            <img class="b-r-10" src="https://source.boringavatars.com/beam/120/{{ Auth::guard('admin')->user()->name }}?square&colors=FAD089,FF9C5B,F5634A,ED303C,3B8183" width="40px">
                        @elseif(Auth::guard('dosen')->check())
                            <img class="b-r-10" src="https://source.boringavatars.com/beam/120/{{ Auth::guard('dosen')->user()->name }}?square&colors=FAD089,FF9C5B,F5634A,ED303C,3B8183" width="40px">
                        @elseif(Auth::guard('mahasiswa')->check())
                            <img class="b-r-10" src="https://source.boringavatars.com/beam/120/{{ Auth::guard('mahasiswa')->user()->name }}?square&colors=FAD089,FF9C5B,F5634A,ED303C,3B8183" width="40px">
                        @endif

                        <div class="media-body">
                            <span>
                                @if (Auth::guard('admin')->check())
                                    {{ Auth::guard('admin')->user()->name }}
                                @elseif(Auth::guard('dosen')->check())
                                    {{ Auth::guard('dosen')->user()->nama }}
                                @elseif(Auth::guard('mahasiswa')->check())
                                    {{ Auth::guard('mahasiswa')->user()->nama }}
                                @endif
                            </span>
                            <p class="mb-0 font-roboto">
                                @if (Auth::guard('admin')->check())
                                    Pengelola
                                @elseif(Auth::guard('dosen')->check())
                                    Dosen DPL
                                @elseif(Auth::guard('mahasiswa')->check())
                                    Mahasiswa
                                @endif
                                <i class="middle fa fa-angle-down"></i>
                            </p>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li>
                            <a href="{{ route('logout') }}" onclick=" event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                <i data-feather="log-out"></i>
                                <span>Log out</span>
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
