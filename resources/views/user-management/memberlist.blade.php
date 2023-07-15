@extends('layouts.main-layout')

@section('title',' لوحة التحكم - أعضاء البلدية')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>قائمة أعضاء البلدية</h4>
          <h6>عرض/بحث أعضاء البلدية</h6>
       </div>
       <div class="page-btn">
          <a data-bs-toggle="modal"
          data-bs-target="#addMemberModal" class="btn btn-added">
          <img src="{{asset('assets/img/icons/plus.svg')}}"   class="me-1" alt="img">اٍضافة عضو
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
                      <th>العضو</th>
                      <th>المنصب</th>
                      <th>رقم الجوال</th>
                      <th>السيرة الذاتية</th>
                      <th>اٍجراءات</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)

                    <tr>
                        <td class="productimgname">
                            <a href="javascript:void(0);" class="product-img">
                            <img src="{{$member->imageurl}}" alt="member">
                            </a>
                            <a href="javascript:void(0);">{{$member->name}}</a>
                         </td>

                        <td>{{$member->position}}</td>
                        <td>{{$member->mobile_number}}</td>
                        <td><a href="{{$member->cvurl}}">اٍضغط هنا لعرض السيرة الذاتية</a></td>
                        <td>
                           <a class="me-3" data-bs-toggle="modal"
                           data-bs-target="#updateMemberModal" data-member_id="{{$member->id}}" data-member_name="{{$member->name}}" data-member_mobile_number="{{$member->mobile_number}}" data-member_position="{{$member->position}}">
                           <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                           </a>
                           <a class="me-3 confirm-text" onclick="performDelete({{$member->id}},this)">
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

 @include('modals.user-management.members.addMember')
 @include('modals.user-management.members.updateMember')
@endsection

@section('js-ext')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script>


$('#updateMemberModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var memberId = button.data('member_id');
  var memberName = button.data('member_name');
  var memberPosition = button.data('member_position');
  var memberMobileNumber = button.data('member_mobile_number');

  var modal = $(this);
  modal.find('#update_member_id').val(memberId);
  modal.find('#update_member_name').val(memberName);
  modal.find('#update_member_position').val(memberPosition);
  modal.find('#update_member_mobile_number').val(memberMobileNumber);
});


function performAdd() {
    // Get form input values
    var name = document.getElementById('member_name').value;
    var position = document.getElementById('member_position').value;
    var mobileNumber = document.getElementById('member_mobile_number').value;
    var cvFile = document.getElementById('cv_file').files[0];
    var imageFile = document.getElementById('image_file').files[0];

    // Create form data object
    var formData = new FormData();
    formData.append('name', name);
    formData.append('position', position);
    formData.append('mobile_number', mobileNumber);

    // Append CV file if not null
    if (cvFile) {
        formData.append('cv_file', cvFile);
    }

    // Append image file if not null
    if (imageFile) {
        formData.append('image_file', imageFile);
    }

    postRequest('/dashboard/members/', formData, '/dashboard/members');
}

function performUpdate() {
    // Get form input values
    var memberId = document.getElementById('update_member_id').value;
    var name = document.getElementById('update_member_name').value;
    var position = document.getElementById('update_member_position').value;
    var mobileNumber = document.getElementById('update_member_mobile_number').value;
    var cvFile = document.getElementById('update_cv_file').files[0];
    var imageFile = document.getElementById('update_image_file').files[0];

    // Create form data object
    var formData = new FormData();
    formData.append('name', name);
    formData.append('position', position);
    formData.append('mobile_number', mobileNumber);

    // Append CV file if not null
    if (cvFile) {
        formData.append('cv_file', cvFile);
    }

    // Append image file if not null
    if (imageFile) {
        formData.append('image_file', imageFile);
    }

    // Perform PUT request to update the member
    postRequest(`/dashboard/members/${memberId}`, formData, '/dashboard/members');
}



    function performDelete(id,reference) {
        confirmDeleteRequest('/dashboard/members/'+id,reference,'/dashboard/members');
    }

</script>

@endsection

