@extends('layouts.main-layout')

@section('title',' لوحة التحكم - الدوائر')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>قائمة الدوائر للشكاوي</h4>
          <h6>عرض/بحث الدوائر التي يتم مراجعتها عند تقديم شكوى</h6>
       </div>
       <div class="page-btn">
          <a data-bs-toggle="modal"
          data-bs-target="#addDepartmentModal" class="btn btn-added">
          <img src="{{asset('assets/img/icons/plus.svg')}}"   class="me-1" alt="img">اٍضافة دائرة
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
                            <option>اٍختر الدائرة</option>
                            <option>الدائرة الفنية</option>
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
                      <th>الدائرة</th>
                      <th>اٍجراءات</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)

                    <tr>
                        <td>{{$department->name}}</td>
                        <td>
                           <a class="me-3" data-bs-toggle="modal"
                           data-bs-target="#updateDepartmentModal" data-department_id="{{$department->id}}" data-department_name="{{$department->name}}">
                           <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                           </a>
                           <a class="me-3 confirm-text" onclick="performDelete({{$department->id}},this)">
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

 @include('modals.departments.addDepartment')
 @include('modals.departments.updateDepartment')
@endsection

@section('js-ext')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script>


    $('#updateDepartmentModal').on('show.bs.modal', function (event) {


    var button = $(event.relatedTarget)

    var id = button.data('department_id');
    var name = button.data('department_name');

    var modal = $(this);

    modal.find('.modal-body #department_id').val(id);
    modal.find('.modal-body #department_name_edit').val(name);

    });


    function performAdd() {
        let data = {
            name:document.getElementById("department-name").value,
        };
        postRequest('/dashboard/departments',data,'/dashboard/departments');
    }

    function performUpdate() {

    var id = document.getElementById("department_id").value;
    let updatedData = {
        name:document.getElementById("department_name_edit").value,
    };
    putRequest('/dashboard/departments/'+id,updatedData,'/dashboard/departments');
}


    function performDelete(id,reference) {
        confirmDeleteRequest('/dashboard/departments/'+id,reference,'/dashboard/departments');
    }

</script>

@endsection

