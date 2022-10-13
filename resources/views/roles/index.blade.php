@extends('layouts.master')

@section('title')
<title>ARAH POS - ROLE</title>
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
                        <li class="breadcrumb-item active">Role</li>
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

            <!-- Create New Role START -->
            @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Create Role'))
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Role</h4>
                        <p class="card-description">After creating role, please go to permission page to add or edit role permission.</p>

                        <form action="{{ route('role.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" placeholder="Manager or Kitchen Crew">
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="scope">Scope</label>
                                <select name="scope" id="scope" class=" form-control">
                                    <option value="">Choose</option>
                                    <!-- Tambah Jenis Bisnis Disini -->
                                    <option value="Company">Company</option>
                                    <option value="Business Unit">Business Unit</option>
                                    <option value="Branch">Outlet</option>
                                    <!-- Tambah Jenis Bisnis Disini END-->
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Create</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            <!-- New Role END -->

            <div class="{{ auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Create Role') ? 'col-md-8' : 'col-md-12'}} grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Role</h4>
                        <p class="card-description">Cashier role is available by default. It cannot be changed or deleted.</p>

                        <div class="table-responsive">
                            <table id="indexRoleTable" class="display expandable-table table-hover table-striped" width="100%"">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Role</th>
                                        <th>Scope</th>
                                        <th>Created At</th>
                                        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Delete Role'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $index => $row)
                                    <tr>
                                        <td>{{ $index + $roles->firstItem() }}</td>
                                        <td>{{ $row->name }}</td>
                                        @if (strpos($row->scope, 'Branch') !== FALSE)
                                        <td> Outlet </td>
                                        @else
                                        <td>{{ $row->scope }}</td>

                                        @endif
                                        <td>{{ $row->created_at }}</td>
                                        <td>
                                            @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Delete Role'))
                                            @if ($row->name != 'Cashier')
                                            <button class=" btn btn-light" data-toggle="modal" data-target="#deleteRoleModal" data-id="{{ $row->id }}">
                                <i class="ti-close text-danger"></i>Remove
                                </button>
                                @endif
                                @endif
                                </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan=" 4" class="text-center">No data</td>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                            {{ $roles->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- row END -->

        <!-- -------------------------------------------------------------------------------------------------------------------------- -->

        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Delete Role'))
        @include('roles.modal.delete')
        @endif

    </div>
    <!-- content-header END -->

</div>
<!-- content-wrapper END -->
@endsection

@section('js')
@section('js')
<script>
    jQuery(document).ready(function($) {

        $('#deleteRoleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes

            var url = "{{ route('role.destroy', ':id') }}";
            url = url.replace(":id", id);

            $("#deleteRoleModal .modal-dialog form").attr("action", url);

        })

        $('#indexRoleTable').DataTable();

    });
</script>
@endsection
@endsection