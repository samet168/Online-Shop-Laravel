<div class="modal fade" id="modalCreateColor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Create Color</h1>
        </div>
        <div class="modal-body">
           <form method="POST" class="formCreateColor" enctype="multipart/form-data">

                <div class="form-group">
                   <label for="">Color Name</label>
                   <input type="text" name="name" class="name form-control" id="">
                   <p></p>
                </div>

                <div class="form-group">
                    <label for="">Color</label>
                    <input type="color" name="color" class="name form-control" id="">
                </div>
                

                <div class="form-group">
                  <label for="">Status</label>
                  <select name="status" class="status form-control">
                     <option value="1">Active</option>
                     <option value="0">Inactive</option>
                  </select>
                  <p></p>
                </div>

           </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" onclick="ColorStore('.formCreateColor')" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
</div>