<!-- Modal Edit Category START-->
<div class="modal fade" id="editCategoryModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        @if (!empty($row->id))
        <form method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category_name">Category</label>
                        <input type="text" id="category_name" name="category_name" class="form-control {{ $errors->has('category_name') ? 'is-invalid':'' }}" value="">
                        <p class="text-danger">{{ $errors->first('name') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="business_unit_id">Business Unit</label>
                        <select name="business_unit_id" required class="form-control {{ $errors->has('business_unit_id') ? 'is-invalid':'' }}">
                            <!-- Disini di populate dengan ajax di file index.blade.php -->
                            <option value="">Choose</option>
                            <!-- Disini di populate dengan ajax di file index.blade.php -->
                        </select>
                        <p class="text-danger">{{ $errors->first('business_unit_id') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="category_description">Description (Optional)</label>
                        <textarea id="category_description" name="category_description" class="form-control {{ $errors->has('category_description') ? 'is-invalid':'' }}" rows="10"></textarea>
                        <p class="text-danger">{{ $errors->first('description') }}</p>
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