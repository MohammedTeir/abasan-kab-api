<div class="modal fade" id="updateVideoModal" tabindex="-1" aria-labelledby="updateVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateVideoModalLabel">تحديث الفيديو</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <input type="hidden" id="video-id-edit">
            <div class="mb-3">
              <label for="video-title" class="col-form-label">العنوان:</label>
              <input type="text" class="form-control" id="video-title-edit">
            </div>

            <div class="mb-3">
                <label for="description" class="col-form-label">الوصف:</label>
                <textarea class="form-control" id="video-description-edit" name="video-description-edit" rows="5" required style="background-color: #F3F4F6; color: #000000;"></textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="col-form-label">رمز التضمين الخاص ب الفيديو:</label>
                <textarea class="form-control" id="video-embed-code-edit" name="video-embed-code-edit" rows="5" required style="background-color: #F3F4F6; color: #000000;"></textarea>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اٍغلاق</button>
          <button type="button" class="btn btn-primary" onclick="performUpdate()">تحديث</button>
        </div>
      </div>
    </div>
  </div>
