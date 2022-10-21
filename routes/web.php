<?php

use App\Http\Controllers\Aktivitas\LaporanAkhirDosenDplController;
use App\Http\Controllers\Aktivitas\LaporanAkhirMahasiswaController;
use App\Http\Controllers\Aktivitas\LogBookHarianController;
use App\Http\Controllers\Aktivitas\LogBookMingguanController;
use App\Http\Controllers\Aktivitas\PenilaianDosenDplController;
use App\Http\Controllers\Aktivitas\RegistrasiMbkmController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Identitas\IdentitasUniversitasController;
use App\Http\Controllers\Masters\BabPenilaianController;
use App\Http\Controllers\Masters\FakultasController;
use App\Http\Controllers\Masters\JenjangController;
use App\Http\Controllers\Masters\JurusanController;
use App\Http\Controllers\Masters\KelasController;
use App\Http\Controllers\Masters\MitraController;
use App\Http\Controllers\Masters\PenilaianController;
use App\Http\Controllers\Masters\PilihanPenilaianController;
use App\Http\Controllers\Masters\ProgramController;
use App\Http\Controllers\Masters\SemesterController;
use App\Http\Controllers\Masters\TahunAjaranController;
use App\Http\Controllers\Pengguna\AdminController;
use App\Http\Controllers\Pengguna\DosenDplController;
use App\Http\Controllers\Pengguna\MahasiswaController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ControllerLoginDashboard;
use App\Http\Controllers\Laporan\LaporanRegistrasiController;
use App\Http\Controllers\Masters\KontenlandingController;

/* -------------------------------------------------------------------------- */
/*                               Front Routes                               */
/* -------------------------------------------------------------------------- */

Route::get('/', [LandingPageController::class, 'index'])->name('show');
Route::get('/daftar/store', [LandingPageController::class, 'storemhs']);
/*Route::get('/', function () {
    return redirect()->route('dashboard');
});
*/
Route::get('check-php-version', function () {
    return phpinfo();
});

/* -------------------------------------------------------------------------- */
/*                               Backend Routes                               */
/* -------------------------------------------------------------------------- */

// login dashboard
Route::post('/logins', [ControllerLoginDashboard::class, 'login']);

Route::prefix('dashboard')->middleware(['auth:admin,mahasiswa,dosen'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Route::middleware(['auth:mahasiswa'])->group(function () {
    //     Route::get('/');
    // });

    Route::middleware(['auth:admin'])->group(function () {
        Route::prefix('identitas-universitas')->group(function () {
            Route::get('/', [IdentitasUniversitasController::class, 'index'])->name('identitas_universitas.index');
            Route::get('create', [IdentitasUniversitasController::class, 'create'])->name('identitas_universitas.create');
            Route::post('store', [IdentitasUniversitasController::class, 'store'])->name('identitas_universitas.store');
            Route::get('edit/{id}', [IdentitasUniversitasController::class, 'edit'])->name('identitas_universitas.edit');
            Route::put('update/{id}', [IdentitasUniversitasController::class, 'update'])->name('identitas_universitas.update');
            Route::delete('destroy/{id}', [IdentitasUniversitasController::class, 'destroy'])->name('identitas_universitas.destroy');
        });

        Route::prefix('pengguna')->group(function () {
            Route::prefix('admin')->group(function () {
                Route::get('/', [AdminController::class, 'index'])->name('pengguna.admin.index');
                Route::get('create', [AdminController::class, 'create'])->name('pengguna.admin.create');
                Route::post('store', [AdminController::class, 'store'])->name('pengguna.admin.store');
                Route::get('edit/{id}', [AdminController::class, 'edit'])->name('pengguna.admin.edit');
                Route::put('update/{id}', [AdminController::class, 'update'])->name('pengguna.admin.update');
                Route::delete('destroy/{id}', [AdminController::class, 'destroy'])->name('pengguna.admin.destroy');
            });

            Route::prefix('dosen')->group(function () {
                Route::get('/', [DosenDplController::class, 'index'])->name('pengguna.dosen.index');
                Route::get('create', [DosenDplController::class, 'create'])->name('pengguna.dosen.create');
                Route::post('store', [DosenDplController::class, 'store'])->name('pengguna.dosen.store');
                Route::get('detail/{id}', [DosenDplController::class, 'show'])->name('pengguna.dosen.show');
                Route::get('edit/{id}', [DosenDplController::class, 'edit'])->name('pengguna.dosen.edit');
                Route::put('update/{id}', [DosenDplController::class, 'update'])->name('pengguna.dosen.update');
                Route::delete('destroy/{id}', [DosenDplController::class, 'destroy'])->name('pengguna.dosen.destroy');
            });

            Route::prefix('mahasiswa')->group(function () {
                Route::get('/', [MahasiswaController::class, 'index'])->name('pengguna.mahasiswa.index');
                Route::get('/create', [MahasiswaController::class, 'create'])->name('pengguna.mahasiswa.create');
                Route::get('/upload', [MahasiswaController::class, 'uploadView'])->name('pengguna.mahasiswa.upload_view');
                Route::post('/upload', [MahasiswaController::class, 'upload'])->name('pengguna.mahasiswa.upload');
                Route::post('/store', [MahasiswaController::class, 'store'])->name('pengguna.mahasiswa.store');
                Route::get('/detail/{id}', [MahasiswaController::class, 'show'])->name('pengguna.mahasiswa.show');
                Route::get('/edit/{id}', [MahasiswaController::class, 'edit'])->name('pengguna.mahasiswa.edit');
                Route::put('/update/{id}', [MahasiswaController::class, 'update'])->name('pengguna.mahasiswa.update');
                Route::delete('/destroy/{id}', [MahasiswaController::class, 'destroy'])->name('pengguna.mahasiswa.destroy');
            });
        });

        Route::prefix('master')->group(function () {
            Route::prefix('laporan')->group(function () {
                Route::get('/registrasi', [LaporanRegistrasiController::class, 'index'])->name('laporan.registrasi.index');
            });

            Route::prefix('jenjang')->group(function () {
                Route::get('/', [JenjangController::class, 'index'])->name('jenjang.index');
                Route::get('create', [JenjangController::class, 'create'])->name('jenjang.create');
                Route::post('store', [JenjangController::class, 'store'])->name('jenjang.store');
                Route::get('edit/{id}', [JenjangController::class, 'edit'])->name('jenjang.edit');
                Route::put('update/{id}', [JenjangController::class, 'update'])->name('jenjang.update');
                Route::delete('destroy/{id}', [JenjangController::class, 'destroy'])->name('jenjang.destroy');
            });

            Route::prefix('fakultas')->group(function () {
                Route::get('/', [FakultasController::class, 'index'])->name('fakultas.index');
                Route::get('create', [FakultasController::class, 'create'])->name('fakultas.create');
                Route::post('store', [FakultasController::class, 'store'])->name('fakultas.store');
                Route::get('edit/{id}', [FakultasController::class, 'edit'])->name('fakultas.edit');
                Route::put('update/{id}', [FakultasController::class, 'update'])->name('fakultas.update');
                Route::delete('destroy/{id}', [FakultasController::class, 'destroy'])->name('fakultas.destroy');
            });

            Route::prefix('jurusan')->group(function () {
                Route::get('/', [JurusanController::class, 'index'])->name('jurusan.index');
                Route::get('create', [JurusanController::class, 'create'])->name('jurusan.create');
                Route::post('store', [JurusanController::class, 'store'])->name('jurusan.store');
                Route::get('edit/{id}', [JurusanController::class, 'edit'])->name('jurusan.edit');
                Route::put('update/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
                Route::delete('destroy/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');
            });

            Route::prefix('kelas')->group(function () {
                Route::get('/', [KelasController::class, 'index'])->name('kelas.index');
                Route::get('create', [KelasController::class, 'create'])->name('kelas.create');
                Route::post('store', [KelasController::class, 'store'])->name('kelas.store');
                Route::get('edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
                Route::put('update/{id}', [KelasController::class, 'update'])->name('kelas.update');
                Route::delete('destroy/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');
            });

            Route::prefix('mitra')->group(function () {
                Route::get('/', [MitraController::class, 'index'])->name('mitra.index');
                Route::get('create', [MitraController::class, 'create'])->name('mitra.create');
                Route::post('store', [MitraController::class, 'store'])->name('mitra.store');
                Route::get('edit/{id}', [MitraController::class, 'edit'])->name('mitra.edit');
                Route::put('update/{id}', [MitraController::class, 'update'])->name('mitra.update');
                Route::delete('destroy/{id}', [MitraController::class, 'destroy'])->name('mitra.destroy');
            });

            Route::prefix('program')->group(function () {
                Route::get('/', [ProgramController::class, 'index'])->name('program.index');
                Route::get('create', [ProgramController::class, 'create'])->name('program.create');
                Route::post('store', [ProgramController::class, 'store'])->name('program.store');
                Route::get('edit/{id}', [ProgramController::class, 'edit'])->name('program.edit');
                Route::put('update/{id}', [ProgramController::class, 'update'])->name('program.update');
                Route::delete('destroy/{id}', [ProgramController::class, 'destroy'])->name('program.destroy');
            });

            Route::prefix('semester')->group(function () {
                Route::get('/', [SemesterController::class, 'index'])->name('semester.index');
                Route::get('create', [SemesterController::class, 'create'])->name('semester.create');
                Route::post('store', [SemesterController::class, 'store'])->name('semester.store');
                Route::get('edit/{id}', [SemesterController::class, 'edit'])->name('semester.edit');
                Route::put('update/{id}', [SemesterController::class, 'update'])->name('semester.update');
                Route::delete('destroy/{id}', [SemesterController::class, 'destroy'])->name('semester.destroy');
            });

            Route::prefix('tahun-ajaran')->group(function () {
                Route::get('/', [TahunAjaranController::class, 'index'])->name('tahun_ajaran.index');
                Route::get('create', [TahunAjaranController::class, 'create'])->name('tahun_ajaran.create');
                Route::post('store', [TahunAjaranController::class, 'store'])->name('tahun_ajaran.store');
                Route::get('edit/{id}', [TahunAjaranController::class, 'edit'])->name('tahun_ajaran.edit');
                Route::put('update/{id}', [TahunAjaranController::class, 'update'])->name('tahun_ajaran.update');
                Route::put('update-status/{id}', [TahunAjaranController::class, 'updateStatus'])->name('tahun_ajaran.update_status');
                Route::delete('destroy/{id}', [TahunAjaranController::class, 'destroy'])->name('tahun_ajaran.destroy');
            });

            Route::prefix('bab-penilaian')->group(function () {
                Route::get('/', [BabPenilaianController::class, 'index'])->name('bab_penilaian.index');
                Route::get('create', [BabPenilaianController::class, 'create'])->name('bab_penilaian.create');
                Route::post('store', [BabPenilaianController::class, 'store'])->name('bab_penilaian.store');
                Route::get('edit/{id}', [BabPenilaianController::class, 'edit'])->name('bab_penilaian.edit');
                Route::put('update/{id}', [BabPenilaianController::class, 'update'])->name('bab_penilaian.update');
                Route::put('update-status/{id}', [BabPenilaianController::class, 'updateStatus'])->name('bab_penilaian.update_status');
                Route::delete('destroy/{id}', [BabPenilaianController::class, 'destroy'])->name('bab_penilaian.destroy');
            });

            Route::prefix('penilaian')->group(function () {
                Route::get('/', [PenilaianController::class, 'index'])->name('penilaian.index');
                Route::get('create', [PenilaianController::class, 'create'])->name('penilaian.create');
                Route::get('view/{id}', [PenilaianController::class, 'show'])->name('penilaian.show');
                Route::post('store', [PenilaianController::class, 'store'])->name('penilaian.store');
                Route::get('edit/{id}', [PenilaianController::class, 'edit'])->name('penilaian.edit');
                Route::put('update/{id}', [PenilaianController::class, 'update'])->name('penilaian.update');
                Route::delete('destroy/{id}', [PenilaianController::class, 'destroy'])->name('penilaian.destroy');

                Route::get('view/{id}/create', [PilihanPenilaianController::class, 'create'])->name('penilaian.pilihan_penilaian.create');
                Route::post('view/{id}/store', [PilihanPenilaianController::class, 'store'])->name('penilaian.pilihan_penilaian.store');
                Route::get('view/{id}/pilihan/{id_pilihan}', [PilihanPenilaianController::class, 'edit'])->name('penilaian.pilihan_penilaian.edit');
                Route::put('view/{id}/pilihan/{id_pilihan}', [PilihanPenilaianController::class, 'update'])->name('penilaian.pilihan_penilaian.update');
                Route::delete('view/{id}/pilihan/{id_pilihan}', [PilihanPenilaianController::class, 'destroy'])->name('penilaian.pilihan_penilaian.destroy');
            });
            // route manajemen konten landing page
            Route::prefix('konten')->group(function () {
                Route::get('/', [KontenlandingController::class, 'index'])->name('Konten.index');
                Route::get('create', [KontenlandingController::class, 'create'])->name('Konten.create');
                Route::post('store', [KontenlandingController::class, 'store'])->name('Konten.store');
                Route::get('edit/{id}', [KontenlandingController::class, 'edit'])->name('Konten.edit');
                Route::put('update/{id}', [KontenlandingController::class, 'update'])->name('Konten.update');
                Route::put('update-status/{id}', [KontenlandingController::class, 'updateStatus'])->name('Konten.update_status');
                Route::get('view/{id}', [KontenlandingController::class, 'show'])->name('Konten.show');
                Route::delete('destroy/{id}', [KontenlandingController::class, 'destroy'])->name('Konten.destroy');
            });
        });
    });

    Route::middleware(['auth:admin,mahasiswa,dosen'])->group(function () {
        Route::prefix('aktivitas')->group(function () {
            Route::prefix('penilaian-dosen-dpl')->group(function () {
                Route::get('/', [PenilaianDosenDplController::class, 'index'])->name('aktivitas.penilaian_dosen_dpl.index');
                Route::get('/list-datatable', [PenilaianDosenDplController::class, 'listPenilaianDosenDpl'])->name('aktivitas.penilaian_dosen_dpl.create');
                Route::get('/detail/{id}', [PenilaianDosenDplController::class, 'show'])->name('aktivitas.penilaian_dosen_dpl.show');
            });

            Route::prefix('laporan-akhir')->group(function () {
                Route::prefix('mahasiswa')->group(function () {
                    Route::get('/get-by-registrasi-id/{id}', [LaporanAkhirMahasiswaController::class, 'getByRegistrasiId'])->name('aktivitas.laporan_akhir.mahasiswa.get_by_registrasi_id');
                    Route::get('/', [LaporanAkhirMahasiswaController::class, 'index'])->name('aktivitas.laporan_akhir.mahasiswa.index');
                    Route::get('/list-datatable', [LaporanAkhirMahasiswaController::class, 'listLaporanAkhirMahasiswa'])->name('aktivitas.laporan_akhir.mahasiswa.listLaporanAkhirMahasiswa');
                    Route::get('/detail/{id}', [LaporanAkhirMahasiswaController::class, 'show'])->name('aktivitas.laporan_akhir.mahasiswa.detail');
                    Route::post('/validate/{id}', [LaporanAkhirMahasiswaController::class, 'validatemahasiswa'])->name('aktivitas.laporan_akhir.mahasiswa.validatemahasiswa');
                });
            });

            Route::prefix('logbook')->group(function () {
                Route::prefix('harian')->group(function () {
                    Route::get('/', [LogBookHarianController::class, 'index'])->name('aktivitas.logbook.harian.index');
                    Route::get('/list-datatable', [LogBookHarianController::class, 'listLogHarianDatatable'])->name('aktivitas.logbook.harian.listlogharian');
                    Route::get('/detail/{id}', [LogBookHarianController::class, 'show'])->name('aktivitas.logbook.harian.detail');
                });

                Route::prefix('mingguan')->group(function () {
                    Route::get('/', [LogBookMingguanController::class, 'index'])->name('aktivitas.logbook.mingguan.index');
                    Route::get('/list-datatable', [LogBookMingguanController::class, 'listLogMingguanDatatable'])->name('aktivitas.logbook.mingguan.listlogmingguan');
                    Route::get('/list-all', [LogBookMingguanController::class, 'listLogMingguan'])->name('aktivitas.logbook.mingguan.listlogmingguan.all');
                    Route::get('/detail/{id}', [LogBookMingguanController::class, 'show'])->name('aktivitas.logbook.mingguan.detail');
                });
            });


            Route::prefix('registrasi-mbkm')->group(function () {
                Route::get('/', [RegistrasiMbkmController::class, 'index'])->name('aktivitas.registrasi_mbkm.index');
                Route::get('/list-datatable', [RegistrasiMbkmController::class, 'listRegistrasiDatatable'])->name('aktivitas.registrasi_mbkm.listregistrasi');
                Route::get('/list-all', [RegistrasiMbkmController::class, 'listRegistrasiAll'])->name('aktivitas.registrasi_mbkm.list_registrasi_all');
                Route::get('/create', [RegistrasiMbkmController::class, 'create'])->name('aktivitas.registrasi_mbkm.create');
                Route::get('/detail/{id}', [RegistrasiMbkmController::class, 'show'])->name('aktivitas.registrasi_mbkm.show');
                Route::get('/edit/{id}', [RegistrasiMbkmController::class, 'edit'])->name('aktivitas.registrasi_mbkm.edit');
                Route::get('/form-upload-file/{id}', [RegistrasiMbkmController::class, 'formUploadFile'])->name('aktivitas.registrasi_mbkm.form_upload_file');
                Route::post('/store-upload-file', [RegistrasiMbkmController::class, 'storeUploadFile'])->name('aktivitas.registrasi_mbkm.store_upload_file');
                Route::delete('/destroy/{id}', [RegistrasiMbkmController::class, 'destroy'])->name('aktivitas.registrasi_mbkm.destroy');
                Route::post('/validate-registrasi/{id}', [RegistrasiMbkmController::class, 'validasiRegistrasi'])->name('aktivitas.registrasi_mbkm.validasi_registrasi');
                Route::post('/accept-reject-registrasi/{id}', [RegistrasiMbkmController::class, 'acceptRejectRegistrasi'])->name('aktivitas.registrasi_mbkm.accept_reject_registrasi');
            });
        });
    });

    Route::middleware(['auth:admin,dosen'])->group(function () {
        Route::prefix('aktivitas')->group(function () {
            Route::prefix('logbook')->group(function () {
                Route::post('/harian/validate/{id}', [LogBookHarianController::class, 'validateLogbook'])->name('aktivitas.logbook.harian.validate.action');
                Route::post('/mingguan/validate/{id}', [LogBookMingguanController::class, 'validateLogbook'])->name('aktivitas.logbook.mingguan.validate.action');
            });

            Route::prefix('laporan-akhir')->group(function () {
                Route::prefix('dosen-dpl')->group(function () {
                    Route::get('/', [LaporanAkhirDosenDplController::class, 'index'])->name('aktivitas.laporan_akhir.dosen_dpl.index');
                    Route::get('/list-datatable', [LaporanAkhirDosenDplController::class, 'listLaporanAkhirDosenDpl'])->name('aktivitas.laporan_akhir.dosen_dpl.listLaporanAkhirDosenDpl');
                    Route::get('/create', [LaporanAkhirDosenDplController::class, 'create'])->name('aktivitas.laporan_akhir.dosen_dpl.create');
                    Route::post('/store', [LaporanAkhirDosenDplController::class, 'store'])->name('aktivitas.laporan_akhir.dosen_dpl.store');
                    Route::get('/edit/{id}', [LaporanAkhirDosenDplController::class, 'edit'])->name('aktivitas.laporan_akhir.dosen_dpl.edit');
                    Route::get('/print/{id}', [LaporanAkhirDosenDplController::class, 'print'])->name('aktivitas.laporan_akhir.dosen_dpl.print');
                    Route::put('/update/{id}', [LaporanAkhirDosenDplController::class, 'update'])->name('aktivitas.laporan_akhir.dosen_dpl.update');
                    Route::delete('/destroy/{id}', [LaporanAkhirDosenDplController::class, 'destroy'])->name('aktivitas.laporan_akhir.dosen_dpl.destroy');
                });
            });

            Route::prefix('aktivitas')->group(function () {
                Route::prefix('penilaian-dosen-dpl')->group(function () {
                    Route::get('/create', [PenilaianDosenDplController::class, 'create'])->name('aktivitas.penilaian_dosen_dpl.create');
                    Route::post('/store', [PenilaianDosenDplController::class, 'store'])->name('aktivitas.penilaian_dosen_dpl.store');
                    Route::post('/penilaian/{id}', [PenilaianDosenDplController::class, 'storePenilaian'])->name('aktivitas.penilaian_dosen_dpl.store_penilaian');
                    Route::get('/edit/{id}', [PenilaianDosenDplController::class, 'edit'])->name('aktivitas.penilaian_dosen_dpl.edit');
                    Route::put('/update/{id}', [PenilaianDosenDplController::class, 'update'])->name('aktivitas.penilaian_dosen_dpl.update');
                    Route::delete('/destroy/{id}', [PenilaianDosenDplController::class, 'destroy'])->name('aktivitas.penilaian_dosen_dpl.destroy');
                    Route::post('/validate-penilaian/{id}', [PenilaianDosenDplController::class, 'validasiPenilaian'])->name('aktivitas.penilaian_dosen_dpl.validasi_penilaian');
                });
            });
        });
    });

    Route::middleware(['auth:admin,mahasiswa'])->group(function () {
        Route::prefix('aktivitas')->group(function () {
            Route::prefix('logbook')->group(function () {
                Route::prefix('harian')->group(function () {
                    Route::get('/create', [LogBookHarianController::class, 'create'])->name('aktivitas.logbook.harian.create');
                    Route::post('/store', [LogBookHarianController::class, 'store'])->name('aktivitas.logbook.harian.store');
                    Route::get('/edit/{id}', [LogBookHarianController::class, 'edit'])->name('aktivitas.logbook.harian.edit');
                    Route::put('/update/{id}', [LogBookHarianController::class, 'update'])->name('aktivitas.logbook.harian.update');
                    Route::delete('/destroy/{id}', [LogBookHarianController::class, 'destroy'])->name('aktivitas.logbook.harian.destroy');
                });

                Route::prefix('mingguan')->group(function () {
                    Route::get('/create', [LogBookMingguanController::class, 'create'])->name('aktivitas.logbook.mingguan.create');
                    Route::post('/store', [LogBookMingguanController::class, 'store'])->name('aktivitas.logbook.mingguan.store');
                    Route::get('/edit/{id}', [LogBookMingguanController::class, 'edit'])->name('aktivitas.logbook.mingguan.edit');
                    Route::put('/update/{id}', [LogBookMingguanController::class, 'update'])->name('aktivitas.logbook.mingguan.update');
                    Route::delete('/destroy/{id}', [LogBookMingguanController::class, 'destroy'])->name('aktivitas.logbook.mingguan.destroy');
                });
            });

            Route::prefix('laporan-akhir')->group(function () {
                Route::prefix('mahasiswa')->group(function () {
                    Route::get('/create', [LaporanAkhirMahasiswaController::class, 'create'])->name('aktivitas.laporan_akhir.mahasiswa.create');
                    Route::post('/store', [LaporanAkhirMahasiswaController::class, 'store'])->name('aktivitas.laporan_akhir.mahasiswa.store');
                    Route::get('/edit/{id}', [LaporanAkhirMahasiswaController::class, 'edit'])->name('aktivitas.laporan_akhir.mahasiswa.edit');
                    Route::put('/update/{id}', [LaporanAkhirMahasiswaController::class, 'update'])->name('aktivitas.laporan_akhir.mahasiswa.update');
                    Route::delete('/destroy/{id}', [LaporanAkhirMahasiswaController::class, 'destroy'])->name('aktivitas.laporan_akhir.mahasiswa.destroy');
                    // Route::get('/get-data-laporan-akhir', [LaporanAkhirMahasiswaController::class, 'getDataLaporanAkhir'])->name('get-data-laporan-akhir');
                    // Route::get('/get-data-laporan-akhir_detail/{id}', [LaporanAkhirMahasiswaController::class, 'getDataLaporanAkhirDetail'])->name('get-data-laporan-akhir_detail');
                });
            });
        });
    });
});

/* -------------------------------------------------------------------------- */
/*                         Laravel File Manager Routes                        */
/* -------------------------------------------------------------------------- */

/* -------------------- Laravel File Manager Main Routes -------------------- */
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


/* -------------------------------------------------------------------------- */
/*                         Laravel Registrasi MBKM Routes                        */
/* -------------------------------------------------------------------------- */

/* -------------------- Laravel Registrasi MBKM Routes  Main Routes -------------------- */
Route::prefix('daftar')->group(function () {
    Route::get('/mh2s', function () {
        // Matches The "/admin/users" URL
    });
    Route::get('/mhs', [LandingPageController::class, 'daftarmhs'])->name('daftarmhs');
    Route::post('/store', [LandingPageController::class, 'storemhs'])->name('daftarmhs.store');

    //Route::post('store', [IdentitasUniversitasController::class, 'store'])->name('identitas_universitas.store');
});


require __DIR__ . '/auth.php';
