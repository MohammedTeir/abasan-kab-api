@extends('layouts.main-layout')
@section('title','لوحة التحكم - المواطنين')
@section('css-ext')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('content')

<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>قائمة المواطنين</h4>
          <h6>بيانات مواطنين بلدية عبسان الكبيرة</h6>
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
                         <input type="text" placeholder="أدخل رقم الهوية">
                      </div>
                   </div>
                   <div class="col-lg-2 col-sm-6 col-12">
                      <div class="form-group">
                         <input type="text" placeholder="أدخل الاٍسم ">
                      </div>
                   </div>
                   <div class="col-lg-2 col-sm-6 col-12">
                      <div class="form-group">
                         <input type="text" placeholder="أدخل رقم الجوال">
                      </div>
                   </div>

                   <div class="col-lg-1 col-sm-6 col-12  ms-auto">
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
                      <th>رقم الهوية</th>
                      <th>العنوان</th>
                      <th>رقم الجوال</th>
                      <th>الحالة</th>
                      <th>أخر دخول</th>
                   </tr>
                </thead>
                <tbody>

                    @foreach ($users as $user)
                    <tr>
                        <td class="productimgname">
                           <a href="javascript:void(0);" class="product-img">
                           <img src="{{$user->imageurl}}" alt="user">
                           </a>
                           <a href="javascript:void(0);">{{$user->name}}</a>
                        </td>
                        <td>{{$user->pin}}</td>
                        <td>{{$user->address}}</td>
                        <td>{{$user->phone}}</td>
                        @if ($user->status=="active")
                        <td>
                            <span class="badges bg-lightgreen">مفعل</span>
                        </td>
                        @else
                        <td>
                            <span class="badges bg-danger">غير مفعل</span>
                        </td>
                        @endif
                        <td>{{$user->last_login}}</td>
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
<script data-cfasync="false" src="{{asset('assets/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script>
<script src="{{asset('assets/js/moment.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalerts.min.js')}}"></script>
@endsection
