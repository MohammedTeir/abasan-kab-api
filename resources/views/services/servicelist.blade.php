@extends('layouts.main-layout')

@section('title',' لوحة التحكم - الخدمات')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>قائمة الخدمات</h4>
          <h6>عرض/بحث الخدمات</h6>
       </div>
       <div class="page-btn">
          <a data-bs-toggle="modal"
          data-bs-target="#addServiceModal" class="btn btn-added">
          <img src="{{asset('assets/img/icons/plus.svg')}}"   class="me-1" alt="img">اٍضافة خدمة
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
                            <option>تركيب خط مياه</option>
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
                      <th>الاٍسم</th>
                      <th>السعر</th>
                      <th>الوقت المطلوب</th>
                      <th>الدائرة</th>
                      <th>اٍجراءات</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)

                    <tr>
                        <td>{{$service->service_name}}</td>
                        <td>{{$service->price}}</td>
                        <td>{{$service->required_time}}</td>
                        <td>{{$service->category->name}}</td>
                        <td>
                           <a class="me-3" data-bs-toggle="modal"
                           data-bs-target="#updateServiceModal" data-service_id="{{$service->id}}" data-required_documents="{{$service->required_documents}}"
                           data-service_category_id="{{$service->service_category_id}}" data-service_name="{{$service->service_name}}"
                           data-service_price="{{$service->price}}" data-required_time="{{$service->required_time}}">
                           <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                           </a>
                           <a class="me-3 confirm-text" onclick="performDelete({{$service->id}},this)">
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

 @include('modals.services.addService')
 @include('modals.services.updateService')
@endsection

@section('js-ext')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script>


$('#updateServiceModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var serviceId = button.data('service_id');
    var serviceName = button.data('service_name');
    var servicePrice = button.data('service_price');
    var serviceRequiredTime = button.data('required_time');
    var serviceRequiredDocuments = button.data('required_documents');
    var serviceCategoryId = button.data('service_category_id');

    // Set the values in the modal
    var modal = $(this);
    modal.find('#update-service-id').val(serviceId);
    modal.find('#update-service-name').val(serviceName);
    modal.find('#update-service-price').val(servicePrice);
    modal.find('#update-service-required_time').val(serviceRequiredTime);
    modal.find('#update-service-required_documents').val(serviceRequiredDocuments);
    modal.find('#update-service-category').val(serviceCategoryId);
});


    function performAdd() {
    // Get the form inputs
    let serviceName = document.getElementById('service-name').value;
    let servicePrice = document.getElementById('service-price').value;
    let serviceRequiredTime = document.getElementById('service-required_time').value;
    let serviceRequiredDocuments = document.getElementById('service-required_documents').value;
    let serviceCategory = document.getElementById('service-category').value;

    // Create a new FormData instance
    let formData = new FormData();

    // Append the form inputs to the FormData
    formData.append('service_category_id', serviceCategory);
    formData.append('service_name', serviceName);
    formData.append('price', servicePrice);
    formData.append('required_time', serviceRequiredTime);
    formData.append('required_documents', serviceRequiredDocuments);

    // Perform the request
    postRequest('/dashboard/services', formData, '/dashboard/services');
}


function performUpdate() {
    // Get the form inputs
    var serviceId = document.getElementById('update-service-id').value;
    var serviceName = document.getElementById('update-service-name').value;
    var servicePrice = document.getElementById('update-service-price').value;
    var serviceRequiredTime = document.getElementById('update-service-required_time').value;
    var serviceRequiredDocuments = document.getElementById('update-service-required_documents').value;
    var serviceCategoryId = document.getElementById('update-service-category').value;

    // Create the data object
    let data = {
        service_name: serviceName,
        price: servicePrice,
        required_time: serviceRequiredTime,
        required_documents: serviceRequiredDocuments,
        service_category_id: serviceCategoryId
    };

    // Perform the request
    putRequest('/dashboard/services/' + serviceId, data, '/dashboard/services');
}




    function performDelete(id,reference) {
        confirmDeleteRequest('/dashboard/services/'+id,reference,'/dashboard/services');
    }

</script>

@endsection

