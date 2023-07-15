@extends('layouts.main-layout')

@section('title',' لوحة التحكم - المستندات')

@section('css-ext')
@endsection

@section('content')
<div class="content">
    <div class="page-header">
       <div class="page-title">
          <h4>قائمة المستندات</h4>
          <h6>عرض/بحث المستندات</h6>
       </div>
       <div class="page-btn">
          <a data-bs-toggle="modal"
          data-bs-target="#addDocumentModal" class="btn btn-added">
          <img src="{{asset('assets/img/icons/plus.svg')}}"   class="me-1" alt="img">اٍضافة مستند
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
                         <select class="form-select" id="category-filter">
                            @foreach ($categories as $category)

                            <option value="{{$category->id}}">{{$category->name}}</option>

                            @endforeach
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
                      <th>المستند</th>
                      <th>التصنيف</th>
                      <th>رابط المستند</th>
                      <th>اٍجراءات</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)

                    <tr>
                        <td>{{$document->name}}</td>
                        <td>{{$document->category->name}}</td>
                        <td><a href="{{$document->doc_url}}">اٍضغط هنا لعرض المستند</a></td>
                        <td>
                           <a class="me-3" data-bs-toggle="modal"
                           data-bs-target="#updateDocumentModal" data-document_id="{{$document->id}}" data-document_name="{{$document->name}}" data-category_id="{{$document->document_category_id}}">
                           <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                           </a>
                           <a class="me-3 confirm-text" onclick="performDelete({{$document->id}},this)">
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

 @include('modals.cms.documents.addDocument')
 @include('modals.cms.documents.updateDocument')
@endsection

@section('js-ext')
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script>


    $('#updateDocumentModal').on('show.bs.modal', function (event) {


    var button = $(event.relatedTarget)

    var docid = button.data('document_id');
    var catid = button.data('category_id');
    var docname = button.data('document_name');

    var modal = $(this);

    modal.find('.modal-body #document_id').val(docid);
    modal.find('.modal-body #document_category_edit').val(catid);
    modal.find('.modal-body #document_name_edit').val(docname);

    });


    function performAdd() {
        let documentFile = document.getElementById('document-file').files[0];

        let formData = new FormData();

        formData.append('name', document.getElementById('document-name').value);
        formData.append('document', documentFile);
        formData.append('document_category_id', document.getElementById('document-category').value);


        postRequest('/dashboard/documents',formData,'/dashboard/documents');
    }

    function performUpdate() {
    var id = document.getElementById("document_id").value;

    let formData = new FormData();

    formData.append('name', document.getElementById('document_name_edit').value);
    formData.append('document_category_id', document.getElementById('document_category_edit').value);

    let documentFile = document.getElementById('document_file_edit').files[0];
    if (documentFile) {
        formData.append('document', documentFile);
    }

    postRequest('/dashboard/documents/' + id, formData, '/dashboard/documents');
    }


    function performDelete(id,reference) {
        confirmDeleteRequest('/dashboard/documents/'+id,reference,'/dashboard/documents');
    }

</script>

@endsection

