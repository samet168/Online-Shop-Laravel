@extends('front-end.components.master')

@section('style')
<style>
/* ══════════════════════════════════════════════
   CHECKOUT PAGE — Dark Luxury
   Fonts: Fraunces + DM Sans
   Palette: #090807 · Ivory · Amber Gold
══════════════════════════════════════════════ */
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=DM+Sans:wght@300;400;500;600&display=swap');

:root {
  /* --bg:         #090807; */
  /* --bg-2:       #0f0e0d; */
  --surface:    #757575;
  --surface-2:  #a3a3a3;
  --surface-3:  #6c6c6c;
  --ivory:      #080808;
  --ivory-soft: #c8c1b6;
  --ivory-mute: #000000;
  --gold:       #c8903a;
  --gold-lt:    #dea84f;
  --gold-glow:  rgba(200,144,58,.13);
  --gold-border:rgba(200,144,58,.3);
  --green:      #3a7a55;
  --rouge:      #b84c3a;
  --border:     rgba(243,237,227,.06);
  --border-2:   rgba(243,237,227,.11);
  --border-3:   rgba(243,237,227,.2);
  --r:          10px;
  --r-lg:       16px;
  --ease:       cubic-bezier(.4,0,.2,1);
  --spring:     cubic-bezier(.34,1.56,.64,1);
  --dur:        .3s;
}

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--ivory);font-size:15px;line-height:1.65}
h1,h2,h3,h4{font-family:'Fraunces',serif}
a{text-decoration:none;color:inherit}
img{display:block;max-width:100%}

/* ── Page Header ───────────────────────────── */
.page-header{
  padding:56px 0 44px;
  background:var(--bg-2);
  border-bottom:1px solid var(--border);
  position:relative;
  overflow:hidden;
}
.page-header::before{
  content:'';position:absolute;inset:0;
  background-image:radial-gradient(circle,rgba(200,144,58,.07) 1px,transparent 1px);
  background-size:30px 30px;pointer-events:none;
}
.page-header::after{
  content:'';position:absolute;bottom:0;left:0;
  width:260px;height:2px;
  background:linear-gradient(90deg,var(--gold),transparent);
}
.page-header .container{position:relative;z-index:2}

.page-name{
  font-size:clamp(2.2rem,5vw,3.8rem);font-weight:700;
  color:var(--ivory);letter-spacing:-.03em;margin-bottom:12px;
}
.breadcrumb{
  background:transparent;padding:0;margin:0;
  list-style:none;display:flex;gap:6px;flex-wrap:wrap;
}
.breadcrumb li{font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--ivory-mute)}
.breadcrumb li a{color:var(--gold);transition:color .2s}
.breadcrumb li a:hover{color:var(--ivory)}
.breadcrumb li+li::before{content:'/';margin-right:6px;color:var(--border-2)}
.breadcrumb li.active{color:var(--ivory-mute)}

/* ── Page Wrapper ──────────────────────────── */
.page-wrapper{padding:56px 0 100px;background:var(--bg)}

/* ── Step indicators ───────────────────────── */
.checkout-steps{
  display:flex;align-items:center;justify-content:center;
  gap:0;margin-bottom:48px;
}
.step{
  display:flex;flex-direction:column;align-items:center;
  gap:8px;flex:1;max-width:160px;
  position:relative;
}
.step:not(:last-child)::after{
  content:'';
  position:absolute;top:18px;left:calc(50% + 18px);
  width:calc(100% - 36px);height:2px;
  background:var(--border-2);
  z-index:0;
}
.step.done:not(:last-child)::after{background:var(--gold)}
.step-circle{
  width:36px;height:36px;border-radius:50%;
  border:2px solid var(--border-2);
  background:var(--surface-2);
  display:flex;align-items:center;justify-content:center;
  font-size:12px;font-weight:700;color:var(--ivory-mute);
  position:relative;z-index:1;
  transition:border-color var(--dur),background var(--dur),color var(--dur);
}
.step.active .step-circle{border-color:var(--gold);background:var(--gold);color:#fff}
.step.done .step-circle{border-color:var(--gold);background:transparent;color:var(--gold)}
.step-label{font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--ivory-mute)}
.step.active .step-label{color:var(--gold)}
.step.done .step-label{color:var(--ivory-soft)}

/* ── Block (card) ──────────────────────────── */
.block{
  background:var(--surface);
  border:1px solid var(--border-2);
  border-radius:var(--r-lg);
  padding:32px;
  margin-bottom:24px;
  animation:fade-up .45s var(--ease) both;
}
.block:nth-child(2){animation-delay:.1s}
@keyframes fade-up{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}

/* Block title */
.widget-title{
  font-size:1.25rem;font-weight:700;color:var(--ivory);
  margin-bottom:24px;padding-bottom:16px;
  border-bottom:1px solid var(--border-2);
  display:flex;align-items:center;gap:10px;
}
.widget-title-icon{
  width:32px;height:32px;border-radius:8px;
  background:var(--gold-glow);border:1px solid var(--gold-border);
  display:flex;align-items:center;justify-content:center;
  color:var(--gold);flex-shrink:0;
}

/* ── Form fields ───────────────────────────── */
.form-group{margin-bottom:20px}
.form-group label{
  display:block;font-size:11px;font-weight:700;
  letter-spacing:.1em;text-transform:uppercase;
  color:var(--ivory-mute);margin-bottom:8px;
}
.form-group label .required{color:var(--gold)}

.form-control{
  width:100%;
  background:var(--surface-2);
  border:1px solid var(--border-2);
  color:var(--ivory);
  font-family:'DM Sans',sans-serif;
  font-size:14px;
  padding:13px 16px;
  border-radius:var(--r);
  outline:none;
  transition:border-color var(--dur),box-shadow var(--dur),background var(--dur);
  height:auto;
  box-shadow:none;
}
.form-control::placeholder{color:var(--ivory-mute)}
.form-control:focus{
  border-color:var(--gold);
  background:var(--surface-3);
  box-shadow:0 0 0 3px var(--gold-glow);
}

/* Row of two fields */
.checkout-country-code{
  display:grid;grid-template-columns:1fr 1fr;gap:16px;
}
@media(max-width:575px){.checkout-country-code{grid-template-columns:1fr}}

/* ── Payment section ───────────────────────── */
.payment-subtitle{
  font-size:12px;color:var(--ivory-mute);
  letter-spacing:.04em;margin-bottom:24px;
  display:flex;align-items:center;gap:8px;
}
.payment-subtitle svg{color:var(--green)}

/* Card brand icons row */
.card-brands{
  display:flex;gap:8px;align-items:center;margin-bottom:24px;
}
.card-brand{
  height:28px;padding:4px 10px;
  background:var(--surface-2);border:1px solid var(--border-2);
  border-radius:6px;display:flex;align-items:center;
  font-size:10px;font-weight:700;letter-spacing:.06em;
  color:var(--ivory-mute);
}
.card-brand.visa{color:#1a6ed8}
.card-brand.mc{color:#eb5c28}
.card-brand.amex{color:#2e77bc}

/* Card number with icon */
.card-input-wrap{position:relative}
.card-input-wrap .card-icon{
  position:absolute;right:14px;top:50%;transform:translateY(-50%);
  color:var(--ivory-mute);pointer-events:none;
}
.card-input-wrap .form-control{padding-right:46px}

/* Half-width fields */
.half-fields{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media(max-width:575px){.half-fields{grid-template-columns:1fr}}

/* ── Place order button ─────────────────────── */
.btn-place-order{
  display:flex;align-items:center;justify-content:center;gap:12px;
  width:100%;padding:16px;
  background:linear-gradient(135deg,var(--gold),var(--gold-lt));
  color:#fff;border:none;border-radius:var(--r);
  font-family:'DM Sans',sans-serif;
  font-size:14px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;
  cursor:pointer;
  transition:transform var(--dur) var(--spring),box-shadow var(--dur),filter var(--dur);
  margin-top:28px;
}
.btn-place-order:hover{
  transform:translateY(-3px);
  box-shadow:0 10px 32px rgba(200,144,58,.4);
  filter:brightness(1.07);
  color:#fff;
}
.btn-place-order:active{transform:translateY(0)}

/* Security note */
.security-note{
  display:flex;align-items:center;justify-content:center;
  gap:6px;font-size:11px;color:var(--ivory-mute);
  letter-spacing:.04em;margin-top:12px;text-align:center;
}
.security-note svg{color:var(--green)}

/* ── Order Summary sidebar ─────────────────── */
.product-checkout-details .block{padding:24px}

.order-item{
  display:flex;align-items:center;gap:14px;
  padding:14px 0;border-bottom:1px solid var(--border);
}
.order-item:last-of-type{border-bottom:none}
.order-item-img{
  width:62px;height:62px;
  object-fit:cover;
  border-radius:var(--r);
  border:1px solid var(--border-2);
  flex-shrink:0;
}
.order-item-info{flex:1;min-width:0}
.order-item-name{
  font-family:'Fraunces',serif;
  font-size:.95rem;font-weight:600;
  color:var(--ivory);margin-bottom:4px;
  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
}
.order-item-qty{font-size:12px;color:var(--ivory-mute);margin-bottom:6px}
.order-item-price{font-size:.9rem;font-weight:700;color:var(--gold)}
.order-item-remove{
  display:inline-flex;align-items:center;gap:4px;
  font-size:11px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;
  color:var(--ivory-mute);
  padding:5px 10px;border:1px solid var(--border);border-radius:var(--r);
  transition:color var(--dur),border-color var(--dur),background var(--dur);
  flex-shrink:0;
}
.order-item-remove:hover{color:#f87171;border-color:rgba(184,76,58,.4);background:rgba(184,76,58,.08)}

/* Summary price list */
.summary-prices{
  list-style:none;padding:20px 0 0;margin:0;
  border-top:1px solid var(--border-2);
}
.summary-prices li{
  display:flex;justify-content:space-between;align-items:center;
  padding:8px 0;font-size:13px;color:var(--ivory-mute);
}
.summary-prices li .price{color:var(--ivory-soft);font-weight:600}
.summary-prices li .free{color:var(--green);font-weight:600}

/* Summary total */
.summary-total{
  display:flex;justify-content:space-between;align-items:center;
  padding:18px 0 0;margin-top:6px;
  border-top:1px solid var(--border-3);
}
.summary-total span:first-child{
  font-family:'Fraunces',serif;font-size:1.05rem;font-weight:600;color:var(--ivory)
}
.summary-total span:last-child{
  font-family:'Fraunces',serif;font-size:1.5rem;font-weight:700;color:var(--gold)
}

/* Trust badges row */
.trust-badges{
  display:flex;gap:10px;flex-wrap:wrap;
  padding-top:20px;margin-top:4px;
  border-top:1px solid var(--border);
}
.trust-badge{
  flex:1;min-width:70px;
  display:flex;flex-direction:column;align-items:center;gap:5px;
  padding:10px 6px;
  background:var(--surface-2);border:1px solid var(--border);border-radius:var(--r);
  text-align:center;
}
.trust-badge svg{color:var(--gold);opacity:.8}
.trust-badge span{font-size:9px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--ivory-mute);line-height:1.3}

/* ── Responsive ─────────────────────────────── */
@media(max-width:991px){
  .checkout-steps{display:none}
  .block{padding:22px}
}
@media(max-width:767px){
  .product-checkout-details{margin-top:8px}
}
</style>
@endsection


@section('contents')

{{-- ── PAGE HEADER ── --}}
<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Checkout</h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('home.index') }}">Home</a></li>
            <li class="active">Checkout</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>


{{-- ── CHECKOUT BODY ── --}}
<div class="page-wrapper">
  <div class="checkout shopping">
    <div class="container">

      {{-- Step indicators --}}
      <div class="checkout-steps">
        <div class="step done">
          <div class="step-circle">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <span class="step-label">Cart</span>
        </div>
        <div class="step active">
          <div class="step-circle">2</div>
          <span class="step-label">Details</span>
        </div>
        <div class="step">
          <div class="step-circle">3</div>
          <span class="step-label">Payment</span>
        </div>
        <div class="step">
          <div class="step-circle">4</div>
          <span class="step-label">Confirm</span>
        </div>
      </div>

      <div class="row">

        {{-- ── LEFT: Forms ── --}}
        <div class="col-md-8">

          {{-- Billing Details --}}
          <div class="block billing-details">
            <h4 class="widget-title">
              <span class="widget-title-icon">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                  <circle cx="12" cy="10" r="3"/>
                </svg>
              </span>
              Billing Details
            </h4>

            <form class="checkout-form" id="billing-form">
              <div class="form-group">
                <label for="full_name">Full Name <span class="required">*</span></label>
                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="John Doe" required/>
              </div>

              <div class="form-group">
                <label for="user_address">Address <span class="required">*</span></label>
                <input type="text" class="form-control" id="user_address" name="address" placeholder="123 Main Street" required/>
              </div>

              <div class="checkout-country-code">
                <div class="form-group">
                  <label for="user_post_code">Zip / Postal Code <span class="required">*</span></label>
                  <input type="text" class="form-control" id="user_post_code" name="zipcode" placeholder="10001" required/>
                </div>
                <div class="form-group">
                  <label for="user_city">City <span class="required">*</span></label>
                  <input type="text" class="form-control" id="user_city" name="city" placeholder="New York" required/>
                </div>
              </div>

              <div class="form-group">
                <label for="user_country">Country <span class="required">*</span></label>
                <input type="text" class="form-control" id="user_country" name="country" placeholder="United States" required/>
              </div>
            </form>
          </div>

          {{-- Payment --}}
          <div class="block">
            <h4 class="widget-title">
              <span class="widget-title-icon">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                  <line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
              </span>
              Payment Method
            </h4>

            <p class="payment-subtitle">
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
              </svg>
              Secure SSL encrypted payment
            </p>

            <div class="card-brands">
              <span class="card-brand visa">VISA</span>
              <span class="card-brand mc">MC</span>
              <span class="card-brand amex">AMEX</span>
            </div>

            <form class="checkout-form" id="payment-form">
              <div class="form-group">
                <label for="card-number">Card Number <span class="required">*</span></label>
                <div class="card-input-wrap">
                  <input id="card-number" class="form-control" type="tel"
                         placeholder="•••• •••• •••• ••••"
                         maxlength="19" autocomplete="cc-number"/>
                  <span class="card-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                      <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                      <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                  </span>
                </div>
              </div>

              <div class="half-fields">
                <div class="form-group">
                  <label for="card-expiry">Expiry Date <span class="required">*</span></label>
                  <input id="card-expiry" class="form-control" type="tel"
                         placeholder="MM / YY" maxlength="7" autocomplete="cc-exp"/>
                </div>
                <div class="form-group">
                  <label for="card-cvc">CVC Code <span class="required">*</span></label>
                  <input id="card-cvc" class="form-control" type="tel"
                         placeholder="•••" maxlength="4" autocomplete="cc-csc"/>
                </div>
              </div>

              <a href="{{ Route::has('checkout.confirmation') ? route('checkout.confirmation') : '#' }}" class="btn-place-order" id="place-order-btn">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                  <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                Place Order
              </a>

              <p class="security-note">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Your payment information is encrypted and secure
              </p>
            </form>
          </div>

        </div>

        {{-- ── RIGHT: Order Summary ── --}}
        <div class="col-md-4">
          <div class="product-checkout-details">
            <div class="block">
              <h4 class="widget-title">
                <span class="widget-title-icon">
                  <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                  </svg>
                </span>
                Order Summary
                <span style="margin-left:auto;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--ivory-mute);font-weight:400">
                  {{ count($items) }} item{{ count($items) != 1 ? 's' : '' }}
                </span>
              </h4>

              {{-- Items --}}
              @foreach($items as $item)
                @php $image = $item->attributes->image; @endphp
                <div class="order-item">
                  <img class="order-item-img"
                       src="{{ asset('uploads/product/'.$image) }}"
                       alt="{{ $item->name }}"/>
                  <div class="order-item-info">
                    <div class="order-item-name">{{ $item->name }}</div>
                    <div class="order-item-qty">Qty: {{ $item->quantity }}</div>
                    <div class="order-item-price">${{ number_format($item->price * $item->quantity, 2) }}</div>
                  </div>
                  <a class="order-item-remove" href="{{ route('cart.remove', $item->id) }}"
                     onclick="return confirm('Remove this item?')">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                      <path d="M18 6 6 18M6 6l12 12"/>
                    </svg>
                  </a>
                </div>
              @endforeach

              {{-- Prices --}}
              <ul class="summary-prices">
                <li>
                  <span>Subtotal</span>
                  <span class="price">${{ number_format($subtotal, 2) }}</span>
                </li>
                <li>
                  <span>Shipping</span>
                  <span class="free">Free</span>
                </li>
                <li>
                  <span>Tax</span>
                  <span class="price">—</span>
                </li>
              </ul>

              <div class="summary-total">
                <span>Total</span>
                <span>${{ number_format($total, 2) }}</span>
              </div>

              {{-- Trust badges --}}
              <div class="trust-badges">
                <div class="trust-badge">
                  <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                  </svg>
                  <span>SSL Secure</span>
                </div>
                <div class="trust-badge">
                  <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                  </svg>
                  <span>Protected</span>
                </div>
                <div class="trust-badge">
                  <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>
                  </svg>
                  <span>Free Returns</span>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>{{-- /.row --}}
    </div>
  </div>
</div>

@endsection


@section('script')
<script>
$(function () {

  /* ── Card number formatting ── */
  $('#card-number').on('input', function () {
    let v = $(this).val().replace(/\D/g, '').substring(0, 16);
    v = v.replace(/(.{4})/g, '$1 ').trim();
    $(this).val(v);
  });

  /* ── Expiry formatting ── */
  $('#card-expiry').on('input', function () {
    let v = $(this).val().replace(/\D/g, '').substring(0, 4);
    if (v.length >= 3) v = v.substring(0, 2) + ' / ' + v.substring(2);
    $(this).val(v);
  });

  /* ── CVC: numbers only ── */
  $('#card-cvc').on('input', function () {
    $(this).val($(this).val().replace(/\D/g, '').substring(0, 4));
  });

  /* ── Place order: basic validation ── */
  $('#place-order-btn').on('click', function (e) {
    const name    = $('#full_name').val().trim();
    const address = $('#user_address').val().trim();
    const zip     = $('#user_post_code').val().trim();
    const city    = $('#user_city').val().trim();
    const country = $('#user_country').val().trim();
    const card    = $('#card-number').val().trim();
    const expiry  = $('#card-expiry').val().trim();
    const cvc     = $('#card-cvc').val().trim();

    if (!name || !address || !zip || !city || !country) {
      e.preventDefault();
      showFieldError('Please fill in all billing details.');
      return;
    }
    if (card.replace(/\s/g,'').length < 16 || !expiry || cvc.length < 3) {
      e.preventDefault();
      showFieldError('Please enter valid card details.');
    }
  });

  function showFieldError(msg) {
    let $err = $('#checkout-error');
    if (!$err.length) {
      $err = $('<div id="checkout-error"></div>').css({
        background:'rgba(184,76,58,.14)',
        border:'1px solid rgba(184,76,58,.4)',
        color:'#f87171',
        borderRadius:'10px',
        padding:'13px 18px',
        marginBottom:'16px',
        fontSize:'13px',
        display:'flex',
        alignItems:'center',
        gap:'8px',
        animation:'none'
      });
      $('.billing-details').before($err);
    }
    $err.html('<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg><span>' + msg + '</span>');
    $err.hide().fadeIn(250);
    $('html,body').animate({ scrollTop: $err.offset().top - 80 }, 300);
  }

  /* ── Focus ring animation on inputs ── */
  $('.form-control').on('focus', function () {
    $(this).closest('.form-group').find('label').css('color', 'var(--gold)');
  }).on('blur', function () {
    $(this).closest('.form-group').find('label').css('color', '');
  });

});
</script>
@endsection