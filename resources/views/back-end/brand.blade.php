@extends('back-end.components.master')
@section('contens')

      {{-- Modal create start --}}
      @include('back-end.messages.brand.create')
      {{-- Modal create end --}}

      {{-- Modal edit start --}}
      @include('back-end.messages.brand.edit')
      {{-- Modal edit start --}}

      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Brands</h3>
                <p data-bs-toggle="modal" data-bs-target="#modalCreateBrand" class="card-description btn btn-primary ">new brand</p>
            </div>
            <table class="table table-striped">
              <thead>
                <tr> 
                  <th>Brand ID</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="brand_list">
                 {{-- <tr>
                    <td>B001</td>
                    <td>Vivo</td>
                    <th>Phone</th>
                    <th>
                        <span class="badge badge-success p-1">Active</span>
                        <span class="badge badge-danger  p-1">Inactive</span>
                    </th>
                    <th>
                        <button type="button" class=" btn btn-info  btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdateBrand">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                    </th>
                 </tr> --}}
              </tbody>

            </table>
            <div class="d-flex justify-content-between align-items-center">

                <div class="show-page mt-3">

                </div>

                <button onclick="BrandRefresh()" class=" btn btn-outline-danger rounded-0 btn-sm">refresh</button>

            </div>
          </div>
        </div>
      </div>
@endsection

@section('scripts')
<script>

const BrandList = () => {
  $.ajax({
    type: "GET",
    url: "{{ route('brand.list') }}",
    dataType: "json",
    success: function(response) {
      console.log(response);

      let tr = '';

      // Loop through each brand
      $.each(response.brands, function(key, value) {
        tr += `
          <tr>
            <td>${value.id}</td>
            <td>${value.name}</td>
            <td>${value.category.name}</td>
            <td>
              ${value.status == 1 
                ? '<span class="badge badge-success p-1">Active</span>' 
                : '<span class="badge badge-danger p-1">Inactive</span>'}
            </td>
            <td>
              <button 
                type="button" 
                class="btn btn-primary btn-sm"
                onClick="EditBrand(${value.id}, '${value.name}', ${value.category_id}, ${value.status})">
                Edit
              </button>
              <button 
                type="button" 
                class="btn btn-danger btn-sm" 
                onClick="DeleteBrand(${value.id})">
                Delete
              </button>
            </td>
          </tr>
        `;
      });

      // Insert all rows into tbody
      $(".brand_list").html(tr);
    },
    error: function(xhr) {
      console.log(xhr.responseText);
    }
  });
}

// Call function to display brands
BrandList();


const BrandStore = (form) => {
  let payloads = new FormData($(form)[0]);
  $.ajax({
  type: "POST",
  url: "{{ route('brand.store') }}",
  data: payloads,
  dataType: "json",
  contentType: false,
  processData: false,
  success: function (response) {
      if(response.status == 200){
          $("#modalCreateBrand").modal("hide");
          $(form).trigger('reset');
          $(".name").removeClass("is-invalid").siblings("p").removeClass("text-danger").text(" ");
          Message(response.message);
          BrandList();
      }else{
          let error = response.error;
          $(".name").addClass("is-invalid").siblings("p").addClass("text-danger").text(error.name);
      }
  }
  });
}

const DeleteBrand = (id) => {
  $.ajax({
    type: "DELETE",
    url: "{{ url('brand/destroy') }}/" + id, 
    dataType: "json",
    success: function(response){
      console.log(response);
      BrandList();
      Message(response.message);
    }
  });
}


const EditBrand = (id, name, category_id, status) => {
  $('.name_edit').val(name);
  $('#brand_id').val(id);
  $('.category').val(category_id); // pre-select category
  $('.status').val(status);        // pre-select status

  $('#modalUpdateBrand').modal('show');
}

const UpdataBrand = (form) => {

    let payload = new FormData($(form)[0]);

    $.ajax({
        type: "POST",
        url: "{{ route('brand.update') }}",   // កែត្រង់នេះ
        data: payload,
        contentType: false,
        processData: false,
        success: function(response){
            console.log(response);

            if(response.status == 200){
                $("#modalUpdateBrand").modal('hide');
                $(form).trigger('reset');
                $('.name_edit')
                    .removeClass("is-invalid")
                    .siblings('p')
                    .removeClass("text-danger")
                    .text("");
                Message(response.message);
                BrandList();
            }else{
                let error = response.errors;
                $('.name_edit')
                    .addClass("is-invalid")
                    .siblings('p')
                    .addClass("text-danger")
                    .text(error.name);
            }
        }
    });

}




</script>

@endsection
