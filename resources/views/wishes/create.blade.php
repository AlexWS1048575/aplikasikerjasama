@extends('adminlte::page')
@section('title', 'Tambah Permohonan Kerjasama')
@section('content_header')
    <h1 class="m-0 text-dark">Tambah Permohonan Kerjasama</h1>
@stop
@section('content')
<form action="{{route('wishes.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputName">Judul Permohonan Kerjasama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Judul Permohonan Kerjasama" name="name" value="{{old('name')}}">
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputDetail">Deskripsi/Uraian Permohonan Kerjasama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('detail') is-invalid @enderror" id="exampleInputDetail" placeholder="Deskripsi/Uraian Permohonan Kerjasama" name="detail" value="{{old('detail')}}">
                        @error('detail') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPhone">Nomor HP/WA</label>
                        <input type="number" class="form-control @error('phone') is-invalid @enderror" id="exampleInputPhone" placeholder="081234567890" name="phone" value="{{old('phone')}}">
                        @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPic">Nama PIC</label>
                        <input type="text" class="form-control @error('pic') is-invalid @enderror" id="exampleInputPic" placeholder="Nama PIC" name="pic" value="{{old('pic')}}">
                        @error('pic') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputOrganization">Nama Instansi/Organisasi/Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('organization') is-invalid @enderror" id="exampleInputOrganization" placeholder="Nama Instansi/Organisasi/Perusahaan" name="organization" value="{{old('organization')}}">
                        @error('organization') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputRequester">Tipe Permohonan <span class="text-danger">*</span></label>
                        <select class="form-control" name="requester_id">
                            @foreach ($requesters as $requester)
                            <option value="{{ $requester->id }}">{{ $requester->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Berkas Permohonan Kerjasama (PDF)</label>
                        <input type="file" class="form-control @error('filename') is-invalid @enderror" id="exampleInputFile" placeholder="Gambar" name="filename" value="{{old('filename')}}">
                        @error('filename') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{route('wishes.index')}}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@stop