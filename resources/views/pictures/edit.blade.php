@extends('adminlte::page')
@section('title', 'Edit Gambar')
@section('content_header')
    <h1 class="m-0 text-dark">Edit Gambar</h1>
@stop
@section('content')
    <form action="{{route('pictures.update', $picture)}}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputName">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Nama lengkap" name="name" value="{{$picture->name ?? old('name')}}">
                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDetail">Detail</label>
                            <input type="text" class="form-control @error('detail') is-invalid @enderror" id="exampleInputDetail" placeholder="Detail" name="detail" value="{{$picture->detail ?? old('detail')}}">
                            @error('detail') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">Gambar</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="exampleInputFile" placeholder="Gambar" name="image" value="{{$picture->image ?? old('image')}}">
                            <br><img src="{{ url('storage/gambar/'.$picture->image) }}" width="100px"></br>
                            <br>Gambar Lama <a href="{{ url('storage/gambar/'.$picture->image) }}" target="_blank" download>Download</a>
                            @error('image') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
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
    </form>
@stop