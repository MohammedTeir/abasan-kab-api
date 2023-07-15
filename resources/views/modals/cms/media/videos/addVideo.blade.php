<div class="modal fade" id="addVideoModal" tabindex="-1" aria-labelledby="addVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addVideoModalLabel">اٍضافة فيديو</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="video-title" class="col-form-label">العنوان:</label>
              <input type="text" class="form-control" id="video-title">
            </div>

            <div class="mb-3">
                <label for="description" class="col-form-label">الوصف:</label>
                <textarea class="form-control" id="video-description" name="video-description" rows="5" required style="background-color: #F3F4F6; color: #000000;"></textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="col-form-label">رمز التضمين الخاص ب الفيديو:</label>
                <textarea class="form-control" id="embed-code" name="embed-code" rows="5" required style="background-color: #F3F4F6; color: #000000;"></textarea>
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
