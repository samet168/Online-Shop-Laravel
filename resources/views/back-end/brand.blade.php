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
              </tbody>
            </table>

            
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="show-page"></div>

                <button onclick="BrandRefresh()" 
                    class="btn btn-outline-danger rounded-0 btn-sm">
                    refresh
                </button>
            </div>
          </div>
        </div>

      </div>

@endsection

@section('scripts')
<script>

const BrandList = (page=1, search="") => {
  $.ajax({
    type: "GET",
    url: "{{ route('brand.list') }}",
    data: { 
      page: page ,
      search: search
            
    },
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
      let page =``;
      let totalPage = response.page.totalPage;
      let currentPage = response.page.currentPage;
      page =`
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li onclick="BackPage(${currentPage})" class="page-item ${(1 == currentPage) ? 'd-none' : ''}">
                  <a class="page-link" href="javascript:void(0);" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>`;
                for(let i = 1; i <= totalPage; i++){
                  page += `
                      <li onclick="BrandPage(${i})" class="page-item ${(i== currentPage) ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);">${i}</a>
                      </li>

                  `
                }
              
                page +=`<li onclick="NexPage(${totalPage})" class="page-item ${(totalPage == currentPage) ? 'd-none' : ''}">
                  <a class="page-link" href="javascript:void(0);" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              </ul>
            </nav>
      `;
      $(".show-page").html(page);
    },
   

  });
}
BrandList();
const BrandPage = (page)=>{

  BrandList(page);
}
const NexPage = (page) => {

  BrandList(page);
  
}
const BackPage =(page) =>{
  BrandList(page - 1);  
}

//search event
$(document).on("click", ".searchBtn", function(){
  let search = $("#search").val();
  BrandList(1, search);
  $('#modalSearch').modal('hide');
})

const BrandRefresh = () => {
 BrandList();
 $('.search').val('');
}


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
