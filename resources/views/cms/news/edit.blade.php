@extends('layouts.main-layout')

@section('title',' لوحة التحكم - تعديل خبر')

@section('css-ext')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

@endsection

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>الأخبار</h4>
            <h6>تعديل خبر</h6>
        </div>
    </div>
    <div class="card">
        <div class="card-body">

                <form>
                    <div class="mb-3">
                        <label for="title" class="col-form-label">العنوان:</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $news->title }}" required style="background-color: #F3F4F6; color: #000000;">
                    </div>

                    <div class="mb-3">
                        <label for="content" class="col-form-label">المحتوى:</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required style="background-color: #F3F4F6; color: #000000;">{{ $news->content }}</textarea>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"  {{ $news->is_featured ? 'checked' : '' }} >
                        <label class="form-check-label" for="is_featured">مميز</label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published" {{ $news->is_published ? 'checked' : '' }} >
                        <label class="form-check-label" for="is_published">نشر</label>
                    </div>

                    <div class="mb-3">
                        <label for="news_images" class="col-form-label">الصور:</label>
                        <input type="file" class="form-control" id="news_images" name="news_images[]" multiple accept="image/*" style="background-color: #F3F4F6; color: #000000;">
                    </div>
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($news->imagesurl as $image_url)
                            <div class="swiper-slide">
                              <img  src="{{ $image_url }}" alt="News Image">
                            </div>
                          @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                      </div>
                    <div class="mb-3">
                        <label for="tags" class="col-form-label">الوسوم:</label>
                        <input type="text" class="form-control" id="tags" name="tags" value="{{ $news->tags }}" style="background-color: #F3F4F6; color: #000000;">
                    </div>

                    <button type="button" class="btn btn-primary" onclick="performUpdate({{ $news->id}})" style="background-color: #007BFF; color: #FFFFFF;">حفظ التغييرات</button>
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
    let isFeatured = document.getElementById('is_featured').checked ? '1' : '0';
    let isPublished = document.getElementById('is_published').checked ? '1' : '0';
    let tags = document.getElementById('tags').value;
    let newsImages = document.getElementById('news_images').files;

    // Create a new FormData instance
    let formData = new FormData();

    // Append the form inputs to the FormData
    formData.append('title', title);
    formData.append('content', content);
    formData.append('is_featured', isFeatured);
    formData.append('is_published', isPublished);
    formData.append('tags', tags);

    // Append the news_images files to the FormData
    for (let i = 0; i < newsImages.length; i++) {
        formData.append('news_images[]', newsImages[i]);
    }

    // Perform the request
    postRequest('/dashboard/news/'+id, formData, '/dashboard/news');
}


</script>



@endsection

