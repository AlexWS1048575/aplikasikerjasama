@extends('adminlte::page')
@section('title', 'Detail Organisasi')
@section('content_header')
    <h1 class="m-0 text-dark">Detail Organisasi/Instansi</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('organizations.index')}}" class="btn btn-primary mb-2">
                        Kembali
                    </a>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nama Organisasi/Instansi : </strong>
                                {{ $organization->name }}
                            </div>
                            <div class="form-group">
                                <strong>Alamat Lengkap Organisasi/Instansi : </strong>
                                {{ $organization->address }}
                            </div>
                            <div class="form-group">
                                <strong>Email : </strong>
                                {{ $organization->email }}
                            </div>
                            <div class="form-group">
                                <strong>No. HP/WA : </strong>
                                {{ $organization->phone }}
                            </div>
                            <div class="form-group">
                                <strong>Nama Pimpinan : </strong>
                                {{ $organization->headofstate }}
                            </div>
                            <div class="form-group">
                                <strong>Nama PIC (Person In Charge) : </strong>
                                {{ $organization->pic }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop