<div class="modal fade" id="updateDocumentModal" tabindex="-1" aria-labelledby="updateDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateDocumentModalLabel">تحديث مستند</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <input type="hidden" id="document_id">
            <div class="mb-3">
              <label for="document_name_edit" class="col-form-label">الاٍسم:</label>
              <input type="text" class="form-control" id="document_name_edit">
            </div>

            <div class="form-group">
                <label for="document_category_edit" class="col-form-label">التصنيف:</label>
                <select class="form-select" id="document_category_edit">
                   @foreach ($categories as $category)

                   <option value="{{$category->id}}" >{{$category->name}}</option>

                   @endforeach
                </select>
             </div>

             <div class="mb-3">
                <label for="document-file-edit" class="col-form-label">المستند:</label>
                <input type="file" class="form-control" id="document_file_edit">
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اٍغلاق</button>
          <button type="button" class="btn btn-primary" onclick="performUpdate()">حفظ التغييرات</button>
        </div>
      </div>
    </div>
  </div>
