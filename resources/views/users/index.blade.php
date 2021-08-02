@extends('layouts.master')

@section('title')
<title>ARAH POS - USER</title>
@endsection

@section('content')
<div class="content-wrapper">

    <div class="content-header">

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">Employee Management</h3>
                </div>
                <div class="col-sm-6 mt-3">
                    <ol class="breadcrumb breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Employee</a></li>
                        <li class="breadcrumb-item active">Employee</li>
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

            <div class="col-md-12 grid-margin stretch-card">

                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8">
                                <h3 class="card-title">All Employee</h3>
                                <p class="card-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            </div>

                            @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Create Employee'))
                            <div class="col-md-4">
                                <div class="grid-margin float-lg-right mb-3">
                                    <button type="button" class="btn btn-md btn-primary btn-icon-text" data-toggle="modal" data-target="#addEmployeeModal">
                                        <i class="ti-plus btn-icon-prepend"></i>
                                        Add Employee
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table id="indexEmployeeTable" class="display expandable-table table-hover table-striped" width="100%"">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Business Unit</th>
                                        <th>Branch</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Employee') || auth()->user()->hasPermissionTo('Delete Employee'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @forelse ($users as $index => $row)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>{{ $row->branch->first()->business_unit->business_unit_name }}</td>
                                        <td>{{ $row->branch->first()->branch_name }}</td>
                                        <td>
                                            @foreach ($row->getRoleNames() as $role)
                                            <label for="" class=" badge badge-info">{{ $role }}</label>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($row->status)
                                            <label class="badge badge-success">Active</label>
                                            @else
                                            <label for="" class="badge badge-danger">Suspend</label>
                                            @endif
                                        </td>
                                        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Employee') || auth()->user()->hasPermissionTo('Delete Employee'))
                                        <td class="text-right">
                                            @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Employee'))
                                            <button class="btn btn-light mb-2" data-toggle="modal" data-target="#editEmployeeModal" data-id="{{ $row->id }}">
                                                <i class="ti-pencil-alt text-primary"></i>Edit
                                            </button>
                                            @endif
                                            @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Delete Employee'))
                                            <button class="btn btn-light" data-toggle="modal" data-target="#deleteEmployeeModal" data-id="{{ $row->id }}">
                                                <i class="ti-close text-danger"></i>Remove
                                            </button>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="12" class="text-center">No data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- row END -->

        <!-- -------------------------------------------------------------------------------------------------------------------------- -->

        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Create Employee'))
        @include('users.modal.add')
        @endif
        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Employee'))
        @include('users.modal.edit')
        @endif
        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Delete Employee'))
        @include('users.modal.delete')
        @endif


    </div>
    <!-- content-header END -->

</div>
<!-- content-wrapper END -->
@endsection

@section('js')
<script>
    jQuery(document).ready(function($) {

        $('#addEmployeeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal

            $('#addEmployeeModal form .modal-content .form-group .business_unit').change(function() {
                var business_unit_id = $(this).val();

                $.ajax({
                    url: 'user/branch',
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: business_unit_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Mengosongkan form-group select terlebih dahulu
                        $('#addEmployeeModal form .modal-content .form-group .branch').empty();
                        // Mengisi bagian 'Choose'
                        $('#addEmployeeModal form .modal-content .form-group .branch').append('<option value="">Choose</option>');

                        // Populate isi dari kategori
                        for (var i = 0; i < response.data.length; i++) {

                            $('#addEmployeeModal form .modal-content .form-group .branch').append('<option value="' + response.data[i]['id'] + '">' + response.data[i]['branch_name'] + '</option>');
                        }
                    }
                });

            });

            $.ajax({
                url: 'user/create',
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    // Mengosongkan form-group select terlebih dahulu
                    $('#addEmployeeModal form .modal-content .form-group select').empty();
                    // Mengisi bagian 'Choose'
                    $('#addEmployeeModal form .modal-content .form-group select').append('<option value="">Choose</option>');

                    // Populate isi dari role
                    for (var i = 0; i < response.data.length; i++) {

                        $('#addEmployeeModal form .modal-content .form-group .role').append('<option value="' + response.data[i]['id'] + '">' + response.data[i]['name'] + '</option>');
                    }

                    // Populate isi dari business_unit
                    for (var i = 0; i < response.business_units.length; i++) {

                        $('#addEmployeeModal form .modal-content .form-group .business_unit').append('<option value="' + response.business_units[i]['id'] + '">' + response.business_units[i]['business_unit_name'] + '</option>');
                    }
                }
            });

        })

        $('#editEmployeeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes

            $('#editEmployeeModal form .modal-content .form-group .business_unit').change(function() {
                var business_unit_id = $(this).val();

                $.ajax({
                    url: 'user/branch',
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: business_unit_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Mengosongkan form-group select terlebih dahulu
                        $('#editEmployeeModal form .modal-content .form-group .branch').empty();
                        // Mengisi bagian 'Choose'
                        $('#editEmployeeModal form .modal-content .form-group .branch').append('<option value="">Choose</option>');

                        // Populate isi dari kategori
                        for (var i = 0; i < response.data.length; i++) {

                            $('#editEmployeeModal form .modal-content .form-group .branch').append('<option value="' + response.data[i]['id'] + '">' + response.data[i]['branch_name'] + '</option>');
                        }
                    }
                });

            });

            $.ajax({
                url: 'user/' + id + '/edit',
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    // Buat variable URL untuk Route Edit Product
                    var url = "{{ route('user.update', ':id') }}";
                    url = url.replace(":id", id);

                    // Masukan variable url ke dalam form attribut 'action'
                    $("#editEmployeeModal .modal-dialog form").attr("action", url);

                    // Masukan value dari response ke dalam element
                    $("#name").val(response.data.name);
                    $("#email").val(response.data.email);

                    // Mengosongkan form-group select terlebih dahulu
                    $('#editEmployeeModal form .modal-content .form-group select').empty();

                    // Mengisi bagian 'Choose'
                    $('#editEmployeeModal form .modal-content .form-group .business_unit').append('<option value="">Choose</option>');
                    $('#editEmployeeModal form .modal-content .form-group .branch').append('<option value="">Choose</option>');

                    // Populate isi dari business unit
                    for (var i = 0; i < response.business_units.length; i++) {

                        $('#editEmployeeModal form .modal-content .form-group .business_unit').append('<option value="' + response.business_units[i]['id'] + '"' +
                            (response.business_units[i]['id'] === response.user_business_unit.id ? 'selected' : '') +
                            '>' + response.business_units[i]['business_unit_name'] + '</option>');
                    }

                    // Populate isi dari branch
                    for (var j = 0; j < response.branches.length; j++) {

                        $('#editEmployeeModal form .modal-content .form-group .branch').append('<option value="' + response.branches[j]['id'] + '"' +
                            (response.branches[j]['id'] === response.user_branch.id ? 'selected' : '') +
                            '>' + response.branches[j]['branch_name'] + '</option>');
                    }

                    // Populate isi dari Role
                    for (var k = 0; k < response.roles.length; k++) {

                        $('#editEmployeeModal form .modal-content .form-group .role').append('<option value="' + response.roles[k]['id'] + '"' +
                            (response.roles[k]['id'] === response.user_role.id ? 'selected' : '') +
                            '>' + response.roles[k]['name'] + '</option>');
                    }

                }
            });

        })

        $('#deleteEmployeeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes

            var url = "{{ route('user.destroy', ':id') }}";
            url = url.replace(":id", id);

            $("#deleteEmployeeModal .modal-dialog form").attr("action", url);

        })

        $('#indexEmployeeTable').DataTable();

    });
</script>
@endsection