<!-- filepath: /d:/App/xampp/htdocs/first-project/ids-d2/resources/views/user/edit_user_modal.blade.php -->
<div class="modal" id="editUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUserForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-user-id" name="id">
                    <div class="form-group">
                        <label for="edit-name">Name:</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-email">Email:</label>
                        <input type="email" class="form-control" id="edit-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-password">Password:</label>
                        <input type="password" class="form-control" id="edit-password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="edit-confirm-password">Confirm Password:</label>
                        <input type="password" class="form-control" id="edit-confirm-password" name="confirm-password">
                    </div>
                    <button type="submit" class="btn btn-primary" id="edit-submit-btn" disabled>Submit</button>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
