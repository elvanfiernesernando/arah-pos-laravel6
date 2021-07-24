<!-- Modal Branch START-->
<div class="modal fade" id="addBranchModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('outlet.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBranchModalLabel">Add New Outlet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="branch_name">Outlet Name</label>
                        <input type="text" name="branch_name" class="form-control {{ $errors->has('branch_name') ? 'is-invalid':'' }}">
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
                        <input type="text" name="branch_address" class="form-control {{ $errors->has('branch_address') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('branch_address') }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add New</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Branch END -->