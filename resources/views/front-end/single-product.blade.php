@extends('front-end.components.master')

@section('style')
<style>
/* ══════════════════════════════════════════════════════
   SINGLE PRODUCT PAGE — Warm Dark Luxury
   Fonts: Playfair Display (serif) + Jost (sans)
   Palette: #0e0d0c · Ivory · Warm Gold · Terracotta
══════════════════════════════════════════════════════ */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Jost:wght@300;400;500;600&display=swap');

/* ── Tokens ── */
:root {

	

  --bg:          #ffffffc0;
  --surface:     #93939394;
  --surface-2:   #876e54;
  --ivory:       #000000;
  --ivory-muted: #3f3e3ebd;
  --gold:        #c8913a;
  --gold-light:  #e0ab56;
  --gold-glow:   rgb(200, 146, 58);
  --terra:       #b85c38;
  --border:      rgba(244,239,230,.07);
  --border-2:    rgba(244,239,230,.14);
  --white:       #ffffff;
  --r:           10px;
  --r-lg:        18px;
  --ease:        cubic-bezier(.4,0,.2,1);
  --spring:      cubic-bezier(.34,1.56,.64,1);
  --dur:         .35s;
}

/* ── Base ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Jost', sans-serif;
  /* background: var(--bg);
  color: var(--ivory); */
  font-size: 15px;
  line-height: 1.7;
  overflow-x: hidden;
}

h1,h2,h3,h4 {
  font-family: 'Playfair Display', serif;
  line-height: 1.2;
}

a { text-decoration: none; color: inherit; }
img { display: block; max-width: 100%; }

/* ── Page Loader ── */
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

.loader-track {
  width: 120px;
  height: 2px;
  background: var(--border-2);
  border-radius: 2px;
  overflow: hidden;
}
.loader-fill {
  height: 100%;
  background: linear-gradient(90deg, var(--gold), var(--gold-light));
  border-radius: 2px;
  animation: track-fill 1.1s var(--ease) forwards;
}
@keyframes track-fill {
  from { width: 0%; }
  to   { width: 100%; }
}

/* ── Breadcrumb ── */
.breadcrumb {
  background: transparent;
  padding: 32px 0 0;
  margin: 0;
  list-style: none;
  display: flex;
  gap: 6px;
  flex-wrap: wrap;
}
.breadcrumb li {
  font-size: 12px;
  font-weight: 500;
  letter-spacing: .06em;
  text-transform: uppercase;
  color: var(--ivory-muted);
}
.breadcrumb li a {
  color: var(--gold);
  transition: color .2s;
}
.breadcrumb li a:hover { color: var(--ivory); }
.breadcrumb li + li::before {
  content: '/ ';
  color: var(--border-2);
  margin-right: 6px;
}
.breadcrumb li.active { color: var(--ivory-muted); }

/* Product pagination */
.product-pagination {
  list-style: none;
  display: flex;
  justify-content: flex-end;
  gap: 8px;
  padding: 32px 0 0;
  margin: 0;
}
.product-pagination li a {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--ivory-muted);
  padding: 8px 16px;
  border: 1px solid var(--border-2);
  border-radius: var(--r);
  transition: color var(--dur), border-color var(--dur), background var(--dur);
}
.product-pagination li a:hover {
  color: var(--gold);
  border-color: var(--gold);
  background: var(--gold-glow);
}

/* ── Single Product ── */
.single-product { padding: 0 0 80px; background: var(--bg); }

.mt-20 { margin-top: 28px !important; }

/* ── Image Gallery ── */
.single-product-slider { position: relative; }

/* Carousel main frame */
#carousel-custom {
  border-radius: var(--r-lg);
  overflow: hidden;
  background: var(--surface);
}

.carousel-outer { position: relative; }

.carousel-inner .item img {
  width: 100%;
  height: 480px;
  object-fit: cover;
  display: block;
  border-radius: var(--r-lg) var(--r-lg) 0 0;
}

/* Carousel controls */
.carousel-control {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 10;
  width: 44px;
  height: 44px;
  background: rgba(14,13,12,.65) !important;
  backdrop-filter: blur(8px);
  border: 1px solid var(--border-2);
  border-radius: 50%;
  display: flex !important;
  align-items: center;
  justify-content: center;
  color: var(--ivory) !important;
  font-size: 16px;
  opacity: 0;
  transition: opacity var(--dur), background var(--dur), border-color var(--dur);
  text-shadow: none;
}
#carousel-custom:hover .carousel-control { opacity: 1; }
.carousel-control.left  { left: 16px; }
.carousel-control.right { right: 16px; }
.carousel-control:hover {
  background: var(--gold) !important;
  border-color: var(--gold);
}

/* Thumbnails strip */
.carousel-indicators.mCustomScrollbar {
  position: static !important;
  display: flex;
  gap: 10px;
  padding: 14px 10px;
  margin: 0;
  overflow-x: auto;
  list-style: none;
  background: var(--surface);
  border-radius: 0 0 var(--r-lg) var(--r-lg);
  border-top: 1px solid var(--border);
  scrollbar-width: none;
  width: auto;
  left: auto;
  bottom: auto;
  justify-content: flex-start;
}
.carousel-indicators.mCustomScrollbar::-webkit-scrollbar { display: none; }
.carousel-indicators.mCustomScrollbar li {
  width: 68px;
  height: 68px;
  min-width: 68px;
  border-radius: 8px;
  overflow: hidden;
  cursor: pointer;
  border: 2px solid transparent;
  transition: border-color var(--dur);
  opacity: .55;
  transition: opacity var(--dur), border-color var(--dur);
  text-indent: 0;
  margin: 0;
}
.carousel-indicators.mCustomScrollbar li.active,
.carousel-indicators.mCustomScrollbar li:hover {
  border-color: var(--gold);
  opacity: 1;
}
.carousel-indicators.mCustomScrollbar li img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* ── Product Details ── */
.single-product-details {
  padding: 8px 0 0 32px;
  animation: slide-up .6s var(--ease) both;
}

@keyframes slide-up {
  from { opacity: 0; transform: translateY(24px); }
  to   { opacity: 1; transform: translateY(0); }
}

.single-product-details h2 {
  font-size: clamp(1.9rem, 3vw, 2.8rem);
  font-weight: 700;
  color: var(--ivory);
  margin-bottom: 14px;
  letter-spacing: -.02em;
}

/* Star rating stub */
.product-rating {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 20px;
}
.stars span {
  color: var(--gold);
  font-size: 14px;
  letter-spacing: 2px;
}
.rating-count {
  font-size: 12px;
  color: var(--ivory-muted);
  letter-spacing: .04em;
}

/* Price */
.product-price {
  font-size: 2rem;
  font-weight: 700;
  color: var(--gold);
  font-family: 'Playfair Display', serif;
  margin-bottom: 20px;
  display: flex;
  align-items: baseline;
  gap: 12px;
}
.price-old {
  font-size: 1.1rem;
  font-weight: 400;
  color: var(--ivory-muted);
  text-decoration: line-through;
  font-family: 'Jost', sans-serif;
}

/* Divider */
.product-divider {
  height: 1px;
  background: var(--border);
  margin: 22px 0;
}

/* Description */
.product-description {
  font-size: 14.5px;
  color: var(--ivory-muted);
  line-height: 1.8;
  margin-bottom: 0;
}

/* Color swatches */
.color-swatches {
  display: flex;
  align-items: center;
  gap: 14px;
  flex-wrap: wrap;
}
.color-swatches > span {
  font-size: 12px;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--ivory-muted);
  min-width: 54px;
}
.color-swatches ul {
  list-style: none;
  display: flex;
  gap: 10px;
  padding: 0;
  margin: 0;
}
.color-swatches ul li a.swatch {
  display: block;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  border: 2px solid transparent;
  box-shadow: 0 0 0 2px transparent;
  transition: box-shadow var(--dur), border-color var(--dur), transform var(--dur) var(--spring);
  cursor: pointer;
}
.color-swatches ul li a.swatch:hover,
.color-swatches ul li a.swatch.active {
  box-shadow: 0 0 0 3px var(--gold);
  transform: scale(1.15);
}

/* Quantity selector */
.quantity-row {
  display: flex;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
}
.qty-label {
  font-size: 12px;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--ivory-muted);
}
.qty-control {
  display: flex;
  align-items: center;
  background: var(--surface);
  border: 1px solid var(--border-2);
  border-radius: var(--r);
  overflow: hidden;
}
.qty-btn {
  width: 40px;
  height: 40px;
  background: none;
  border: none;
  color: var(--ivory);
  font-size: 18px;
  cursor: pointer;
  transition: background var(--dur), color var(--dur);
  display: flex;
  align-items: center;
  justify-content: center;
}
.qty-btn:hover { background: var(--gold); color: #fff; }
.qty-input {
  width: 48px;
  text-align: center;
  background: none;
  border: none;
  color: var(--ivory);
  font-family: 'Jost', sans-serif;
  font-size: 15px;
  font-weight: 600;
  outline: none;
  -moz-appearance: textfield;
}
.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }

/* Categories row */
.product-category {
  display: flex;
  align-items: center;
  gap: 14px;
  flex-wrap: wrap;
}
.product-category > span {
  font-size: 12px;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--ivory-muted);
}
.product-category ul {
  list-style: none;
  display: flex;
  gap: 8px;
  padding: 0;
  margin: 0;
}
.product-category ul li a {
  display: inline-block;
  font-size: 12px;
  font-weight: 500;
  color: var(--ivory-muted);
  background: var(--surface);
  border: 1px solid var(--border-2);
  padding: 5px 14px;
  border-radius: var(--r);
  transition: color var(--dur), border-color var(--dur), background var(--dur);
}
.product-category ul li a:hover {
  color: var(--gold);
  border-color: var(--gold);
  background: var(--gold-glow);
}

/* CTA Buttons */
.btn-cta-row {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  margin-top: 8px;
}

.btn-add-cart {
  flex: 1;
  min-width: 160px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 15px 28px;
  background: linear-gradient(135deg, var(--gold), var(--gold-light));
  color: #fff;
  font-family: 'Jost', sans-serif;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: .14em;
  text-transform: uppercase;
  border: none;
  border-radius: var(--r);
  cursor: pointer;
  transition: transform var(--dur) var(--spring), box-shadow var(--dur), filter var(--dur);
  position: relative;
  overflow: hidden;
}
.btn-add-cart::after {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(255,255,255,0);
  transition: background .2s;
}
.btn-add-cart:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 30px rgba(200,145,58,.4);
  filter: brightness(1.08);
}
.btn-add-cart:active { transform: translateY(0); }
.btn-add-cart svg { flex-shrink: 0; }

.btn-wishlist {
  width: 52px;
  height: 52px;
  background: var(--surface);
  border: 1px solid var(--border-2);
  border-radius: var(--r);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: var(--ivory-muted);
  transition: color var(--dur), border-color var(--dur), background var(--dur), transform var(--dur) var(--spring);
}
.btn-wishlist:hover {
  color: var(--terra);
  border-color: var(--terra);
  background: rgba(184,92,56,.12);
  transform: scale(1.08);
}

/* ── Tabs ── */
.tabCommon { margin-top: 52px; }

.nav-tabs {
  border-bottom: 1px solid var(--border-2);
  display: flex;
  gap: 0;
  padding: 0;
  margin: 0;
  list-style: none;
}

.nav-tabs li a {
  display: block;
  padding: 14px 28px;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--ivory-muted);
  border-bottom: 2px solid transparent;
  transition: color var(--dur), border-color var(--dur);
  position: relative;
  top: 1px;
}
.nav-tabs li.active a,
.nav-tabs li a:hover {
  color: var(--gold);
  border-bottom-color: var(--gold);
}

.tab-content.patternbg {
  background: var(--bg-2);
  border: 1px solid var(--border);
  border-top: none;
  border-radius: 0 0 var(--r-lg) var(--r-lg);
  padding: 36px;
  animation: fade-tab .3s var(--ease) both;
}
@keyframes fade-tab {
  from { opacity: 0; transform: translateY(8px); }
  to   { opacity: 1; transform: translateY(0); }
}

.tab-pane h4 {
  font-size: 1.2rem;
  margin-bottom: 16px;
  color: var(--ivory);
}
.tab-pane p {
  font-size: 14px;
  color: var(--ivory-muted);
  line-height: 1.8;
  margin-bottom: 14px;
}

/* Reviews */
.comments-list { list-style: none; padding: 0; margin: 0; }
.comments-list .media {
  display: flex;
  gap: 18px;
  padding: 24px 0;
  border-bottom: 1px solid var(--border);
  animation: slide-up .4s var(--ease) both;
}
.comments-list .media:last-child { border-bottom: none; }

.comment-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid var(--border-2);
  flex-shrink: 0;
  background: var(--surface-2);
}

.media-body { flex: 1; }

.comment-info {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 10px;
}
.comment-author a {
  font-family: 'Playfair Display', serif;
  font-size: 1rem;
  font-weight: 600;
  color: var(--ivory);
  transition: color .2s;
}
.comment-author a:hover { color: var(--gold); }

.comment-info time {
  font-size: 11px;
  color: var(--ivory-muted);
  letter-spacing: .04em;
}
.comment-button {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--gold);
  transition: color .2s;
}
.comment-button:hover { color: var(--gold-light); }

/* ── Related Products ── */
.related-products {
  padding: 60px 0 80px;
  background: linear-gradient(180deg, var(--bg) 0%, var(--bg-2) 100%);
}

.related-products .title {
  margin-bottom: 40px;
}
.related-products .title h2 {
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  color: var(--ivory);
  display: inline-block;
  position: relative;
}
.related-products .title h2::after {
  content: '';
  display: block;
  height: 2px;
  width: 48px;
  background: var(--gold);
  margin: 12px auto 0;
  border-radius: 2px;
}

/* Related product card */
.product-item {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--r-lg);
  overflow: hidden;
  transition: transform var(--dur) var(--ease), box-shadow var(--dur), border-color var(--dur);
  margin-bottom: 28px;
}
.product-item:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 48px rgba(0,0,0,.4);
  border-color: var(--border-2);
}

.product-thumb {
  position: relative;
  overflow: hidden;
  aspect-ratio: 3/4;
}
.product-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform .65s var(--ease);
}
.product-item:hover .product-thumb img { transform: scale(1.08); }

/* Related preview meta */
.preview-meta {
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom, transparent 30%, rgba(14,13,12,.7) 100%);
  display: flex;
  align-items: flex-end;
  justify-content: center;
  padding-bottom: 18px;
  opacity: 0;
  transition: opacity var(--dur);
}
.product-item:hover .preview-meta { opacity: 1; }
.preview-meta ul {
  list-style: none;
  display: flex;
  gap: 8px;
  padding: 0; margin: 0;
}
.preview-meta ul li {
  width: 40px;
  height: 40px;
  background: rgba(244,239,230,.1);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(244,239,230,.18);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: var(--ivory);
  font-size: 16px;
  transition: background var(--dur), border-color var(--dur), transform var(--dur) var(--spring);
  transform: translateY(10px);
}
.product-item:hover .preview-meta ul li { transform: translateY(0); }
.preview-meta ul li:nth-child(1){transition-delay:.0s}
.preview-meta ul li:nth-child(2){transition-delay:.06s}
.preview-meta ul li:nth-child(3){transition-delay:.12s}
.preview-meta ul li:hover { background: var(--gold); border-color: var(--gold); }
.preview-meta ul li a { color: var(--ivory); display:flex;align-items:center;justify-content:center;width:100%;height:100%; }

/* Quick add bar */
.quick-add-rel {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  background: var(--gold);
  color: #fff;
  text-align: center;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .14em;
  text-transform: uppercase;
  padding: 12px;
  transform: translateY(100%);
  transition: transform .3s var(--ease);
  z-index: 4;
  display: block;
}
.product-item:hover .quick-add-rel { transform: translateY(0); }

.product-content {
  padding: 16px 16px 18px;
  border-top: 1px solid var(--border);
}
.product-content h4 {
  font-family: 'Playfair Display', serif;
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 6px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.product-content h4 a { color: var(--ivory); transition: color .2s; }
.product-content h4 a:hover { color: var(--gold); }
.product-content .price { color: var(--gold); font-weight: 600; font-size: .95rem; }

/* ── Modal ── */
.product-modal .modal-dialog { max-width: 900px; }
.product-modal .modal-content {
  background: var(--surface);
  border: 1px solid var(--border-2);
  border-radius: var(--r-lg);
  overflow: hidden;
  box-shadow: 0 40px 100px rgba(0,0,0,.7);
}
.product-modal .modal-body { padding: 0; }
.product-modal .close {
  position: absolute; top: 16px; right: 16px; z-index: 20;
  width: 38px; height: 38px;
  background: var(--surface-2);
  border: 1px solid var(--border-2);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; color: var(--ivory); font-size: 16px;
  opacity: 1; text-shadow: none;
  transition: background var(--dur), border-color var(--dur);
  padding: 0;
}
.product-modal .close:hover { background: var(--gold); border-color: var(--gold); color:#fff; }

#loading-overlay {
  position: absolute; inset: 0;
  background: rgba(14,13,12,.8);
  backdrop-filter: blur(4px);
  display: flex; align-items: center; justify-content: center;
  z-index: 15; border-radius: var(--r-lg);
}
.loader-dots { display:flex; gap:9px; }
.loader-dots span {
  width: 9px; height: 9px;
  background: var(--gold); border-radius: 50%;
  animation: dp 1.1s ease-in-out infinite;
}
.loader-dots span:nth-child(2){animation-delay:.18s}
.loader-dots span:nth-child(3){animation-delay:.36s}
@keyframes dp {
  0%,80%,100%{transform:scale(.55);opacity:.4}
  40%{transform:scale(1);opacity:1}
}

.modal-image img {
  width: 100%; height: 100%; min-height: 480px; object-fit: cover;
}
.product-short-details {
  padding: 48px 36px;
  display: flex; flex-direction: column; justify-content: center;
  height: 100%;
}
.product-title {
  font-size: 1.8rem; font-family:'Playfair Display',serif;
  color: var(--ivory); margin-bottom: 10px;
}
.product-short-details .product-price {
  font-size: 1.5rem; color: var(--gold); margin-bottom: 16px;
}
.product-short-description {
  font-size: 13.5px; color: var(--ivory-muted); line-height: 1.75;
  margin-bottom: 28px; padding-top: 18px;
  border-top: 1px solid var(--border);
}
.btn-main {
  display: block; width: 100%; padding: 14px;
  background: linear-gradient(135deg, var(--gold), var(--gold-light));
  color: #fff !important; border: none; border-radius: var(--r);
  font-size: 13px; font-weight: 700; letter-spacing: .12em;
  text-transform: uppercase; text-align: center; margin-bottom: 10px;
  transition: transform var(--dur) var(--spring), box-shadow var(--dur);
  cursor: pointer;
}
.btn-main:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(200,145,58,.4); }
.btn-transparent {
  display: block; width: 100%; padding: 13px;
  background: transparent; color: var(--ivory) !important;
  border: 1px solid var(--border-2); border-radius: var(--r);
  font-size: 13px; font-weight: 600; letter-spacing: .1em;
  text-transform: uppercase; text-align: center;
  transition: border-color var(--dur), background var(--dur);
}
.btn-transparent:hover { border-color: var(--gold); background: var(--gold-glow); }

/* ── Responsive ── */
@media(max-width: 991px) {
  .single-product-details { padding: 32px 0 0; }
  .carousel-inner .item img { height: 360px; }
  .product-modal .modal-dialog { max-width: 95%; }
}
@media(max-width: 767px) {
  .product-pagination { display: none; }
  .carousel-inner .item img { height: 280px; }
  .btn-cta-row { flex-direction: column; }
  .btn-add-cart { min-width: 100%; }
  .product-short-details { padding: 28px 20px; }
}
</style>
@endsection


@section('contents')

{{-- ── PAGE LOADER ── --}}
<div id="global-loading">
  <div class="loader-track"><div class="loader-fill"></div></div>
</div>

{{-- ══════════════════════════════════════════════ --}}
{{--   SINGLE PRODUCT                              --}}
{{-- ══════════════════════════════════════════════ --}}
<section class="single-product">
  <div class="container">

    {{-- Breadcrumb + Pagination row --}}
    <div class="row align-items-start">
      <div class="col-md-6">
        <ol class="breadcrumb">
          <li><a href="{{ route('home.index') }}">Home</a></li>
          <li><a href="#">Shop</a></li>
          <li class="active">{{ Str::limit($product->name, 28) }}</li>
        </ol>
      </div>
      <div class="col-md-6">
        <ol class="product-pagination">
          <li>
            <a href="#">
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
              Prev
            </a>
          </li>
          <li>
            <a href="#">
              Next
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            </a>
          </li>
        </ol>
      </div>
    </div>

    {{-- Main product row --}}
    <div class="row mt-20">

      {{-- ── LEFT: Image Gallery ── --}}
      <div class="col-md-5">
        <div class="single-product-slider">
          <div id='carousel-custom' class='carousel slide' data-ride='carousel'>
            <div class='carousel-outer'>
              <div class='carousel-inner'>
                @foreach($images as $key => $image)
                  <div class='item {{ $key == 0 ? "active" : "" }}'>
                    <img src="{{ asset('uploads/product/'.$image->image) }}"
                         alt='Product Image'/>
                  </div>
                @endforeach
              </div>
              <a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
              </a>
              <a class='right carousel-control' href='#carousel-custom' data-slide='next'>
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
              </a>
            </div>
            {{-- Thumbnails --}}
            <ol class='carousel-indicators mCustomScrollbar meartlab'>
              @foreach($images as $key => $image)
                <li data-target='#carousel-custom' data-slide-to='{{ $key }}'
                    class='{{ $key == 0 ? "active" : "" }}'>
                  <img src="{{ asset('uploads/product/'.$image->image) }}" alt='Thumb'/>
                </li>
              @endforeach
            </ol>
          </div>
        </div>
      </div>

      {{-- ── RIGHT: Details ── --}}
      <div class="col-md-7">
        <div class="single-product-details">

          {{-- Rating (static display) --}}
          <div class="product-rating">
            <div class="stars"><span>★★★★☆</span></div>
            <span class="rating-count">(24 reviews)</span>
          </div>

          <h2>{{ $product->name }}</h2>

          {{-- Price --}}
          <p class="product-price">
            ${{ number_format($product->price, 2) }}
            @if(isset($product->original_price) && $product->original_price > $product->price)
              <span class="price-old">${{ number_format($product->original_price, 2) }}</span>
            @endif
          </p>

          <div class="product-divider"></div>

          <p class="product-description">
            {{ Str::limit($product->desc, 400) }}
          </p>

          <div class="product-divider"></div>

          {{-- Color swatches --}}
          <div class="color-swatches mb-4">
            <span>Color:</span>
            <ul>
              @foreach($colors as $color)
                <li>
                  <a href="#!" style="background-color:{{ $color->color_code }};"
                     class="swatch"
                     title="{{ $color->name ?? $color->color_code }}"></a>
                </li>
              @endforeach
            </ul>
          </div>

          {{-- Quantity --}}
          <div class="quantity-row mb-4">
            <span class="qty-label">Qty:</span>
            <div class="qty-control">
              <button class="qty-btn" id="qty-minus">−</button>
              <input class="qty-input" type="number" id="qty-value" value="1" min="1"/>
              <button class="qty-btn" id="qty-plus">+</button>
            </div>
          </div>

          {{-- Categories --}}
          <div class="product-category mb-4">
            <span>Tags:</span>
            <ul>
              <li><a href="#">{{ $category->name }}</a></li>
              <li><a href="#">{{ $brand->name }}</a></li>
            </ul>
          </div>

          {{-- CTA --}}
          <div class="btn-cta-row">
            @auth
              <a href="{{ route('cart.add', $product->id) }}" class="btn-add-cart">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                  <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                Add to Cart
              </a>
            @else
              <a href="{{ route('customer.login') }}" class="btn-add-cart">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                  <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                Login to Buy
              </a>
            @endauth
            <button class="btn-wishlist" title="Add to Wishlist">
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
              </svg>
            </button>
          </div>

        </div>
      </div>
    </div>{{-- /.row product --}}

    {{-- ── TABS ── --}}
    <div class="row">
      <div class="col-xs-12 col-12">
        <div class="tabCommon mt-20">
          <ul class="nav nav-tabs" id="product-tabs">
            <li class="active"><a data-toggle="tab" href="#details">Details</a></li>
            <li><a data-toggle="tab" href="#reviews">Reviews <span style="color:var(--gold)">(3)</span></a></li>
          </ul>
          <div class="tab-content patternbg">

            {{-- Details tab --}}
            <div id="details" class="tab-pane fade active in">
              <h4>Product Description</h4>
              <p>{{ $product->desc }}</p>
             



          </div>
        </div>
      </div>
    </div>

  </div>
</section>


{{-- ══════════════════════════════════════════════ --}}
{{--   RELATED PRODUCTS                            --}}
{{-- ══════════════════════════════════════════════ --}}
<section class="products related-products section">
  <div class="container">

    <div class="row">
      <div class="col-12">
        <div class="title text-center">
          <h2>Related Products</h2>
        </div>
      </div>
    </div>

    <div class="row">
      @if($related_products->isNotEmpty())
        @foreach($related_products as $related)
          @php
            $img = $related->images->first();
            $imageUrl = $img
              ? asset('uploads/product/'.$img->image)
              : asset('front-end/assets/images/shop/products/product-1.jpg');
          @endphp
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="product-item">
              <div class="product-thumb">
                <img src="{{ $imageUrl }}" alt="{{ $related->name }}"/>
                <div class="preview-meta">
                  <ul>
                    <li onclick="viewProduct({{ $related->id }})"
                        data-toggle="modal" data-target="#product-modal">
                      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    </li>
                    <li><a href="#"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></a></li>
                    <li><a href="#"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></a></li>
                  </ul>
                </div>
                <a href="{{ route('cart.add', $related->id) }}" class="quick-add-rel">Add to Cart</a>
              </div>
              <div class="product-content">
                <h4><a href="{{ route('product.single', ['id'=>$related->id]) }}">{{ $related->name }}</a></h4>
                <p class="price">${{ number_format($related->price, 2) }}</p>
              </div>
            </div>
          </div>
        @endforeach
      @endif
    </div>

  </div>
</section>


{{-- ── QUICK VIEW MODAL ── --}}
<div class="modal product-modal fade" id="product-modal" tabindex="-1" role="dialog">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
      <path d="M18 6 6 18M6 6l12 12"/>
    </svg>
  </button>
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div id="loading-overlay" style="display:none;">
        <div class="loader-dots"><span></span><span></span><span></span></div>
      </div>
      <div class="modal-body view-product"></div>
    </div>
  </div>
</div>

@endsection


@section('script')
<script>
$(function () {

  /* ── Page Loader ── */
  $(window).on('load', function () {
    $('#global-loading').addClass('out');
    setTimeout(function () { $('#global-loading').hide(); }, 550);
  });
  setTimeout(function () {
    if ($('#global-loading').is(':visible')) {
      $('#global-loading').addClass('out');
      setTimeout(function () { $('#global-loading').hide(); }, 550);
    }
  }, 2500);

  $(document).ajaxStart(function () { $('#loading-overlay').fadeIn(150); });
  $(document).ajaxStop(function ()  { $('#loading-overlay').fadeOut(250); });

  /* ── Quantity controls ── */
  $('#qty-plus').on('click', function () {
    var v = parseInt($('#qty-value').val()) || 1;
    $('#qty-value').val(v + 1);
  });
  $('#qty-minus').on('click', function () {
    var v = parseInt($('#qty-value').val()) || 1;
    if (v > 1) $('#qty-value').val(v - 1);
  });

  /* ── Color swatch select ── */
  $('.swatch').on('click', function (e) {
    e.preventDefault();
    $('.swatch').removeClass('active');
    $(this).addClass('active');
  });

  /* ── Tab animation on switch ── */
  $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
    $('.tab-pane.active').css({ animation: 'none' });
    setTimeout(function () {
      $('.tab-pane.active').css({ animation: '' });
    }, 10);
  });

  /* ── Reset modal on close ── */
  $('#product-modal').on('hidden.bs.modal', function () {
    $('.view-product').empty();
  });

  /* ── Stagger related cards on scroll ── */
  var cards = document.querySelectorAll('.related-products .product-item');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry, i) {
        if (entry.isIntersecting) {
          entry.target.style.animation =
            'slide-up .5s cubic-bezier(.4,0,.2,1) ' + (i * 0.08) + 's both';
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });
    cards.forEach(function (c) {
      c.style.opacity = '0';
      io.observe(c);
    });
  }

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
      if (response.status === 200) {
        const p   = response.product;
        const img = p.images.length
          ? '/uploads/product/' + p.images[0].image
          : '{{ asset("front-end/assets/images/shop/products/product-1.jpg") }}';

        const desc = p.desc
          ? p.desc.substring(0, 200) + (p.desc.length > 200 ? '...' : '')
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
    complete: function () { $('#loading-overlay').fadeOut(200); },
    error   : function () {
      $('.view-product').html(
        '<p style="padding:60px;text-align:center;color:var(--ivory-muted)">Could not load product.</p>'
      );
    }
  });
}
</script>
@endsection