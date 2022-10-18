<?php

namespace Database\Seeders;

use App\Models\Masters\BabPenilaian;
use App\Models\Masters\Penilaian;
use App\Models\Masters\PilihanPenilaian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BabPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama_bab' => 'Proses dan Hasil Kegiatan',
                'bobot' => '0.5',
                'soal' => [
                    [
                        'soal_penilaian' => 'Rasional rencana kegiatan',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Rasional kegiatan disusun tidak berdasarkan hasil observasi awal',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Rasional kegiatan disusun berdasarkan hasil observasi awal, sesuai dengan situasi dan kondisi mitra, namun tidak diuraikan dengan lengkap dan rinci',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Rasional kegiatan disusun berdasarkan hasil observasi awal, sesuai dengan situasi dan kondisi mitra,diuraikan lengkap dan rinci',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Rasional kegiatan disusun berdasarkan hasil observasi awal, sesuai dengan situasi dan kondisi mitra,diuraikan sangat lengkap dan rinci',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Kelayakan rencana kegiatan',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Rencana kegiatan disusun tidak sesuai dengan kondisi mitra',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Rencana kegiatan disusun sesuai dengan kondisi mitra namun dengan tahapan yang kurang jelas',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Rencana kegiatan disusun sesuai dengan kondisi mitra dengan tahapan yang jelas disertai jadwal kegiatan yang rinci',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Rencana kegiatan disusun sesuai dengan kondisi mitra dengan tahapan yang sangat jelas disertai jadwal kegiatan yang rinci',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Keterpaduan kegiatan dengan program mitra',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Sangat sedikit rencana kegiatan yang disusun sesuai dengan program mitra',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Sebagian kecil rencana kegiatan yang disusun sesuai dengan program mitra',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Sebagian besar rencana kegiatan yang disusun sesuai dengan program mitra',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Semua rencana kegiatan yang disusun sesuai dengan program mitra',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Rancangan evaluasi dan tindaklanjut kegiatan',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Rancangan evaluasi dan tindaklanjut disusun dengan strategi yang tidak tepat',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Rancangan evaluasi dan tindaklanjut disusun dengan strategi yang tepat namun dengan tahapan yang kurang jelas dan rinci',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Rancangan evaluasi dan tindaklanjut disusun dengan strategi yang tepat dengan tahapan yang jelas dan rinci',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Rancangan evaluasi dan tindaklanjut disusun dengan strategi yang tepat dengan tahapan yang sangat jelas dan rinci',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Persiapan kegiatan',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Persiapan dilakukan hanya pada kegiatan tertentu',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Persiapan dilakukan dengan baik pada semua kegiatan namun tidak didukung sumberdaya yang memadai',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Persiapan dilakukan dengan baik pada semua kegiatan dan didukung sumberdaya yang memadai',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Persiapan dilakukan sangat baik pada semua kegiatan dan didukung sumberdaya yang memadai',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Pelaksanaan kegiatan',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Pelaksanaan kegiatan dilakukan tidak sesuai dengan rancangan kegiatan',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Pelaksanaan kegiatan dilakukan sesuai dengan rancangan kegiatan namun hanya beberapa kegiatan',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Pelaksanaan kegiatan dilakukan sesuai dengan rancangan kegiatan dan lengkap',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Pelaksanaan kegiatan dilakukan sesuai dengan rancangan kegiatan, lengkap dan bekerjasama dengan mitra',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Evaluasi',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Evaluasi dilakukan hanya di beberapa kegiatan',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Evaluasi dilakukan diseluruh kegiatan namun dengan metode yang kurang tepat atau tidak dilaporkan secara rutin',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Evaluasi dilakukan diseluruh kegiatan dengan metode yang tepat, dan dilaporkan secara rutin',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Evaluasi dilakukan diseluruh kegiatan dengan metode yang sangat tepat, dan dilaporkan secara rutin',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Tindak lanjut kegiatan',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Tindaklanjut kegiatan dirumuskan tidak berdasarkan hasil evaluasi',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Tindaklanjut kegiatan dirumuskan berdasarkan hasil evaluasi namun dengan strategi dan tahapan yang kurang tepat dan rinci',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Tindaklanjut kegiatan dirumuskan berdasarkan hasil evaluasi dengan strategi dan tahapan yang sangat tepat dan rinci di semua kegiatan',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Tindaklanjut kegiatan dirumuskan berdasarkan hasil evaluasi dengan strategi dan tahapan yang sangat tepat dan rinci di semua kegiatan',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                ]
            ],
            [
                'nama_bab' => 'Pelaporan Kegiatan',
                'bobot' => '0.2',
                'soal' => [
                    [
                        'soal_penilaian' => 'Isi laporan',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Isi laporan tidak lengkap',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Isi laporan lengkap disertai penjelasan yang rinci namun hanya di beberapa kegiatan',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Isi laporan lengkap disertai penjelasan yang rinci dan meliputi seluruh kegiatan',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Isi laporan lengkap disertai penjelasan yang sangat rinci dan meliputi seluruh kegiatan',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Kebermaknaan',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Kebermaknaan sangat kurang',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Kebermaknaan kurang',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Kebermaknaan tinggi',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Kebermaknaan sangat tinggi',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Sistematika penulisan, tata tulis, bahasa',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Laporan ditulis tidak sistimatis/runtut',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Laporan ditulis dengan sistimatis/runtut, namun tidak sesuai panduanatau sulit dipahami',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Laporan ditulis dengan sistimatis/runtut, sesuai panduan, dan mudah dipahami',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Laporan ditulis dengan sistimatis/runtut, sesuai panduan, dan sangat mudah dipahami',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                ]
            ],
            [
                'nama_bab' => 'Kepribadian dan Sosial',
                'bobot' => '0.15',
                'soal' => [
                    [
                        'soal_penilaian' => 'Percaya diri',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan sikap ragu-ragu dalam setiap tindakan',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan sikap percaya diri, namun dalam beberapa kesempatan terlihat ragu dalam bertindak',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan sikap percaya diri, berkepribadian mantap, dan tidak ragu-ragu dalam bertindak',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan sikap sangat percaya diri, berkepribadian mantap, dan tidak ragu-ragu dalam bertindak',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Inisiatif',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Mahasiswa kurang menunjukkan inisiatif yang baik dalam mengatasi permasalahan',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan inisiatif yang baik dalam mengatasi permasalahan namun kurang didasari alasan yang kuat',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan inisiatif yang baik dalam mengatasi permasalahan didasari alasan yang kuat dan rencana tindakan yang sangat jelas',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan inisiatif yang sangat baik dalam mengatasi permasalahan didasari alasan yang sangat kuat dan rencana tindakan yang sangat jelas',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Kreatifitas dan Inovasi',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Mahasiswa kurang menunjukkan menunjukkan kreatifitas dan inovasi',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan kreatifitas dan inovasi yang tinggi namun kurang disertai alasan yang kuat atau rencana kegiatan yang jelas',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan kreatifitas dan inovasi yang tinggi disertai alasan yang kuat dan rencana kegiatan yang jelas',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan kreatifitas dan inovasi yang sangat tinggi disertai alasan yang kuat dan rencana kegiatan yang jelas',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Komunikasi',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan komunikasi yang tidak hangat dan empatik',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa mampu menjalin komunikasi yang hangat dan empatik namun hanya dengan beberapa orang saja',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa mampu menjalin komunikasi yang hangat dan empatik dengan warga sekolah, guru, dan siswa',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa mampu menjalin komunikasi yang sangat hangat dan empatik dengan warga sekolah, guru, dan siswa',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Kerjasama',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Mahasiswa kurang mampu mampu menjalin kerjasama',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa mampu menjalin kerjasama namun hanya dengan beberapa pihak',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa mampu menjalin kerjasama dengan semua pihak dengan pendekatan yang humanis',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa mampu menjalin kerjasama dengan semua pihak dengan pendekatan yang sangat humanis',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Disiplin',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan sikap tidak disiplin',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan disiplin tinggi namun di beberapa kegiatan saja',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan disiplin yang tinggi di seluruh kegiatan',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Mahasiswa menunjukkan disiplin yang sangat tinggi di seluruh kegiatan',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                ]
            ],
            [
                'nama_bab' => 'Video dan Dokumentasi Kegiatan',
                'bobot' => '0.15',
                'soal' => [
                    [
                        'soal_penilaian' => 'Efektivitas setting cerita yang dipaparkan',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Tidak memuat bagian dari kegiatan yang dilaksanakan selama kegiatan',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Memuat bagian dari kegiatan yang dilaksanakan selama kegiatan namun tidak lengkap',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Memuat bagian dari kegiatan yang dilaksanakan selama kegiatan dan lengkap',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Memuat semua bagian dari kegiatan yang dilaksanakan, lengkap dan tersistematis',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Organisasi/susunan konten',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Tidak memuat konten yang sesuai dengan kegiatan',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Memuat konten namun tidak lengkap dan tidak terdapat hubungan antarbagian',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Memuat konten yang tersusun dan terdapat hubungan antarbagian',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Memuat konten yang tersusun, lengkap dan mengalir/terdapat hubungan antarbagian',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                    [
                        'soal_penilaian' => 'Kualitas gambar dan suara',
                        'pilihan_penilaian' => [
                            [
                                'isi_pilihan' => 'Kualitas gambar dan suara sangat kurang',
                                'bobot' => '0.1'
                            ],
                            [
                                'isi_pilihan' => 'Kualitas gambar dan suara kurang',
                                'bobot' => '0.2'
                            ],
                            [
                                'isi_pilihan' => 'Kualitas gambar dan suara tinggi',
                                'bobot' => '0.3'
                            ],
                            [
                                'isi_pilihan' => 'Kualitas gambar dan suara sangat tinggi',
                                'bobot' => '0.4'
                            ],
                        ]
                    ],
                ]
            ],
        ];

        DB::beginTransaction();
        foreach($data as $d){
            $dataBab = collect($d)->only(['nama_bab', 'bobot']);
            $dataSoalAll = collect($d)->only('soal');
            
            $insertedBab = BabPenilaian::create($dataBab->toArray());

            foreach($dataSoalAll['soal'] as $dSoal){
                $dataSoal = collect($dSoal)->only('soal_penilaian');
                $dataJawabanAll = collect($dSoal)->only('pilihan_penilaian');

                $dataSoal = $dataSoal->merge(['bab_penilaian_id' => $insertedBab->id])->toArray();

                $insertedPenilaian = Penilaian::create($dataSoal);

                foreach($dataJawabanAll['pilihan_penilaian'] as $dJawab){
                    $dataJawab = collect($dJawab);
                    $dataJawab = $dataJawab->merge(['penilaian_id' => $insertedPenilaian->id])->toArray();

                    PilihanPenilaian::create($dataJawab);
                }
            }
        }
        DB::commit();
    }
}
