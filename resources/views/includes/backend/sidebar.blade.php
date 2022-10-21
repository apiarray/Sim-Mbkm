@if (auth()->guard('mahasiswa')->check())
    @php
        $statusRegistrasi = \App\Models\Aktivitas\RegistrasiMbkm::where(
            'registrasi_mbkm.mahasiswa_id',
            auth()
                ->guard('mahasiswa')
                ->user()->id,
        )
            ->where('registrasi_mbkm.status_validasi', '=', 'tervalidasi')
            ->first();
    @endphp
@endif
<div class="sidebar-wrapper h-100">
    <nav class="sidebar-main">
        <div id="sidebar-menu">
            <ul class="sidebar-links custom-scrollbar">
                <li class="back-btn">
                    <a href="#">
                        <img class="img-fluid" src="#" alt="">
                    </a>
                    <div class="mobile-back text-right">
                        <span>Back</span>
                        <i class="fa fa-angle-right pl-2" aria-hidden="true"></i>
                    </div>
                </li>
                <li class="sidebar-main-title pt-0">
                    <div>
                        <h6>Halaman Utama

                            @if (auth()->guard('mahasiswa')->check())
                                <div>Mahasiswa</div>
                            @elseif (auth()->guard('dosen')->check())
                                Dosen
                            @else
                                Admin
                            @endif
                        </h6>
                        <p>Dashboard & Overview</p>
                    </div>
                </li>
                <li class="sidebar-list">
                    <a class="sidebar-link sidebar-title link-nav" href="{{ route('dashboard') }}">
                        <i data-feather="home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if (auth()->guard('admin')->check())
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('identitas_universitas.index') }}">
                            <i data-feather="home"></i>
                            <span>Identitas Universitas</span>
                        </a>
                    </li>
                @endif

                {{-- SIDEBAR DATA AKTIVITAS --}}
                <li class="sidebar-main-title">
                    <div>
                        <h6>Aktivitas</h6>
                        <p>Menu pembelajaran</p>
                    </div>
                </li>
                @if (auth()->guard('admin')->check() or
                    auth()->guard('mahasiswa')->check() or
                    auth()->guard('dosen')->check())
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('aktivitas.registrasi_mbkm.index') }}">
                            <i data-feather="clipboard"></i>
                            <span>Registrasi MBKM</span>
                        </a>
                        @if ((auth()->guard('mahasiswa')->check() &&
                            $statusRegistrasi != null) ||
                            auth()->guard('dosen')->check() ||
                            auth()->guard('admin')->check())
                            <a class="sidebar-link sidebar-title" href="#">
                                <i data-feather="clipboard"></i>
                                <span>Log Book</span>
                            </a>

                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('aktivitas.logbook.harian.index') }}">Log Book Harian</a></li>
                                <li><a href="{{ route('aktivitas.logbook.mingguan.index') }}">Log Book Mingguan</a></li>
                            </ul>

                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('aktivitas.laporan_akhir.mahasiswa.index') }}">
                                <i data-feather="clipboard"></i>
                                <span>Laporan Akhir Mahasiswa</span>
                            </a>
                        @endif
                    </li>

                    {{-- SIDEBAR DATA AKTIVITAS DOSEN --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Aktivitas Dosen</h6>
                            <p>Menu Aktivitas Dosen</p>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('aktivitas.penilaian_dosen_dpl.index') }}">
                            <i data-feather="clipboard"></i>
                            <span>Penilaian Dosen DPL</span>
                        </a>
                        @if (auth()->guard('dosen')->check() ||
                            auth()->guard('admin')->check())
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('aktivitas.laporan_akhir.dosen_dpl.index') }}">
                                <i data-feather="clipboard"></i>
                                <span>Laporan Akhir Dosen DPL</span>
                            </a>
                        @endif
                    </li>

                    @if (auth()->guard('admin')->check())
                        {{-- SIDEBAR DATA PENGGUNA --}}

                        <li class="sidebar-main-title">
                            <div>
                                <h6>Data Pengguna</h6>
                                <p>Menu akun admin, dosen, & mahasiswa</p>
                            </div>
                        </li>

                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('pengguna.admin.index') }}">
                                <i data-feather="users"></i>
                                <span>Akun Admin</span>
                            </a>

                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('pengguna.dosen.index') }}">
                                <i data-feather="users"></i>
                                <span>Akun Dosen</span>
                            </a>

                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('pengguna.mahasiswa.index') }}">
                                <i data-feather="users"></i>
                                <span>Akun Mahasiswa</span>
                            </a>
                        </li>

                        {{-- SIDEBAR LAPORAN --}}
                        <li class="sidebar-main-title">
                            <div>
                                <h6>LAPORAN</h6>
                                <p>Menu Laporan</p>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('laporan.registrasi.index') }}">
                                <i data-feather="users"></i>
                                <span>Laporan Registrasi</span>
                            </a>
                        </li>

                        {{-- SIDEBAR DATA MASTER --}}
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Data Master</h6>
                                <p>Menu data dasar</p>
                            </div>
                        </li>

                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="#">
                                <i data-feather="award"></i>
                                <span>Master Studi</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('jenjang.index') }}">
                                        <span>Jenjang</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('fakultas.index') }}">
                                        <span>Fakultas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('jurusan.index') }}">
                                        <span>Jurusan</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('kelas.index') }}">
                                        <span>Kelas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('semester.index') }}">
                                        <span>Semester</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('tahun_ajaran.index') }}">
                                        <span>Tahun Ajaran</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('program.index') }}">
                                        <span>Program</span>
                                    </a>
                                </li>
                            </ul>
                            <a class="sidebar-link sidebar-title" href="#">
                                <i data-feather="file"></i>
                                <span>Master Penilaian</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('bab_penilaian.index') }}">
                                        <span>Bab Penilaian</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('penilaian.index') }}">
                                        <span>Penilaian</span>
                                    </a>
                                </li>
                            </ul>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('mitra.index') }}">
                                <i data-feather="users"></i>
                                <span>Mitra</span>
                            </a>
                            <a class="sidebar-link sidebar-title" href="#">
                                <i data-feather="file"></i>
                                <span>Master Konten</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('Konten.index') }}">
                                        <span>Konten</span>
                                    </a>
                                </li>
                                <!--li>
                            <a href="{{ route('kelas.index') }}">
                                <span>Kelas</span>
                            </a>
                        </li-->
                            </ul>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
</div>
