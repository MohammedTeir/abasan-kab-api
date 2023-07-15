<div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateCategoryModalLabel">تعديل التصنيف</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <input type="hidden" id="category_id">
            <div class="mb-3">
              <label for="category_name_edit" class="col-form-label">الاٍسم:</label>
              <input type="text" class="form-control" id="category_name_edit" value="">
            </div>
          </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="performUpdate()">حفظ التغييرات</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اٍغلاق</button>
        </div>
      </div>
    </div>
  </div>
