@extends('adminlte::page')
@section('title', 'Tambah Kerjasama')
@section('content_header')
    <h1 class="m-0 text-dark">Tambah Kerjasama</h1>
@stop
@section('content')
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
<link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
<style>
    .kbw-signature {
        width: 100%;
        height: 200px;
    }
</style>
<form action="{{route('corporations.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputName">Nama Kerjasama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Nama Kerjasama" name="name" value="{{old('name')}}">
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputTitle">Judul Kerjasama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputTitle" placeholder="Judul Kerjasama" name="title" value="{{old('title')}}">
                        @error('title') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputDocumentNo">Nomor Dokumen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('document_no') is-invalid @enderror" id="exampleInputDocumentNo" placeholder="Nomor Dokumen" name="document_no" value="{{old('document_no')}}">
                        @error('document_no') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPhone">Nomor HP/WA</label>
                        <input type="number" class="form-control @error('phonenumber') is-invalid @enderror" id="exampleInputPhone" placeholder="081234567890" name="phonenumber" value="{{old('phonenumber')}}">
                        @error('phonenumber') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputSummary">Ringkasan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('summary') is-invalid @enderror" id="exampleInputSummary" placeholder="Penjelasan Singkat Kerjasama" name="summary">{{old('summary')}}</textarea>
                        @error('summary') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPic">PIC</label>
                        <input type="text" class="form-control @error('pic') is-invalid @enderror" id="exampleInputPic" placeholder="Nama PIC" name="pic" value="{{old('pic')}}">
                        @error('pic') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputAssignmentDate">Tanggal Penetapan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('assignment_date') is-invalid @enderror" id="exampleInputAssignmentDate" placeholder="" name="assignment_date" value="{{old('assignment_date')}}">
                        @error('assignment_date') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputDuration">Durasi Kerjasama <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('duration') is-invalid @enderror" id="exampleInputDuration" placeholder="Contoh : 4" name="duration" value="{{old('duration')}}">
                        @error('duration') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputType4">Tipe Durasi Kerjasama <span class="text-danger">*</span></label>
                        <select class="form-control" name="durationtype_id">
                            @foreach ($durationtypes as $durationtype)
                            <option value="{{ $durationtype->id }}">{{ $durationtype->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputType2">Tipe Kerjasama <span class="text-danger">*</span></label>
                        <select class="form-control" name="type_id">
                            @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputType3">Jenis Kerjasama <span class="text-danger">*</span></label>
                        <select class="form-control" name="corporationtype_id">
                            @foreach ($corporationtypes as $corporationtype)
                            <option value="{{ $corporationtype->id }}">{{ $corporationtype->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputAttachment">Lampiran Kerjasama (PDF)</label>
                        <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="exampleInputAttachment" placeholder="Lampiran" name="attachment" multiple value="{{old('attachment')}}">
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

<script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature', syncFormat: 'PNG'});
    $('#clear').click(function (e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>
@stop