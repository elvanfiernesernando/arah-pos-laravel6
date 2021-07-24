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
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Role</h4>
                        <p class="card-description">
                        </p>

                        <form action="{{ route('role.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" placeholder="Cashier or Manager">
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Create</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- New Role END -->

            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Role</h4>
                        <p class="card-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>

                        <div class="table-responsive">
                            <table id="indexRoleTable" class="display expandable-table table-hover table-striped" width="100%"">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $index => $row)
                                    <tr>
                                        <td>{{ $index + $roles->firstItem() }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->created_at }}</td>
                                        <td>
                                            @if ($row->name != 'Cashier')
                                            <button class=" btn btn-light" data-toggle="modal" data-target="#deleteRoleModal" data-id="{{ $row->id }}">
                                <i class="ti-close text-danger"></i>Remove
                                </button>
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

        @include('roles.modal.delete')

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