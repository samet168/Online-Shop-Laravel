@extends('back-end.components.master')
@section('contens')

     <!-- Page Title Header Starts-->
     <div class="row page-title-header">
        <div class="col-12">
          <div class="page-header">
            <h4 class="page-title">Dashboard</h4>
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
              <ul class="quick-links">
                <li><a href="#">ICE Market data</a></li>
                <li><a href="#">Own analysis</a></li>
                <li><a href="#">Historic market data</a></li>
              </ul>
              <ul class="quick-links ml-auto">
                <li><a href="#">Settings</a></li>
                <li><a href="#">Analytics</a></li>
                <li><a href="#">Watchlist</a></li>
              </ul>
            </div>
          </div>
        </div> 
      </div>
      <!-- Page Title Header Ends-->


      {{-- Modal  start --}}
      @include('back-end.messages.category.create')
      {{-- Modal end --}}

      @include('back-end.messages.category.edit')
    

      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 >Category</h4>
                <p data-bs-toggle="modal" data-bs-target="#modalCreateCategory" class="card-description btn btn-primary ">new category</p>
            </div>
            <table class="table table-striped">
              <thead>
                <tr> 
                  <th>Category ID</th>
                  <th>Category name</th>
                  <th>image</th>
                  <th>Status</th>
                  <th>Action</th>

                </tr>
              </thead>
              {{-- <tbody class="categoryList">
                <tr>
                  <td>1001</td>
                  <td>phument007</td>
                  <td>phument@gmail.com</td>
                  <td>
                    <a href="#" class="btn btn-primary btn-sm">view</a>
                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                  </td>
                 
                  
                </tr>
              </tbody> --}}
              <tbody class="categoryList">

              </tbody>
            </table> 
          </div>
        </div>
      </div>
@endsection

@section('scripts')

<script>
  
const ListCategory = () => {
    $.ajax({
        type: "GET",
        url: "{{ route('category.list') }}",
        dataType: "json",
        success: function (response) {
            if(response.status == 200){
                let categories = response.categories;
                let tr = ''; // define variable before using
                $.each(categories, function(key,value){
                    tr += `
                        <tr>
                          <td>${value.id}</td>
                          <td>${value.name}</td>
                          <td>
                            <img src="{{ asset('uploads/category/${value.image}') }}">
                          </td>
                          <td>${value.status == 1 ? 'Active' : 'blocked'}</td>
                          <td>
                            <a href="javascript:void(0)" onClick="EditCategory(${value.id})" data-bs-toggle="modal" data-bs-target="#modalUpdateCategory" class="btn  btn-primary btn-sm">Edit</a>
                            <a href="javascript:void(0)" onClick="DeleteCategory(${value.id})" class="btn btn-danger btn-sm">Delete</a>
                          </td>
                        </tr>
                    `;
                });
                $('.categoryList').html(tr); // inject rows
            }
        }
    });
}

ListCategory();
const uploadImage = (form) =>{
    let payload = new FormData($(form)[0]);

    $.ajax({
        type: "POST",
        url: "{{ route('category.upload') }}",
        data: payload,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);

           if(response.status === true){
              let img = `
                    <div class="image-preview-wrapper mt-2">
                      <input type="hidden" name="category_image" value="${response.image}">
                      <div class="d-flex align-items-center gap-2">
                        <!-- Preview Image -->
                        <img src="/uploads/temp/${response.image}" 
                            alt="category" 
                            class="img-thumbnail" 
                            style="width: 100px; height: 100px; object-fit: cover;">

                        <!-- Cancel Button -->
                        <button type="button" 
                                class="btn btn-sm btn-danger" 
                                onclick="cancelImage('${response.image}')">
                          <i class="bi bi-x-circle me-1"></i> Cancel
                        </button>
                      </div>
                    </div>
              `;

              $(".show-image-category").html(img);
              // $(form).trigger('reset');
                 $('.image').removeClass("is-invalid").siblings('p').removeClass("text-danger").text("");

          }else{
            let errors = response.errors;
            $('.image').addClass("is-invalid").siblings('p').addClass("text-danger").text(errors.image);
          }
        }
    });
}


const cancelImage = (img) =>{
  if(confirm("Are you sure you want to cancel?")) {
    $.ajax({
      type: "POST",
      url: "{{ route('category.cancel') }}",
      data: { image: img },
      dataType: "json",
      success: function (response) {
        if(response.status ){
          $('.show-image-category').html('');
          Message(response.message);
        }
      }
    });
  }
}
const storeCategory = (form) => {
 let payload = new FormData($(form)[0]);
  $.ajax({
    type: "POST",
    url: "{{ route('category.store') }}",
    data: payload,
    dataType: "json",
    processData: false,
    contentType: false,
    success: function (response) {
      if(response.status==200){
        $("#modalCreateCategory").modal('hide');
        // $(form).trigger("reset");
        $(".show-image-category").html('');
        $('.name').removeClass("is-invalid").siblings('p').removeClass("text-danger").text("");
        ListCategory();
        Message(response.message);
      }else{
        let error =response.errors;
        $('.name').addClass("is-invalid").siblings('p').addClass("text-danger").text(error.name);

      }
      
    }
  });
}

const DeleteCategory = (id) => {
   if(confirm("Do you want to delete this category?")) {
       $.ajax({
           type: "DELETE",
           url: "/category/destroy/" + id, // append id
           data: {
               _token: "{{ csrf_token() }}" // ចាំបាច់សម្រាប់ DELETE
           }, 
           dataType: "json",
           success: function(response){
               if(response.status == 200){
                   ListCategory(); // refresh table
                   Message(response.message);
               } else {
                   Message(response.message);
               }
           }
       });
   }
}

const EditCategory = (id) => {
  $.ajax({
    type: "POST",
    url: "{{ route('category.edit') }}",
    data: { id: id },
    dataType: "json",

    success: function (response) {
      if(response.status == 200){
          $('.editName').val(response.category.name);
          $('#category_id').val(response.category.id);
            if(response.category.image != null){

                let img = `
                    <div class="image-preview-wrapper mt-3">
                      <!-- Hidden input to store old image -->
                      <input type="hidden" name="cate_old_image" value="${response.category.image}">

                      <div class="d-flex flex-column align-items-center gap-2">
                          
                          <img src="/uploads/category/${response.category.image}" 
                              alt="Category Image" 
                              class="img-fluid rounded shadow-sm" 
                              style="max-width: 400px; max-height: 300px; object-fit: cover;">

                          <!-- Optional info / text -->
                          <small class="text-muted">Current Category Image</small>
                      </div>
                    </div>
                `;

                $(".show-edit-image").html(img);
            }

          
      }
      
    }
  });

}


// const UpdateCategory = (form) => {

//     let payload = new FormData($(form)[0]);

//     $.ajax({
//         type: "POST",
//         url: "{{ route('category.update') }}", // ✅ FIX HERE
//         data: payload,
//         dataType: "json",
//         processData: false,
//         contentType: false,

//         success: function (response) {

//             if(response.status == 200){

//                 $("#modalUpdateCategory").modal('hide');
//                 $(".show-edit-image").html('');
//                 $('.name').removeClass("is-invalid")
//                           .siblings('p')
//                           .removeClass("text-danger")
//                           .text("");

//                 Message(response.message);
//                 ListCategory();

//             }else{

//                 let error = response.errors;

//                 $('.name')
//                     .addClass("is-invalid")
//                     .siblings('p')
//                     .addClass("text-danger")
//                     .text(error.name);

//             }
//         }
//     });
// }

const UpdateCategory = (form) => {
    let payload = new FormData($(form)[0]);

    $.ajax({
        type: "POST",
        url: "{{ route('category.update') }}",
        data: payload,
        dataType: "json",
        processData: false,
        contentType: false,

        success: function (response) {
            if(response.status==200){
                $("#modalUpdateCategory").modal('hide');
                $(".show-edit-image").html('');
                $('.name').removeClass("is-invalid")
                          .siblings('p')
                          .removeClass("text-danger")
                          .text("");
                Message(response.message);
                ListCategory();
            } else {
                let error = response.errors;
                $('.name').addClass("is-invalid")
                          .siblings('p')
                          .addClass("text-danger")
                          .text(error.name);
            }
        },
        error: function(xhr){
            console.log(xhr.responseText); // 👈 debug 500
        }
    });
}
</script>
@endsection

