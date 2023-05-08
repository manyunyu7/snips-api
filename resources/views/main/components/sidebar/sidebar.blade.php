@include('main.components.sidebar.left-sidebar-admin')

<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"><a class="sidebar-link sidebar-link" href="{{ URL('/home') }}"
                                            aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                            class="hide-menu">Dashboard</span></a></li>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Verifikasi NIK</span></li>

                <li class="sidebar-item active">
                    <a class="sidebar-link" href="{{ URL('nik/verification') }}" aria-expanded="false">
                        <i data-feather="tag" class="feather-icon"></i>
                        <span class="hide-menu">Lihat Verifikasi
                        </span>
                    </a>
                </li>


                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">DATA KTP</span></li>

                <li class="sidebar-item active">
                    <a class="sidebar-link" href="{{ URL('pengajuan-warga/create') }}" aria-expanded="false">
                        <i data-feather="tag" class="feather-icon"></i>
                        <span class="hide-menu">Tambah KTP
                        </span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <li class="nav-small-cap"><span class="hide-menu">Customer Service</span></li>

                <li class="sidebar-item active">
                    <a class="sidebar-link" href="{{ URL('/cs-chat/manage') }}" aria-expanded="false">
                        <i data-feather="tag" class="feather-icon"></i>
                        <span class="hide-menu">Chat
                            </span>
                    </a>
                </li>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Komplain</span></li>

                <li class="sidebar-item active">
                    <a class="sidebar-link" href="{{ URL('komplain/manage') }}" aria-expanded="false">
                        <i data-feather="tag" class="feather-icon"></i>
                        <span class="hide-menu">Lihat Komplain
                        </span>
                    </a>
                </li>
                <li class="list-divider"></li>

                <li class="nav-small-cap"><span class="hide-menu">Pengajuan BLT</span></li>


                @if(Auth::user()->role==1)
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('pengajuan-warga/all') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Semua Pengajuan
                        </span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role==1 || Auth::user()->role==4)
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('pengajuan-warga/kelurahan') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Approval Kelurahan
                        </span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role==1 || Auth::user()->role==5)
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('pengajuan-warga/kecamatan') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Approval Kecamatan
                        </span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role==1)

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('pengajuan-warga/panitia') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Approval Panitia
                        </span>
                        </a>
                    </li>
                @endif


                @if (Auth::user()->role == 1)
                    <li class="list-divider"></li>

                    <li class="nav-small-cap"><span class="hide-menu">Data Pengguna</span></li>

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('/admin/user/create') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Tambah Pengguna
                            </span>
                        </a>
                    </li>
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('/admin/user/manage') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Manage
                            </span>
                        </a>
                    </li>

                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Laporan Kesalahan Data</span></li>

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('data-fix/manage') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Lihat Laporan
                        </span>
                        </a>
                    </li>



                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">DATA KTP</span></li>

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('ktp/create') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Tambah KTP
                        </span>
                        </a>
                    </li>
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('ktp/manage') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Manage KTP
                        </span>
                        </a>
                    </li>

                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Konten</span></li>

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('news/create') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Tambah Konten
                        </span>
                        </a>
                    </li>
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('news/manage') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Manage Konten
                        </span>
                        </a>
                    </li>

                    <li class="list-divider"></li>

                    <li class="nav-small-cap"><span class="hide-menu">Kegiatan Sumbangsih</span></li>

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('/bansos-event/create') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Tambah Kegiatan
                            </span>
                        </a>
                    </li>
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('/bansos-event/manage') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Manage Kegiatan
                            </span>
                        </a>
                    </li>

                @endif

                <li class="list-divider"></li>


                <li class="nav-small-cap"><span class="hide-menu">Extra</span></li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

                <li class="sidebar-item"><a class="sidebar-link sidebar-link" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();  document.getElementById('logout-form').submit();"
                                            aria-expanded="false"><i data-feather="log-out"
                                                                     class="feather-icon"></i><span
                            class="hide-menu">Logout</span></a></li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

