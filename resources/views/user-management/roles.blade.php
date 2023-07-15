@extends('layouts.main-layout')

@section('css-ext')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">

@endsection


@section('title','لوحة التحكم - الأدوار')



@section('content')

<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>الأدوار</h4>
          <h6>اٍدارة الأدوار</h6>
       </div>
       <div class="page-btn">


        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
            <i data-feather="plus"></i> اٍضافة دور
          </a>

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
                      <th>الدور</th>
                      <th>الوصف</th>
                      <th class="text-end">اٍجراءات</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                   <tr>

                    <td>{{$role->name}}</td>
                    <td>{{$role->description}}</td>
                    <td class="text-end">
                       <a class="me-3" href="editpermission.html">
                       <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                       </a>
                       <a class="me-3 confirm-text" onclick="performDelete({{$role->id}},this)">
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

 @include('modals.user-management.Roles.addRole')

@endsection



@section('js-ext')

<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>

<script>


    function performAdd() {
        let data = {
            role_name:document.getElementById("role-name").value,
            description:document.getElementById("role-description").value
        };
        postRequest('/dashboard/roles',data,'/dashboard/roles');
    }



    function performDelete(id,reference) {
        confirmDeleteRequest('/dashboard/roles/'+id,reference,'/dashboard/roles');
    }

</script>

@endsection
