@extends('layouts.main-layout')
@section('title','لوحة التحكم - مستخدمين النظام')
@section('css-ext')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection
@section('content')
<div class="content">
   <div class="page-header">
      <div class="page-title">
         <h4>قائمة المستخدمين</h4>
         <h6>اٍدارة المستخدمين</h6>
      </div>
      <div class="page-btn">
         <a href="{{route('admins.create')}}" class="btn btn-added"><img src="{{asset('assets/img/icons/plus.svg')}}" alt="img">اٍضافة مستخدم</a>
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
                        <input type="text" placeholder="الاٍسم">
                     </div>
                  </div>
                  <div class="col-lg-2 col-sm-6 col-12">
                     <div class="form-group">
                        <input type="text" placeholder="رقم الجوال">
                     </div>
                  </div>
                  <div class="col-lg-2 col-sm-6 col-12">
                     <div class="form-group">
                        <input type="text" placeholder="البريد الاٍلكتروني">
                     </div>
                  </div>

                  <div class="col-lg-2 col-sm-6 col-12">
                    <div class="form-group">
                        <select class="form-select" id="admin-status">
                            <option selected value="">نشط</option>
                            <option value="">مقيد</option>
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
                     <th>البريد الاٍلكتروني</th>
                     <th>الدور</th>
                     <th>تاريخ الانضمام</th>
                     <th>اخر دخول</th>
                     <th>الحالة</th>
                     <th>اٍجراءات</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($admins as $admin)
                  <tr>
                    <td>{{$admin->name}}</td>
                    <td>{{$admin->email}}</td>
                    <td>{{optional($admin->role)->name}}</td>
                    <td>{{$admin->joined_date}}</td>
                    <td>{{$admin->last_login}}</td>
                    @if ($admin->status=="active")
                    <td><span class="bg-lightgreen badges">نشط</span></td>
                    @else
                    <td><span class="bg-lightred badges">مقيد</span></td>
                    @endif
                    <td>
                       @if ($admin->status=="active")
                       <a class="me-3" onclick="performRestrict({{ $admin->id }}, this)">
                       <img src="{{asset('assets/img/icons/lock.svg')}}" alt="img">
                       </a>
                       @else
                       <a class="me-3" onclick="performRestore({{ $admin->id }}, this)">
                       <img src="{{asset('assets/img/icons/unlock.svg')}}" alt="img">
                       </a>
                       @endif
                       <a class="me-3 confirm-text" onclick="performDelete({{$admin->id }}, this)">
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
@endsection
@section('js-ext')
<script data-cfasync="false" src="{{asset('assets/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script><script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/js/moment.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script>
   function performDelete(id,reference) {
               confirmDeleteRequest('/dashboard/admins/'+id,reference,'/dashboard/admins');
           }

   function performRestore(id,reference) {
               putRequest(`/dashboard/admins/${id}/restore/`,reference,'/dashboard/admins');
           }

   function performRestrict(id,reference) {
               putRequest(`/dashboard/admins/${id}/restrict/`,reference,'/dashboard/admins');
           }

</script>
@endsection
