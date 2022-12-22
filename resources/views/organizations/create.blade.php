@extends('adminlte::page')
@section('title', 'Tambah Organisasi')
@section('content_header')
    <h1 class="m-0 text-dark">Tambah Organisasi/Instansi</h1>
@stop
@section('content')
    <form action="{{route('organizations.store')}}" method="post">
        @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputName">Nama Organisasi/Instansi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Nama Organisasi/Instansi" name="name" value="{{old('name')}}">
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputAddress">Alamat Lengkap Organisasi/Instansi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="exampleInputAddress" placeholder="Alamat Lengkap Organisasi/Instansi" name="address" value="{{old('address')}}">
                        @error('address') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="youremail@example.com" name="email" value="{{old('email')}}">
                        @error('email') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPhone">Nomor Telepon/WA</label>
                        <input type="number" class="form-control @error('phone') is-invalid @enderror" id="exampleInputPhone" placeholder="081234567890" name="phone" value="{{old('phone')}}">
                        @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputHeadofstate">Nama Pimpinan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('headofstate') is-invalid @enderror" id="exampleInputHeadofstate" placeholder="Nama Pimpinan" name="headofstate" value="{{old('headofstate')}}">
                        @error('headofstate') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPic">Nama PIC (Person In Charge)</label>
                        <input type="text" class="form-control @error('pic') is-invalid @enderror" id="exampleInputPic" placeholder="Nama PIC" name="pic" value="{{old('pic')}}">
                        @error('pic') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{route('organizations.index')}}" class="btn btn-default">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@stop