@extends('front-end.components.master')

@section('style')
<style>
/* ══════════════════════════════════════════════
   CART PAGE — Dark Minimal, No Background Image
   Fonts: Fraunces + DM Sans
   Palette: Deep black · Ivory · Amber gold
══════════════════════════════════════════════ */
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=DM+Sans:wght@300;400;500;600&display=swap');

:root {
  --bg:          #ffffff;
  /* --bg-2:        #6a6666; */
  --surface:     #c2baba;
  --surface-2:   #504f4ed7;
  --surface-3:   #827f7fa3;
  --ivory:       #2e2d2c;
  --ivory-soft:  #1e1d1c;
  --ivory-muted: #8a8178;
  --gold:        #c8903a;
  --gold-light:  #dea84f;
  --gold-glow:   rgba(200,144,58,.14);
  --rouge:       #b84c3a;
  --green:       #3d7a54;
  --border:      rgba(243,237,227,.06);
  --border-2:    rgba(243,237,227,.12);
  --border-3:    rgba(243,237,227,.20);
  --r:           10px;
  --r-lg:        16px;
  --ease:        cubic-bezier(.4,0,.2,1);
  --spring:      cubic-bezier(.34,1.56,.64,1);
  --dur:         .3s;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'DM Sans', sans-serif;
  /* background: var(--bg); */
  color: var(--ivory);
  font-size: 15px;
  line-height: 1.65;
}
h1,h2,h3,h4 { font-family: 'Fraunces', serif; }
a { text-decoration: none; color: inherit; }
img { display: block; max-width: 100%; }

/* ── Page Header ── */
.page-header {
  padding: 60px 0 48px;
  background: var(--bg-2);
  border-bottom: 1px solid var(--border);
  position: relative;
  overflow: hidden;
}
/* Subtle dot-grid texture */
.page-header::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle, rgba(200,144,58,.08) 1px, transparent 1px);
  background-size: 28px 28px;
  pointer-events: none;
}
/* Gold corner accent */
.page-header::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0;
  width: 220px;
  height: 2px;
  background: linear-gradient(90deg, var(--gold), transparent);
}
.page-header .container { position: relative; z-index: 2; }

.page-name {
  font-size: clamp(2.4rem, 5vw, 4rem);
  font-weight: 700;
  color: var(--ivory);
  letter-spacing: -.03em;
  margin-bottom: 14px;
}

.breadcrumb {
  background: transparent;
  padding: 0; margin: 0;
  list-style: none;
  display: flex; gap: 6px; flex-wrap: wrap;
}
.breadcrumb li {
  font-size: 11px;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--ivory-muted);
}
.breadcrumb li a { color: var(--gold); transition: color .2s; }
.breadcrumb li a:hover { color: var(--ivory); }
.breadcrumb li + li::before { content: '/'; margin-right: 6px; color: var(--border-2); }
.breadcrumb li.active { color: var(--ivory-muted); }

/* ── Page Wrapper ── */
.page-wrapper {
  padding: 64px 0 100px;
  background: var(--bg);
  min-height: 60vh;
}

/* ── Alert ── */
.alert-success {
  background: rgba(61,122,84,.15);
  border: 1px solid rgba(61,122,84,.35);
  color: #6ecf94;
  border-radius: var(--r);
  padding: 14px 20px;
  margin-bottom: 28px;
  font-size: 14px;
  animation: slide-down .4s var(--ease) both;
  display: flex;
  align-items: center;
  gap: 10px;
}
@keyframes slide-down {
  from { opacity: 0; transform: translateY(-12px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── Cart Block ── */
.block {
  background: var(--surface);
  border: 1px solid var(--border-2);
  border-radius: var(--r-lg);
  overflow: hidden;
  box-shadow: 0 8px 48px rgba(0,0,0,.35);
  animation: fade-up .5s var(--ease) both;
}
@keyframes fade-up {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── Table ── */
.table {
  width: 100%;
  margin: 0;
  border-collapse: collapse;
  color: var(--ivory);
}

/* Header row */
.table thead tr {
  background: var(--surface-2);
  border-bottom: 1px solid var(--border-2);
}
.table thead th {
  font-family: 'DM Sans', sans-serif;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: var(--ivory-muted);
  padding: 18px 24px;
  border: none;
  white-space: nowrap;
}

/* Body rows */
.table tbody tr {
  border-bottom: 1px solid var(--border);
  transition: background var(--dur) var(--ease);
}
.table tbody tr:last-child { border-bottom: none; }
.table tbody tr:hover { background: rgba(243,237,227,.025); }
.table tbody td {
  padding: 20px 24px;
  border: none;
  vertical-align: middle;
}

/* Product info cell */
.product-info {
  display: flex;
  align-items: center;
  gap: 16px;
}
.product-info img {
  width: 76px;
  height: 76px;
  object-fit: cover;
  border-radius: var(--r);
  border: 1px solid var(--border-2);
  flex-shrink: 0;
  transition: transform var(--dur) var(--spring);
}
.product-info:hover img { transform: scale(1.06); }

.product-info a {
  font-family: 'Fraunces', serif;
  font-size: 1rem;
  font-weight: 600;
  color: var(--ivory);
  transition: color .2s;
  line-height: 1.3;
}
.product-info a:hover { color: var(--gold); }

/* Price cell */
.price-cell {
  font-size: 1rem;
  font-weight: 700;
  color: var(--gold);
  font-family: 'Fraunces', serif;
  white-space: nowrap;
}

/* ── Qty Control ── */
.qty-control {
  display: inline-flex;
  align-items: center;
  background: var(--surface-3);
  border: 1px solid var(--border-2);
  border-radius: var(--r);
  overflow: hidden;
}

.qty-btn {
  width: 36px;
  height: 36px;
  background: none;
  border: none;
  color: var(--ivory-soft);
  font-size: 18px;
  font-weight: 300;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background var(--dur), color var(--dur);
  flex-shrink: 0;
}
.qty-btn.decrease:hover { background: rgba(184,76,58,.2); color: #f87171; }
.qty-btn.increase:hover { background: rgba(61,122,84,.2); color: #6ecf94; }

.qty-input {
  width: 44px;
  text-align: center;
  background: none;
  border: none;
  border-left: 1px solid var(--border);
  border-right: 1px solid var(--border);
  color: var(--ivory);
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  font-weight: 600;
  padding: 0;
  outline: none;
  -moz-appearance: textfield;
  height: 36px;
}
.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }

/* ── Remove link ── */
.product-remove {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: .06em;
  text-transform: uppercase;
  color: var(--ivory-muted);
  padding: 8px 14px;
  border: 1px solid var(--border);
  border-radius: var(--r);
  transition: color var(--dur), border-color var(--dur), background var(--dur);
  white-space: nowrap;
}
.product-remove:hover {
  color: #f87171;
  border-color: rgba(184,76,58,.4);
  background: rgba(184,76,58,.1);
}

/* ── Cart Footer ── */
.cart-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 16px;
  padding: 22px 24px;
  background: var(--surface-2);
  border-top: 1px solid var(--border-2);
}

.cart-total {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.cart-total-label {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: var(--ivory-muted);
}
.cart-total-value {
  font-family: 'Fraunces', serif;
  font-size: 1.8rem;
  font-weight: 700;
  color: var(--gold);
  line-height: 1.1;
}

.btn-continue {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 22px;
  background: transparent;
  border: 1px solid var(--border-2);
  color: var(--ivory-soft);
  font-family: 'DM Sans', sans-serif;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  border-radius: var(--r);
  transition: color var(--dur), border-color var(--dur), background var(--dur);
}
.btn-continue:hover {
  color: var(--ivory);
  border-color: var(--border-3);
  background: rgba(243,237,227,.04);
}

.btn-checkout {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 14px 32px;
  background: linear-gradient(135deg, var(--gold), var(--gold-light));
  color: #fff;
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: .12em;
  text-transform: uppercase;
  border: none;
  border-radius: var(--r);
  cursor: pointer;
  transition: transform var(--dur) var(--spring),
              box-shadow var(--dur),
              filter var(--dur);
}
.btn-checkout:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 28px rgba(200,144,58,.38);
  filter: brightness(1.07);
  color: #fff;
}
.btn-checkout:active { transform: translateY(0); }

/* ── Empty cart ── */
.cart-empty {
  text-align: center;
  padding: 80px 24px;
}
.cart-empty-icon {
  width: 72px;
  height: 72px;
  margin: 0 auto 20px;
  color: var(--border-3);
}
.cart-empty h3 {
  font-size: 1.4rem;
  color: var(--ivory-muted);
  margin-bottom: 10px;
}
.cart-empty p {
  font-size: 14px;
  color: var(--ivory-muted);
  margin-bottom: 24px;
}
.btn-shop {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 13px 28px;
  background: var(--gold);
  color: #fff;
  border-radius: var(--r);
  font-size: 13px;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  transition: background var(--dur), transform var(--dur) var(--spring);
}
.btn-shop:hover { background: #b37d30; transform: translateY(-2px); color: #fff; }

/* ── Toast notification ── */
#cart-toast {
  position: fixed;
  bottom: 28px;
  right: 28px;
  z-index: 9999;
  padding: 14px 20px;
  border-radius: var(--r);
  font-size: 13px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 10px;
  box-shadow: 0 8px 32px rgba(0,0,0,.4);
  transform: translateY(20px);
  opacity: 0;
  transition: transform .35s var(--spring), opacity .3s var(--ease);
  pointer-events: none;
  min-width: 220px;
}
#cart-toast.show { transform: translateY(0); opacity: 1; }
#cart-toast.success-toast {
  background: rgba(30,38,30,.95);
  border: 1px solid rgba(61,122,84,.4);
  color: #6ecf94;
  backdrop-filter: blur(12px);
}
#cart-toast.error-toast {
  background: rgba(38,22,20,.95);
  border: 1px solid rgba(184,76,58,.4);
  color: #f87171;
  backdrop-filter: blur(12px);
}

/* ── Updating row animation ── */
.row-updating {
  opacity: .45;
  pointer-events: none;
  transition: opacity .25s;
}

/* ── Responsive ── */
@media (max-width: 767px) {
  .table thead { display: none; }
  .table tbody tr {
    display: flex;
    flex-direction: column;
    padding: 16px 0;
    gap: 12px;
  }
  .table tbody td { padding: 4px 16px; }
  .cart-footer { flex-direction: column; align-items: flex-start; }
  .btn-checkout { width: 100%; justify-content: center; }
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
          <h1 class="page-name">Cart</h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('home.index') }}">Home</a></li>
            <li class="active">Cart</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ── CART CONTENT ── --}}
<div class="page-wrapper">
  <div class="cart shopping">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">

          {{-- Success alert --}}
          @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
              <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
              {{ Session::get('success') }}
            </div>
          @endif

          <div class="block">

            @if(count($items) > 0)

              <form method="post" id="cart-form">
                @csrf
                <table class="table" id="cart-table">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Remove</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($items as $item)
                      @php $image = $item->attributes->image; @endphp
                      <tr id="row-{{ $item->id }}" data-price="{{ $item->price }}">

                        {{-- Item name --}}
                        <td>
                          <div class="product-info">
                            <img src="{{ asset('uploads/product/'.$image) }}" alt="{{ $item->name }}"/>
                            <a href="#">{{ $item->name }}</a>
                          </div>
                        </td>

                        {{-- Quantity --}}
                        <td>
                          <div class="qty-control">
                            <button type="button" class="qty-btn decrease decrease-btn"
                                    data-id="{{ $item->id }}" aria-label="Decrease">
                              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14"/></svg>
                            </button>
                            <input type="number"
                                   class="qty-input item-qty-{{ $item->id }}"
                                   name="qty[{{ $item->id }}]"
                                   value="{{ $item->quantity }}"
                                   min="1" readonly/>
                            <button type="button" class="qty-btn increase increase-btn"
                                    data-id="{{ $item->id }}" aria-label="Increase">
                              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                            </button>
                          </div>
                        </td>

                        {{-- Price --}}
                        <td class="price-cell">
                          ${{ number_format($item->price, 2) }}
                        </td>

                        {{-- Remove --}}
                        <td>
                          <a class="product-remove" href="{{ route('cart.remove', $item->id) }}"
                             onclick="return confirmRemove(event, this)">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                              <polyline points="3 6 5 6 21 6"/>
                              <path d="M19 6l-1 14H6L5 6"/>
                              <path d="M10 11v6M14 11v6"/>
                              <path d="M9 6V4h6v2"/>
                            </svg>
                            Remove
                          </a>
                        </td>

                      </tr>
                    @endforeach
                  </tbody>
                </table>

                {{-- Footer: total + actions --}}
                <div class="cart-footer">
                  <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">
                    <a href="#" class="btn-continue">
                      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M15 18l-6-6 6-6"/>
                      </svg>
                      Continue Shopping
                    </a>
                    <div class="cart-total">
                      <span class="cart-total-label">Order Total</span>
                      <span class="cart-total-value" id="cart-total">
                        ${{ number_format(collect($items)->sum(fn($i) => $i->price * $i->quantity), 2) }}
                      </span>
                    </div>
                  </div>
                  <a href="{{ route('checkout.index') }}" class="btn-checkout">
                    Checkout
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                      <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                  </a>
                </div>

              </form>

            @else

              {{-- Empty cart state --}}
              <div class="cart-empty">
                <svg class="cart-empty-icon" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                  <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                  <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                <h3>Your cart is empty</h3>
                <p>Looks like you haven't added anything yet.</p>
                <a href="#" class="btn-shop">
                  Browse Products
                  <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                  </svg>
                </a>
              </div>

            @endif

          </div>{{-- /.block --}}
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ── TOAST ── --}}
<div id="cart-toast" role="alert"></div>

@endsection


@section('script')
<script>
/* ── Toast helper ── */
let toastTimer;
function showToast(msg, success = true) {
  const $t = $('#cart-toast');
  $t.removeClass('success-toast error-toast show');
  const icon = success
    ? '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>'
    : '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg>';
  $t.html(icon + '<span>' + msg + '</span>');
  $t.addClass(success ? 'success-toast' : 'error-toast');
  clearTimeout(toastTimer);
  setTimeout(function() { $t.addClass('show'); }, 10);
  toastTimer = setTimeout(function() { $t.removeClass('show'); }, 3000);
}

/* ── Recalculate total ── */
function recalcTotal() {
  let total = 0;
  $('#cart-table tbody tr').each(function () {
    const price = parseFloat($(this).data('price')) || 0;
    const qty   = parseInt($(this).find('input[type="number"]').val()) || 0;
    total += price * qty;
  });
  $('#cart-total').text('$' + total.toFixed(2));
}

/* ── Quantity update ── */
function updateQuantity(itemId, action) {
  const $row = $('#row-' + itemId);
  $row.addClass('row-updating');

  $.ajax({
    url  : '{{ route("cart.update") }}',
    type : 'POST',
    data : {
      _token: '{{ csrf_token() }}',
      id    : itemId,
      action: action
    },
    success: function (response) {
      if (response.success) {
        $('.item-qty-' + itemId).val(response.newQuantity);
        recalcTotal();
        showToast(response.message, true);
      } else {
        showToast(response.message, false);
      }
    },
    error: function () {
      showToast('Something went wrong. Please try again.', false);
    },
    complete: function () {
      $row.removeClass('row-updating');
    }
  });
}

/* ── Confirm remove ── */
function confirmRemove(e, el) {
  e.preventDefault();
  if (confirm('Remove this item from your cart?')) {
    window.location.href = el.href;
  }
  return false;
}

/* ── Event bindings ── */
$(function () {
  $(document).on('click', '.increase-btn', function () {
    updateQuantity($(this).data('id'), 'increase');
  });
  $(document).on('click', '.decrease-btn', function () {
    updateQuantity($(this).data('id'), 'decrease');
  });
});
</script>
@endsection