@extends('adminlte::page')
@section('title', 'Daftar Organisasi')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Organisasi/Instansi</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('organizations.create')}}" class="btn btn-primary mb-2">
                        Tambah
                    </a>
                    <table class="table table-hover table-bordered table-stripped" id="example2" style="text-align: center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>No. HP/WA</th>
                            <th>Nama Pimpinan</th>
                            <th>Nama PIC</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($organizations as $key => $organizationy)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$organizationy->name}}</td>
                                <td>{{$organizationy->address}}</td>
                                <td>{{$organizationy->email}}</td>
                                <td>{{$organizationy->phone}}</td>
                                <td>{{$organizationy->headofstate}}</td>
                                <td>{{$organizationy->pic}}</td>
                                <td>
                                    <a href="{{route('organizations.show', $organizationy)}}" class="btn btn-secondary btn-xs">
                                        Show
                                    </a>
                                    <a href="{{route('organizations.edit', $organizationy)}}" class="btn btn-primary btn-xs">
                                        Edit
                                    </a>
                                    @if ($user->role_id == 1)
                                    <a href="{{route('organizations.destroy', $organizationy)}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                    @endif
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