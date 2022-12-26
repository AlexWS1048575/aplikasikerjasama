@extends('adminlte::page')
@section('title', 'Daftar Kerjasama')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Kerjasama</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('corporations.create')}}" class="btn btn-primary mb-2">
                        Tambah
                    </a>
                    <a href="{{route('corporations.downloadpdf')}}" class="btn btn-success mb-2">
                        Cetak PDF
                    </a>
                    <a href="{{route('corporations.exportexcel')}}" class="btn btn-warning mb-2">
                        Ekspor ke Excel
                    </a>
                    <a href="{{route('corporations.viewimport')}}" class="btn btn-danger mb-2">
                        Import 
                    </a>
                    <table class="table table-hover table-bordered table-stripped table-responsive" id="example2" style="text-align: center">
                        <thead>
                        <tr>
                            <th class="align-middle">No</th>
                            <th class="align-middle">Nama</th>
                            <th class="align-middle">Judul</th>
                            <th class="align-middle">Nomor Dokumen</th>
                            <th class="align-middle">Nomor HP/WA</th>
                            <th class="align-middle">Ringkasan</th>
                            <th class="align-middle">PIC</th>
                            <th class="align-middle">Tanggal Penetapan</th>
                            <th class="align-middle">Durasi</th>
                            <th class="align-middle">Tanggal Kadaluarsa</th>
                            <th class="align-middle">Tipe Kerjasama</th>
                            <th class="align-middle">Jenis Kerjasama</th>
                            <th class="align-middle">Status Kerjasama</th>
                            <th class="align-middle">Status Masa Aktif Kerjasama</th>
                            <th class="align-middle">Download</th>
                            <th class="align-middle">Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($corporations as $key => $corporation)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td>{{ $corporation->name }}</td>
                                <td>{{ $corporation->title }}</td>
                                <td>{{ $corporation->document_no }}</td>
                                <td>{{ $corporation->phonenumber }}</td>
                                <td>{{ $corporation->summary }}</td>
                                <td>{{ $corporation->pic }}</td>
                                <td>{{ \Carbon\Carbon::parse($corporation->assignment_date)->format('d/m/Y') }}</td>
                                @if(($corporation->durationtype_id == 1) && ($corporation->duration > 12))
                                <td>{{ $corporation->duration }} {{ $corporation->durationtype->name }} ({{ floor($corporation->duration / 12) }} Tahun {{ $corporation->duration % 12 }} Bulan)</td>
                                @elseif($corporation->durationtype_id == 1)
                                <td>{{ $corporation->duration }} {{ $corporation->durationtype->name }}</td>
                                @else
                                <td>{{ $corporation->duration }} {{ $corporation->durationtype->name }}</td>
                                @endif
                                <!-- <td>{{ date('d-m-Y', strtotime($corporation->assignment_date)) }}</td> -->
                                @if($corporation->durationtype_id == 1)
                                <td>{{ \Carbon\Carbon::parse($corporation->assignment_date)->addMonth($corporation->duration)->format('d/m/Y') }}</td>
                                @else
                                <td>{{ \Carbon\Carbon::parse($corporation->assignment_date)->addYear($corporation->duration)->format('d/m/Y') }}</td>
                                @endif
                                <td>{{ $corporation->type->name }}</td>
                                <td>{{ $corporation->corporationtype->name }}</td>
                                <!-- <td>{{ $corporation->status->name }}</td> -->
                                @if($corporation->status_id == 1)
                                <td class="text-primary"><strong>{{ $corporation->status->name }}</strong></td>
                                @elseif ($corporation->status_id == 2)
                                <td class="text-warning"><strong>{{ $corporation->status->name }}</strong></td>
                                @else
                                <td class="text-success"><strong>{{ $corporation->status->name }}</strong></td>
                                @endif
                                @if($corporation->durationtype_id == 1)
                                    @if((\Carbon\Carbon::parse($corporation->assignment_date)->addMonth($corporation->duration)) > now())
                                    <td class="text-success"><strong>Active</strong></td>
                                    @else
                                    <td class="text-danger"><strong>Expired</strong></td>
                                    @endif
                                @else
                                    @if((\Carbon\Carbon::parse($corporation->assignment_date)->addYear($corporation->duration)) > now())
                                    <td class="text-success"><strong>Active</strong></td>
                                    @else
                                    <td class="text-danger"><strong>Expired</strong></td>
                                    @endif
                                @endif
                                <td><a href="{{ url('storage/attachment/'.$corporation->attachment) }}" target="_blank" download>Download</a></td>
                                <td>
                                    @if($corporation->status_id < 3)
                                    <a href="{{route('corporations.setasapproved', $corporation)}}" onclick="return confirm('Apakah anda ingin update status dokumen ini menjadi disetujui?')" class="btn btn-success btn-xs" method="post">
                                        Set To Approve
                                    </a>
                                    @else
                                    <a href="{{route('corporations.setasrevisions', $corporation)}}" onclick="return confirm('Apakah anda ingin membatalkan dokumen ini?')" class="btn btn-warning btn-xs" method="post">
                                        Cancel
                                    </a>
                                    @endif
                                    <a href="{{route('corporations.show', $corporation)}}" class="btn btn-secondary btn-xs">
                                        Show
                                    </a>
                                    <a href="{{route('corporations.edit', $corporation)}}" class="btn btn-primary btn-xs">
                                        Edit
                                    </a>
                                    <a href="{{route('corporations.destroy', $corporation)}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <form action="" id="delete-form" method="post">
        @method('delete')
        @csrf
    </form>
    <script>
        $('#example2').DataTable({
            "responsive": true,
        });
        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }
    </script>
@endpush