@extends('adminlte::page')
@section('title', 'Daftar Permohonan Kerjasama')
@section('content_header')
<h1 class="m-0 text-dark">Daftar Permohonan Kerjasama</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('wishes.create')}}" class="btn btn-primary mb-2">
                    Tambah
                </a>
                <table class="table table-hover table-bordered table-stripped" id="example2" style="text-align: center">
                    <thead>
                        <tr>
                            <th class="align-middle">No</th>
                            <th class="align-middle">Nama Permohonan Kerjasama</th>
                            <th class="align-middle">Deskripsi</th>
                            <th class="align-middle">Nomor HP/WA</th>
                            <th class="align-middle">PIC</th>
                            <th class="align-middle">Nama Instansi/Organisasi</th>
                            <th class="align-middle">Tanggal Update Terakhir</th>
                            <th class="align-middle">Status Permohonan</th>
                            <th class="align-middle">Download</th>
                            <th class="align-middle">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishes as $key => $wish)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$wish->name}}</td>
                            <td>{{$wish->detail}}</td>
                            <td>{{$wish->phone}}</td>
                            <td>{{$wish->pic}}</td>
                            <td>{{$wish->organization}}</td>
                            <td>{{ \Carbon\Carbon::parse($wish->updated_at)->format('d/m/Y') }}</td>
                            @if($wish->status_id == 1)
                            <td class="text-primary"><strong>{{ $wish->status->name }}</strong></td>
                            @elseif ($wish->status_id == 2)
                            <td class="text-warning"><strong>{{ $wish->status->name }}</strong></td>
                            @else
                            <td class="text-success"><strong>{{ $wish->status->name }}</strong></td>
                            @endif
                            <td><a href="{{ url('wishes-pdf/'.$wish->filename) }}" target="_blank" download>Download</a></td>
                            <td>
                                @if($user->role_id == 1)
                                @if($wish->status_id < 3) <a href="{{route('wishes.wishcometrue', $wish)}}" onclick="return confirm('Apakah anda ingin update status dokumen ini menjadi disetujui?')" class="btn btn-success btn-xs" method="post">
                                    Set To Approve
                                    </a>
                                    @else
                                    <a href="{{route('wishes.wishcancelled', $wish)}}" onclick="return confirm('Apakah anda ingin membatalkan dokumen ini?')" class="btn btn-warning btn-xs" method="post">
                                        Cancel
                                    </a>
                                    @endif
                                    @endif
                                    <a href="{{route('wishes.show', $wish)}}" class="btn btn-secondary btn-xs">
                                        Show
                                    </a>
                                    @if($user->role_id == 1)
                                    <a href="{{route('wishes.edit', $wish)}}" class="btn btn-primary btn-xs">
                                        Edit
                                    </a>
                                    @elseif(($user->role_id > 1) && ($wish->status_id < 3)) <a href="{{route('wishes.edit', $wish)}}" class="btn btn-primary btn-xs">
                                        Edit
                                        </a>
                                        @endif
                                        <a href="{{route('wishes.destroy', $wish)}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
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