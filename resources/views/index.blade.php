
@extends('layouts.main-layout')

@section('title','لوحة التحكم - الصفحة الرئيسية')

@section('content')


<div class="content">
    <div class="row">



       <div class="col-lg-3 col-sm-6 col-12 d-flex">
          <div class="dash-count das1">
             <div class="dash-counts">
                <h4>عدد المواطنين</h4>
                <h5>{{$totalUsers}}</h5>
             </div>
             <div class="dash-imgs">
                <i data-feather="users"></i>
             </div>
          </div>
       </div>

       <div class="col-lg-3 col-sm-6 col-12 d-flex">
        <div class="dash-count">
           <div class="dash-counts">
              <h4>عدد الأخبار</h4>
              <h5>{{$totalNews}}</h5>
           </div>
           <div class="dash-imgs">
              <i data-feather="globe"></i>
           </div>
        </div>
     </div>

       <div class="col-lg-3 col-sm-6 col-12 d-flex">
          <div class="dash-count das2">
             <div class="dash-counts">
                <h4>عدد المشاريع</h4>
                <h5>{{$totalProjects}}</h5>
             </div>
             <div class="dash-imgs">
                <i data-feather="trending-up"></i>
             </div>
          </div>
       </div>
       <div class="col-lg-3 col-sm-6 col-12 d-flex">
          <div class="dash-count das3">
             <div class="dash-counts">
                <h4>عدد الوظائف المتوفرة</h4>
                <h5>{{$totalVacanicies}}</h5>
             </div>
             <div class="dash-imgs">
                <i data-feather="briefcase"></i>
             </div>
          </div>
       </div>
    </div>

    <div class="card mb-0">
       <div class="card-body">
          <h4 class="card-title">أخر المستندات المضافة</h4>
          <div class="table-responsive dataview">
             <table class="table datatable ">
                <thead>
                   <tr>
                      <th>الاٍسم</th>
                      <th>القسم</th>
                      <th>المستند</th>
                      <th>تاريخ الاٍضافة</th>

                   </tr>
                </thead>
                <tbody>
                    @foreach ($recentDocuments as $document)
                    <tr>
                        <td>{{$document->name}}</td>
                        <td>{{$document->category->name}}</td>
                        <td><a href="{{$document->doc_url}}">اضغط هنا لرؤية المستند</a></td>
                        <td>{{$document->createddate}}</td>
                    @endforeach
                 </tr>
                </tbody>
             </table>
          </div>
       </div>
    </div>


    <div class="card mb-0">
        <div class="card-body">
           <h4 class="card-title">أخر المشاريع المضافة</h4>
           <div class="table-responsive dataview">
              <table class="table datatable">
                 <thead>
                    <tr>
                       <th>المشروع</th>
                       <th>التصنيف</th>
                       <th>تاريخ الإضافة</th>
                    </tr>
                 </thead>
                 <tbody>
                    @foreach ($latestProjects as $project)
                    <tr>
                        <td class="productimgname">
                            <a href="javascript:void(0);" class="product-img" style="width: 100px;">
                            <img src="{{$project->imagesurl[0]}}" alt="صورة المشروع">
                            </a>
                            <a href="javascript:void(0);">{{$project->title}}</a>
                         </td>
                       <td>{{$project->category->name}}</td>
                       <td>{{$project->createddate}}</td>
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
<script src="{{asset('assets/plugins/apexchart/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/plugins/apexchart/chart-data.js')}}"></script>
@endsection
