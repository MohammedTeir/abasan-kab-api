<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addMemberModalLabel">اٍضافة عضو</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="member_name" class="col-form-label">الاٍسم:</label>
                        <input type="text" class="form-control" id="member_name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="member_position" class="col-form-label">المنصب:</label>
                        <input type="text" class="form-control" id="member_position" name="position" required>
                    </div>

                    <div class="mb-3">
                        <label for="member_mobile_number" class="col-form-label">رقم الجوال:</label>
                        <input type="text" class="form-control" id="member_mobile_number" name="mobile_number" required>
                    </div>

                    <div class="mb-3">
                        <label for="cv_file" class="col-form-label">ملف السيرة الذاتية:</label>
                        <input type="file" class="form-control" id="cv_file" name="cv_file" required>
                    </div>

                    <div class="mb-3">
                        <label for="image_file" class="col-form-label">صورة العضو:</label>
                        <input type="file" class="form-control" id="image_file" name="image_file" required>
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
