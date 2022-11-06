<!DOCTYPE html>

<head>
    <title>Contoh Surat Pernyataan</title>
    <meta charset="utf-8">
    <style>
        #judul {
            text-align: center;
            margin-bottom: 5px;
        }

        #halaman {
            width: auto;
            height: auto;
            position: absolute;
            /* border: 1px solid; */
            padding-top: 30px;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 80px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>

<body>
    <div id=halaman>
        <h6 id=judul>KOP DINAS</h6>
        <br>
        <h6 id=judul>SURAT KETERANGAN</h6>
        <br>

        <p>Saya yang bertanda tangan di bawah ini :</p>

        <table>
            <tr>
                <td style="width: 30%;">Nama </td>
                <td style="width: 5%;">:</td>
                <td style="width: 65%;">{{ $d[0]->nama; }}</td>
            </tr>
            <tr>
                <td style="width: 30%;">Instansi</td>
                <td style="width: 5%;">:</td>
                <td style="width: 65%;">Universitas Wisnuwardhana Malang</td>
            </tr>
            <tr>
                <td style="width: 30%; vertical-align: top;">Jabatan</td>
                <td style="width: 5%; vertical-align: top;">:</td>
                <td style="width: 65%;">Dosen</td>
            </tr>
            <tr>
                <td style="width: 30%;">No Telpn</td>
                <td style="width: 5%;">:</td>
                <td style="width: 65%;">{{ $d[0]->no_telp; }}</td>
            </tr>
        </table><br>
        <p>Dengan ini menerangkan bahwa mahasiswa yang tersebut di bawah ini :</p>
        <table>
            <tr>
                <td style="width: 30%;">Nama </td>
                <td style="width: 5%;">:</td>
                <td style="width: 65%;">{{ $m[0]->nama; }}</td>
            </tr>
            <tr>
                <td style="width: 30%;">Nim</td>
                <td style="width: 5%;">:</td>
                <td style="width: 65%;">{{ $m[0]->nim; }}</td>
            </tr>
            <tr>
                <td style="width: 30%; vertical-align: top;">Program Studi</td>
                <td style="width: 5%; vertical-align: top;">:</td>
                <td style="width: 65%;">{{ $p[0]->nama; }}</td>
            </tr>
            <tr>
                <td style="width: 30%;">No Telpn</td>
                <td style="width: 5%;">:</td>
                <td style="width: 65%;">{{ $m[0]->no_telp; }}</td>
            </tr>
        </table>
        <br>
        <p>Telah melaksanakan kegiatan {{ $p[0]->nama; }}
            dari tanggal {{$tgl_regis}} sampai dengan {{$tgl_valid}}, di {nama mitra},
            adapun hasil penilaian mahasiswa dalam melaksanakan kegiatan sebagai berikut</p>
        <table class="table table-bordered">
            <tr>
                <td>No</td>
                <td>Komponen Penilaian</td>
                <td>Skor</td>
                <td>Bobot</td>
                <td>Skor X Bobot</td>
            </tr>
            <tr>
                <td>
                    <p>1</p>
                    <p>2</p>
                    <p>3</p>
                    <p>4</p>
                </td>

                <td>
                    @foreach($dataSoal as $bab)
                    @php
                    $sum = 0;
                    @endphp
                    @foreach($dataJawaban as $j)
                    @php
                    if($j->penilaian->bab_penilaian->id == $bab->id){
                    $sum += ($j->bobot * $j->penilaian->bab_penilaian->bobot);
                    }
                    @endphp
                    @endforeach
                    <p>{{ $bab->nama_bab }}</li>
                        @endforeach
                </td>
                <td>
                    <?php
                    foreach ($dataSoal as $bab) {
                        $sum = 0;
                        foreach ($dataJawaban as $j)
                            if ($j->penilaian->bab_penilaian->id == $bab->id) {
                                $sum += ($j->bobot * $j->penilaian->bab_penilaian->bobot);
                            }
                        echo '<p>' . $sum . '</p>';
                    }

                    ?>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Jumlah Total</td>
                <td></td>
                <td> {{ $penilaian->nilai }}</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Nilai</td>
                <td></td>
                <td>{{ ($penilaian->nilai / 23.8)*100 }}</td>
                <td></td>
            </tr>
        </table>

        <p>Demikian Surat Pernyataan ini di berikan untuk di pergunakan sebagaimana mestinya</p>
        <div style="width: 50%; text-align: left;margin-left: 300;">Malang, Kepala PK2P</div><br>
        <br>

    </div>
</body>

</html>