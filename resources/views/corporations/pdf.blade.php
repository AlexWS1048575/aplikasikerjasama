<!DOCTYPE html>
<html>
    <style>
        table {
            border: 2px solid black;
        }
        th {
            border: 2px solid black;
        }
        td {
            border: 2px solid black;
        }
        thead {
            border: 2px solid black;
        }
        tbody {
            border: 2px solid black;
        }
    </style>
    <head>
        <title>Daftar Kerjasama</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <h1>{{ $title }}</h1>
        <p>Daftar Kerja Sama</p>
    
        <table class="table" style="text-align:center">
            <thead>
                <tr>
                    <th class="align-middle">#</th>
                    <th class="align-middle">Nama</th>
                    <th class="align-middle">Judul</th>
                    <th class="align-middle">Nomor Dokumen</th>
                    <th class="align-middle">Tanggal Penetapan</th>
                    <th class="align-middle">Durasi</th>
                    <th class="align-middle">Tanggal Kadaluarsa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($corporations as $key => $corporation)
                <tr>
                    <td class="align-middle">{{ $key+1 }}</td>
                    <td class="align-middle">{{ $corporation->name }}</td>
                    <td class="align-middle">{{ $corporation->title }}</td>
                    <td class="align-middle">{{ $corporation->document_no }}</td>
                    <td class="align-middle">{{ \Carbon\Carbon::parse($corporation->assignment_date)->format('d/m/Y') }}</td>
                    @if(($corporation->durationtype_id == 1) && ($corporation->duration > 12))
                    <td class="align-middle">{{ $corporation->duration }} {{ $corporation->durationtype->name }} ({{ floor($corporation->duration / 12) }} Tahun {{ $corporation->duration % 12 }} Bulan)</td>
                    @elseif($corporation->durationtype_id == 1)
                    <td class="align-middle">{{ $corporation->duration }} {{ $corporation->durationtype->name }}</td>
                    @else
                    <td class="align-middle">{{ $corporation->duration }} {{ $corporation->durationtype->name }}</td>
                    @endif
                    @if($corporation->durationtype_id == 1)
                    <td class="align-middle">{{ \Carbon\Carbon::parse($corporation->assignment_date)->addMonth($corporation->duration)->format('d/m/Y') }}</td>
                    @else
                    <td class="align-middle">{{ \Carbon\Carbon::parse($corporation->assignment_date)->addYear($corporation->duration)->format('d/m/Y') }}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>