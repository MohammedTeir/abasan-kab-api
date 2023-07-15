@extends('layouts.main-layout')

@section('title', 'لوحة التحكم - الألبومات')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>قائمة الألبومات</h4>
            <h6>عرض/بحث الألبومات</h6>
        </div>
        <div class="page-btn">
            <a class="btn btn-added" href="{{route('albums.create')}}">
                <img src="{{asset('assets/img/icons/plus.svg')}}" class="me-1" alt="img">اٍضافة ألبوم
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
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th>العنوان</th>
                            <th>الوصف</th>
                            <th>اٍجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($albums as $album)
                        <tr>
                            <td>{{$album->title}}</td>
                            <td>{{$album->description}}</td>
                            <td>
                                <a class="me-3" href="{{route('albums.edit',['album'=>$album->id])}}">
                                    <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                                </a>
                                <a class="me-3 confirm-text" onclick="performDelete({{$album->id}},this)">
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
        confirmDeleteRequest('/dashboard/albums/' + id, reference, '/dashboard/albums');
    }

</script>
@endsection
