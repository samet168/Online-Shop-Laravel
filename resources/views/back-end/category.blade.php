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
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody >
                <tr>
                  <td>1001</td>
                  <td>phument007</td>
                  <td>phument@gmail.com</td>
                  <td>
                    <a href="#" class="btn btn-primary btn-sm">view</a>
                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                  </td>
                  
                </tr>
              </tbody>
            </table> 
          </div>
        </div>
      </div>
@endsection

@section('scripts')

<script>
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
                  <div class="image-preview d-flex align-items-center mt-2">
                      <img src="/uploads/temp/${response.image}" alt="category" width="100" class="img-thumbnail me-2">

                      <button type="button" onClick="cancelImage('${response.image}')" class="btn btn-danger btn-cancel-preview">Cancel </button>
                  </div>
              `;

              $(".show-image-category").html(img);
              $(form).trigger('reset');
                 $(selector).removeClass("is-invalid").siblings('p').removeClass("text-danger").text("");

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
      
    }
  });
}
</script>
@endsection

