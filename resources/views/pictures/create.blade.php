@extends('adminlte::page')
@section('title', 'Tambah Gambar')
@section('content_header')
    <h1 class="m-0 text-dark">Tambah Gambar</h1>
@stop
@section('content')
<form action="{{route('pictures.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputName">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Nama" name="name" value="{{old('name')}}">
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputDetail">Detail</label>
                        <input type="text" class="form-control @error('detail') is-invalid @enderror" id="exampleInputDetail" placeholder="Detail" name="detail" value="{{old('detail')}}">
                        @error('detail') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Gambar</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="exampleInputFile" placeholder="Gambar" name="image" value="{{old('image')}}">
                        @error('image') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{route('pictures.index')}}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@stop