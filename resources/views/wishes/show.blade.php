@extends('adminlte::page')
@section('title', 'Detail Permohonan Kerjasama')
@section('content_header')
    <h1 class="m-0 text-dark">Detail Permohonan Kerjasama</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('wishes.index')}}" class="btn btn-primary mb-2">
                        Kembali
                    </a>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Judul Permohonan Kerjasama : </strong>
                                {{ $wish->name }}
                            </div>
                            <div class="form-group">
                                <strong>Deskripsi/Uraian Permohonan Kerjasama : </strong>
                                {{ $wish->detail }}
                            </div>
                            <div class="form-group">
                                <strong>Nomor HP/WA : </strong>
                                {{ $wish->phone }}
                            </div>
                            <div class="form-group">
                                <strong>Nama PIC : </strong>
                                {{ $wish->pic }}
                            </div>
                            <div class="form-group">
                                <strong>Nama Instansi/Organisasi : </strong>
                                {{ $wish->organization }}
                            </div>
                            <div class="form-group">
                                <strong>Tanggal Upload : </strong>
                                {{ \Carbon\Carbon::parse($wish->created_at)->format('d/m/Y') }}
                            </div>
                            <div class="form-group">
                                <strong>Tanggal Update Terakhir : </strong>
                                {{ \Carbon\Carbon::parse($wish->updated_at)->format('d/m/Y') }}
                            </div>
                            <div class="form-group">
                                <strong>Status Permohonan Kerjasama : </strong>
                                @if($wish->status_id == 1)
                                <span class="text-primary"><strong>{{ $wish->status->name }}</strong></span>
                                @elseif($wish->status_id == 2)
                                <span class="text-warning"><strong>{{ $wish->status->name }}</strong></span>
                                @else
                                <span class="text-success"><strong>{{ $wish->status->name }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop