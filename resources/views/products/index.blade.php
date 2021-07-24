@extends('layouts.master')

@section('title')
<title>ARAH POS - PRODUCT</title>
@endsection

@section('content')
<div class="content-wrapper">

    <div class="content-header">

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">Product Management</h3>
                </div>
                <div class="col-sm-6 mt-3">
                    <ol class="breadcrumb breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Inventory</a></li>
                        <li class="breadcrumb-item active">Product</li>
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

        <!-- ------------------------------------------- MAIN CONTENT START--------------------------------------------------------------- -->

        <div class="row">

            <div class="col-md-12 grid-margin stretch-card">

                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8">
                                <h3 class="card-title">All Product</h3>
                                <p class="card-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            </div>

                            @if (auth()->user()->roles('Master') || auth()->user()->can('Create Product'))
                            <div class="col-md-4">
                                <div class="grid-margin float-lg-right mb-3">
                                    <button type="button" class="btn btn-md btn-primary btn-icon-text" data-toggle="modal" data-target="#addProductModal">
                                        <i class="ti-plus btn-icon-prepend"></i>
                                        Add Product
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table id="indexProductTable" class="display expandable-table table-hover table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th>Cost of Goods Sold</th>
                                        <th>Business Unit</th>
                                        <th>Category</th>
                                        <th>Last update</th>
                                        @if (auth()->user()->roles('Master') || auth()->user()->can('Edit Product') || auth()->user()->can('Delete Product'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @forelse ($products as $index => $row)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>
                                            @if (!empty($row->product_photo))
                                            <img src=" {{ asset('uploads/product/' . $row->product_photo) }}" alt="{{ $row->product_name }}" width="50px" height="50px">
                                            @else
                                            <img src="http://via.placeholder.com/50x50" alt="{{ $row->product_name }}">
                                            @endif
                                        </td>
                                        <td>
                                            <sup>
                                                <label class="badge badge-success">({{ $row->product_sku }})</label>
                                            </sup><br>
                                            <strong>{{ ucfirst($row->product_name) }}</strong>
                                        </td>
                                        <td>{{ $row->product_stock }}</td>
                                        <td>Rp. {{ number_format($row->product_price) }}</td>
                                        <td>Rp. {{ number_format($row->product_cogs) }} </td>
                                        <td>{{ $row->category->business_unit->business_unit_name }}</td>
                                        <td>{{ $row->category->category_name }}</td>
                                        <td>{{ $row->updated_at }}</td>
                                        @if (auth()->user()->roles('Master') || auth()->user()->can('Edit Product') || auth()->user()->can('Delete Product'))
                                        <td class="text-right">
                                            @if (auth()->user()->roles('Master') || auth()->user()->can('Edit Product'))
                                            <button class="btn btn-light mb-2" data-toggle="modal" data-target="#editProductModal" data-id="{{ $row->id }}">
                                                <i class="ti-pencil-alt text-primary"></i>Edit
                                            </button>
                                            @endif
                                            @if (auth()->user()->roles('Master') || auth()->user()->can('Delete Product'))
                                            <button class="btn btn-light" data-toggle="modal" data-target="#deleteProductModal" data-id="{{ $row->id }}">
                                                <i class="ti-close text-danger"></i>Remove
                                            </button>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No data</td>
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

        <!-- ------------------------------------------------------ MAIN CONTENT END -------------------------------------------------------------------- -->

        @if (auth()->user()->roles('Master') || auth()->user()->can('Create Product'))
        @include('products.modal.add')
        @endif
        @if (auth()->user()->roles('Master') || auth()->user()->can('Edit Product'))
        @include('products.modal.edit')
        @endif
        @if (auth()->user()->roles('Master') || auth()->user()->can('Delete Product'))
        @include('products.modal.delete')
        @endif

    </div>
    <!-- content-header END -->

</div>
<!-- content-wrapper END -->
@endsection

@section('js')
<script>
    jQuery(document).ready(function($) {

        $('#addProductModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal

            $.ajax({
                url: 'product/create',
                type: "GET",
                dataType: 'json',
                success: function(response) {

                    // Mengosongkan form-group select terlebih dahulu
                    $('#addProductModal form .modal-content .form-group .business_unit').empty();
                    // Mengisi bagian 'Choose'
                    $('#addProductModal form .modal-content .form-group .business_unit').append('<option value="">Choose</option>');

                    // Populate isi dari kategori
                    for (var i = 0; i < response.data.length; i++) {

                        $('#addProductModal form .modal-content .form-group .business_unit').append('<option value="' + response.data[i]['id'] + '">' + response.data[i]['business_unit_name'] + '</option>');
                    }
                }
            });

            $('#addProductModal form .modal-content .form-group .business_unit').change(function() {
                var business_unit_id = $(this).val();

                $.ajax({
                    url: 'product/category',
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: business_unit_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Mengosongkan form-group select terlebih dahulu
                        $('#addProductModal form .modal-content .form-group .category').empty();
                        // Mengisi bagian 'Choose'
                        $('#addProductModal form .modal-content .form-group .category').append('<option value="">Choose</option>');

                        // Populate isi dari kategori
                        for (var i = 0; i < response.data.length; i++) {

                            $('#addProductModal form .modal-content .form-group .category').append('<option value="' + response.data[i]['id'] + '">' + response.data[i]['category_name'] + '</option>');
                        }
                    }
                });

            });

        })

        $('#editProductModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes

            $('#editProductModal form .modal-content .form-group .business_unit').change(function() {
                var business_unit_id = $(this).val();

                $.ajax({
                    url: 'product/category',
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: business_unit_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Mengosongkan form-group select terlebih dahulu
                        $('#editProductModal form .modal-content .form-group .category').empty();
                        // Mengisi bagian 'Choose'
                        $('#editProductModal form .modal-content .form-group .category').append('<option value="">Choose</option>');

                        // Populate isi dari kategori
                        for (var i = 0; i < response.data.length; i++) {

                            $('#editProductModal form .modal-content .form-group .category').append('<option value="' + response.data[i]['id'] + '">' + response.data[i]['category_name'] + '</option>');
                        }
                    }
                });

            });

            $.ajax({
                url: 'product/' + id + '/edit',
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    // Buat variable URL untuk Route Edit Product
                    var url = "{{ route('product.update', ':id') }}";
                    url = url.replace(":id", id);

                    // Masukan variable url ke dalam form attribut 'action'
                    $("#editProductModal .modal-dialog form").attr("action", url);

                    console.log(response.current_product_categories.id)

                    // Masukan value dari response ke dalam element
                    $("#product_sku").val(response.data.product_sku);
                    $("#product_name").val(response.data.product_name);
                    $("#product_description").text(response.data.product_description);
                    $("#product_stock").val(response.data.product_stock);
                    $("#product_price").val(response.data.product_price);
                    $("#product_cogs").val(response.data.product_cogs);

                    // Mengosongkan form-group select terlebih dahulu
                    $('#editProductModal form .modal-content .form-group select').empty();
                    // Mengisi bagian 'Choose'
                    $('#editProductModal form .modal-content .form-group select').append('<option value="">Choose</option>');

                    // Populate isi dari business unit
                    for (var i = 0; i < response.business_units.length; i++) {

                        $('#editProductModal form .modal-content .form-group .business_unit').append('<option value="' + response.business_units[i]['id'] + '"' +
                            (response.business_units[i]['id'] === response.current_business_unit.id ? 'selected' : '') +
                            '>' + response.business_units[i]['business_unit_name'] + '</option>');
                    }

                    // Populate isi dari branch
                    for (var j = 0; j < response.categories.length; j++) {

                        $('#editProductModal form .modal-content .form-group .category').append('<option value="' + response.categories[j]['id'] + '"' +
                            (response.categories[j]['id'] === response.current_product_categories.id ? 'selected' : '') +
                            '>' + response.categories[j]['category_name'] + '</option>');
                    }

                    // Cek apakah photo tersedia
                    // Jika ada, maka set src sebagai berikut, jika tidak ada set src menjadi default placeholder
                    if (response.data.product_photo != null) {
                        var product_photo_url = "{{ asset('uploads/product/' . ':photo_name') }}"
                        product_photo_url = product_photo_url.replace(":photo_name", response.data.product_photo);
                    } else {
                        var product_photo_url = "{{ asset('uploads/product/placeholder/' . ':photo_name') }}"
                        product_photo_url = product_photo_url.replace(":photo_name", "no_image.png");
                    }

                    // Tambahkan attribut src dan alt ke element img
                    $('#editProductModal form .modal-content .form-group img').attr({
                        src: product_photo_url,
                        alt: response.data.product_name
                    });

                }
            });

        })

        $('#deleteProductModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes

            var url = "{{ route('product.destroy', ':id') }}";
            url = url.replace(":id", id);

            $("#deleteProductModal .modal-dialog form").attr("action", url);

        })

        $('#indexProductTable').DataTable();

    });
</script>
@endsection