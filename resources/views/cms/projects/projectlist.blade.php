@extends('layouts.main-layout')

@section('title', 'لوحة التحكم - المشاريع')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>قائمة المشاريع</h4>
            <h6>عرض/بحث المشاريع</h6>
        </div>
        <div class="page-btn">
            <a class="btn btn-added" href="{{route('projects.create')}}">
                <img src="{{asset('assets/img/icons/plus.svg')}}" class="me-1" alt="img">اٍضافة مشروع
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
                                <label for="is_featured_filter">التصنيف</label>
                                <select class="form-select" id="is_featured_filter">
                                    <option value="1">مشاريع مستقبلية</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                            <div class="form-group">
                                <a class="btn btn-filters ms-auto" id="filter_btn" href="#"><img src="{{asset('assets/img/icons/search-whites.svg')}}" alt="img"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th>العنوان</th>
                            <th>التصنيف</th>
                            <th>اٍجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                        <tr>
                            <td>{{$project->title}}</td>
                            <td>{{$project->category->name}}</td>
                            <td>
                                <a class="me-3" href="{{route('projects.edit',['project'=>$project->id])}}">
                                    <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                                </a>
                                <a class="me-3 confirm-text" onclick="performDelete({{$project->id}},this)">
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
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>

<script>
    function performDelete(id, reference) {
        confirmDeleteRequest('/dashboard/projects/' + id, reference, '/dashboard/projects');
    }

</script>
@endsection
