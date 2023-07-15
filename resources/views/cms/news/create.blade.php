@extends('layouts.main-layout')

@section('title',' لوحة التحكم - اٍضافة خبر')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>الأخبار</h4>
            <h6>اٍضافة خبر</h6>
        </div>
    </div>
    <div class="card">
        <div class="card-body">

                <form>
                    <div class="mb-3">
                        <label for="title" class="col-form-label">العنوان:</label>
                        <input type="text" class="form-control" id="title" name="title" required style="background-color: #F3F4F6; color: #000000;">
                    </div>

                    <div class="mb-3">
                        <label for="content" class="col-form-label">المحتوى:</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required style="background-color: #F3F4F6; color: #000000;"></textarea>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"  >
                        <label class="form-check-label" for="is_featured">مميز</label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published"  >
                        <label class="form-check-label" for="is_published">نشر</label>
                    </div>

                    <div class="mb-3">
                        <label for="news_images" class="col-form-label">الصور:</label>
                        <input type="file" class="form-control" id="news_images" name="news_images[]" multiple accept="image/*" style="background-color: #F3F4F6; color: #000000;">
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="col-form-label">الوسوم:</label>
                        <input type="text" class="form-control" id="tags" name="tags" style="background-color: #F3F4F6; color: #000000;">
                    </div>

                    <button type="button" class="btn btn-primary" onclick="performAdd()" style="background-color: #007BFF; color: #FFFFFF;">اٍضافة</button>
                </form>

        </div>
    </div>
</div>


@endsection

@section('js-ext')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>

<script>

function performAdd() {
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
    postRequest('/dashboard/news', formData, '/dashboard/news');
}


</script>

@endsection

