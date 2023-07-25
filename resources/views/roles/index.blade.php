@extends('adminlte::page')
@section('title', 'Daftar Role')
@section('content_header')
    <h1 class="m-0 text-dark">Daftar Role</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('role-create')
                    <a href="{{route('roles.create')}}" class="btn btn-primary mb-2">
                        Tambah
                    </a>
                    @endcan
                    <table class="table table-hover table-bordered table-stripped" id="example2" style="text-align: center">
                        <thead>
                        <tr>
                            <th class="align-middle">No</th>
                            <th class="align-middle">Nama</th>
                            <th class="align-middle">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $key => $role)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @if($role->name != "Admin")
                                        @can('role-update')
                                        <a href="{{route('roles.edit', $role)}}" class="btn btn-primary btn-xs">
                                            Edit
                                        </a>
                                        @endcan
                                        @can('role-delete')
                                        <a href="{{route('roles.destroy', $role)}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                            Delete
                                        </a>
                                        @endcan
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