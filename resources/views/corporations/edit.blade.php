@extends('adminlte::page')
@section('title', 'Edit Kerjasama')
@section('content_header')
    <h1 class="m-0 text-dark">Edit Kerjasama</h1>
@stop
@section('content')
    <form action="{{route('corporations.update', $corporation)}}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputName">Nama Kerjasama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Nama Kerjasama" name="name" value="{{$corporation->name ?? old('name')}}">
                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputTitle">Judul Kerjasama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputTitle" placeholder="Judul Kerjasama" name="title" value="{{$corporation->title ?? old('title')}}">
                            @error('title') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDocumentNo">Nomor Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('document_no') is-invalid @enderror" id="exampleInputDocumentNo" placeholder="Nomor Dokumen" name="document_no" value="{{$corporation->document_no ?? old('document_no')}}">
                            @error('document_no') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPhone">Nomor HP/WA</label>
                            <input type="number" class="form-control @error('phonenumber') is-invalid @enderror" id="exampleInputPhone" placeholder="081234567890" name="phonenumber" value="{{$corporation->phonenumber ?? old('phonenumber')}}">
                            @error('phonenumber') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputSummary">Ringkasan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('summary') is-invalid @enderror" id="exampleInputSummary" placeholder="Penjelasan Singkat Kerjasama" name="summary">{{old('summary', $corporation->summary ?? null)}}</textarea>
                            @error('summary') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPic">PIC</label>
                            <input type="text" class="form-control @error('pic') is-invalid @enderror" id="exampleInputPic" placeholder="Nama PIC" name="pic" value="{{$corporation->pic ?? old('pic')}}">
                            @error('pic') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputAssignmentDate">Tanggal Penetapan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('assignment_date') is-invalid @enderror" id="exampleInputAssignmentDate" placeholder="" name="assignment_date" value="{{$corporation->assignment_date ?? old('assignment_date')}}">
                            @error('assignment_date') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDuration">Durasi Kerjasama <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" id="exampleInputDuration" placeholder="Contoh : 4" name="duration" value="{{$corporation->duration ?? old('duration')}}">
                            @error('duration') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputType4">Tipe Durasi Kerjasama <span class="text-danger">*</span></label>
                            <select class="form-control" name="durationtype_id">
                                @foreach ($durationtypes as $durationtype)
                                    <option value="{{ $durationtype->id }}" {{ $durationtype->id == $corporation->durationtype_id ? 'selected' : '' }}>{{ $durationtype->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputType2">Tipe Kerjasama <span class="text-danger">*</span></label>
                            <select class="form-control" name="type_id">
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" {{ $type->id == $corporation->type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputType3">Jenis Kerjasama <span class="text-danger">*</span></label>
                            <select class="form-control" name="corporationtype_id">
                                @foreach ($corporationtypes as $corporationtype)
                                    <option value="{{ $corporationtype->id }}" {{ $corporationtype->id == $corporation->corporationtype_id ? 'selected' : '' }}>{{ $corporationtype->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($user->role_id == 1)
                        <div class="form-group">
                            <label for="exampleInputStatus">Status</label>
                            <select class="form-control" name="status_id">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $status->id == $corporation->status_id ? 'selected' : '' }}>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleInputAttachment">Lampiran Kerjasama (PDF)</label>
                            <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="exampleInputAttachment" placeholder="Gambar" name="attachment" value="{{$corporation->attachment ?? old('attachment')}}">
                            <br>Berkas Lama <a href="{{ url('/storage/attachment/'.$corporation->attachment) }}" target="_blank" download>Download</a>
                            @error('attachment') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{route('corporations.index')}}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop