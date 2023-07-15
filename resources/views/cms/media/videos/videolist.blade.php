@extends('layouts.main-layout')

@section('title',' لوحة التحكم - الفيديوهات')

@section('css-ext')



@endsection

@section('content')
<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>قائمة الفيديوهات</h4>
          <h6>عرض/بحث الفيديوهات</h6>
       </div>
       <div class="page-btn">
          <a data-bs-toggle="modal"
          data-bs-target="#addVideoModal" class="btn btn-added">
          <img src="{{asset('assets/img/icons/plus.svg')}}"   class="me-1" alt="img">اٍضافة فيديو
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
                      <th>العنوان</th>
                      <th>الوصف</th>
                      <th>اٍجراءات</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($videos as $video)

                    <tr>
                        <td>{{$video->title}}</td>
                        <td>{{$video->description}}</td>
                       
                        <td>
                           <a class="me-3" data-bs-toggle="modal"
                           data-bs-target="#updateVideoModal" data-video_id="{{$video->id}}" data-video_title="{{$video->title}}" data-video_embed="{{$video->video->url}}" data-video_description="{{$video->description}}" >
                           <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                           </a>
                           <a class="me-3 confirm-text" onclick="performDelete({{$video->id}},this)">
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

 @include('modals.cms.media.videos.addVideo')
 @include('modals.cms.media.videos.updateVideo')
@endsection

@section('js-ext')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script>


    $('#updateVideoModal').on('show.bs.modal', function (event) {


        var button = $(event.relatedTarget)

        var videoId = button.data('video_id');
        var videoTitle = button.data('video_title');
        var videoDescription = button.data('video_description');
        var videoEmbed = button.data('video_embed');


        var modal = $(this);

        modal.find('.modal-body #video-id-edit').val(videoId);
        modal.find('.modal-body #video-title-edit').val(videoTitle);
        modal.find('.modal-body #video-description-edit').val(videoDescription);
        modal.find('.modal-body #video-embed-code-edit').val(videoEmbed);


    });


    function performAdd() {

        let formData = new FormData();

        formData.append('title', document.getElementById('video-title').value);
        formData.append('description', document.getElementById('video-description').value);
        formData.append('embed_code', document.getElementById('embed-code').value);


        postRequest('/dashboard/videos',formData,'/dashboard/videos');
    }

    function performUpdate() {

        var id = document.getElementById('video-id-edit').value;

        let formData = new FormData();

        formData.append('title', document.getElementById('video-title-edit').value);
        formData.append('description', document.getElementById('video-description-edit').value);
        formData.append('embed_code', document.getElementById('video-embed-code-edit').value);



        postRequest('/dashboard/videos/' + id, formData, '/dashboard/videos');
    }


    function performDelete(id,reference) {
        confirmDeleteRequest('/dashboard/videos/'+id,reference,'/dashboard/videos');
    }

</script>

@endsection

