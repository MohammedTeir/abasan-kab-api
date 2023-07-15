@extends('layouts.main-layout')

@section('title', 'لوحة التحكم - الأخبار')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>قائمة الأخبار</h4>
            <h6>عرض/بحث الأخبار</h6>
        </div>
        <div class="page-btn">
            <a class="btn btn-added" href="{{route('news.create')}}">
                <img src="{{asset('assets/img/icons/plus.svg')}}" class="me-1" alt="img">اٍضافة خبر
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
                                <label for="is_featured_filter">تمييز</label>
                                <select class="form-select" id="is_featured_filter">
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="is_published_filter">تم النشر</label>
                                <select class="form-select" id="is_published_filter">
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
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
                            <th>المشاهدات</th>
                            <th>اٍجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $newselement)
                        <tr>
                            <td>{{$newselement->title}}</td>
                            <td>{{$newselement->views}}</td>
                            <td>
                                <a class="me-3" href="{{route('news.edit',['news'=>$newselement->id])}}">
                                    <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                                </a>
                                <a class="me-3 confirm-text" onclick="performDelete({{$newselement->id}},this)">
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
        confirmDeleteRequest('/dashboard/news/' + id, reference, '/dashboard/news');
    }

    // Get the filter button element
    var filterBtn = document.getElementById('filter_btn');

    // Add click event listener to the filter button
    filterBtn.addEventListener('click', function(event) {
        event.preventDefault();

        // Get the selected values from the filter dropdowns
        var isFeaturedFilter = document.getElementById('is_featured_filter').value;
        var isPublishedFilter = document.getElementById('is_published_filter').value;

        // Construct the URL with the selected filter values
        var url = "{{route('news.filter')}}?is_featured=" + isFeaturedFilter + "&is_published=" + isPublishedFilter;

        // Redirect to the filtered URL
        window.location.href = url;
    });
</script>
@endsection
