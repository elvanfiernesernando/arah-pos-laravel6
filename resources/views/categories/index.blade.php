@extends('layouts.master')

@section('title')
<title>ARAH POS - CATEGORY</title>
@endsection

@section('content')

<div class="content-wrapper">

    <div class="content-header">

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">Category Management</h3>
                </div>
                <div class="col-sm-6 mt-3">
                    <ol class="breadcrumb breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Inventory</a></li>
                        <li class="breadcrumb-item active">Category</li>
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
                                <h3 class="card-title">All Category</h3>
                                <p class="card-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            </div>

                            @if (auth()->user()->roles('Master') || auth()->user()->can('Create Category'))
                            <div class="col-md-4">
                                <div class="grid-margin float-lg-right mb-3">
                                    <button type="button" class="btn btn-md btn-primary btn-icon-text" data-toggle="modal" data-target="#addCategoryModal">
                                        <i class="ti-plus btn-icon-prepend"></i>
                                        Add Category
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table id="indexCategoryTable" class="display expandable-table table-hover table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Category</th>
                                        <th>Business Unit</th>
                                        <th>Description</th>
                                        @if (auth()->user()->roles('Master') || auth()->user()->can('Edit Category') || auth()->user()->can('Delete Category'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @forelse ($categories as $index => $row)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $row->category_name }}</td>
                                        <td>{{ $row->business_unit->business_unit_name }}</td>
                                        <td>{{ $row->category_description ?? "-"}}</td>
                                        @if (auth()->user()->roles('Master') || auth()->user()->can('Edit Category') || auth()->user()->can('Delete Category'))
                                        <td class="text-right">
                                            @if (auth()->user()->roles('Master') || auth()->user()->can('Edit Category'))
                                            <button class="btn btn-light mb-2" data-toggle="modal" data-target="#editCategoryModal" data-id="{{ $row->id }}">
                                                <i class="ti-pencil-alt text-primary"></i>Edit
                                            </button>
                                            @endif
                                            @if (auth()->user()->roles('Master') || auth()->user()->can('Delete Category'))
                                            <button class="btn btn-light" data-toggle="modal" data-target="#deleteCategoryModal" data-id="{{ $row->id }}">
                                                <i class="ti-close text-danger"></i>Remove
                                            </button>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No data</td>
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

        @if (auth()->user()->roles('Master') || auth()->user()->can('Create Category'))
        @include('categories.modal.add')
        @endif
        @if (auth()->user()->roles('Master') || auth()->user()->can('Edit Category'))
        @include('categories.modal.edit')
        @endif
        @if (auth()->user()->roles('Master') || auth()->user()->can('Delete Category'))
        @include('categories.modal.delete')
        @endif

    </div>
    <!-- content-header END -->

</div>
<!-- content-wrapper END -->
@endsection

@section('js')
<script>
    jQuery(document).ready(function($) {

        $('#addCategoryModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal

            $.ajax({
                url: 'category/create',
                type: "GET",
                dataType: 'json',
                success: function(response) {

                    // Mengosongkan form-group select terlebih dahulu
                    $('#addCategoryModal form .modal-content .form-group select').empty();
                    // Mengisi bagian 'Choose'
                    $('#addCategoryModal form .modal-content .form-group select').append('<option value="">Choose</option>');

                    // Populate isi dari unit bisini
                    for (var i = 0; i < response.data.length; i++) {

                        $('#addCategoryModal form .modal-content .form-group select').append('<option value="' + response.data[i]['id'] + '">' + response.data[i]['business_unit_name'] + '</option>');
                    }
                }
            });

        })

        $('#editCategoryModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            $.ajax({
                url: 'category/' + id + '/edit',
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    var url = "{{ route('category.update', ':id') }}";
                    url = url.replace(":id", id);

                    console.log(url)

                    $("#editCategoryModal .modal-dialog form").attr("action", url);
                    $("#category_name").val(response.categories.category_name);

                    // Mengosongkan form-group select terlebih dahulu
                    $('#editCategoryModal form .modal-content .form-group select').empty();
                    // Mengisi bagian 'Choose'
                    $('#editCategoryModal form .modal-content .form-group select').append('<option value="">Choose</option>');

                    // Populate isi dari unit bisini
                    for (var i = 0; i < response.business_units.length; i++) {

                        $('#editCategoryModal form .modal-content .form-group select').append('<option value="' + response.business_units[i]['id'] + '"' +
                            (response.business_units[i]['id'] === response.categories.business_unit_id ? 'selected' : '') +
                            '>' + response.business_units[i]['business_unit_name'] + '</option>');
                    }

                    $("#category_description").text(response.categories.category_description);
                }

            });

            // CARA LAIN UNTUK JQUERY
            // var url = 'category/' + id + '/edit';
            // $.get(url, function(data, status) {
            //     console.log(data.data.name)
            //     $("#name").val(data.data.name);
            //     $("#description").text(data.data.name);
            // });

        })

        $('#deleteCategoryModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes

            var url = "{{ route('category.destroy', ':id') }}";
            url = url.replace(":id", id);

            $("#deleteCategoryModal .modal-dialog form").attr("action", url);

        })

        $('#indexCategoryTable').DataTable();

    });
</script>
@endsection