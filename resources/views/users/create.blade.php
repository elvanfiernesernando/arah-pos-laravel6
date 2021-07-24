@extends('layouts.master')
​
@section('title')
<title>ARAH POS - Add User</title>
@endsection

@section('content')
<div class="content-wrapper">

    <div class="content-header">

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">User Management > Add User</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- ------------------------------------------- MAIN CONTENT --------------------------------------------------------------- -->

            <!-- Create New Category START -->
            <div class="col-md-8 grid-margin stretch-card mx-0">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add User</h4>
                        <p class="card-description">
                        </p>

                        @if (session('error'))
                        @alert(['type' => 'danger'])
                        {!! session('error') !!}
                        @endalert
                        @endif

                        <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" required class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}">
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" required class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}">
                                <p class="text-danger">{{ $errors->first('email') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" required class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}">
                                <p class="text-danger">{{ $errors->first('password') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Role</label>
                                <select name="role" class="form-control {{ $errors->has('role') ? 'is-invalid':'' }}" required>
                                    <option value="">Choose</option>
                                    @foreach ($roles as $row)
                                    <option value="{{ $row->name }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->first('role') }}</p>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-md">
                                    <i class="fa fa-send"></i> Save
                                </button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
            <!-- New category END -->

            <!-- -------------------------------------------------------------------------------------------------------------------------- -->

        </div>
        <!-- row END -->

    </div>
    <!-- content-header END -->

</div>
<!-- content-wrapper END -->
@endsection