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
            <div class="col-md-4 grid-margin stretch-card">
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
            </div>
            <!-- New permission END -->

            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Set Permission to this Role</h4>
                        <p class="card-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>

                        <form action="{{ route('permission.roles_permission') }}" method="GET">
                            <div class="form-group">
                                <label for="">Roles</label>
                                <div class="input-group">
                                    <select name="role" class="form-control">
                                        @foreach ($roles as $value)
                                        <option value="{{ $value }}" {{ request()->get('role') == $value ? 'selected':'' }}>{{ $value }}</option>
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
                            <div class="form-group">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <label for="">Permissions</label>
                                    </ul>
                                    @php $no = 1; @endphp
                                    @foreach ($permissions as $key => $row)
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="permission[]" class="form-check-input" value="{{ $row }}" {{--  CHECK, JIKA PERMISSION TERSEBUT SUDAH DI SET, MAKA CHECKED --}} {{ in_array($row, $hasPermission) ? 'checked':'' }}>
                                            {{ $row }}
                                        </label>
                                        @if ($no++%4 == 0)
                                        <br>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="float-right">
                                <button class="btn btn-primary btn-md">
                                    <i class="fa fa-send"></i>Save Permission
                                </button>
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