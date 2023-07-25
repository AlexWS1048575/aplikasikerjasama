@extends('adminlte::page')
@section('title', 'Ubah Profil')
@section('content_header')
    <h1 class="m-0 text-dark">Ubah Profil</h1>
@stop
@section('content')
    <form action="{{ route('update-profile') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputName">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Nama" name="name" value="{{$user->name ?? old('name')}}">
                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="test@example.com" name="email" value="{{$user->email ?? old('email')}}" readonly>
                            @error('email') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPhone">Nomor HP/WA</label>
                            <input type="number" class="form-control @error('phone') is-invalid @enderror" id="exampleInputPhone" placeholder="081234567890" name="phone" value="{{$user->phone ?? old('phone')}}">
                            @error('phone') <span class="text-danger">{{$message}}</span> @enderror
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