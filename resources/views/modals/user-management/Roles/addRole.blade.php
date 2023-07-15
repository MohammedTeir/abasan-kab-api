<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addRoleModalLabel">اٍضافة دور جديد</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="role-name" class="col-form-label">الاٍسم:</label>
              <input type="text" class="form-control" id="role-name">
            </div>
            <div class="mb-3">
              <label for="role-description" class="col-form-label">الوصف:</label>
              <textarea class="form-control" id="role-description"></textarea>
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
