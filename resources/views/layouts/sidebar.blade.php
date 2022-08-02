<nav class="page-sidebar" data-pages="sidebar">

    <div class="sidebar-header">
        <img src="{{ asset('/assets/img/logo_white.png') }}" alt="logo" class="brand"
            data-src="{{ asset('/assets/img/logo_white.png') }}"
            data-src-retina="{{ asset('/assets/img/logo_white_2x.png') }}" width="78" height="22">
        <div class="sidebar-header-controls">
            {{-- <button aria-label="Toggle Drawer" type="button"
                class="btn btn-icon-link invert sidebar-slide-toggle m-l-20 m-r-10" data-pages-toggle="#appMenu">
                <i class="pg-icon">chevron_down</i>
            </button> --}}
            <button aria-label="Pin Menu" type="button"
                class="btn btn-icon-link invert d-lg-inline-block d-xlg-inline-block d-md-inline-block d-sm-none d-none"
                data-toggle-pin="sidebar">
                <i class="pg-icon"></i>
            </button>
        </div>
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->
    <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
            <li>
                <a href="{{ route('home') }}" class="detailed">
                    <span class="title">Dashboard</span>
                </a>
                <span class="icon-thumbnail"><i class="pg-icon">home</i></span>
            </li>
            <li>
                <a href="{{ route('kasir.home') }}" class="detailed">
                    <span class="title">Kasir</span>
                </a>
                <span class="icon-thumbnail"><i class="pg-icon">KS</i></span>
            </li>
            {{-- <li>
                <a href="{{ route('retur.home') }}" class="detailed">
                    <span class="title">Retur</span>
                </a>
                <span class="icon-thumbnail"><i class="pg-icon">RT</i></span>
            </li> --}}
            <li>
                <a href="{{ route('simpan_pinjam.home') }}" class="detailed">
                    <span class="title">Simpan Pinjam</span>
                </a>
                <span class="icon-thumbnail"><i class="pg-icon">SP</i></span>
            </li>

            <li>
                <a href="javascript:;"><span class="title">Data Master</span>
                    <span class=" arrow"></span></a>
                <span class="icon-thumbnail"><i class="pg-icon">database</i></span>
                <ul class="sub-menu">
                    <li class="">
                        <a href="{{ route('anggota.home') }}">Anggota</a>
                        <span class="icon-thumbnail"><i class="pg-icon">users</i></span>
                    </li>
                    <li class="">
                        <a href="{{ route('jabatan.home') }}">Jabatan</a>
                        <span class="icon-thumbnail"><i class="pg-icon">J</i></span>
                    </li>
                    <li class="">
                        <a href="{{ route('divisi.home') }}">Divisi</a>
                        <span class="icon-thumbnail"><i class="pg-icon">D</i></span>
                    </li>
                    <li class="">
                        <a href="{{ route('barang.home') }}">Barang</a>
                        <span class="icon-thumbnail"><i class="pg-icon">B</i></span>
                    </li>
                    <li class="">
                        <a href="{{ route('kategori.home') }}">Kategori Barang</a>
                        <span class="icon-thumbnail"><i class="pg-icon">KB</i></span>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"><span class="title">Laporan</span>
                    <span class=" arrow"></span></a>
                <span class="icon-thumbnail"><i class="pg-icon">LP</i></span>
                <ul class="sub-menu">
                    <li class="">
                        <a href="{{ route('transaksi.home') }}">Laporan Transaksi</a>
                        <span class="icon-thumbnail"><i class="pg-icon">LT</i></span>
                    </li>
                    <li class="">
                        <a href="{{ route('retur.laporan_barang') }}">Laporan Retur</a>
                        <span class="icon-thumbnail"><i class="pg-icon">LR</i></span>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
</nav>
