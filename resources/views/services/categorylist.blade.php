@extends('layouts.main-layout')

@section('title',' لوحة التحكم -  تصنيفات الخدمات')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>قائمة تصنيفات الخدمات</h4>
          <h6>عرض/بحث تصنيفات الخدمات</h6>
       </div>
       <div class="page-btn">
          <a data-bs-toggle="modal"
          data-bs-target="#addCategoryModal" class="btn btn-added">
          <img src="{{asset('assets/img/icons/plus.svg')}}"   class="me-1" alt="img">اٍضافة تصنيف
          </a>
       </div>
    </div>
    <div class="card">
       <div class="card-body">
          <div class="table-top">
             <div class="search-set">
                <div class="search-path">
                   <a class="btn btn-filter" id="filter_search">
                   <img src="{{asset('assets/img/icons/filter.svg')}}" alt="img">
                   <span><img src="{{asset('assets/img/icons/closes.svg')}}" alt="img"></span>
                   </a>
                </div>
                <div class="search-input">
                   <a class="btn btn-searchset"><img src="{{asset('assets/img/icons/search-white.svg')}}" alt="img"></a>
                </div>
             </div>
             <div class="wordset">
                <ul>
                   <li>
                      <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="{{asset('assets/img/icons/pdf.svg')}}" alt="img"></a>
                   </li>
                   <li>
                      <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="{{asset('assets/img/icons/excel.svg')}}" alt="img"></a>
                   </li>
                   <li>
                      <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="{{asset('assets/img/icons/printer.svg')}}" alt="img"></a>
                   </li>
                </ul>
             </div>
          </div>
          <div class="card" id="filter_inputs">
             <div class="card-body pb-0">
                <div class="row">
                   <div class="col-lg-2 col-sm-6 col-12">
                      <div class="form-group">
                         <select class="form-select">
                            <option>اٍختر التصنيف</option>
                            <option>خدمات الدائرة الفنية</option>
                         </select>
                      </div>
                   </div>
                   <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                      <div class="form-group">
                         <a class="btn btn-filters ms-auto"><img src="{{asset('assets/img/icons/search-whites.svg')}}" alt="img"></a>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="table-responsive">
             <table class="table  datanew">
                <thead>
                   <tr>
                      <th>التصنيف</th>
                      <th>اٍجراءات</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)

                    <tr>
                        <td>{{$category->name}}</td>
                        <td>
                           <a class="me-3" data-bs-toggle="modal"
                           data-bs-target="#updateCategoryModal" data-category_id="{{$category->id}}" data-category_name="{{$category->name}}">
                           <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                           </a>
                           <a class="me-3 confirm-text" onclick="performDelete({{$category->id}},this)">
                           <img src="{{asset('assets/img/icons/delete.svg')}}" alt="img">
                           </a>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
             </table>
          </div>
       </div>
    </div>
 </div>

 @include('modals.services.category.addCategory')
 @include('modals.services.category.updateCategory')
@endsection

@section('js-ext')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script>


    $('#updateCategoryModal').on('show.bs.modal', function (event) {


    var button = $(event.relatedTarget)

    var id = button.data('category_id');
    var name = button.data('category_name');

    var modal = $(this);

    modal.find('.modal-body #category_id').val(id);
    modal.find('.modal-body #category_name_edit').val(name);

    });


    function performAdd() {
        let data = {
            name:document.getElementById("category-name").value,
        };
        postRequest('/dashboard/service-categories',data,'/dashboard/service-categories');
    }

    function performUpdate() {

    var id = document.getElementById("category_id").value;
    let updatedData = {
        name:document.getElementById("category_name_edit").value,
    };
    putRequest('/dashboard/service-categories/'+id,updatedData,'/dashboard/service-categories');
}


    function performDelete(id,reference) {
        confirmDeleteRequest('/dashboard/service-categories/'+id,reference,'/dashboard/service-categories');
    }

</script>

@endsection

