<!-- Modal Delete Business Unit START-->
<div class="modal fade" id="deleteBusinessUnitModal" tabindex="-1" role="dialog" aria-labelledby="deleteBusinessUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    All your data related to this Business Unit will be deleted also, are you sure you want to delete this Business Unit?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete !</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete Business Unit END -->