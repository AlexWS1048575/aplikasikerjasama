@extends('adminlte::page')
@section('title', 'Detail Kerjasama')
@section('content_header')
    <h1 class="m-0 text-dark">Detail Kerjasama</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('corporations.index')}}" class="btn btn-primary mb-2">
                        Kembali
                    </a>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nama Kerjasama : </strong>
                                {{ $corporation->name }}
                            </div>
                            <div class="form-group">
                                <strong>Judul Kerjasama : </strong>
                                {{ $corporation->title }}
                            </div>
                            <div class="form-group">
                                <strong>Nomor Dokumen : </strong>
                                {{ $corporation->document_no }}
                            </div>
                            <div class="form-group">
                                <strong>Nomor HP/WA : </strong>
                                {{ $corporation->phonenumber }}
                            </div>
                            <div class="form-group">
                                <strong>Ringkasan : </strong>
                                {{ $corporation->summary }}
                            </div>
                            <div class="form-group">
                                <strong>PIC : </strong>
                                {{ $corporation->pic }}
                            </div>
                            <div class="form-group">
                                <strong>Tanggal Penetapan : </strong>
                                {{ \Carbon\Carbon::parse($corporation->assignment_date)->format('d/m/Y') }}
                            </div>
                            <div class="form-group">
                                <strong>Durasi : </strong>
                                @if(($corporation->durationtype_id == 1) && ($corporation->duration > 12))
                                {{ $corporation->duration }} {{ $corporation->durationtype->name }} ({{ floor($corporation->duration / 12) }} Tahun {{ $corporation->duration % 12 }} Bulan)
                                @elseif($corporation->durationtype_id == 1)
                                {{ $corporation->duration }} {{ $corporation->durationtype->name }}
                                @else
                                {{ $corporation->duration }} {{ $corporation->durationtype->name }}
                                @endif
                            </div>
                            <div class="form-group">
                                <strong>Tanggal Kadaluarsa : </strong>
                                @if($corporation->durationtype_id == 1)
                                {{ \Carbon\Carbon::parse($corporation->assignment_date)->addMonth($corporation->duration)->format('d/m/Y') }}
                                @else
                                {{ \Carbon\Carbon::parse($corporation->assignment_date)->addYear($corporation->duration)->format('d/m/Y') }}
                                @endif
                            </div>
                            <div class="form-group">
                                <strong>Tipe Kerjasama : </strong>
                                {{ $corporation->type->name }}
                            </div>
                            <div class="form-group">
                                <strong>Jenis Kerjasama : </strong>
                                {{ $corporation->corporationtype->name }}
                            </div>
                            <div class="form-group">
                                <strong>Status Kerjasama : </strong>
                                @if($corporation->status_id == 1)
                                <span class="text-primary"><strong>{{ $corporation->status->name }}</strong></span>
                                @elseif($corporation->status_id == 2)
                                <span class="text-warning"><strong>{{ $corporation->status->name }}</strong></span>
                                @else
                                <span class="text-success"><strong>{{ $corporation->status->name }}</strong></span>
                                @endif
                            </div>
                            <div class="form-group">
                                <strong>Status Masa Aktif Kerjasama : </strong>
                                @if($corporation->durationtype_id == 1)
                                    @if((\Carbon\Carbon::parse($corporation->assignment_date)->addMonth($corporation->duration)) > now())
                                    <span class="text-success"><strong>Active</strong></span>
                                    @else
                                    <span class="text-danger"><strong>Expired</strong></span>
                                    @endif
                                @else
                                    @if((\Carbon\Carbon::parse($corporation->assignment_date)->addYear($corporation->duration)) > now())
                                    <span class="text-success"><strong>Active</strong></span>
                                    @else
                                    <span class="text-danger"><strong>Expired</strong></span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop