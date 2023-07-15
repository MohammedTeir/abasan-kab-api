<div class="modal fade" id="updateMemberModal" tabindex="-1" aria-labelledby="updateMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateMemberModalLabel">تعديل العضو</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <input type="hidden" id="update_member_id" name="update_member_id">

            <div class="mb-3">
              <label for="update_member_name" class="col-form-label">الاسم:</label>
              <input type="text" class="form-control" id="update_member_name" name="update_member_name">
            </div>

            <div class="mb-3">
              <label for="update_member_position" class="col-form-label">المنصب:</label>
              <input type="text" class="form-control" id="update_member_position" name="update_member_position">
            </div>

            <div class="mb-3">
              <label for="update_member_mobile_number" class="col-form-label">رقم الجوال:</label>
              <input type="text" class="form-control" id="update_member_mobile_number" name="update_member_mobile_number">
            </div>

            <div class="mb-3">
              <label for="update_cv_file" class="col-form-label">ملف السيرة الذاتية:</label>
              <input type="file" class="form-control" id="update_cv_file" name="update_cv_file">
            </div>

            <div class="mb-3">
              <label for="update_image_file" class="col-form-label">الصورة الشخصية:</label>
              <input type="file" class="form-control" id="update_image_file" name="update_image_file">
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
          <button type="button" class="btn btn-primary" onclick="performUpdate()">تحديث</button>
        </div>
      </div>
    </div>
  </div>
