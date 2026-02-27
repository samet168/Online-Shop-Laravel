@extends('back-end.components.master')
@section('contens')

      {{-- Modal create start --}}
      @include('back-end.messages.color.create')
      {{-- Modal create end --}}

      {{-- Modal edit start --}}
      @include('back-end.messages.color.edit')
      {{-- Modal edit start --}}

      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Colors</h3>
                <p data-bs-toggle="modal" data-bs-target="#modalCreateColor" class="card-description btn btn-primary ">new color</p>
            </div>
            <table class="table table-striped mb-3">
              <thead>
                <tr> 
                  <th>Color ID</th>
                  <th>Name</th>
                  <th>Color</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="colors_list">
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

                <button onclick="ColorRefresh()" class=" btn btn-outline-danger rounded-0 btn-sm">refresh</button>

            </div>
          </div>
        </div>
      </div>
@endsection

@section('scripts')
<script>
    
    const ColorList = (page = 1, search = '') => {

    $.ajax({
    type: "GET",
    url: "{{ route('color.list') }}",
    data: {
    page: page,
    search: search
    },
    dataType: "json",

    success: function (response) {

    console.log(response);

    if(response.status == 200){

    let colors = response.colors;
    let tr = ``;

    $.each(colors, function (key, value) {

    tr += `
    <tr>
    <td>C${value.id}</td>

    <td>${value.name}</td>

    <td>
    <div class="d-flex align-items-center gap-2">
        <div style="
            background:${value.color_code};
            width:25px;
            height:25px;
            border-radius:50%;
            border:1px solid #000;">
        </div>
        <small>${value.color_code}</small>
    </div>
    </td>

    <td>
    ${value.status == 1
        ? '<span class="badge bg-success">Active</span>'
        : '<span class="badge bg-danger">Inactive</span>'}
    </td>

    <td>
    <button class="btn btn-info btn-sm"
        onclick="ColorEdit(${value.id},'${value.name}','${value.color_code}',${value.status})"
        data-bs-toggle="modal"
        data-bs-target="#modalUpdateColor">
        Edit
    </button>

    <button class="btn btn-danger btn-sm"
        onclick="ColorDelete(${value.id})">
        Delete
    </button>
    </td>
    </tr>
    `;
    });

    $(".colors_list").html(tr);


    // ================= Pagination =================
    //pagination
    let page = ``;
    let totalPage = response.page.totalPage;
    let currentPage = response.page.currentPage;
    console.log(currentPage);
    page = `
    <nav aria-label="Page navigation example">
    <ul class="pagination">
    <li onclick="PreviousPage(${currentPage})" class="page-item ${(currentPage == 1) ? 'd-none' : 'd-block' }">
    <a class="page-link" href="javascript:void()" aria-label="Previous">
    <span aria-hidden="true">&laquo;</span>
    </a>
    </li>`;

    for(let i=1;i<=totalPage;i++){
    page += `
        <li onclick="ColorPage(${i})" class="page-item ${(i == currentPage) ? 'active' : '' }">
            <a class="page-link" href="javascript:void()">${i}</a>
        </li>`;
    }

    page +=`<li onclick="NextPage(${currentPage})" class="page-item ${( currentPage == totalPage ) ? 'd-none' : 'd-block'}">
    <a class="page-link" href="javascript:void()" aria-label="Next">
    <span aria-hidden="true">&raquo;</span>
    </a>
    </li>
    </ul>
    </nav>
    `;

    if(totalPage > 1 ){
    $(".show-page").html(page);
    }


    }
    }
    });
    }
    ColorList();
    //Color Refresh
    const ColorRefresh = () => {
        ColorList();
        $("#searchBox").val(" ");
    }

    
    //Color Page
    const ColorPage = (page) => {
        ColorList(page);
    }


    //Next Page
    const NextPage  = (page) => {
        ColorList(page + 1);
    }


    //Previous Page
    const PreviousPage = (page) => {
        ColorList(page - 1);
    }

    //Color Search with event
    $(document).on("click",'.searchBtn', function () {
         let searchValue = $("#searchBox").val();
         ColorList(1,searchValue);
         //close modal
         $("#modalSearch").modal('hide');
    });
    const ColorStore = (form) => {

        let payloads = new FormData($(form)[0]);

        $.ajax({
            type: "POST",
            url: "{{ route('color.store') }}",
            data: payloads,
            dataType: "json",
            contentType: false,
            processData: false,

            success: function (response) {

                if(response.status == 200){

                    $("#modalCreateColor").modal("hide");
                    $(form).trigger('reset');

                    $(".name").removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("text-danger")
                            .text("");

                    Message(response.message);
                    ColorList(); 

                }else{

                    let error = response.error;

                    $(".name").addClass("is-invalid")
                            .siblings("p")
                            .addClass("text-danger")
                            .text(error.name);
                }
            }
        });
    }
    const ColorEdit = (id, name, color_code, status) => {
        $('#color_id').val(id);
        $('.name_edit').val(name);
        $('.color_edit').val(color);
        let option = `
        <option value="${status == 1 ? 'selected' : ''}">Active</option>

        <option value="${status == 0 ? 'selected' : ''}">Inactive</option>
        `;

        $('.status_edit').modal('show');
        
    }
    const ColorUpdate = (form) => {
        let payloads = new FormData($(form)[0]);

        $.ajax({
            type: "POST",
            url: "{{ route('color.update') }}",
            data: payloads,
            dataType: "json",
            contentType: false,
            processData: false,

            success: function (response) {

                if(response.status == 200){

                    $("#modalUpdateColor").modal("hide");
                    $(form).trigger('reset');

                    $(".name_edit").removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("text-danger")
                            .text("");

                    Message(response.message);
                    ColorList(); 

                }else{

                    let error = response.error;

                    $(".name_edit").addClass("is-invalid")
                            .siblings("p")
                            .addClass("text-danger")
                            .text(error.name);
                }
            }
        });
    }

    const ColorDelete = (id) => {
        $.ajax({
            type: "DELETE",
            url: "{{ route('color.destroy', ':id') }}".replace(':id', id),
            data: {
                _token: "{{ csrf_token() }}" // CSRF for DELETE
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                if(response.status == 200){
                    Message(response.message);
                    ColorList();
                }
            }
        });
    }
</script>

@endsection