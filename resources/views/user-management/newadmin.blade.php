@extends('layouts.main-layout')

@section('title','لوحة التحكم - اٍضافة مستخدم جديد')

@section('css-ext')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
@endsection

@section('content')


    <div class="content">
               <div class="page-header">
                  <div class="page-title">
                     <h4>اٍدارة المستخدمين</h4>
                     <h6>اٍضافة مستخدم</h6>
                  </div>
               </div>
               <div class="card">
                  <div class="card-body">
                     <form>

                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                               <div class="form-group">
                                  <label>الاٍسم</label>
                                  <input type="text" id="name">
                               </div>
                               <div class="form-group">
                                  <label>البريد الاٍلكتروني</label>
                                  <input type="text" id="email">
                               </div>
                               <div class="form-group">
                                  <label>كلمة المرور</label>
                                  <div class="pass-group">
                                     <input type="password" class=" pass-input" id="password">
                                     <span class="fas toggle-password fa-eye-slash"></span>
                                  </div>
                               </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                               <div class="form-group">
                                <label>الدور</label>
                                <select class="form-select" id="role">
                                    <option selected></option>
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                  </select>
                               </div>

                               <div class="form-group">
                                  <label>تاكيد كلمة المرور</label>
                                  <div class="pass-group">
                                     <input type="password" class=" pass-inputs" id="password-confirm">
                                     <span class="fas toggle-passworda fa-eye-slash"></span>
                                  </div>
                               </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                               <div class="form-group">
                                  <label>صورة المستخدم</label>
                                  <div class="image-upload image-upload-new">
                                    <input type="file" id="profile-image" name="profile-image" onchange="changePreviewImage(event)">
                                    <div class="image-uploads">
                                        <img src="{{asset('assets/img/icons/upload.svg')}}" alt="img" id="preview_image">
                                        <h4 id="upload-text">قم بسحب وإسقاط ملف للتحميل</h4>
                                    </div>
                                  </div>
                               </div>
                            </div>
                            <div class="col-lg-12">
                               <a href="javascript:void(0);" class="btn btn-submit me-2" onclick="performAddAdmin()">حفظ التغييرات</a>
                               <button class="btn btn-cancel" type="reset">إلغاء</button>

                            </div>
                         </div>

                     </form>
                  </div>
               </div>
            </div>


@endsection

@section('js-ext')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalerts.min.js')}}"></script>

<script>
    function changePreviewImage(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var previewImage = document.getElementById('preview_image');
            previewImage.setAttribute('src', e.target.result);
        };
        document.getElementById('upload-text').style.display = 'none';
        reader.readAsDataURL(file);
    }
</script>

<script>

function performAddAdmin() {


            let avatarFile = document.getElementById('profile-image').files[0];

            let formData = new FormData();
            formData.append('avatar', avatarFile);
            formData.append('full_name', document.getElementById("name").value);
            formData.append('email', document.getElementById("email").value);
            formData.append('password', document.getElementById('password').value);
            formData.append('password_confirmation', document.getElementById('password-confirm').value);
            formData.append('role_id', document.getElementById('role').value);

            postRequest('/dashboard/admins',formData,'/dashboard/admins');
        }


</script>

@endsection
