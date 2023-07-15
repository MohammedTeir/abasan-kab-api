@extends('layouts.main-layout')

@section('title',' لوحة التحكم - تعديل وظيفة')

@section('css-ext')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

@endsection

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>الوظائف</h4>
            <h6>تعديل وظيفة</h6>
        </div>
    </div>
    <div class="card">
        <div class="card-body">

                <form>
                    <div class="mb-3">
                        <label for="title" class="col-form-label">العنوان:</label>
                        <input type="text" class="form-control" id="title" value="{{$vacancy->title}}" name="title" required style="background-color: #F3F4F6; color: #000000;">
                    </div>

                    <div class="mb-3">
                        <label for="content" class="col-form-label">المحتوى:</label>
                        <textarea class="form-control" id="content"  name="content" rows="5" required style="background-color: #F3F4F6; color: #000000;">{{$vacancy->content}}</textarea>
                    </div>


                    <div class="mb-3">
                        <label for="image" class="col-form-label">الصورة:</label>
                        <input type="file" class="form-control" id="image" name="image"  accept="image/*" style="background-color: #F3F4F6; color: #000000;">
                    </div>

                    <div class="swiper-container">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                              <img  src="{{ $vacancy->imageurl }}" alt="News Image">
                            </div>

                        </div>
                        <div class="swiper-pagination"></div>
                      </div>


                    <button type="button" class="btn btn-primary" onclick="performUpdate({{ $vacancy->id}})" style="background-color: #007BFF; color: #FFFFFF;">حفظ التغييرات</button>
                </form>

        </div>
    </div>
</div>



@endsection

@section('js-ext')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>




<script>
  var swiper = new Swiper('.swiper-container', {
    loop: true,
    speed: 400,
    autoplay: {
    delay: 1000,
        },

    // Default parameters
  slidesPerView: 1,
  spaceBetween: 10,
  // Responsive breakpoints
  breakpoints: {
    // when window width is >= 320px
    320: {
      slidesPerView: 2,
      spaceBetween: 20
    },
    // when window width is >= 480px
    480: {
      slidesPerView: 3,
      spaceBetween: 30
    },
    // when window width is >= 640px
    640: {
      slidesPerView: 4,
      spaceBetween: 40
    }
  },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });
</script>


<script>


function performUpdate(id) {
    // Get the form inputs
    let title = document.getElementById('title').value;
    let content = document.getElementById('content').value;
    let image = document.getElementById('image').files[0];

    // Create a new FormData instance
    let formData = new FormData();

    // Append the form inputs to the FormData
    formData.append('title', title);
    formData.append('content', content);

    // Check if image is selected
    if (image) {
        formData.append('image', image);
    }

    // Perform the request
    postRequest('/dashboard/vacancies/'+id, formData, '/dashboard/vacancies');
}



</script>



@endsection

