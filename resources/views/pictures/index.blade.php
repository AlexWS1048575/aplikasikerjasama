@extends('adminlte::page')
@section('title', 'Daftar Gambar')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Gambar</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('pictures.create')}}" class="btn btn-primary mb-2">
                        Tambah
                    </a>
                    <table class="table table-hover table-bordered table-stripped" id="example2" style="text-align: center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Gambar</th>
                                <th>Download</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($pictures as $key => $picture)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$picture->name}}</td>
                                <td>{{$picture->detail}}</td>
                                <td><img src="{{ url('storage/gambar/'.$picture->image) }}" width="100px"></td>
                                <td><a href="{{ url('storage/gambar/'.$picture->image) }}" target="_blank" download>Download</a>  </td>
                                <td>
                                    <a href="{{route('pictures.edit', $picture)}}" class="btn btn-primary btn-xs">
                                        Edit
                                    </a>
                                    <a href="{{route('pictures.destroy', $picture)}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
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