@extends('layouts.main-layout')

@section('title',' لوحة التحكم - الشكاوي')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>قائمة الشكاوي المغلقة</h4>
          <h6>عرض/بحث الشكاوي المغلقة</h6>
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
                      <th>الاٍسم</th>
                      <th>رقم الهوية</th>
                      <th>رقم الجوال</th>
                      <th>الدائرة</th>
                      <th>عنوان الشكوى</th>
                      <th>الحالة</th>
                      <th>اٍجراءات</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($complaints as $complaint)

                    <tr>
                        <td>{{$complaint->user->name}}</td>
                        <td>{{$complaint->user->pin}}</td>
                        <td>{{$complaint->user->phone}}</td>
                        <td>{{$complaint->department->name}}</td>
                        <td>{{$complaint->complaint_title}}</td>
                        <td>
                            @if ($complaint->status === 'open')
                                <span class="badges bg-lightgreen">مفتوحة</span>
                            @elseif ($complaint->status === 'in progress')
                                <span class="badges bg-warning">قيد المراجعة</span>
                            @elseif ($complaint->status === 'closed')
                                <span class="badges bg-danger">مغلقة</span>
                            @endif
                        </td>

                        <td>
                            <a class="me-3 confirm-text" onclick="markInProgress({{$complaint->id}},this)">
                                <img src="{{asset('assets/img/icons/accept.svg')}}" alt="img">
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


function markInProgress(complaintId) {
    putRequest(`/dashboard/complaints/${complaintId}/mark-in-progress`,{},'/dashboard/complaints')
}








</script>

@endsection

