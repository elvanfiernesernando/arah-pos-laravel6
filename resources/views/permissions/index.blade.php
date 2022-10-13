@extends('layouts.master')

@section('title')
<title>Role Permission</title>
@endsection

@section('css')
<style type="text/css">
    .tab-panel {
        height: 150px;
        overflow-y: scroll;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">

    <div class="content-header">

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">Role Management</h3>
                </div>
                <div class="col-sm-6 mt-3">
                    <ol class="breadcrumb breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Employee</a></li>
                        <li class="breadcrumb-item active">Permission</li>
                    </ol>
                </div>
            </div>
        </div>

        @if (session('error'))
        @alert(['type' => 'danger'])
        {!! session('error') !!}
        @endalert
        @endif

        @if (session('success'))
        @alert(['type' => 'success'])
        {!! session('success') !!}
        @endalert
        @endif

        @if ($errors->any())
        @alert(['type' => 'danger'])
        {{ $errors->first() }}
        @endalert
        @endif

        <!-- ------------------------------------------- MAIN CONTENT --------------------------------------------------------------- -->

        <div class="row">

            <!-- Create New Permission START -->
            {{-- <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Permission</h4>
                        <p class="card-description">
                        </p>

                        <form action="{{ route('permission.add_permission') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" placeholder="Create Product or Create Category" required>
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Add New</button>
                        </form>
                    </div>
                </div>
            </div> --}}
            <!-- New permission END -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Set Role Permission</h4>
                        <p class="card-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>

                        <form action="{{ route('permission.roles_permission') }}" method="GET">
                            <div class="form-group">
                                <label for="">Roles</label>
                                <div class="input-group">
                                    <select name="role" class="form-control">
                                        @foreach ($roles as $value)
                                        <option value="{{ $value->name }}" {{ request()->get('role') == $value->name ? 'selected':'' }}>{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-primary" type="submit">Check Permission</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        
                        {{-- jika $permission tidak bernilai kosong --}}
                        @if (!empty($permissions))
                        <form action="{{ route('permission.setRolePermission', request()->get('role')) }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <label for="">Permissions</label>
                                            </ul>
                                            @php $no = 1; @endphp
                                            @foreach ($permissions as $key => $row)
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="permission[]" class="form-check-input" value="{{ $row }}" {{--  CHECK, JIKA PERMISSION TERSEBUT SUDAH DI SET, MAKA CHECKED --}} {{ in_array($row, $hasPermission) ? 'checked':'' }} {{ (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Permission')) && request()->get('role') != 'Cashier' ? '' : 'disabled' }}>
                                                    {{ $row }}
                                                </label>
                                                @if ($no++%4 == 0 && $no<=23)
                                                <br>
                                                @endif
                                                @if ($no>=24 && $no<=26 && $no++%3 == 0)
                                                <br>
                                                @endif
                                                @if ($no>=28)
                                                <br>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="nav-tabs-custom" id="scope_section">
                                            <ul class="nav nav-tabs">
                                                <label for="">Permission Scope</label>
                                            </ul>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input id="rb_company" type="radio" class="form-check-input" name="scope" value="Company" {{ ($getRole->scope == "Company") ? "checked" : "" }}  {{ (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Permission')) && request()->get('role') != 'Cashier' ? '' : 'disabled' }}>
                                                Company
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input id="rb_business_unit" type="radio" class="form-check-input" name="scope" value="Business Unit" {{ ($getRole->scope == "Business Unit") ? "checked" : "" }} {{ (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Permission')) && request()->get('role') != 'Cashier' ? '' : 'disabled' }}>
                                                Business Unit
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input id="rb_outlet" type="radio" class="form-check-input" name="scope" value="Branch" {{ ($getRole->scope == "Branch") ? "checked" : "" }} {{ (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Permission')) && request()->get('role') != 'Cashier' ? '' : 'disabled' }}>
                                                Outlet
                                                </label>
                                            </div>
                        
                                            
                                        </div>
                                    </div>

                                    <div class="float-right">
                                        <button class="btn {{ (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Permission')) && request()->get('role') != 'Cashier' ? 'btn-primary' : 'btn-secondary' }} btn-md" {{ (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Permission')) && request()->get('role') != 'Cashier' ? '' : 'disabled' }}>
                                            <i class="fa fa-send"></i>Save
                                        </button>
                                    </div>

                                </div>

                            </div>

                        </form>
                        @endif

                    </div>
                </div>
            </div>

        </div>
        <!-- row END -->

        <!-- -------------------------------------------------------------------------------------------------------------------------- -->

    </div>
    <!-- content-header END -->

</div>
<!-- content-wrapper END -->
@endsection

@section('js')
<script>
    jQuery(document).ready(function($) {

        if($('#rb_business_unit').is(':checked')) { 
                $('#scope_section').append('<div class="alert alert-warning scope_info mt-3" role="alert">Business unit scope refer to assigned user\'s business unit.</div><a href="{{ route('user.index') }}"><u><p class="scope_info">Set user\'s business unit and outlet</p></u></a>');
        }

        if($('#rb_outlet').is(':checked')) { 
                $('#scope_section').append('<div class="alert alert-warning scope_info  mt-3" role="alert">Outlet scope refer to assigned user\'s outlet.</div><a href="{{ route('user.index') }}"><u><p class="scope_info">Set user\'s business unit and outlet</p></u></a>');
        }

    });
</script>
@endsection