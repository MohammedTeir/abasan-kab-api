<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addDocumentModalLabel">اٍضافة مستند</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="document-name" class="col-form-label">الاٍسم:</label>
              <input type="text" class="form-control" id="document-name">
            </div>

            <div class="form-group">
                <label for="document-category" class="col-form-label">التصنيف:</label>

                <select class="form-select" id="document-category">
                   @foreach ($categories as $category)

                   <option value="{{$category->id}}">{{$category->name}}</option>

                   @endforeach
                </select>
             </div>

             <div class="mb-3">
                <label for="document-file" class="col-form-label">المستند:</label>
                <input type="file" class="form-control" id="document-file">
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اٍغلاق</button>
          <button type="button" class="btn btn-primary" onclick="performAdd()">اٍضافة</button>
        </div>
      </div>
    </div>
  </div>
