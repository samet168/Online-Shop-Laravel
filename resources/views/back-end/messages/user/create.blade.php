<div class="modal fade" id="modalCreateUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Creating Users</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form method="POST" class="frmCreateUser">
                    @csrf
                    <div class="form-group mb-2">
                        <label>Username</label>
                        <input type="text" name="name" class="name form-control" required>
                        <p></p>
                    </div>

                    <div class="form-group mb-2">
                        <label>Email</label>
                        <input type="email" name="email" class="email form-control" required>
                        <p></p>
                    </div>

                    <div class="form-group mb-2">
                        <label>Password</label>
                        <input type="password" name="password" class="password form-control" required autocomplete="new-password">
                        <p></p>
                    </div>

                    <div class="form-group mb-2">
                        <label>Role</label>
                        <select name="role" class="role form-control">
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </div>
               </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="StoreUser('.frmCreateUser')">Save</button>
            </div>
        </div>
    </div>
</div>