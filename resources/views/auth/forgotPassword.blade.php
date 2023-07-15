@extends('layouts.auth')

@section('title','استرجاع كلمة المرور - لوحة تحكم بلدية عبسان الكبيرة')



@section('content')

<body class="account-page">
    <div class="main-wrapper">
       <div class="account-content">
          <div class="login-wrapper">
             <div class="login-content">
                <div class="login-userset ">
                   <div class="login-logo">
                      <img src="{{asset('assets/img/logo.svg')}}" alt="img">
                   </div>
                   <div class="login-userheading">
                      <h3>نسيت كلمة المرور؟</h3>
                      <h4>لا تقلق! يحدث ذلك. يرجى إدخال عنوان البريد الاٍلكتروني <br>
                         المرتبط بحسابك.
                      </h4>
                   </div>
                   <div class="form-login">
                      <label>البريد الإلكتروني</label>
                      <div class="form-addons">
                         <input type="text" id="email" placeholder="أدخل عنوان بريدك الإلكتروني">
                         <img src="{{asset('assets/img/icons/mail.svg')}}" alt="img">
                      </div>
                   </div>
                   <div class="form-login">
                      <a class="btn btn-login" onclick="forgotPassword()">إرسال</a>
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
        function forgotPassword() {


            let formData = new FormData();
            formData.append('email', document.getElementById("email").value);


            postRequest('/dashboard/reset',formData,'/dashboard/');
        }
    </script>

@endsection
