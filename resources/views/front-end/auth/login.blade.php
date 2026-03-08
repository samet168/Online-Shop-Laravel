<!DOCTYPE html>
<html lang="en">
<head>
    @include('front-end.components.header')
    <style>
        /* General body style */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /* background: linear-gradient(135deg, rgb(58,123,213), rgb(0,210,255)); */
            overflow: hidden;
            animation: bgMove 10s linear infinite alternate;
        }

        @keyframes bgMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Container for login box */
        .login-container {
            display: flex;
            width: 800px;
            max-width: 90%;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        /* Left illustration */
        .login-left {
            flex: 1;
            background: url('{{ asset("front-end/assets/images/login-illustration.jpg") }}') center/cover no-repeat;
        }

        /* Right login form */
        .login-right {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h2 {
            margin-bottom: 30px;
            font-weight: 600;
            color: #333;
            text-align: center;
        }

        /* Social login buttons */
        .social-btn {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .social-btn button {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
            background: #fff;
            font-weight: 500;
            transition: 0.3s;
        }

        .social-btn button:hover {
            background: rgb(240, 240, 240);
        }

        .social-btn img {
            width: 20px;
            margin-right: 8px;
        }

        /* Login form style */
        .login-form {
            display: flex;
            flex-direction: column;
        }

        .login-form .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .login-form input {
            width: 100%;
            border: none;
            border-bottom: 2px solid #ddd;
            padding: 10px 0;
            outline: none;
            font-size: 16px;
            transition: 0.3s;
        }

        .login-form label {
            position: absolute;
            top: 10px;
            left: 0;
            color: #aaa;
            font-size: 14px;
            pointer-events: none;
            transition: 0.3s;
        }

        .login-form input:focus + label,
        .login-form input:not(:placeholder-shown) + label {
            top: -15px;
            font-size: 12px;
            color: rgb(0,210,255);
        }

        /* Sign in button */
        .login-form button {
            padding: 12px;
            border: none;
            border-radius: 50px;
            background: linear-gradient(90deg, rgb(58,123,213), rgb(0,210,255));
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: 0.5s;
        }

        .login-form button:hover {
            background: linear-gradient(90deg, rgb(0,210,255), rgb(58,123,213));
        }

        /* Footer links */
        .login-form .text-center {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
        }

        .login-form .text-center a {
            color: rgb(0,210,255);
            text-decoration: none;
            font-weight: 500;
        }

        /* Responsive */
        @media(max-width: 768px){
            .login-container {
                flex-direction: column;
                border-radius: 0;
            }
            .login-left {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left"></div>
        <div class="login-right">
            <h2>Sign In</h2>

            <div class="social-btn">
                <button><img src="{{ asset('front-end/assets/images/google-icon.jpg') }}" alt="Google"> Google</button>
                <button><img src="{{ asset('front-end/assets/images/facebook-icon.jpg') }}" alt="Facebook"> Facebook</button>
            </div>

            <div class="text-center mb-3">- OR -</div>

            <form class="login-form" action="{{ route('customer.login.process') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" placeholder=" " required value="{{ old('email') }}">
                    <label>Email Address</label>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder=" " required>
                    <label>Password</label>
                </div>
                <button type="submit">Sign In</button>
                <div class="text-center mt-2">
                    Don't have an account? <a href="{{ route('customer.register') }}">Register</a>
                </div>
                <div class="text-center mt-2">
                    <a href="{{ route('send.email.show') }}">Forgot Password</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>