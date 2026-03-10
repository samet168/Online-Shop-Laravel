@extends('front-end.components.master')

@section('style')
<style>
/* ══════════════════════════════════════════════
   SHOP PAGE — Editorial Dark Theme
   Fonts: Fraunces (display) + DM Sans (body)
   Palette: Deep charcoal · Warm ivory · Amber
══════════════════════════════════════════════ */
@import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,600;0,9..144,700;1,9..144,400&family=DM+Sans:wght@300;400;500;600&display=swap');

/* ── Tokens ───────────────────────────────── */
:root {


  --bg:          #bcb7b7;
  --bg-card:     #7e7a7a;
  --bg-hover:    #9e9e9e;
  --surface:     #5b5957;
  --ivory:       #000000;
  --ivory-dim:   #171615;
  --amber:       #d4963a;
  --amber-glow:  rgba(212,150,58,.18);
  --rouge:       #c0392b;
  --border:      rgba(245,240,232,.08);
  --border-lit:  rgba(245,240,232,.18);
  --r:           12px;
  --r-pill:      40px;
  --ease:        cubic-bezier(.4,0,.2,1);
  --dur:         .32s;
}

/* ── Reset / Base ─────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'DM Sans', sans-serif;
  /* background: var(--bg); */
  /* color: var(--ivory); */
  font-size: 15px;
  line-height: 1.65;
  overflow-x: hidden;
}

h1, h2, h3, h4 {
  font-family: 'Fraunces', serif;
  line-height: 1.15;
}

a { text-decoration: none; color: inherit; }
img { display: block; max-width: 100%; }

/* ── Page Loader ──────────────────────────── */
#global-loading {
  position: fixed;
  inset: 0;
  background: var(--bg);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  transition: opacity .5s var(--ease);
}
#global-loading.out { opacity: 0; pointer-events: none; }

.loader-dots {
  display: flex;
  gap: 10px;
  align-items: center;
}
.loader-dots span {
  width: 10px;
  height: 10px;
  background: var(--amber);
  border-radius: 50%;
  animation: dot-pulse 1.2s ease-in-out infinite;
}
.loader-dots span:nth-child(2) { animation-delay: .2s; }
.loader-dots span:nth-child(3) { animation-delay: .4s; }

@keyframes dot-pulse {
  0%, 80%, 100% { transform: scale(.6); opacity: .4; }
  40%            { transform: scale(1);  opacity: 1;   }
}

/* ── Page Header ──────────────────────────── */
.page-header {
  position: relative;
  padding: 80px 0 60px;
  background: var(--bg-card);
  border-bottom: 1px solid var(--border);
  overflow: hidden;
}

/* Decorative grid lines */
.page-header::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(var(--border) 1px, transparent 1px),
    linear-gradient(90deg, var(--border) 1px, transparent 1px);
  background-size: 60px 60px;
  pointer-events: none;
}

/* Glow blob */
.page-header::after {
  content: '';
  position: absolute;
  top: -80px;
  right: -80px;
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, var(--amber-glow) 0%, transparent 70%);
  pointer-events: none;
}

.page-header .container { position: relative; z-index: 2; }

.page-header .content { text-align: left; }

.page-name {
  font-size: clamp(2.8rem, 6vw, 5rem);
  font-weight: 700;
  color: var(--ivory);
  letter-spacing: -.03em;
  margin-bottom: 16px;
  position: relative;
  display: inline-block;
}

/* Amber underline accent */
.page-name::after {
  content: '';
  display: block;
  height: 3px;
  width: 60%;
  background: linear-gradient(90deg, var(--amber), transparent);
  margin-top: 10px;
  border-radius: 2px;
}

/* Breadcrumb */
.breadcrumb {
  background: transparent;
  padding: 0;
  margin: 0;
}
.breadcrumb li {
  font-size: 13px;
  font-weight: 400;
  color: var(--ivory-dim);
  letter-spacing: .04em;
}
.breadcrumb li a {
  color: var(--amber);
  transition: color var(--dur) var(--ease);
}
.breadcrumb li a:hover { color: var(--ivory); }
.breadcrumb-item + .breadcrumb-item::before { color: var(--border-lit); }
.breadcrumb-item.active { color: var(--ivory-dim); }

/* ── Filter / Sort Bar ───────────────────── */
.shop-toolbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  padding: 22px 0 32px;
  border-bottom: 1px solid var(--border);
  margin-bottom: 40px;
}

.shop-count {
  font-size: 13px;
  color: var(--ivory-dim);
  letter-spacing: .04em;
}
.shop-count strong { color: var(--ivory); font-weight: 600; }

.sort-select {
  background: var(--surface);
  border: 1px solid var(--border-lit);
  color: var(--ivory);
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  padding: 9px 16px;
  border-radius: var(--r-pill);
  cursor: pointer;
  outline: none;
  transition: border-color var(--dur) var(--ease);
  appearance: none;
  padding-right: 32px;
  background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' fill='none' stroke='%23b5afa3' stroke-width='2' viewBox='0 0 12 8' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
}
.sort-select:focus { border-color: var(--amber); }

/* ── Products Section ─────────────────────── */
.products.section {
  padding: 60px 0 80px;
  background: var(--bg);
}

/* ── Product Card ──────────────────────────── */
.product-card-wrap {
  margin-bottom: 32px;
}

.product-item {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: var(--r);
  overflow: hidden;
  transition:
    transform var(--dur) var(--ease),
    border-color var(--dur) var(--ease),
    box-shadow var(--dur) var(--ease);
  position: relative;
}

.product-item:hover {
  transform: translateY(-6px);
  border-color: var(--border-lit);
  box-shadow: 0 16px 48px rgba(0,0,0,.45), 0 0 0 1px rgba(212,150,58,.12);
}

/* Thumb */
.product-thumb {
  position: relative;
  overflow: hidden;
  aspect-ratio: 4/5;
}

.product-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform .65s var(--ease);
}
.product-item:hover .product-thumb img {
  transform: scale(1.08);
}

/* Sale badge */
.bage {
  position: absolute;
  top: 14px;
  left: 14px;
  z-index: 5;
  background: var(--rouge);
  color: #fff;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .12em;
  text-transform: uppercase;
  padding: 5px 12px;
  border-radius: var(--r-pill);
}

/* Action icons overlay */
.preview-meta {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to bottom,
    rgba(17,16,16,0) 30%,
    rgba(17,16,16,.65) 100%
  );
  display: flex;
  align-items: flex-end;
  justify-content: center;
  padding-bottom: 20px;
  opacity: 0;
  transition: opacity var(--dur) var(--ease);
}

.product-item:hover .preview-meta { opacity: 1; }

.preview-meta ul {
  list-style: none;
  display: flex;
  gap: 10px;
  padding: 0;
  margin: 0;
}

.preview-meta ul li {
  width: 42px;
  height: 42px;
  background: rgba(245,240,232,.12);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(245,240,232,.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition:
    background var(--dur) var(--ease),
    border-color var(--dur) var(--ease),
    transform var(--dur) var(--ease);
  transform: translateY(12px);
  transition-delay: calc(var(--i, 0) * .06s);
}
.product-item:hover .preview-meta ul li {
  transform: translateY(0);
}
.preview-meta ul li:nth-child(1) { --i: 0; }
.preview-meta ul li:nth-child(2) { --i: 1; }
.preview-meta ul li:nth-child(3) { --i: 2; }

.preview-meta ul li:hover {
  background: var(--amber);
  border-color: var(--amber);
}

.preview-meta ul li i,
.preview-meta ul li a { color: var(--ivory); font-size: 17px; display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; }
.preview-meta ul li a { color: var(--ivory); }

/* Quick-add strip slides up */
.quick-add {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  background: var(--amber);
  color: #fff;
  text-align: center;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: .14em;
  text-transform: uppercase;
  padding: 13px;
  transform: translateY(100%);
  transition: transform .3s var(--ease);
  z-index: 4;
}
.product-item:hover .quick-add { transform: translateY(0); }
.quick-add:hover { background: #c4892f; color: #fff; }

/* Product info */
.product-content {
  padding: 18px 18px 20px;
  border-top: 1px solid var(--border);
}

.product-content h4 {
  font-family: 'Fraunces', serif;
  font-size: 1.05rem;
  font-weight: 600;
  margin-bottom: 8px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.product-content h4 a {
  color: var(--ivory);
  transition: color .2s;
}
.product-content h4 a:hover { color: var(--amber); }

.product-content .price {
  font-size: .98rem;
  font-weight: 600;
  color: var(--amber);
  margin: 0;
}

/* ── Pagination ───────────────────────────── */
.pagination-wrap {
  padding: 20px 0 10px;
  display: flex;
  justify-content: center;
}

/* Override Laravel default pagination */
.pagination .page-item .page-link {
  background: var(--surface);
  border: 1px solid var(--border-lit);
  color: var(--ivory-dim);
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  font-weight: 500;
  padding: 8px 16px;
  margin: 0 3px;
  border-radius: var(--r) !important;
  transition: background var(--dur) var(--ease), color var(--dur) var(--ease), border-color var(--dur) var(--ease);
}
.pagination .page-item .page-link:hover {
  background: var(--amber);
  border-color: var(--amber);
  color: #fff;
}
.pagination .page-item.active .page-link {
  background: var(--amber);
  border-color: var(--amber);
  color: #fff;
}
.pagination .page-item.disabled .page-link {
  opacity: .35;
  pointer-events: none;
}

/* ── Quick View Modal ─────────────────────── */
.product-modal .modal-dialog {
  max-width: 920px;
}

.product-modal .modal-content {
  background: var(--bg-card);
  border: 1px solid var(--border-lit);
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 40px 100px rgba(0,0,0,.6);
}

.product-modal .modal-body {
  padding: 0;
}

/* Close btn */
.product-modal .close {
  position: absolute;
  top: 18px;
  right: 18px;
  z-index: 20;
  width: 40px;
  height: 40px;
  background: var(--surface);
  border: 1px solid var(--border-lit);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: var(--ivory);
  font-size: 18px;
  transition: background var(--dur) var(--ease), border-color var(--dur) var(--ease);
  line-height: 1;
  padding: 0;
  opacity: 1;
  text-shadow: none;
}
.product-modal .close:hover {
  background: var(--amber);
  border-color: var(--amber);
  color: #fff;
}

/* Modal loading overlay */
#loading-overlay {
  position: absolute;
  inset: 0;
  background: rgba(17,16,16,.85);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 15;
  border-radius: 18px;
}

/* Modal inner layout (injected via JS) */
.modal-image img {
  width: 100%;
  height: 100%;
  min-height: 480px;
  object-fit: cover;
}

.product-short-details {
  padding: 52px 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background: var(--bg-card);
  height: 100%;
}

.product-title {
  font-family: 'Fraunces', serif;
  font-size: 1.9rem;
  font-weight: 700;
  color: var(--ivory);
  margin-bottom: 10px;
  line-height: 1.2;
}

.product-price {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--amber);
  margin-bottom: 20px;
}

.product-short-description {
  font-size: 14px;
  color: var(--ivory-dim);
  line-height: 1.75;
  margin-bottom: 32px;
  padding-top: 20px;
  border-top: 1px solid var(--border);
}

.btn-main {
  display: block;
  width: 100%;
  padding: 15px;
  background: var(--amber);
  color: #fff !important;
  border: none;
  border-radius: var(--r);
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: .12em;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 12px;
  transition: background var(--dur) var(--ease), transform var(--dur) var(--ease);
  cursor: pointer;
}
.btn-main:hover {
  background: #c4892f;
  transform: translateY(-2px);
  color: #fff !important;
}

.btn-transparent {
  display: block;
  width: 100%;
  padding: 14px;
  background: transparent;
  color: var(--ivory) !important;
  border: 1px solid var(--border-lit);
  border-radius: var(--r);
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  text-align: center;
  transition: border-color var(--dur) var(--ease), background var(--dur) var(--ease);
  cursor: pointer;
}
.btn-transparent:hover {
  border-color: var(--amber);
  background: var(--amber-glow);
  color: var(--ivory) !important;
}

/* ── Empty state ──────────────────────────── */
.empty-state {
  padding: 80px 20px;
  text-align: center;
}
.empty-state h3 {
  font-size: 1.5rem;
  color: var(--ivory-dim);
  margin-bottom: 8px;
}
.empty-state p { color: var(--ivory-dim); font-size: 14px; }

/* ── Responsive ───────────────────────────── */
@media (max-width: 991px) {
  .product-modal .modal-dialog { max-width: 95%; }
  .product-short-details { padding: 32px 24px; }
  .modal-image img { min-height: 320px; }
}

@media (max-width: 767px) {
  .page-name { font-size: 2.4rem; }
  .shop-toolbar { flex-direction: column; align-items: flex-start; }
}

@media (max-width: 575px) {
  .preview-meta ul li { width: 36px; height: 36px; }
  .product-content { padding: 14px 14px 16px; }
}
</style>
@endsection


@section('contents')

{{-- ── PAGE LOADER ── --}}
<div id="global-loading">
  <div class="loader-dots">
    <span></span><span></span><span></span>
  </div>
</div>

{{-- ── PAGE HEADER ── --}}
<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Shop</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Shop</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>


{{-- ── PRODUCTS ── --}}
<section class="products section">
  <div class="container">

    {{-- Toolbar --}}
    <div class="shop-toolbar">
      <span class="shop-count">
        Showing <strong>{{ $products->count() }}</strong> of
        <strong>{{ $products->total() }}</strong> products
      </span>
      <select class="sort-select">
        <option>Sort by: Default</option>
        <option>Price: Low to High</option>
        <option>Price: High to Low</option>
        <option>Newest First</option>
      </select>
    </div>

    {{-- Grid --}}
    <div class="row">

      @if($products->isNotEmpty())
        @foreach($products as $product)
          @php
            $img = $product->images->first();
            $imageUrl = $img
              ? asset('uploads/product/' . $img->image)
              : asset('front-end/assets/images/shop/products/product-1.jpg');
          @endphp

          <div class="col-lg-3 col-md-4 col-sm-6 product-card-wrap">
            <div class="product-item">

              {{-- Thumb --}}
              <div class="product-thumb">
                @if($product->discount > 0)
                  <span class="bage">−{{ $product->discount }}%</span>
                @else
                  <span class="bage">Sale</span>
                @endif

                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" />

                {{-- Actions overlay --}}
                <div class="preview-meta">
                  <ul>
                    <li onclick="viewProduct({{ $product->id }})"
                        data-toggle="modal" data-target="#product-modal">
                      <i class="tf-ion-ios-search-strong"></i>
                    </li>
                    <li><a href="#!"><i class="tf-ion-ios-heart"></i></a></li>
                    <li>
                      @auth
                        <a href="{{ route('cart.add', $product->id) }}">
                          <i class="tf-ion-android-cart"></i>
                        </a>
                      @else
                        <a href="{{ route('customer.login') }}">
                          <i class="tf-ion-android-cart"></i>
                        </a>
                      @endauth
                    </li>
                  </ul>
                </div>

                {{-- Quick add bar --}}
                @auth
                  <a href="{{ route('cart.add', $product->id) }}" class="quick-add">
                    Add to Cart
                  </a>
                @else
                  <a href="{{ route('customer.login') }}" class="quick-add">
                    Add to Cart
                  </a>
                @endauth
              </div>

              {{-- Info --}}
              <div class="product-content">
                <h4><a href="/product/{{ $product->id }}">{{ $product->name }}</a></h4>
                <p class="price">
                  @if($product->discount > 0)
                    ${{ number_format($product->price * (1 - $product->discount/100), 2) }}
                    <small style="color:var(--ivory-dim);font-weight:400;text-decoration:line-through;font-size:.8rem;margin-left:6px">
                      ${{ number_format($product->price, 2) }}
                    </small>
                  @else
                    ${{ number_format($product->price, 2) }}
                  @endif
                </p>
              </div>

            </div>
          </div>
        @endforeach

      @else
        <div class="col-12 empty-state">
          <h3>No products found</h3>
          <p>Check back later for new arrivals.</p>
        </div>
      @endif

    </div>{{-- /.row --}}

    {{-- Pagination --}}
    <div class="pagination-wrap">
      {{ $products->links() }}
    </div>

  </div>
</section>


{{-- ── QUICK VIEW MODAL ── --}}
<div class="modal product-modal fade" id="product-modal" tabindex="-1" role="dialog">

  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
      <path d="M18 6 6 18M6 6l12 12"/>
    </svg>
  </button>

  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">

      {{-- Modal loader --}}
      <div id="loading-overlay" style="display:none;">
        <div class="loader-dots">
          <span></span><span></span><span></span>
        </div>
      </div>

      <div class="modal-body view-product"></div>

    </div>
  </div>
</div>

@endsection


@section('script')
<script>
$(function () {

  /* ── Page loader ── */
  $(window).on('load', function () {
    $('#global-loading').addClass('out');
    setTimeout(function () { $('#global-loading').hide(); }, 550);
  });

  $(document).ajaxStart(function () {
    $('#loading-overlay').fadeIn(150);
  });
  $(document).ajaxStop(function () {
    $('#loading-overlay').fadeOut(250);
  });

  /* ── Reset modal on close ── */
  $('#product-modal').on('hidden.bs.modal', function () {
    $('.view-product').empty();
  });

});

/* ── Quick View ── */
function viewProduct(id) {
  $('#loading-overlay').fadeIn(150);
  $('.view-product').empty();

  $.ajax({
    type    : 'GET',
    url     : '{{ route("product.view") }}',
    data    : { id: id },
    dataType: 'json',
    success : function (response) {
      $('#loading-overlay').fadeOut(200);

      if (response.status === 200) {
        const p   = response.product;
        const img = p.images.length
          ? '/uploads/product/' + p.images[0].image
          : '{{ asset("front-end/assets/images/shop/products/product-1.jpg") }}';

        const desc = p.desc
          ? p.desc.substring(0, 220) + (p.desc.length > 220 ? '...' : '')
          : 'No description available.';

        const html = `
        <div class="row no-gutters" style="min-height:480px">
          <div class="col-md-6">
            <div class="modal-image h-100">
              <img src="${img}" alt="${p.name}" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="product-short-details">
              <h2 class="product-title">${p.name}</h2>
              <p class="product-price">$${parseFloat(p.price).toFixed(2)}</p>
              <p class="product-short-description">${desc}</p>
              <a href="/cart/add/${p.id}" class="btn btn-main">Add to Cart</a>
              <a href="/product/single/${p.id}" class="btn btn-transparent">View Full Details</a>
            </div>
          </div>
        </div>`;

        $('.view-product').html(html);
      }
    },
    error: function () {
      $('#loading-overlay').fadeOut(200);
      $('.view-product').html(
        '<p style="padding:60px;text-align:center;color:var(--ivory-dim)">Could not load product details.</p>'
      );
    }
  });
}
</script>
@endsection