@extends('adminlte::page')
@section('title', 'Edit Permohonan Kerjasama')
@section('content_header')
    <h1 class="m-0 text-dark">Edit Permohonan Kerjasama</h1>
@stop
@section('content')
    <form action="{{route('wishes.update', $wish)}}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputName">Judul Permohonan Kerjasama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Judul Permohonan Kerjasama" name="name" value="{{$wish->name ?? old('name')}}">
                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDetail">Deskripsi/Uraian Permohonan Kerjasama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('detail') is-invalid @enderror" id="exampleInputDetail" placeholder="Deskripsi/Uraian Permohonan Kerjasama" name="detail" value="{{$wish->detail ?? old('detail')}}">
                            @error('detail') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPhone">Nomor HP/WA</label>
                            <input type="number" class="form-control @error('phone') is-invalid @enderror" id="exampleInputPhone" placeholder="081234567890" name="phone" value="{{$wish->phone ?? old('phone')}}">
                            @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPic">Nama PIC</label>
                            <input type="text" class="form-control @error('pic') is-invalid @enderror" id="exampleInputPic" placeholder="Nama PIC" name="pic" value="{{$wish->pic ?? old('pic')}}">
                            @error('pic') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputOrganization">Nama Instansi/Organisasi/Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('organization') is-invalid @enderror" id="exampleInputPhone" placeholder="Nama Instansi/Organisasi/Perusahaan" name="organization" value="{{$wish->organization ?? old('organization')}}">
                            @error('organization') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputRequester">Tipe Permohonan <span class="text-danger">*</span></label>
                            <select class="form-control" name="requester_id">
                                @foreach ($requesters as $requester)
                                    <option value="{{ $requester->id }}" {{ $requester->id == $wish->requester_id ? 'selected' : '' }}>{{ $requester->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputStatus">Status Permohonan</label>
                            <select class="form-control" name="status_id">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $status->id == $wish->status_id ? 'selected' : '' }}>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Berkas Permohonan Kerjasama (PDF)</label>
                            <input type="file" class="form-control @error('filename') is-invalid @enderror" id="exampleInputFile" placeholder="Gambar" name="filename" value="{{$wish->filename ?? old('filename')}}">
                            <br>Berkas Lama <a href="{{ url('/storage/berkas/'.$wish->filename) }}" target="_blank" download>Download</a>
                            @error('filename') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
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
    </form>
@stop