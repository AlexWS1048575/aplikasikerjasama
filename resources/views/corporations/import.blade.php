@extends('adminlte::page')
@section('title', 'Import Data Kerjasama')
@section('content_header')
    <h1 class="m-0 text-dark">Import Data Kerjasama</h1>
@stop
@section('content')
<form action="{{route('corporations.importexcel')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputFile">Berkas</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="exampleInputFile" placeholder="Berkas" name="file" value="{{old('file')}}">
                        @error('file') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <span class="text-danger">Perhatikan posisi tabel di excel sebelum mengimpornya. Format kolom nya adalah "Nama", "Email", "Nomor Dokumen", "Nomor HP(WA)", "Ringkasan", "PIC", "Tanggal Aktif", "Durasi",  dan "Tipe Durasi".</span>
                    <br><span class="text-danger">Jika tipe durasi adalah Bulan, maka input 1, jika tipe durasi adalah tahun, maka input 2.</span>
                    <br><span class="text-danger">Format tanggal pada file Excel adalah mm/dd/YYYY. Contoh : 15 November 2022 ditulis 11/15/2022.</span>
                    <br><span class="text-danger">Jika tidak ada data yang diisi saat mengimport data yang bersifat wajib diisi, seperti kolom "Nomor Dokumen", harap menuliskan <b>null</b> pada file Excel tersebut.</span>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Import</button>
                        <a href="{{route('corporations.index')}}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@stop