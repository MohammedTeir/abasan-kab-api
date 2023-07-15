@extends('layouts.main-layout')

@section('title',' لوحة التحكم - خدمات قيد الطلب')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>قائمة الخدمات التي قيد الطلب</h4>
          <h6>عرض/بحث الخدمات التي قيد الطلب</h6>
       </div>
    </div>
    <div class="card">
       <div class="card-body">
          <div class="table-top">
             <div class="search-set">
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
          <div class="table-responsive">
             <table class="table  datanew">
                <thead>
                   <tr>
                      <th>اٍسم الخدمة</th>
                      <th>الدائرة</th>
                      <th>اٍسم المستفيد</th>
                      <th>رقم هوية المستفيد</th>
                      <th>الوثائق المرفقة</th>
                      <th>اٍجراءات</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($serviceRequests as $serviceRequest)

                    <tr>
                        <td>{{$serviceRequest->service->service_name}}</td>
                        <td>{{$serviceRequest->serviceCategory->name}}</td>
                        <td>{{$serviceRequest->user->name}}</td>
                        <td>{{$serviceRequest->user->pin}}</td>
                        <td>
                            @if ($serviceRequest->images->count() > 0)
                            <a href="{{ route('service-requests.download-archive', ['serviceRequest' => $serviceRequest->id]) }}">
                                <i class="fas fa-download"></i> تنزيل الوثائق
                            </a>
                            @else
                                <i class="fas fa-times"></i> لا يوجد وثائق مرفقات
                            @endif

                        </td>

                        <td>
                            <a class="me-3 confirm-text" onclick="performAccept({{$serviceRequest->id}},this)">
                                <img src="{{asset('assets/img/icons/accept.svg')}}" alt="img">
                            </a>
                           <a class="me-3 confirm-text" onclick="performReject({{$serviceRequest->id}},this)">
                           <img src="{{asset('assets/img/icons/cancel.svg')}}" alt="img">
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


@endsection

@section('js-ext')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script>

function performAccept(id,reference) {
        confirmAccept('/dashboard/service-requests/accept/'+id,{},'/dashboard/service-requests/in-progress');
    }

function performReject(id,reference) {
        confirmReject('/dashboard/service-requests/reject/'+id,{},'/dashboard/service-requests/in-progress');
    }

</script>

@endsection

