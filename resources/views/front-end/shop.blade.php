@extends('front-end.components.master')
@section('contents')
<div id="global-loading" style="display:none;">
    <div class="spinner"></div>
</div
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Shop</h1>
					<ol class="breadcrumb">
						<li><a href="{{ route('home.index') }}">Home</a></li>
						<li class="active">shop</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="products section">
	<div class="container">
		<div class="row">

            @if ($products->isNotEmpty())
                @foreach ($products as $product)
                    @php

                        if ($product->images != '') {
                            $img = $product->images->first();
                            $imageUrl = $img
                                ? asset('uploads/product/' . $img->image)
                                : asset('front-end/assets/images/shop/products/product-1.jpg');
                        }

                    @endphp
                    <div class="col-md-4">
                        <div class="product-item">
                            <div class="product-thumb">
                                <span class="bage">Sale</span>
                                <img class="img-responsive" src="{{ $imageUrl }}" alt="{{ $product->name }}" />
                                <div class="preview-meta">
                                    <ul>
                                        <li onclick="viewProduct({{ $product->id }})" >
                                            <span data-toggle="modal" data-target="#product-modal">
                                                <i class="tf-ion-ios-search-strong"></i>
                                            </span>
                                        </li>
                                        <li>
                                            <a href="#!"><i class="tf-ion-ios-heart"></i></a>
                                        </li>
                                        <li>
                                            <a href="#!"><i class="tf-ion-android-cart"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <h4><a href="product-single.html">{{ $product->name }}</a></h4>
                                <p class="price">${{ $product->price }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif



            <!-- Modal start  -->
                <div id="global-loading" style="display:none;">
                    <div class="spinner"></div>
                </div>
            <div class="modal product-modal fade" id="product-modal">
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="tf-ion-close"></i>
                </button>
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        
                        <div class="modal-body view-product">

                        </div>
                    </div>
                </div>
                <!-- Loading overlay -->
                <div id="loading-overlay" style="display:none;">
                <div class="spinner"></div>
                </div>
            </div>
            <!--modal end -->

        </div>

        <div class=" text-center">
            {{ $products->links() }}
        </div>
            {{-- <nav aria-label="...">
            <ul class="pagination pagination-sm  ">
                <li class="page-item active">
                <a class="page-link" aria-current="page">1</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
            </ul>
            </nav> --}}
        
        
	</div>
</section>

@endsection
@section('script')
<script>


$(document).ready(function() {
    // បង្ហាញ loading overlay ពេល page load
    $('#global-loading').show();

    // លាក់ loading overlay បន្ទាប់ពីទំព័រ load សម្រេច
    $(window).on('load', function() {
        $('#global-loading').fadeOut();
    });

    // Optional: ចង់ប្រើសម្រាប់ AJAX ទាំងអស់
    $(document).ajaxStart(function() {
        $('#global-loading').show();
    });

    $(document).ajaxStop(function() {
        $('#global-loading').fadeOut();
    });
});


   
const viewProduct = (id) => {
    // បង្ហាញ loading
    $('#loading-overlay').show();
    $('#product-modal').modal('show'); 

    $.ajax({
        type: "GET",
        url: "{{ route('product.view') }}",
        data: { "id": id },
        dataType: "json",
        success: function(response) {
            if (response.status == 200) {
                let product = response.product;

                let productHTML = `

                <div class="row">
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <div class="modal-image">`;

                if (product.images.length > 0) {
                    productHTML += `<img class="img-responsive" src="{{ asset('uploads/product/${product.images[0].image}') }}" />`;
                }

                productHTML += `
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="product-short-details">
                            <h2 class="product-title">${product.name}</h2>
                            <p class="product-price">$${product.price}</p>
                            <p class="product-short-description">
                                ${(product.desc.substring(0, 200) + '...')}
                            </p>
                            <a href="cart.html" class="btn btn-main">Add To Cart</a>
                            <a href="/product/single/${product.id}" class="btn btn-transparent">View Product Details</a>
                        </div>
                    </div>
                    
                </div>`;

                $('.view-product').html(productHTML);
            }
        },
        // error: function() {
        //     $('.view-product').html('<p class="text-danger">Something went wrong!</p>');
        // },
        complete: function() {
            // លាក់ loading នៅពេល AJAX បញ្ចប់
            $('#loading-overlay').hide();
        }
    });
}

</script>
@endsection