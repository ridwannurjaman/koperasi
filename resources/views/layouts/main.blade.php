<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

<body class="fixed-header dashboard">
    @include('layouts.sidebar')
    <div class="page-container ">
        <div class="header ">
            <!-- START MOBILE SIDEBAR TOGGLE -->
            <a href="#" class="btn-link toggle-sidebar d-lg-none pg-icon btn-icon-link" data-toggle="sidebar">
                menu</a>
            <!-- END MOBILE SIDEBAR TOGGLE -->
            <div class="">
                <div class="brand inline   ">
                    <img src="{{ asset('/assets/img/logo.png') }}" alt="logo"
                        data-src="{{ asset('/assets/img/logo.png') }}"
                        data-src-retina="{{ asset('/assets/img/logo_2x.png') }}" width="78" height="22">
                </div>
            </div>
            <div class="d-flex align-items-center">
                <!-- START User Info-->
                <div class="dropdown pull-right d-lg-block d-none">
                    <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" aria-label="profile dropdown">
                        <span class="thumbnail-wrapper d32 circular inline">
                            <img src="{{ asset('/assets/img/profiles/avatar.jpg') }}" alt=""
                                data-src="{{ asset('/assets/img/profiles/avatar.jpg') }}"
                                data-src-retina="{{ asset('/assets/img/profiles/avatar_small2x.jpg') }}" width="32"
                                height="32">
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                        <a href="#" class="dropdown-item"><span>Signed in as {{ Auth::user()->name }}

                                <br /><b>{{ Auth::user()->username }}</b></span></a>
                        <div class="dropdown-divider"></div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                        <div class="dropdown-divider"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content-wrapper">
            <div class="content m-3">
                @yield('content')
            </div>
            {{-- Footer --}}
            <div class=" container-fluid  container-fixed-lg footer">
                <div class="copyright sm-text-center">
                    <p class="small-text no-margin pull-left sm-pull-reset">
                        ©2022
                        <span class="hint-text m-l-15">Koperasi</span>
                    </p>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>


    @include('layouts.footer')
</body>

</html>
