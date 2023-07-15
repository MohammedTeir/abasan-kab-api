@extends('layouts.auth')

@section('title','تسجيل دخول - لوحة تحكم بلدية عبسان الكبيرة')



@section('content')
<body class="account-page">
    <div class="main-wrapper">
       <div class="account-content">
          <div class="login-wrapper">
             <div class="login-content">
                <div class="login-userset">
                   <div class="login-logo logo-normal">
                      <img src="{{asset('assets/img/logo.svg')}}" alt="img">
                   </div>
                   <a href="{{route('dashboard.home')}}" class="login-logo logo-white">
                   <img src="{{asset('assets/img/logo-white.svg')}}" alt>
                   </a>
                   <div class="login-userheading">
                      <h3>تسجيل الدخول</h3>
                      <h4>يرجى تسجيل الدخول إلى حسابك</h4>
                   </div>
                   <div class="form-login">
                      <label>البريد الإلكتروني</label>
                      <div class="form-addons">
                         <input type="text" id="email" placeholder="Enter your email address">
                         <img src="{{asset('assets/img/icons/mail.svg')}}" alt="img">
                      </div>
                   </div>
                   <div class="form-login">
                      <label>كلمة المرور</label>
                      <div class="pass-group">
                         <input type="password" id="password" class="pass-input" placeholder="Enter your password">
                         <span class="fas toggle-password fa-eye-slash"></span>
                      </div>
                   </div>
                   <div class="form-login">
                      <div class="alreadyuser">
                         <h4><a href="{{route('forgot')}}" class="hover-a">هل نسيت كلمة المرور؟</a></h4>
                      </div>
                   </div>
                   <div class="form-login">
                      <a class="btn btn-login" onclick="login()">تسجيل الدخول</a>
                   </div>
                </div>
             </div>
             <div class="login-img" style="background-color: #50A060;">
                <img src="{{asset('assets/img/logo-auth.svg')}}" alt="img">
             </div>
          </div>
       </div>
    </div>
 </body>

@endsection

@section('js-ext')




    <!--end::Custom Javascript-->
    <script>
        function login() {


            let formData = new FormData();
            formData.append('email', document.getElementById("email").value);
            formData.append('password', document.getElementById("password").value);


            postRequest('/dashboard/login',formData,'/dashboard');
        }
    </script>

@endsection
