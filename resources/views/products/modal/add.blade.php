<!-- Modal Add Product START-->
<div class="modal fade" id="addProductModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product_">Product SKU</label>
                        <input type="text" name="product_sku" required maxlength="10" class="form-control {{ $errors->has('product_sku') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('product_sku') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" name="product_name" required class="form-control {{ $errors->has('product_name') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('product_name') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="product_description">Description (Optional)</label>
                        <textarea name="product_description" cols="5" rows="5" class="form-control {{ $errors->has('product_description') ? 'is-invalid':'' }}"></textarea>
                        <p class="text-danger">{{ $errors->first('product_description') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="product_stock">Stock</label>
                        <input type="number" name="product_stock" required class="form-control {{ $errors->has('product_stock') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('product_stock') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="product_price">Price</label>
                        <input type="number" name="product_price" required class="form-control {{ $errors->has('product_price') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('product_price') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="product_cogs">Cost of Goods Sold (Optional)</label>
                        <input type="number" name="product_cogs" class="form-control {{ $errors->has('product_cogs') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('product_cogs') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="business_unit_id">Business Unit</label>
                        <select name="business_unit_id" required class="business_unit form-control {{ $errors->has('business_unit_id') ? 'is-invalid':'' }}">
                            <!-- Disini di populate dengan ajax di file index.blade.php -->
                            <option value="">Choose</option>
                            <!-- Disini di populate dengan ajax di file index.blade.php -->
                        </select>
                        <p class="text-danger">{{ $errors->first('business_unit_id') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" required class="category form-control {{ $errors->has('category_id') ? 'is-invalid':'' }}">
                            <!-- Disini di populate dengan ajax di file index.blade.php -->
                            <option value="">Choose</option>
                            <!-- Disini di populate dengan ajax di file index.blade.php -->
                        </select>
                        <p class="text-danger">{{ $errors->first('category_id') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="product_photo">Image</label>
                        <input type="file" name="product_photo" class="form-control">
                        <p class="text-danger">{{ $errors->first('product_photo') }}</p>
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

<!-- Modal Add Product END -->