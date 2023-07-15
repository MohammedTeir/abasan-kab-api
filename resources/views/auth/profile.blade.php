@extends('layouts.main-layout')

@section('css-ext')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
@endsection
@section('title','لوحة التحكم - حسابي')



@section('content')
<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>حسابي</h4>
       </div>
    </div>
    <div class="card">
       <div class="card-body">
          <div class="profile-set">
             <div class="profile-head"></div>
             <div class="profile-top">
                <div class="profile-content">
                   <div class="profile-contentimg">
                    @if ($user->image_url==null)
                    <img src="{{asset('assets/img/profiles/default-profile.png')}}" alt="img" id="preview_image">

                    @else
                    <img src="{{$user->image_url}}" alt="img" id="preview_image" >

                    @endif
                      <div class="profileupload">
                        <input type="file" id="avatar" onchange="updateProfileImage()">
                        <a><img src="{{asset('assets/img/icons/edit-set.svg')}}" alt="img"></a>
                      </div>
                   </div>
                   <div class="profile-contentname">
                      <h2>{{$user->name}}</h2>
                      <h4>تحديث صورتك وبياناتك الشخصية.</h4>
                   </div>
                </div>
             </div>
          </div>
          <div class="row">
             <div class="col-lg-6 col-sm-12">
                <div class="form-group">
                   <label>الإسم</label>
                   <input type="text" id="name" placeholder="الإسم الكامل" value="{{$user->name}}">
                </div>
             </div>
             <div class="col-lg-6 col-sm-12">
                <div class="form-group">
                   <label>البريد الإلكتروني</label>
                   <input type="text" id="email" placeholder="abasan@mail.com" value="{{$user->email}}">
                </div>
             </div>
             <div class="col-lg-6 col-sm-12">
                <div class="form-group">
                   <label>Password</label>
                   <div class="pass-group">
                      <input type="password" id="password" class=" pass-input">
                      <span class="fas toggle-password fa-eye-slash"></span>
                   </div>
                </div>
             </div>
             <div class="col-12">
                <a onclick="updateProfile()" class="btn btn-submit me-2">حفظ التغييرات</a>
             </div>
          </div>
       </div>
    </div>
 </div>
@endsection

@section('js-ext')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

<script>
    function updateProfile() {


        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;


  // Create the request data object
        const requestData = {
            name: name,
            email: email,
            password: password
        };

        putRequest('/dashboard/update',requestData,'/dashboard/my-profile');
    }
</script>

<script>
    function updateProfileImage() {

        let avatarFile = document.getElementById('avatar').files[0];
        let formData = new FormData();
        formData.append('avatar', avatarFile);
        postRequest('/dashboard/update-image',formData,'/dashboard');
    }
</script>
@endsection
