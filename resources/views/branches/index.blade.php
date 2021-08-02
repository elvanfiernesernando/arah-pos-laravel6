@extends('layouts.master')

@section('title')
<title>ARAH POS - OUTLET</title>
@endsection

@section('content')

<div class="content-wrapper">

    <div class="content-header">

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">Outlet Management</h3>
                </div>
                <div class="col-sm-6 mt-3">
                    <ol class="breadcrumb breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('outlet.index') }}">Business</a></li>
                        <li class="breadcrumb-item active">Outlet</li>
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
                                <h3 class="card-title">All Outlet</h3>
                                <p class="card-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            </div>

                            @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Create Outlet'))
                            <div class="col-md-4">
                                <div class="grid-margin float-lg-right mb-3">
                                    <button type="button" class="btn btn-md btn-primary btn-icon-text" data-toggle="modal" data-target="#addBranchModal">
                                        <i class="ti-plus btn-icon-prepend"></i>
                                        Add Outlet
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table id="indexBranchTable" class="display expandable-table table-hover table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Outlet Name</th>
                                        <th>Business Unit</th>
                                        <th>Outlet Address</th>
                                        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Outlet') || auth()->user()->hasPermissionTo('Delete Outlet'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @forelse ($branches as $index => $row)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $row->branch_name }}</td>
                                        <td>{{ $row->business_unit->business_unit_name}}</td>
                                        <td>{{ $row->branch_address }}</td>
                                        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Outlet') || auth()->user()->hasPermissionTo('Delete Outlet'))
                                        <td class="text-right">
                                            @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Outlet'))
                                            <button class="btn btn-light mb-2" data-toggle="modal" data-target="#editBranchModal" data-id="{{ $row->id }}">
                                                <i class="ti-pencil-alt text-primary"></i>Edit
                                            </button>
                                            @endif
                                            @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Delete Outlet'))
                                            <button class="btn btn-light" data-toggle="modal" data-target="#deleteBranchModal" data-id="{{ $row->id }}">
                                                <i class="ti-close text-danger"></i>Remove
                                            </button>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No data</td>
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

        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Create Outlet'))
        @include('branches.modal.add')
        @endif
        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Outlet'))
        @include('branches.modal.edit')
        @endif
        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Delete Outlet'))
        @include('branches.modal.delete')
        @endif

    </div>
    <!-- content-header END -->

</div>
<!-- content-wrapper END -->
@endsection

@section('js')
<script>
    jQuery(document).ready(function($) {

        $('#addBranchModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal

            $.ajax({
                url: 'outlet/create',
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    // Mengosongkan form-group select terlebih dahulu
                    $('#addBranchModal form .modal-content .form-group select').empty();
                    // Mengisi bagian 'Choose'
                    $('#addBranchModal form .modal-content .form-group select').append('<option value="">Choose</option>');

                    // Populate isi dari kategori
                    for (var i = 0; i < response.data.length; i++) {

                        $('#addBranchModal form .modal-content .form-group select').append('<option value="' + response.data[i]['id'] + '">' + response.data[i]['business_unit_name'] + '</option>');
                    }
                }
            });

        })

        $('#editBranchModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes

            $.ajax({
                url: 'outlet/' + id + '/edit',
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    // Buat variable URL untuk Route Edit Branch
                    var url = "{{ route('outlet.update', ':id') }}";
                    url = url.replace(":id", id);

                    // Masukan variable url ke dalam form attribut 'action'
                    $("#editBranchModal .modal-dialog form").attr("action", url);

                    // Masukan value dari response ke dalam element
                    $("#branch_name").val(response.branches.branch_name);
                    $("#branch_address").val(response.branches.branch_address);

                    // Mengosongkan form-group select terlebih dahulu
                    $('#editBranchModal form .modal-content .form-group select').empty();

                    // Populate isi dari kategori
                    for (var i = 0; i < response.business_units.length; i++) {

                        $('#editBranchModal form .modal-content .form-group select').append('<option value="' + response.business_units[i]['id'] + '"' +
                            (response.business_units[i]['id'] === response.branches.business_unit_id ? 'selected' : '') +
                            '>' + response.business_units[i]['business_unit_name'] + '</option>');
                    }

                }
            });

        });

        $('#deleteBranchModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes

            var url = "{{ route('outlet.destroy', ':id') }}";
            url = url.replace(":id", id);

            $("#deleteBranchModal .modal-dialog form").attr("action", url);

        })

        $('#indexBranchTable').DataTable();

    });
</script>
@endsection