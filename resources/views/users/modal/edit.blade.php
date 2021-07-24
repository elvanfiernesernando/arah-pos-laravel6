<!-- Modal Add Employee START-->
<div class="modal fade" id="editEmployeeModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        @if (!empty($row->id))
        <form method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" id="name" name="name" required class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('name') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" id="email" name="email" required class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('email') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}">
                        <p class="text-warning">Leave empty, if you don't want to change password</p>
                        <p class="text-danger">{{ $errors->first('password') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="business_unit_id">Business Unit</label>
                        <select name="business_unit_id" required class="business_unit form-control {{ $errors->has('business_unit_id') ? 'is-invalid':'' }}" required>
                            <option value="">Choose</option>
                            <option value=""></option>
                        </select>
                        <p class="text-danger">{{ $errors->first('business_unit_id') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="branch_id">Outlet</label>
                        <select name="branch_id" class="branch form-control {{ $errors->has('branch_id') ? 'is-invalid':'' }}" required>
                            <option value="">Choose</option>
                        </select>
                        <p class="text-danger">{{ $errors->first('') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="">Role</label>
                        <select name="role_id" class="role form-control {{ $errors->has('role_id') ? 'is-invalid':'' }}" required>
                            <option value="">Choose</option>
                        </select>
                        <p class="text-danger">{{ $errors->first('role') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
        @endif
    </div>
</div>

<!-- Modal Add Employee END -->