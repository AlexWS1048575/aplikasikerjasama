@extends('adminlte::page')
@section('title', 'User Guide')
@section('content_header')
    <h1 class="m-0 text-dark">User Guide</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Untuk melihat panduan penggunaan aplikasi ini, silahkan klik <a href="{{ url('/storage/manual/manualbook.pdf') }}" target="_blank" download>download</a> user guide di bawah ini.</h5>
                    <h5>Untuk melihat FAQ aplikasi ini, silahkan klik pada halaman <a href="{{route('faqs.index')}}">FAQ</a>.</h5>
                </div>
            </div>
        </div>
    </div>
@stop