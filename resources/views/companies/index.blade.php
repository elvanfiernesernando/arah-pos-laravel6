@extends('layouts.master')

@section('title')
<title>ARAH POS - COMPANY</title>
@endsection

@section('content')
<div class="content-wrapper">

    <div class="content-header">

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">Company Profile</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Company</li>
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

        <!-- Row START -->
        <div class="row">

            <!-- Company Profile START -->
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Company Detail</h4>
                        <p class="card-description">
                        </p>

                        <form action="#" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Company Name</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" readonly value=" {{ $companies->name}}">
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" class="form-control {{ $errors->has('address') ? 'is-invalid':'' }}" readonly value=" {{ $companies->address}}">
                                <p class="text-danger">{{ $errors->first('address') }}</p>
                            </div>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Company Profile END -->

            <!-- Business Unit START -->
            <div class="col-md-8">

                <div class="row grid-margin stretch-card">

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h3 class="card-title">All Business Unit</h3>
                                    <p class="card-description">Lorem Ipsum is simply dummy text of the printing.</p>
                                </div>

                                <div class="col-md-4">
                                    <div class="grid-margin float-lg-right mb-3">
                                        <button type="button" class="btn btn-md btn-primary btn-icon-text" data-toggle="modal" data-target="#addBusinessUnitModal">
                                            <i class="ti-file btn-icon-prepend"></i>
                                            Add Business Unit
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="indexBusinessUnitTable" class="display expandable-table table-hover table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Business Unit Name</th>
                                            <th>Business Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $business_unit_no = 1; @endphp
                                        @forelse ($business_units as $business_unit => $row_business_unit)
                                        <tr>
                                            <td>{{ $business_unit_no++ }}</td>
                                            <td>{{ $row_business_unit->name }}</td>
                                            <td>{{ $row_business_unit->business_type }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm mb-1" data-toggle="modal" data-target="#editBusinessUnitModal" data-id="{{ $row_business_unit->id }}">Edit</button>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteBusinessUnitModal" data-id="{{ $row_business_unit->id }}">Delete</button>
                                            </td>
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
            <!--  Business Unit END-->



        </div>
        <!-- row END -->

        <!-- Branch START -->
        <div class="col-md-12">

            <div class="row grid-margin stretch-card">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h3 class="card-title">All Branch</h3>
                                <p class="card-description">Lorem Ipsum is simply dummy text of the printing.</p>
                            </div>

                            <div class="col-md-4">
                                <div class="grid-margin float-lg-right mb-3">
                                    <button type="button" class="btn btn-md btn-primary btn-icon-text" data-toggle="modal" data-target="#addBranchModal">
                                        <i class="ti-file btn-icon-prepend"></i>
                                        Add Branch
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="indexBranchTable" class="display expandable-table table-hover table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Branch</th>
                                        <th>Business Unit</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $branch_no = 1; @endphp
                                    @forelse ($branches as $index => $row_branch)
                                    <tr>
                                        <td>{{ $branch_no++ }}</td>
                                        <td>{{ $row_branch->name }}</td>
                                        <td>{{ $row_branch->business_unit->name }}</td>
                                        <td>{{ $row_branch->address }}</td>
                                        <td>
                                            <button class=" btn btn-info btn-sm mb-1" data-toggle="modal" data-target="#editBranchModal" data-id="{{ $row_branch->id }}">Edit</button>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteBranchUnitModal" data-id="{{ $row_branch->id }}">Delete</button>
                                        </td>
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
        <!-- Branch END -->

        @include('companies.business_units.add')

        <!-- Modal Branch START-->
        <div class="modal fade" id="addBranchModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addBranchModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('branch.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addBranchModalLabel">Add New Branch</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}">
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="">Business Unit</label>
                                <select name="business_type" id="business_type" required class="form-control {{ $errors->has('business_type') ? 'is-invalid':'' }}">
                                    <option value="">Choose</option>
                                </select>
                                <p class="text-danger">{{ $errors->first('business_type') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" class="form-control {{ $errors->has('address') ? 'is-invalid':'' }}">
                                <p class="text-danger">{{ $errors->first('address') }}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Branch END -->

        <!-- ---------------------------------------------------  MAIN CONTENT END ----------------------------------------------------------------------- -->


    </div>
    <!-- content-header END -->

</div>
<!-- content-wrapper END -->
@endsection

@section('js')
<script>
    jQuery(document).ready(function($) {

        $('#addBusinessUnitModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal

            $.ajax({
                url: 'business/create',
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    // Mengosongkan form-group select terlebih dahulu
                    $('#addBusinessUnitModal form .modal-content .form-group select').empty();
                    // Mengisi bagian 'Choose'
                    $('#addBusinessUnitModal form .modal-content .form-group select').append('<option value="">Choose</option>');

                    // Populate isi dari kategori
                    for (var i = 0; i < response.data.length; i++) {

                        $('#addBusinessUnitModal form .modal-content .form-group select').append('<option value="' + response.data[i]['id'] + '">' + response.data[i]['name'] + '</option>');
                    }
                }
            });

        })

        $('#indexBusinessUnitTable').DataTable({
            "lengthMenu": [
                [1, 2, 3, 4, 5],
                [1, 2, 3, 4, 5]
            ]
        });

        $('#indexBranchTable').DataTable();

    });
</script>
@endsection