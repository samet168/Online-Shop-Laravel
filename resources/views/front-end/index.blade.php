@extends('front-end.components.master')

@section('slider')
    <div class="hero-slider">
        <div class="slider-item th-fullpage hero-area"
            style="background-image: url({{ asset('front-end/assets/images/slider/slider-1.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 text-center">
                        <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                        <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature <br>
                            is hidden in details.</h1>
                        <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn"
                            href="shop.html">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-item th-fullpage hero-area"
            style="background-image: url({{ asset('front-end/assets/images/slider/slider-3.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 text-left">
                        <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                        <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature <br>
                            is hidden in details.</h1>
                        <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn"
                            href="shop.html">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-item th-fullpage hero-area"
            style="background-image: url({{ asset('front-end/assets/images/slider/slider-2.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 text-right">
                        <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                        <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature <br>
                            is hidden in details.</h1>
                        <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn"
                            href="shop.html">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('contents')
<div id="global-loading" style="display:none;">
    <div class="spinner"></div>
</div
<section class="product-category section">
>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="title text-center mb-5">
          <h2>Product Category</h2>
        </div>
      </div>

      <!-- Left Column -->
      <div class="col-md-6">
        <div class="category-box card-style">
          <a href="{{ route('product.category',$categories[0]->id) }}">
            <img src="{{ asset('uploads/category/' . $categories[0]->image) }}" alt="" />
            <div class="content">
              <h3>{{ $categories[0]->name }}</h3>
              <p>Shop New Season Clothing</p>
            </div>
          </a>
          
        </div>

        <div class="category-box card-style mt-4">
          <a href="{{ route('product.category',$categories[1]->id) }}">
            <img src="{{ asset('uploads/category/' . $categories[1]->image) }}" alt="" />
            <div class="content">
              <h3>{{ $categories[1]->name }}</h3>
              <p>Get Wide Range Selection</p>
            </div>
          </a>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-md-6">
        <div class="category-box card-style category-box-2">
          <a href="{{ route('product.category',$categories[2]->id) }}">
            <img src="{{ asset('uploads/category/' . $categories[2]->image) }}" alt="" />
            <div class="content">
              <h3>{{ $categories[2]->name }}</h3>
              <p>Special Design Comes First</p>
            </div>
          </a>
        </div>
      </div>
            <div class="col-md-6">
        <div class="category-box card-style category-box-2">
          <a href="{{ route('product.category',$categories[3]->id) }}">
            <img src="{{ asset('uploads/category/' . $categories[3]->image) }}" alt="" />
            <div class="content">
              <h3>{{ $categories[3]->name }}</h3>
              <p>Special Design Comes First</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="products section bg-gray">
  <div class="container">
    <div class="row">
      <div class="title text-center mb-5">
        <h2>ALL Products</h2>
      </div>
    </div>
    <div class="row">

      @if($products->isNotEmpty())
          @foreach($products as $product)
              @php 
                  $img = $product->images->first();
                  $imageUrl = $img
                      ? asset('uploads/product/' . $img->image)
                      : asset('front-end/assets/images/shop/products/product-1.jpg');
              @endphp

              <div class="col-md-4 col-sm-6 mb-4">
                  <div class="product-item card-hover">
                      <div class="product-thumb position-relative">
                          @if($product->discount > 0)
                          <span class="badge badge-sale">Sale</span>
                          @endif
                          <img class="img-fluid" src="{{ $imageUrl }}" alt="{{ $product->name }}" />
                          <div class="preview-meta">
                            <div class="preview-meta">
                                <ul>
                                    <li onclick="viewProduct({{ $product->id }})" class="preview-icon">
                                        <span data-toggle="modal" data-target="#product-modal">
                                            <i class="tf-ion-ios-search-strong"></i>
                                        </span>
                                    </li>
                                    <li class="preview-icon">
                                        <a href="#"><i class="tf-ion-ios-heart"></i></a>
                                    </li>
                                    <li class="preview-icon">
                                        <a href="#"><i class="tf-ion-android-cart"></i></a>
                                    </li>
                                </ul>
                            </div>
                          </div>
                      </div>
                      <div class="product-content text-center">
                          <h4><a href="/product/{{ $product->id }}">{{ $product->name }}</a></h4>
                          <p class="price">${{ $product->price }}</p>
                      </div>
                  </div>
              </div>

          @endforeach
      @endif

      <!-- Product Modal -->
      <div class="modal product-modal fade" id="product-modal" tabindex="-1">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="tf-ion-close"></i>
        </button>
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-body view-product"></div>
          </div>
        </div>
             <!-- Loading overlay -->
                <div id="loading-overlay" style="display:none;">
                <div class="spinner"></div>
                </div>
      </div>

    </div>
  </div>
</section>



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
    
    const viewProduct = (id)=>{
        $('#loading-overlay').show();
        $.ajax({
            type: "GET",
            url: "{{ route('product.view') }}",
            data: {id:id},
            dataType: "json",
            success: function (response) {

                if(response.status == 200){

                    let product = response.product;
                    let productHtml = '';

                    productHtml += `
                    <div class="row">
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="modal-image">`;

                    if(product.images.length > 0){
                        productHtml += `
                            <img class="img-responsive"
                            src="/uploads/product/${product.images[0].image}"
                            alt="product-img" />
                        `;
                    }

                    productHtml += `
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="product-short-details">
                                <h2 class="product-title">${product.name}</h2>
                                <p class="product-price">$${product.price}</p>
                                <p class="product-short-description">
                                    ${product.desc ?? ''}
                                </p>

                                <a href="#" class="btn btn-main">Add To Cart</a>
                                <a href="/product/single/${product.id}" class="btn btn-transparent">
                                    View Product Details
                                </a>
                            </div>
                        </div>
                    </div>
                    `;

                    $('.view-product').html(productHtml);
                }

        
            },
            complete: function() {
            // លាក់ loading នៅពេល AJAX បញ្ចប់
            $('#loading-overlay').hide();
        }
        });
    }




</script>
@endsection




