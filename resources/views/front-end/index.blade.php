{{-- @extends('front-end.components.master')

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
                                      <li>
                                        <a href="#!"><i class="tf-ion-ios-heart"></i></a>
                                    </li>
                                    <li>

                                        @if (Auth::check())
                                            <a href="{{ route('cart.add',$product->id) }}">
                                                <i class="tf-ion-android-cart"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('customer.login') }}">
                                                <i class="tf-ion-android-cart"></i>
                                            </a>
                                        @endif

                                    
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

                                <a href="{{ route('cart.add',$product->id) }}" class="btn btn-main">Add To Cart</a>
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

        });
    }




</script>
@endsection



 --}}
@extends('front-end.components.master')

{{-- ═══════════════════════════════════════════════
     HERO SLIDER
═══════════════════════════════════════════════ --}}
@section('slider')
<div class="hero-slider">

    <div class="slider-item th-fullpage hero-area"
         style="background-image:url({{ asset('front-end/assets/images/slider/slider-1.jpg') }});">
        <div class="hero-overlay"></div>
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8">
                    <span class="hero-tag" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</span>
                    <h1 class="hero-title" data-animation-in="fadeInUp" data-delay-in=".5">
                        The beauty of nature<br>is hidden in details.
                    </h1>
                    {{-- <a href="{{ route('shop') }}" class="btn-hero" data-animation-in="fadeInUp" data-delay-in=".8">
                        Shop Now <span class="btn-hero-arrow">→</span>
                    </a> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="slider-item th-fullpage hero-area"
         style="background-image:url({{ asset('front-end/assets/images/slider/slider-3.jpg') }});">
        <div class="hero-overlay"></div>
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-8">
                    <span class="hero-tag">PRODUCTS</span>
                    <h1 class="hero-title">The beauty of nature<br>is hidden in details.</h1>
                    <a href="{{ route('home.index') }}" class="btn-hero">Shop Now <span class="btn-hero-arrow">→</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="slider-item th-fullpage hero-area"
         style="background-image:url({{ asset('front-end/assets/images/slider/slider-2.jpg') }});">
        <div class="hero-overlay"></div>
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-end">
                <div class="col-lg-8 text-right">
                    <span class="hero-tag">PRODUCTS</span>
                    <h1 class="hero-title">The beauty of nature<br>is hidden in details.</h1>
                    <a href="{{ route('home.index') }}" class="btn-hero">Shop Now <span class="btn-hero-arrow">→</span></a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


{{-- ═══════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════ --}}
@section('contents')

{{-- Global page loader --}}
<div id="global-loading">
    <div class="loader-ring">
        <div></div><div></div><div></div><div></div>
    </div>
</div>

{{-- ─── PRODUCT CATEGORIES ─── --}}
<section class="section-categories py-5">
    <div class="container">

        {{-- Section heading --}}
        <div class="section-head text-center mb-5">
            <span class="section-eyebrow">Browse by type</span>
            <h2 class="section-title">Product Categories</h2>
        </div>

        <div class="row g-4">

            {{-- Left column: two small cards --}}
            <div class="col-md-6">
                <div class="cat-card cat-card-sm mb-4">
                    <a href="{{ route('product.category', $categories[0]->id) }}">
                        <img src="{{ asset('uploads/category/'.$categories[0]->image) }}"
                             alt="{{ $categories[0]->name }}" class="cat-img"/>
                        <div class="cat-overlay">
                            <div class="cat-body">
                                <h3 class="cat-name">{{ $categories[0]->name }}</h3>
                                <p class="cat-sub">Shop New Season Clothing</p>
                                <span class="cat-link">Explore →</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="cat-card cat-card-sm">
                    <a href="{{ route('product.category', $categories[1]->id) }}">
                        <img src="{{ asset('uploads/category/'.$categories[1]->image) }}"
                             alt="{{ $categories[1]->name }}" class="cat-img"/>
                        <div class="cat-overlay">
                            <div class="cat-body">
                                <h3 class="cat-name">{{ $categories[1]->name }}</h3>
                                <p class="cat-sub">Get Wide Range Selection</p>
                                <span class="cat-link">Explore →</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Right column: two tall cards --}}
            <div class="col-md-3">
                <div class="cat-card cat-card-tall">
                    <a href="{{ route('product.category', $categories[2]->id) }}">
                        <img src="{{ asset('uploads/category/'.$categories[2]->image) }}"
                             alt="{{ $categories[2]->name }}" class="cat-img"/>
                        <div class="cat-overlay">
                            <div class="cat-body">
                                <h3 class="cat-name">{{ $categories[2]->name }}</h3>
                                <p class="cat-sub">Special Design Comes First</p>
                                <span class="cat-link">Explore →</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="cat-card cat-card-tall">
                    <a href="{{ route('product.category', $categories[3]->id) }}">
                        <img src="{{ asset('uploads/category/'.$categories[3]->image) }}"
                             alt="{{ $categories[3]->name }}" class="cat-img"/>
                        <div class="cat-overlay">
                            <div class="cat-body">
                                <h3 class="cat-name">{{ $categories[3]->name }}</h3>
                                <p class="cat-sub">Exclusive Collection</p>
                                <span class="cat-link">Explore →</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ─── PROMO STRIP ─── --}}
<div class="promo-strip">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 promo-item">
                <span class="promo-icon">🚚</span>
                <span class="promo-text">Free Shipping over $99</span>
            </div>
            <div class="col-md-4 promo-item">
                <span class="promo-icon">🔄</span>
                <span class="promo-text">30-Day Easy Returns</span>
            </div>
            <div class="col-md-4 promo-item">
                <span class="promo-icon">🔒</span>
                <span class="promo-text">Secure Checkout</span>
            </div>
        </div>
    </div>
</div>


{{-- ─── ALL PRODUCTS ─── --}}
<section class="section-products py-5">
    <div class="container">

        <div class="section-head text-center mb-5">
            <span class="section-eyebrow">Fresh Arrivals</span>
            <h2 class="section-title">All Products</h2>
        </div>

        <div class="row g-4">

            @if($products->isNotEmpty())
                @foreach($products as $product)
                    @php
                            if ($product->images != '') {
                                $img = $product->images->first();
                                $imageUrl = $img
                                    ? asset('uploads/product/' . $img->image)
                                    : asset('front-end/assets/images/shop/products/product-1.jpg');
                            }
                    @endphp

                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="product-card">

                            {{-- Thumb --}}
                            <div class="product-thumb">
                                @if($product->discount > 0)
                                    <span class="badge-sale">−{{ $product->discount }}%</span>
                                @endif

                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="product-img"/>

                                {{-- Hover actions --}}
                                <div class="product-actions">
                                    <button class="action-btn"
                                            onclick="viewProduct({{ $product->id }})"
                                            data-toggle="modal"
                                            data-target="#product-modal"
                                            title="Quick View">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                                        </svg>
                                    </button>

                                    <button class="action-btn" title="Wishlist">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                    </button>

                                    @auth
                                        <a href="{{ route('cart.add', $product->id) }}" class="action-btn" title="Add to Cart">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ route('customer.login') }}" class="action-btn" title="Login to Add">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                            </svg>
                                        </a>
                                    @endauth
                                </div>

                                {{-- Quick add bar --}}
                                @auth
                                    <a href="{{ route('cart.add', $product->id) }}" class="quick-add-bar">
                                        Add to Cart
                                    </a>
                                @else
                                    <a href="{{ route('customer.login') }}" class="quick-add-bar">
                                        Login to Purchase
                                    </a>
                                @endauth
                            </div>

                            {{-- Info --}}
                            <div class="product-info">
                                <h5 class="product-name">
                                    <a href="/product/{{ $product->id }}">{{ $product->name }}</a>
                                </h5>
                                <div class="product-price-row">
                                    @if($product->discount > 0)
                                        <span class="price-now">
                                            ${{ number_format($product->price * (1 - $product->discount/100), 2) }}
                                        </span>
                                        <span class="price-old">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="price-now">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>

                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No products available at the moment.</p>
                </div>
            @endif

        </div>{{-- /.row --}}
    </div>
</section>


{{-- ─── QUICK VIEW MODAL ─── --}}
<div class="modal fade product-modal" id="product-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">

            <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
            </button>

            {{-- Loading state --}}
            <div id="modal-loader" class="modal-loader">
                <div class="loader-ring sm">
                    <div></div><div></div><div></div><div></div>
                </div>
            </div>

            <div class="modal-body p-0 view-product"></div>

        </div>
    </div>
</div>

@endsection


{{-- ═══════════════════════════════════════════════
     STYLES
═══════════════════════════════════════════════ --}}
@section('style')
<style>
/* ── Google Fonts ── */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500;600&display=swap');

/* ── Tokens ── */

:root {
    --ink:        #1c1917;
    --ink-soft:   #78716c;
    --pearl:      #faf8f5;
    --linen:      #f0ebe3;
    --border:     #e7e0d8;
    --sage:       #4a7c59;
    --sage-deep:  #355942;
    --gold:       #b5874c;
    --rouge:      #c0392b;
    --white:      #ffffff;

    --r-sm: 8px;
    --r-md: 14px;
    --r-lg: 22px;

    --ease: cubic-bezier(.4,0,.2,1);
    --dur:  .36s;
}

/* ── Base ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Outfit', sans-serif;
    background: var(--pearl);
    color: var(--ink);
    font-size: 15px;
    line-height: 1.65;
    overflow-x: hidden;
}

h1,h2,h3,h4 {
    font-family: 'Cormorant Garamond', serif;
    font-weight: 600;
    line-height: 1.15;
    letter-spacing: -.01em;
}

a { text-decoration: none; color: inherit; }
img { display: block; max-width: 100%; }

/* ── Global Loader ── */
#global-loading {
    position: fixed;
    inset: 0;
    background: var(--pearl);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    transition: opacity .4s var(--ease);
}
#global-loading.hidden { opacity: 0; pointer-events: none; }

/* Loader ring animation */
.loader-ring {
    display: inline-block;
    position: relative;
    width: 56px;
    height: 56px;
}
.loader-ring.sm { width: 36px; height: 36px; }
.loader-ring div {
    box-sizing: border-box;
    display: block;
    position: absolute;
    width: 44px; height: 44px;
    margin: 6px;
    border: 4px solid transparent;
    border-top-color: var(--sage);
    border-radius: 50%;
    animation: ring-spin 1s linear infinite;
}
.loader-ring.sm div { width: 28px; height: 28px; margin: 4px; border-width: 3px; }
.loader-ring div:nth-child(1) { animation-delay: -0.45s; }
.loader-ring div:nth-child(2) { animation-delay: -0.3s;  }
.loader-ring div:nth-child(3) { animation-delay: -0.15s; }
@keyframes ring-spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

/* ── Hero Slider ── */
.hero-slider .slider-item {
    position: relative;
    min-height: 90vh;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, rgba(28,25,23,.62) 0%, rgba(28,25,23,.22) 100%);
}
.hero-area .container { position: relative; z-index: 2; }

.hero-tag {
    display: inline-block;
    font-family: 'Outfit', sans-serif;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .28em;
    text-transform: uppercase;
    color: rgba(255,255,255,.7);
    border: 1px solid rgba(255,255,255,.3);
    padding: 6px 16px;
    border-radius: 40px;
    margin-bottom: 24px;
}
.hero-title {
    font-size: clamp(2.6rem, 6vw, 5rem);
    color: var(--white);
    margin-bottom: 36px;
    text-shadow: 0 2px 32px rgba(0,0,0,.18);
}
.btn-hero {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 40px;
    background: var(--white);
    color: var(--ink);
    font-family: 'Outfit', sans-serif;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    border-radius: var(--r-sm);
    transition: background var(--dur) var(--ease),
                color var(--dur) var(--ease),
                transform var(--dur) var(--ease),
                box-shadow var(--dur) var(--ease);
}
.btn-hero-arrow { font-size: 18px; transition: transform var(--dur) var(--ease); }
.btn-hero:hover {
    background: var(--sage);
    color: var(--white);
    transform: translateY(-3px);
    box-shadow: 0 10px 32px rgba(74,124,89,.38);
}
.btn-hero:hover .btn-hero-arrow { transform: translateX(4px); }

/* ── Section Head ── */
.section-eyebrow {
    display: block;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .26em;
    text-transform: uppercase;
    color: var(--sage);
    margin-bottom: 10px;
}
.section-title {
    font-size: clamp(1.8rem, 3.5vw, 2.8rem);
    color: var(--ink);
    position: relative;
    display: inline-block;
}
.section-title::after {
    content: '';
    display: block;
    height: 3px;
    width: 52px;
    background: var(--gold);
    margin: 14px auto 0;
    border-radius: 2px;
}

/* ── Promo Strip ── */
.promo-strip {
    background: var(--ink);
    color: var(--white);
    padding: 18px 0;
}
.promo-item {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border-right: 1px solid rgba(255,255,255,.12);
}
.promo-item:last-child { border-right: none; }
.promo-icon { font-size: 20px; }
.promo-text { font-size: 13px; font-weight: 500; letter-spacing: .04em; }

/* ── Category Cards ── */
.section-categories { background: var(--pearl); }

.cat-card {
    position: relative;
    border-radius: var(--r-lg);
    overflow: hidden;
    box-shadow: 0 4px 28px rgba(28,25,23,.08);
}
.cat-card a { display: block; position: relative; }
.cat-img {
    width: 100%;
    object-fit: cover;
    transition: transform .6s var(--ease);
}
.cat-card-sm  .cat-img { height: 230px; }
.cat-card-tall .cat-img { height: 492px; }

.cat-card:hover .cat-img { transform: scale(1.07); }

.cat-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(28,25,23,.75) 0%, rgba(28,25,23,0) 55%);
    display: flex;
    align-items: flex-end;
    padding: 28px 24px;
    transition: background var(--dur) var(--ease);
}
.cat-card:hover .cat-overlay {
    background: linear-gradient(to top, rgba(28,25,23,.86) 0%, rgba(28,25,23,.12) 70%);
}

.cat-name {
    font-size: 1.45rem;
    color: var(--white);
    margin-bottom: 4px;
}
.cat-sub {
    font-size: 12px;
    color: rgba(255,255,255,.72);
    letter-spacing: .04em;
    margin-bottom: 12px;
}
.cat-link {
    display: inline-block;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--white);
    border-bottom: 1px solid rgba(255,255,255,.5);
    padding-bottom: 2px;
    opacity: 0;
    transform: translateY(6px);
    transition: opacity var(--dur) var(--ease), transform var(--dur) var(--ease);
}
.cat-card:hover .cat-link { opacity: 1; transform: translateY(0); }

/* ── Product Cards ── */
.section-products { background: var(--linen); }

.product-card {
    background: var(--white);
    border-radius: var(--r-md);
    overflow: hidden;
    box-shadow: 0 2px 20px rgba(28,25,23,.07);
    transition: box-shadow var(--dur) var(--ease),
                transform var(--dur) var(--ease);
}
.product-card:hover {
    box-shadow: 0 12px 48px rgba(28,25,23,.14);
    transform: translateY(-6px);
}

/* Thumb */
.product-thumb {
    position: relative;
    overflow: hidden;
}
.product-img {
    width: 100%;
    height: 290px;
    object-fit: cover;
    transition: transform .6s var(--ease);
}
.product-card:hover .product-img { transform: scale(1.07); }

/* Sale badge */
.badge-sale {
    position: absolute;
    top: 14px;
    left: 14px;
    z-index: 4;
    background: var(--rouge);
    color: var(--white);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    padding: 5px 11px;
    border-radius: 40px;
}

/* Action buttons overlay */
.product-actions {
    position: absolute;
    top: 14px;
    right: 14px;
    z-index: 4;
    display: flex;
    flex-direction: column;
    gap: 8px;
    opacity: 0;
    transform: translateX(10px);
    transition: opacity var(--dur) var(--ease),
                transform var(--dur) var(--ease);
}
.product-card:hover .product-actions {
    opacity: 1;
    transform: translateX(0);
}
.action-btn {
    width: 40px;
    height: 40px;
    background: var(--white);
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 12px rgba(0,0,0,.12);
    transition: background var(--dur) var(--ease), color var(--dur) var(--ease);
    color: var(--ink);
}
.action-btn:hover { background: var(--sage); color: var(--white); }

/* Quick add bar */
.quick-add-bar {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    z-index: 4;
    background: var(--sage);
    color: var(--white);
    text-align: center;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: 13px;
    transform: translateY(100%);
    transition: transform .32s var(--ease);
}
.product-card:hover .quick-add-bar { transform: translateY(0); }
.quick-add-bar:hover { background: var(--sage-deep); color: var(--white); }

/* Product info */
.product-info {
    padding: 18px 18px 20px;
    border-top: 1px solid var(--border);
}
.product-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem;
    margin-bottom: 8px;
}
.product-name a { color: var(--ink); transition: color .2s; }
.product-name a:hover { color: var(--sage); }

.product-price-row { display: flex; align-items: center; gap: 10px; }
.price-now {
    font-size: 1rem;
    font-weight: 600;
    color: var(--sage);
}
.price-old {
    font-size: .85rem;
    color: var(--ink-soft);
    text-decoration: line-through;
}

/* ── Product Modal ── */
.product-modal .modal-dialog { max-width: 900px; }
.product-modal .modal-content {
    border: none;
    border-radius: var(--r-lg);
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,.22);
}
.modal-close-btn {
    position: absolute;
    top: 18px;
    right: 18px;
    z-index: 20;
    width: 40px;
    height: 40px;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background var(--dur) var(--ease);
    color: var(--ink);
}
.modal-close-btn:hover { background: var(--ink); color: var(--white); border-color: var(--ink); }

.modal-loader {
    position: absolute;
    inset: 0;
    background: rgba(250,248,245,.88);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    border-radius: var(--r-lg);
}
.modal-loader.hidden { display: none; }

/* Modal inner layout injected via JS */
.modal-product-img {
    width: 100%;
    height: 100%;
    min-height: 460px;
    object-fit: cover;
}
.modal-product-details {
    padding: 48px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: var(--white);
}
.modal-product-name { font-size: 2rem; margin-bottom: 8px; }
.modal-product-price {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--sage);
    margin-bottom: 20px;
}
.modal-product-desc {
    font-size: 14px;
    color: var(--ink-soft);
    line-height: 1.75;
    margin-bottom: 32px;
    border-top: 1px solid var(--border);
    padding-top: 20px;
}
.modal-btn-cart {
    display: block;
    width: 100%;
    padding: 15px;
    background: var(--sage);
    color: var(--white);
    text-align: center;
    border: none;
    border-radius: var(--r-sm);
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    margin-bottom: 12px;
    transition: background var(--dur) var(--ease), transform var(--dur) var(--ease);
    cursor: pointer;
}
.modal-btn-cart:hover {
    background: var(--sage-deep);
    color: var(--white);
    transform: translateY(-2px);
}
.modal-btn-view {
    display: block;
    width: 100%;
    padding: 14px;
    background: transparent;
    color: var(--sage);
    text-align: center;
    border: 2px solid var(--sage);
    border-radius: var(--r-sm);
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    transition: background var(--dur) var(--ease), color var(--dur) var(--ease);
}
.modal-btn-view:hover { background: var(--sage); color: var(--white); }

/* ── Responsive ── */
@media (max-width: 991px) {
    .cat-card-sm  .cat-img { height: 190px; }
    .cat-card-tall .cat-img { height: 310px; }
    .product-img { height: 240px; }
    .promo-item { border-right: none; padding: 8px 0; }
}
@media (max-width: 767px) {
    .hero-slider .slider-item { min-height: 70vh; }
    .hero-title { font-size: 2rem; }
    .modal-product-details { padding: 28px 22px; }
    .product-img { height: 220px; }
}
@media (max-width: 575px) {
    .cat-card-sm  .cat-img { height: 170px; }
    .section-title::after { margin: 10px auto 0; }
}
</style>
@endsection


{{-- ═══════════════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════════════ --}}
@section('script')
<script>
$(function () {

    /* ── Page loader ── */
    $(window).on('load', function () {
        $('#global-loading').addClass('hidden');
        setTimeout(function(){ $('#global-loading').hide(); }, 500);
    });

    /* AJAX start/stop */
    $(document).ajaxStart(function () { $('#global-loading').show().removeClass('hidden'); });
    $(document).ajaxStop(function ()  { $('#global-loading').addClass('hidden'); });

    /* ── Smooth open / close modal ── */
    $('#product-modal').on('show.bs.modal', function () {
        $('#modal-loader').removeClass('hidden');
        $('.view-product').empty();
    });

});

/* ── Quick View ── */
function viewProduct(id) {
    $('#modal-loader').removeClass('hidden');
    $('.view-product').empty();

    $.ajax({
        type    : 'GET',
        url     : "{{ route('product.view') }}",
        data    : { id: id },
        dataType: 'json',
        success : function (res) {
            if (res.status === 200) {
                var p   = res.product;
                var img = p.images.length
                    ? '/uploads/product/' + p.images[0].image
                    : "{{ asset('front-end/assets/images/shop/products/product-1.jpg') }}";

                var html = `
                <div class="row no-gutters" style="min-height:460px;">
                    <div class="col-md-6">
                        <img src="${img}" alt="${p.name}" class="modal-product-img"/>
                    </div>
                    <div class="col-md-6">
                        <div class="modal-product-details">
                            <h2 class="modal-product-name">${p.name}</h2>
                            <p class="modal-product-price">$${parseFloat(p.price).toFixed(2)}</p>
                            <p class="modal-product-desc">${p.desc ?? 'No description available.'}</p>
                            <a href="/cart/add/${p.id}" class="modal-btn-cart">Add to Cart</a>
                            <a href="/product/single/${p.id}" class="modal-btn-view">View Full Details</a>
                        </div>
                    </div>
                </div>`;

                $('.view-product').html(html);
                $('#modal-loader').addClass('hidden');
            }
        },
        error: function () {
            $('.view-product').html('<p class="text-center p-5 text-muted">Could not load product.</p>');
            $('#modal-loader').addClass('hidden');
        }
    });
}
</script>
@endsection