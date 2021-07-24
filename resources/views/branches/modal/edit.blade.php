<!--Edit Modal Branch START-->
<div class="modal fade" id="editBranchModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBranchModalLabel">Edit Outlet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="branch_name">Outlet Name</label>
                        <input id="branch_name" type="text" name="branch_name" class="form-control {{ $errors->has('branch_name') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('branch_name') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="business_unit_id">Business Unit</label>
                        <select name="business_unit_id" id="business_unit_id" required class="form-control {{ $errors->has('business_unit_id') ? 'is-invalid':'' }}">
                            <option value="">Choose</option>
                        </select>
                        <p class="text-danger">{{ $errors->first('business_unit_id') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="branch_address">Address</label>
                        <input id="branch_address" type="text" name="branch_address" class="form-control {{ $errors->has('branch_address') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('branch_address') }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--Edit Modal Branch END -->