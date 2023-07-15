@extends('layouts.main-layout')

@section('title',' لوحة التحكم - اٍضافة وظيفة')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>الوظائف</h4>
            <h6>اٍضافة وظيفة</h6>
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


                    <div class="mb-3">
                        <label for="image" class="col-form-label">الصورة:</label>
                        <input type="file" class="form-control" id="image" name="image"  accept="image/*" style="background-color: #F3F4F6; color: #000000;">
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
    let image = document.getElementById('image').files[0];

    // Create a new FormData instance
    let formData = new FormData();

    // Append the form inputs to the FormData
    formData.append('title', title);
    formData.append('content', content);
    formData.append('image', image);



    // Perform the request
    postRequest('/dashboard/vacancies', formData, '/dashboard/vacancies');
}


</script>

@endsection

