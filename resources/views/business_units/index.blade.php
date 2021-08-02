@extends('layouts.master')

@section('title')
<title>ARAH POS - BUSINESS UNIT</title>
@endsection

@section('content')

<div class="content-wrapper">

    <div class="content-header">

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">Business Unit Management</h3>
                </div>
                <div class="col-sm-6 mt-3">
                    <ol class="breadcrumb breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('business-unit.index') }}">Business</a></li>
                        <li class="breadcrumb-item active">Business Unit</li>
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
                                <h3 class="card-title">All Business Unit</h3>
                                <p class="card-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            </div>

                            @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Create Business Unit'))
                            <div class="col-md-4">
                                <div class="grid-margin float-lg-right mb-3">
                                    <button type="button" class="btn btn-md btn-primary btn-icon-text" data-toggle="modal" data-target="#addBusinessUnitModal">
                                        <i class="ti-plus btn-icon-prepend"></i>
                                        Add Business Unit
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table id="indexBusinessUnitTable" class="display expandable-table table-hover table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Business Unit Name</th>
                                        <th>Business Type</th>
                                        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Business Unit') || auth()->user()->hasPermissionTo('Delete Business Unit'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @forelse ($business_units as $index => $row)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $row->business_unit_name }}</td>
                                        <td>{{ $row->business_type }}</td>
                                        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Business Unit') || auth()->user()->hasPermissionTo('Delete Business Unit'))
                                        <td class="text-right">
                                            @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Business Unit'))
                                            <button class="btn btn-light mb-2" data-toggle="modal" data-target="#editBusinessUnitModal" data-id="{{ $row->id }}">
                                                <i class="ti-pencil-alt text-primary"></i>Edit
                                            </button>
                                            @endif
                                            @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Delete Business Unit'))
                                            <button class="btn btn-light" data-toggle="modal" data-target="#deleteBusinessUnitModal" data-id="{{ $row->id }}">
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

        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Create Business Unit'))
        @include('business_units.modal.add')
        @endif
        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Edit Business Unit'))
        @include('business_units.modal.edit')
        @endif
        @if (auth()->user()->hasRole('Master') || auth()->user()->hasPermissionTo('Delete Business Unit'))
        @include('business_units.modal.delete')
        @endif

    </div>
    <!-- content-header END -->

</div>
<!-- content-wrapper END -->
@endsection

@section('js')
<script>
    jQuery(document).ready(function($) {

        $('#editBusinessUnitModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            $.ajax({
                url: 'business-unit/' + id + '/edit',
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    var url = "{{ route('business-unit.update', ':id') }}";
                    url = url.replace(":id", id);

                    $("#editBusinessUnitModal .modal-dialog form").attr("action", url);
                    $("#business_unit_name").val(response.business_units.business_unit_name);

                    $('#editBusinessUnitModal form .modal-content .form-group select option[value="' + response.business_units.business_type + '"]').attr("selected", "selected");

                }

            });

        })

        $('#deleteBusinessUnitModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes

            var url = "{{ route('business-unit.destroy', ':id') }}";
            url = url.replace(":id", id);

            $("#deleteBusinessUnitModal .modal-dialog form").attr("action", url);

        })

        $('#indexBusinessUnitTable').DataTable();

    });
</script>
@endsection