@extends('back-end.components.master')
@section('contens')
    {{-- Modal create start --}}
    @include('back-end.messages.product.create')
    {{-- Modal create end --}}

    {{-- Modal edit start --}}
    @include('back-end.messages.product.edit')
    {{-- Modal edit start --}}

    

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Products</h3>
                    <p onclick="handleClickOnButtonNewProduct()" data-bs-toggle="modal" data-bs-target="#modalCreateProduct"
                        class="card-description btn btn-primary ">new product</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped mb-3">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            
                        </thead>
                        <tbody class="products_list">
                        <tr>
                            <td>P001</td>

                            <!-- Product Image -->
                            <td>
                                <img src="uploads/product/sample.jpg" alt="Product Name" class="img-thumbnail" style="width: 60px; height: 60px;">
                            </td>

                            <!-- Product Info -->
                            <td>Product Name</td>
                            <td>Category Name</td>
                            <td>Brand Name</td>
                            <td>$99.99</td>
                            <td>10</td>

                            <!-- Stock Status Badge -->
                            <td>
                                <span class="badge bg-success text-light p-1">In Stock</span>
                            </td>

                            <!-- Product Status Badge -->
                            <td>
                                <span class="badge bg-success text-light p-1">Active</span>
                            </td>

                            <!-- Action Buttons -->
                            <td class="text-nowrap">
                                <button type="button" class="btn btn-info btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalUpdateProduct">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        </tbody>

                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center">

                    <div class="show-page mt-3">

                    </div>

                    <button onclick="ProductRefresh()" class=" btn btn-outline-danger rounded-0 btn-sm">refresh</button>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>

        $(document).ready(function() {

            $('#color_add').select2({
                placeholder: 'Select options',
                allowClear: true,
                tags: true,
                width: '100%',
                dropdownParent: $('#modalCreateProduct')
            });
                $('#color_edit').select2({
                placeholder: 'Select options',
                allowClear: true,
                tags: true,
                width: '100%',
                dropdownParent: $('#modalCreateProduct') 
            });

        });

        const handleClickOnButtonNewProduct = () => {
            $.ajax({
                type: "POST",
                url: "{{ route('product.data') }}",
                dataType: "json",
                success: function (response) {
                    console.log(response.data);

                    if(response.status == 200){

                        let categories = response.data.categories;
                        let brands = response.data.brands;
                        let colors = response.data.colors;

                        let category_html = ``;
                        let brand_html = ``;
                        let color_html = ``;

                        $.each(categories, function(index, value){
                            category_html += `
                                <option value="${value.id}">${value.name}</option>
                            `;
                        });

                        $.each(brands, function(index, value){
                            brand_html += `
                                <option value="${value.id}">${value.name}</option>
                            `;
                        });

                        $.each(colors, function(index, value){
                            color_html += `
                                <option value="${value.id}">${value.name}</option>
                            `;
                        });

                        $('.category_add').html(category_html);
                        $('.brand_add').html(brand_html);
                        $('.color_add').html(color_html);
                    }
                }
            });
        }


        const ProductList = () => {
            $.ajax({
                type: "GET",
                url: "{{ route('product.list') }}",
                dataType: "json",
                success: function (response) {
                    console.log(response);

                    let html = '';

                    response.products.forEach(product => {

                        // Stock Status
                        let stockStatus = product.qty > 0 
                            ? '<span class="badge bg-success text-light p-1">In Stock</span>'
                            : '<span class="badge bg-danger text-light p-1">Out of Stock</span>';

                        // Product Status
                        let productStatus = product.status == 1 
                            ? '<span class="badge bg-success text-light p-1">Active</span>'
                            : '<span class="badge bg-danger text-light p-1">Inactive</span>';

                        // Product Image
                        let image = product.Images.length > 0 
                            ? product.Images[0].image 
                            : 'sample.jpg'; // fallback

                        html += `<tr>
                                    <td>P${product.id.toString().padStart(3,'0')}</td>
                                    <td>
                                        <img src="uploads/product/${image}" alt="${product.name}" class="img-thumbnail" style="width: 60px; height: 60px;">
                                    </td>
                                    <td>${product.name}</td>
                                    <td>${product.Category ? product.Category.name : ''}</td>
                                    <td>${product.Brand ? product.Brand.name : ''}</td>
                                    <td>$${product.price}</td>
                                    <td>${product.qty}</td>
                                    <td>${stockStatus}</td>
                                    <td>${productStatus}</td>
                                    <td class="text-nowrap">
                                        <button type="button" class="btn btn-info btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalUpdateProduct">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>`;
                    });

                    $('.products_list').html(html);
                }
            });
        }
        ProductList();

        const ProductUpload = (form) => {
            let payload = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('product.uploads') }}",
                data: payload,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response.status){
                        // $('.image').val('');
                        // $('.image').removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                        Message(response.message);
                        let images = response.image;
                        let img =``;
                        $.each(images , function(index, value){
                            img += `
                                <div class="col-lg-4 col-md-6 col-12 mb-3">
                                    <input type="hidden" name="image_uploads[]" value="${value}">
                                    <img class="w-100" src="{{ asset('uploads/temp/${value}') }}">
                                    <button onclick="ProductCancelImage(this,'${value}')" type="button" class="btn btn-danger btn-sm ">cancel</button>
                                </div>
                            `;
                            $('.show-images').html(img);
                        })
                    }else{
                        let error = response.errors;
                        $('.image').addClass('is-invalid').siblings('p').addClass('text-danger').text(error.image);
                    }

                    
                }
            
            });
        }
        const ProductCancelImage = (e, image) => {
            if(confirm("Are you sure you want to cancel?")) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('product.cancel') }}",
                    data: { image: image },
                    dataType: "json",
                    success: function (response) {
                        if(response.status){
                            $(e).parent().remove();
                            Message(response.message);
                        }
                    }
                });
            }
        }


        const ProductStore = (form) => {
            let payload = new FormData($(form)[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('product.store') }}",
                data: payload,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log("hi", response);

                    if (response.status == 200) {

                        $(form).trigger("reset");
                        $('.show-images').html('');
                        $('#modalCreateProduct').modal('hide');
                        $('input').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('text-danger')
                                .text('');

                        Message(response.message, true);

                    } else {

                        Message(response.message, false);

                        // Title
                        if (response.errors?.title) {
                            $('.title_add').addClass('is-invalid')
                                .siblings('p')
                                .addClass('text-danger')
                                .text(response.errors.title);
                        } else {
                            $('.title_add').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('text-danger')
                                .text('');
                        }

                        // Description
                        if (response.errors?.desc) {
                            $('.desc').addClass('is-invalid')
                                .siblings('p')
                                .addClass('text-danger')
                                .text(response.errors.desc);
                        } else {
                            $('.desc').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('text-danger')
                                .text('');
                        }

                        // Price
                        if (response.errors?.price) {
                            $('.price_add').addClass('is-invalid')
                                .siblings('p')
                                .addClass('text-danger')
                                .text(response.errors.price);
                        } else {
                            $('.price_add').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('text-danger')
                                .text('');
                        }

                        // Qty
                        if (response.errors?.qty) {
                            $('.qty_add').addClass('is-invalid')
                                .siblings('p')
                                .addClass('text-danger')
                                .text(response.errors.qty);
                        } else {
                            $('.qty_add').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('text-danger')
                                .text('');
                        }
                    }
                }
            });
        };
    </script>
@endsection
