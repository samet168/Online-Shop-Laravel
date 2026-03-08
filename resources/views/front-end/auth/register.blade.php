<!DOCTYPE html>
<html lang="en">
@include('front-end.components.header')

<style>

body{
    background:#f5f6fa;
    font-family: 'Poppins', sans-serif;
}

.register-wrapper{
    width:100%;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.register-card{
    width:900px;
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    display:flex;
    box-shadow:0 20px 60px rgba(0,0,0,0.15);
}

/* LEFT SIDE */

.register-left{
    width:40%;
    background:#FFC107;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    padding:40px;
    text-align:center;
}

.register-left img{
    width:120px;
    margin-bottom:20px;
}

.register-left h3{
    font-weight:600;
}

.register-left p{
    font-size:14px;
}

/* RIGHT SIDE */

.register-right{
    width:60%;
    padding:50px;
}

.form-control{
    border-radius:10px;
    height:45px;
    box-shadow:none;
}

.btn-register{
    background:#00c9a7;
    border:none;
    padding:12px;
    width:100%;
    border-radius:10px;
    color:#fff;
    font-weight:600;
}

.btn-register:hover{
    background:#00b89a;
}

</style>

<body>

<div class="register-wrapper">

<div class="register-card">

<!-- LEFT PANEL -->

<div class="register-left">

<img src="https://cdn-icons-png.flaticon.com/512/847/847969.png">

<h3>Let's get you set up</h3>

<p>
It should only take a couple of minutes
to create your account.
</p>

</div>


<!-- RIGHT PANEL -->

<div class="register-right">

<h3 class="mb-4">Create Your Account</h3>

<form action="{{ route('customer.register.process') }}" method="POST" onsubmit="showLoading(this)">
@csrf

<div class="form-group mb-3">
<input type="text" class="form-control" name="name" placeholder="Full Name" value="{{ old('name') }}">
@error('name')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="form-group mb-3">
<input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">
@error('email')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="form-group mb-3">
<input type="text" class="form-control" name="phone" placeholder="Phone Number" value="{{ old('phone') }}">
@error('phone')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="form-group mb-3">
<input type="password" class="form-control" name="password" placeholder="Password">
@error('password')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="form-group mb-4">
<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
</div>

<button type="submit" class="btn-register" id="submitBtn">
Sign Up
</button>

</form>

<p class="mt-3 text-center">
Already have an account?
<a href="{{ route('customer.login') }}">Login</a>
</p>

</div>

</div>
</div>


<script>
function showLoading(form) {
const btn = form.querySelector("#submitBtn");
btn.disabled = true;
btn.innerHTML = "Processing...";
return true;
}
</script>

</body>
</html>