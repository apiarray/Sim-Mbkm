<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Akhir DPL</title>
    <link rel="stylesheet" type="text/css" href="{{url('cuba/assets/css/vendors/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url("cuba/assets/css/style.css")}}">
    <link id="color" rel="stylesheet" href="{{url("cuba/assets/css/color-1.css")}}" media="screen">

    <style>
        /* table {
            border-collapse: collapse;
            width: 100%;
        } 
        
        .table-rincian th {
            background-color: lightgray;
        }
        .table-rincian th, 
        .table-rincian td {
            border: 1px solid;
        } */
    </style>
</head>
<body>
    <div class="mb-3">
        <h1 class="text-center">Laporan Akhir DPL</h1>
        <table class="table table-borderless">
            <tr>
                <th style="text-align:left; width:30%">Dosen</th>
                <td style="width: 5px;">:</td>
                <td>{{ $dataLaporanAkhir->nama_dosen }}</td>
            </tr>
            <tr>
                <th style="text-align:left;">Semester / Tahun Ajaran</th>
                <td>:</td>
                <td>{{ $dataLaporanAkhir->semester . ' / ' . $dataLaporanAkhir->tahun_ajaran }}</td>
            </tr>
            <tr>
                <th style="text-align:left;">Nomor Laporan</th>
                <td>:</td>
                <td>{{ $dataLaporanAkhir->id_laporan_akhir_dosen_dpl }}</td>
            </tr>
            <tr>
                <th style="text-align:left;">Tanggal Laporan</th>
                <td>:</td>
                <td>{{ $dataLaporanAkhir->tanggal_laporan_akhir }}</td>
            </tr>
        </table>
    </div>
    <hr>
    <div>
        <h2>Rincian Laporan Akhir</h2>
        <table class="table">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>ID Validasi Registrasi</th>
                    <th>ID Penilaian</th>
                    <th>Tanggal Penilaian</th>
                    <th>NIM - Mahasiswa</th>
                    <th>Log Book Harian</th>
                    <th>Beban Jam</th>
                    <th>Log Book Mingguan</th>
                    <th>Beban Jam</th>
                    <th>Laporan Akhir</th>
                    <th>Beban Jam</th>
                </tr>
            </thead>
            @foreach($dataLaporanAkhirDetail as $dtl)
                <tr>
                    <td style="text-align: left;">{{ $dtl->id_registrasi }}</td>
                    <td style="text-align: left;">{{ $dtl->id_penilaian }}</td>
                    <td style="text-align: left;">{{ $dtl->tanggal_penilaian }}</td>
                    <td style="text-align: left;">{{ $dtl->nim_mahasiswa }} - {{ $dtl->nama_mahasiswa }}</td>
                    <td style="text-align: right;">{{ $dtl->count_logbook_harian }}</td>
                    <td style="text-align: right;">{{ $dtl->beban_jam_log_harian }}</td>
                    <td style="text-align: right;">{{ $dtl->count_logbook_mingguan }}</td>
                    <td style="text-align: right;">{{ $dtl->beban_jam_log_mingguan }}</td>
                    <td style="text-align: left;">{{ $dtl->id_laporan_akhir_mahasiswa }}</td>
                    <td style="text-align: right;">{{ $dtl->beban_jam_laporan_akhir }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>