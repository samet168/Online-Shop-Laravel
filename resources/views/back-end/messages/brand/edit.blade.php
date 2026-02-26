<div class="modal fade" id="modalUpdateBrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:40%;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Update Brand</h1>
        </div>
        <div class="modal-body">
           <form method="POST" class="formUpdateUpdate" enctype="multipart/form-data">

                <div class="form-group">
                    <input type="hidden" id="brand_id" name="brand_id">
                   <label for="">Brand Name</label>
                   <input type="text" name="name" class="name name_edit form-control" id="">
                   <p></p>
                </div>

                <div class="form-group">
                    <label for="">Category</label>
                    <select name="category" class="category form-control">
                        @foreach ($categories as $category)
                          <option value="{{$category->id }}">{{ $category->name }}</option>
                       @endforeach
                    </select>
                </div>
            
                <div class="form-group">
                  <label for="">Status</label>
                  <select name="status" class="status form-control">
                     <option value="1">Active</option>
                     <option value="0">Block</option>
                  </select>
                  <p></p>
                </div>

           </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" onclick="BrandUpdate('.formUpdateUpdate')" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
</div>