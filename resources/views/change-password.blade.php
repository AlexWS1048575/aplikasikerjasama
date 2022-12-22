@extends('adminlte::page')
@section('title', 'Ubah Password')
@section('content_header')
    <h1 class="m-0 text-dark">Ubah Password</h1>
@stop
@section('content')
    <form action="{{ route('update-password') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputOldPassword">Password Lama</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputOldPassword" placeholder="Password Lama" name="old_password">
                            @error('old_password') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Password Baru (min: 8)" name="new_password">
                            @error('new_password') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputConfirmPassword">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="exampleInputConfirmPassword" placeholder="Konfirmasi Password" name="password_confirmation">
                            @error('password_confirmation') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{route('home')}}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop