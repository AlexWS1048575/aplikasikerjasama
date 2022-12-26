@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    @if($user->role_id == 1)
    <h1>Dashboard Admin</h1>
    @else
    <h1>Dashboard User</h1>
    @endif
@stop

@section('content')
    <style>
        .scroll {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
    @if($user->role_id == 1)
    <p>Welcome back, {{$user->name }}</p>
    @else
    <p>Welcome back, {{$user->name }}</p>
    @endif
    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>Total Organisasi</p>
                        <h1>{{ $totalOrganizations }}</h1>
                    </div>
                    <a href="{{route('organizations.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <p>Total Kerjasama</p>
                        <h1>{{ $totalCorporations }}</h1>
                    </div>
                    <a href="{{route('corporations.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <p>Total Permohonan Kerjasama</p>
                        <h1>{{ $totalWishes }}</h1>
                    </div>
                    <a href="{{route('wishes.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <p>Total User</p>
                        <h1>{{ $totalUsers }}</h1>
                    </div>
                    <a href="{{route('users.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card card-danger col-6">
                <div class="card-header">
                    <h3 class="card-title">Tipe Kerjasama</h3>

                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="firstChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            <div class="card card-primary col-6">
                <div class="card-header">
                    <h3 class="card-title">Jenis Kerjasama</h3>

                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="secondChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card card-dark col-12">
                <div class="card-header">
                        <h3 class="card-title">Notifikasi ({{ Auth::user()->unreadNotifications->count()}})</h3>

                        <div class="card-tools">
                        </div>
                    </div>
                    <div class="card-body scroll">
                    @if($user->role_id == 1)
                        @forelse($notifications as $notification)
                            @if (($notification->data['type']) == 'register')
                                <div class="alert alert-secondary" role="alert">
                                    [{{ $notification->created_at }}] User ({{ $notification->data['name'] }}) {{ $notification->data['message'] }}
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif (($notification->data['type']) == 'create')
                                <div class="alert alert-primary" role="alert">
                                    [{{ $notification->created_at }}] {{ $notification->data['message'] }} ({{ $notification->data['name'] }}).
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif (($notification->data['type']) == 'createbyuser')
                                <div class="alert alert-primary" role="alert">
                                    [{{ $notification->created_at }}] User ({{ $notification->data['user'] }}) {{ $notification->data['message'] }} ({{ $notification->data['name'] }}).
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif (($notification->data['type']) == 'update')
                                <div class="alert alert-warning" role="alert">
                                    [{{ $notification->created_at }}] {{ $notification->data['message'] }} ({{ $notification->data['name'] }}).
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif (($notification->data['type']) == 'updatebyuser')
                                <div class="alert alert-warning" role="alert">
                                    [{{ $notification->created_at }}] User ({{ $notification->data['user'] }}) {{ $notification->data['message'] }} ({{ $notification->data['name'] }}).
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif (($notification->data['type']) == 'approved')
                                <div class="alert alert-success" role="alert">
                                    [{{ $notification->created_at }}] {{ $notification->data['message'] }} ({{ $notification->data['name'] }}).
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif (($notification->data['type']) == 'rejected')
                                <div class="alert alert-danger" role="alert">
                                    [{{ $notification->created_at }}] {{ $notification->data['message'] }} ({{ $notification->data['name'] }}).
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @endif
                            @if($loop->last)
                                <a href="#" id="mark-all">
                                    Mark all as read
                                </a>
                            @endif
                        @empty
                            There are no new notifications
                        @endforelse
                    @else
                        @forelse($notifications as $notification)
                            @if (($notification->data['type']) == 'create')
                                <div class="alert alert-primary" role="alert">
                                    [{{ $notification->created_at }}] {{ $notification->data['message'] }} ({{ $notification->data['name'] }}).
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif (($notification->data['type']) == 'update')
                                <div class="alert alert-warning" role="alert">
                                    [{{ $notification->created_at }}] {{ $notification->data['message'] }} ({{ $notification->data['name'] }}).
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif (($notification->data['type']) == 'updatebyadmin')
                                <div class="alert alert-warning" role="alert">
                                    [{{ $notification->created_at }}] {{ $notification->data['message'] }} ({{ $notification->data['name'] }}).
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif (($notification->data['type']) == 'approved')
                                <div class="alert alert-success" role="alert">
                                    [{{ $notification->created_at }}] {{ $notification->data['message'] }} ({{ $notification->data['name'] }}).
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif (($notification->data['type']) == 'rejected')
                                <div class="alert alert-danger" role="alert">
                                    [{{ $notification->created_at }}] {{ $notification->data['message'] }} ({{ $notification->data['name'] }}).
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @endif
                            @if($loop->last)
                                <a href="#" id="mark-all">
                                    Mark all as read
                                </a>
                            @endif
                        @empty
                            There are no new notifications
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        var labels =  {{ Js::from($labels) }};
        var users =  {{ Js::from($data) }};
        var labels2 =  {{ Js::from($labels2) }};
        var users2 =  {{ Js::from($data2) }};
    
        const data = {
            labels: labels,
            datasets: [{
                label: 'Total',
                backgroundColor: ['#ff21a7', '#05e4e4', '#964b00', '#68ff21'],
                borderColor: ['#ff21a7', '#05e4e4', '#964b00', '#68ff21'],
                data: users,
            }]
        };

        const data2 = {
            labels: labels2,
            datasets: [{
                label: 'Total',
                backgroundColor: ['#f56954', '#00a65a'],
                borderColor: ['#f56954', '#00a65a'],
                data: users2,
            }]
        };
    
        const config = {
            type: 'pie',
            data: data,
            options: {}
        };

        const config2 = {
            type: 'pie',
            data: data2,
            options: {}
        };
    
        const firstChart = new Chart(
            document.getElementById('firstChart'),
            config
        );

        const secondChart = new Chart(
            document.getElementById('secondChart'),
            config2
        );
    </script>
    <script>
    function sendMarkRequest(id = null) {
        return $.ajax("{{ route('markNotification') }}", {
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id
            }
        });
    }
    $(function() {
        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));
            request.done(() => {
                $(this).parents('div.alert').remove();
            });
        });
        $('#mark-all').click(function() {
            let request = sendMarkRequest();
            request.done(() => {
                $('div.alert').remove();
            })
        });
    });
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

<script>

</script>