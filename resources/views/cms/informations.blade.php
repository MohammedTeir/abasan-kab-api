@extends('layouts.main-layout')

@section('title',' لوحة التحكم -  معلومات عن البلدية')

@section('css-ext')

<style>
    #email {
        text-align: right;
    }


</style>

@endsection

@section('content')

<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>حول البلدية</h4>
       </div>
    </div>
    <div class="card">
        <div class="card-body">
           <form>

              <div class="row">
                  <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="telephone-number">رقم الهاتف</label>
                        <input type="text" class="form-control" id="telephone-number" value="{{ $settings ? $settings->telephone_number : '' }}" name="telephone_number" placeholder="أدخل رقم الهاتف">
                    </div>
                    <div class="form-group">
                        <label for="mobile-number">رقم الجوال</label>
                        <input type="text" class="form-control" id="mobile-number" value="{{ $settings ? $settings->mobile_number : '' }}" name="mobile_number" placeholder="أدخل رقم الجوال">
                    </div>

                    <div class="form-group">
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" class="form-control" id="email" value="{{ $settings ? $settings->email : '' }}" name="email" placeholder="أدخل البريد الإلكتروني">
                    </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="address">العنوان</label>
                            <input type="text" class="form-control" id="address" value="{{ $settings ? $settings->address : '' }}" name="address" placeholder="أدخل العنوان">
                        </div>
                        <div class="form-group">
                            <label for="facebook">حساب فيسبوك</label>
                            <input type="text" class="form-control" id="facebook" value="{{ $settings ? $settings->facebook : '' }}" name="facebook" placeholder="أدخل حساب فيسبوك">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="instagram">حساب إنستغرام</label>
                            <input type="text" class="form-control" id="instagram" value="{{ $settings ? $settings->instagram : '' }}" name="instagram" placeholder="أدخل حساب إنستجرام">
                        </div>
                        <div class="form-group">
                            <label for="youtube">حساب يوتيوب</label>
                            <input type="text" class="form-control" id="youtube" value="{{ $settings ? $settings->youtube : '' }}" name="youtube" placeholder="أدخل حساب يوتيوب">
                        </div>
                    </div>


                  </div>


                  <div class="col-lg-12">
                     <a  class="btn btn-submit me-2" onclick="performAddSetting()">حفظ وتحديث</a>

                  </div>
               </div>

           </form>
        </div>
     </div>












<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>كلمة رئيس البلدية</h4>
       </div>
    </div>
    <div class="card">
        <div class="card-body">
           <form>

              <div class="row">
                  <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="mayor_speech_title">العنوان</label>
                        <input type="text" class="form-control" id="mayor_speech_title" value="{{ $mayorSpeech ? $mayorSpeech->title : '' }}" name="mayor_speech_title" placeholder="أدخل العنوان">
                    </div>
                    <div class="form-group">
                        <label for="mayor_speech_content">كلمة رئيس البلدية</label>
                        <textarea class="form-control" id="mayor_speech_content" name="mayor_speech_content" placeholder="كلمة رئيس البلدية">{{ $mayorSpeech ? $mayorSpeech->content : '' }}</textarea>
                    </div>


                        <div class="form-group">
                            <label>صورة رئيس البلدية</label>

                           <div class="image-upload image-upload-new">
                             <input type="file" id="mayor_speech_image" name="mayor_speech_image" onchange="changeMayorPreviewImage(event)">
                             <div class="image-uploads">
                                @if ($mayorSpeech)
                                    @if ($mayorSpeech->imageurl == null)
                                        <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img" id="preview_mayor_speech_image">
                                    @else
                                        <img src="{{ $mayorSpeech->imageurl }}" alt="img" id="preview_mayor_speech_image">
                                    @endif
                                @endif
                                <h4 id="upload_mayor_image_text">قم بسحب وإسقاط ملف للتحميل</h4>
                            </div>
                           </div>
                        </div>
                     </div>


                  <div class="col-lg-12">
                     <a  class="btn btn-submit me-2"  onclick="performAddMayorSpeech()">حفظ وتحديث</a>

                  </div>
               </div>

           </form>
        </div>
     </div>
 </div>



<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>نبذة عن البلدية</h4>
       </div>
    </div>
    <div class="card">
        <div class="card-body">
           <form>

              <div class="row">
                  <div class="col-lg-3 col-sm-6 col-12">

                    <div class="form-group">
                        <label for="about_content">محتوى النبذة</label>
                        <textarea class="form-control" id="about_content" name="about_content">{{ $about ? $about->content : '' }}</textarea>
                    </div>

                        <div class="form-group">
                            <label>صورة النبذة</label>

                           <div class="image-upload image-upload-new">
                             <input type="file" id="about_image" name="about_image" onchange="changeAboutPreviewImage(event)">
                             <div class="image-uploads">
                                @if ($about)
                                    @if ($about->imageurl == null)
                                        <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img" id="preview_about_image">
                                    @else
                                        <img src="{{ $about->imageurl }}" alt="img" id="preview_about_image">
                                    @endif
                                @else
                                    <p>لا يوجد معلومات حول البلدية.</p>
                                @endif
                                <h4 id="upload_about_image_text">قم بسحب وإسقاط ملف للتحميل</h4>
                            </div>

                           </div>
                        </div>
                     </div>

                  <div class="col-lg-12">
                     <a  class="btn btn-submit me-2" onclick="performAddAbout()">حفظ وتحديث</a>

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

<script>

   function changeMayorPreviewImage(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var previewImage = document.getElementById('preview_mayor_speech_image');
            previewImage.setAttribute('src', e.target.result);
        };
        document.getElementById('upload_mayor_image_text').style.display = 'none';
        reader.readAsDataURL(file);
    }


function changeAboutPreviewImage(event) {
    var file = event.target.files[0];
    var reader = new FileReader();


    reader.onload = function (e) {
        var previewImage = document.getElementById('preview_about_image');
        previewImage.setAttribute('src', e.target.result);
    };
    document.getElementById('upload_about_image_text').style.display = 'none';
    reader.readAsDataURL(file);
}



function  performAddSetting(){


    let formData = new FormData();
    formData.append('telephone_number', document.getElementById("telephone-number").value);
    formData.append('mobile_number', document.getElementById("mobile-number").value);
    formData.append('email', document.getElementById('email').value);
    formData.append('address', document.getElementById('address').value);
    formData.append('facebook', document.getElementById('facebook').value);
    formData.append('instagram', document.getElementById('instagram').value);
    formData.append('youtube', document.getElementById('youtube').value);

    postRequest('/dashboard/informations/setting',formData,'/dashboard/informations');

}






function performAddAbout() {
    let aboutImage = document.getElementById('about_image').files[0];

    let formData = new FormData();
    if (aboutImage) {
        formData.append('image', aboutImage);
    }
    formData.append('content', document.getElementById("about_content").value);

    postRequest('/dashboard/informations/about', formData, '/dashboard/informations');
}

function performAddMayorSpeech() {
    let mayorImage = document.getElementById('mayor_speech_image').files[0];

    let formData = new FormData();
    if (mayorImage) {
        formData.append('image', mayorImage);
    }
    formData.append('title', document.getElementById("mayor_speech_title").value);
    formData.append('content', document.getElementById("mayor_speech_content").value);

    postRequest('/dashboard/informations/mayor-speech', formData, '/dashboard/informations');
}

</script>


@endsection
