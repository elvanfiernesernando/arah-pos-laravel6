<!-- Modal Add Customer START-->
<div class="modal fade" id="addCustomerModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="#" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="customer_name">Customer Name</label>
                        <input type="text" name="customer_name" required class="form-control {{ $errors->has('customer_name') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('customer_name') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="customer_email">Email (Optional)</label>
                        <input type="email" name="customer_email" required class="form-control {{ $errors->has('customer_email') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('customer_email') }}</p>
                    </div>
                    <div class="form-group">
                        <label for=customer_phone"">Phone Number</label>
                        <input type="text" name="customer_phone" required class="form-control {{ $errors->has('customer_phone') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('customer_phone') }}</p>
                    </div>
                    <div class="form-group">
                        <label for="customer_address">Address (Optional)</label>
                        <input type="text" name="customer_address" class="form-control {{ $errors->has('customer_address') ? 'is-invalid':'' }}">
                        <p class="text-danger">{{ $errors->first('customer_address') }}</p>
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

<!-- Modal Add Customer END -->