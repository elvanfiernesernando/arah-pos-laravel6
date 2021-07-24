<!-- Modal Edit Category START-->
<div class="modal fade" id="editBusinessUnitModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editBusinessUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        @if (!empty($row->id))
        <form method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBusinessUnitModalLabel">Edit Business Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="business_unit_name">Name</label>
                        <input type="text" name="business_unit_name" id="business_unit_name" class="form-control {{ $errors->has('business_unit_name') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('business_unit_name') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="">Business Type</label>
                        <select name="business_type" id="business_type" required class="form-control {{ $errors->has('business_type') ? 'is-invalid':'' }}">
                            <option value="">Choose</option>
                            <!-- Tambah Jenis Bisnis Disini -->
                            <option value="Food & Beverages">Food & Beverages</option>
                            <option value="Salon & Barbershop">Salon & Barbershop</option>
                            <option value="Technology">Technology</option>
                            <!-- Tambah Jenis Bisnis Disini END-->
                        </select>
                        <p class="text-danger">{{ $errors->first('business_type') }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
        @endif
    </div>
</div>

<!-- Modal Edit Category END -->