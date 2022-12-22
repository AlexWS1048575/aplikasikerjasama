<!DOCTYPE html>
<html>
    <head>
        <title>Daftar Kerjasama</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <h1>{{ $title }}</h1>
        <p>Daftar Kerja Sama</p>
    
        <table class="table table-bordered" style="text-align:center">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Judul</th>
                <th>Nomor Dokumen</th>
                <th>Tanggal Penetapan</th>
                <th>Jangka Waktu Pelaksanaan</th>
                <th>Tanggal Akhir Masa Aktif</th>
                <th>Tipe Kerjasama</th>
                <th>Jenis Kerjasama</th>
            </tr>
            @foreach($corporations as $key => $corporation)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $corporation->name }}</td>
                <td>{{ $corporation->title }}</td>
                <td>{{ $corporation->document_no }}</td>
                <td>{{ \Carbon\Carbon::parse($corporation->assignment_date)->format('d/m/Y') }}</td>
                @if(($corporation->durationtype_id == 1) && ($corporation->duration > 12))
                <td>{{ $corporation->duration }} {{ $corporation->durationtype->name }} ({{ floor($corporation->duration / 12) }} Tahun {{ $corporation->duration % 12 }} Bulan)</td>
                @elseif($corporation->durationtype_id == 1)
                <td>{{ $corporation->duration }} {{ $corporation->durationtype->name }}</td>
                @else
                <td>{{ $corporation->duration }} {{ $corporation->durationtype->name }}</td>
                @endif
                @if($corporation->durationtype_id == 1)
                <td>{{ \Carbon\Carbon::parse($corporation->assignment_date)->addMonth($corporation->duration)->format('d/m/Y') }}</td>
                @else
                <td>{{ \Carbon\Carbon::parse($corporation->assignment_date)->addYear($corporation->duration)->format('d/m/Y') }}</td>
                @endif
                <td>{{ $corporation->type->name }}</td>
                <td>{{ $corporation->corporationtype->name }}</td>
            </tr>
            @endforeach
        </table>
    </body>
</html>