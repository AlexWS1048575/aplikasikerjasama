@extends('adminlte::page')
@section('title', 'Edit Role')
@section('content_header')
    <h1 class="m-0 text-dark">Edit Role</h1>
@stop
@section('content')
    <form action="{{route('roles.update', $role)}}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputName">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Nama lengkap" name="name" value="{{$role->name ?? old('name')}}">
                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <strong>Permission <span class="text-danger">*</span></strong>
                            <div>
                                <label>
                                    <input type="checkbox" id="selectAllPermissions" onclick="checkAll()">
                                    Select All
                                </label>
                            </div>
                            @foreach($permission as $value)
                                &nbsp;
                                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                {{ $value->name }}</label>
                            <br/>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{route('roles.index')}}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
<script>
    function checkAll() {
        // Get the "Select All" checkbox element
        var selectAllCheckbox = document.getElementById('selectAllPermissions');

        // Get all permission checkboxes
        var permissionCheckboxes = document.querySelectorAll('.name');

        // Determine whether to check or uncheck based on the "Select All" checkbox's state
        var isChecked = selectAllCheckbox.checked;
        
        // Update the state of individual permission checkboxes
        permissionCheckboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    }
</script>