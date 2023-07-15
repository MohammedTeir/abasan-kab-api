@extends('layouts.main-layout')

@section('title',' لوحة التحكم - اٍضافة مشروع')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>المشاريع</h4>
            <h6>اٍضافة مشروع</h6>
        </div>
    </div>
    <div class="card">
        <div class="card-body">

            <form >

                <div class="mb-3">
                    <label for="title" class="col-form-label">العنوان:</label>
                    <input type="text" class="form-control" id="title" name="title" required style="background-color: #F3F4F6; color: #000000;">
                </div>

                <div class="mb-3">
                    <label for="content" class="col-form-label">المحتوى:</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required style="background-color: #F3F4F6; color: #000000;"></textarea>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="col-form-label">التصنيف:</label>
                    <select class="form-control" id="category_id" name="category_id" required style="background-color: #F3F4F6; color: #000000;">
                        <option disabled selected>اختر التصنيف</option>
                        @foreach ($projectCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="project_images" class="col-form-label">الصور:</label>
                    <input type="file" class="form-control" id="project_images" name="project_images[]" multiple accept="image/*" style="background-color: #F3F4F6; color: #000000;">
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
    let projectImages = document.getElementById('project_images').files;
    let categoryId = document.getElementById('category_id').value;
    // Create a new FormData instance
    let formData = new FormData();

    // Append the form inputs to the FormData

    formData.append('title', title);
    formData.append('content', content);
    formData.append('category_id', categoryId);
    // Append the project_images files to the FormData
    for (let i = 0; i < projectImages.length; i++) {
        formData.append('project_images[]', projectImages[i]);
    }

    // Perform the request
    postRequest('/dashboard/projects', formData, '/dashboard/projects');

}


</script>

@endsection

