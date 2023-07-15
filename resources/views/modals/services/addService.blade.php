<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addServiceModalLabel">اٍضافة خدمة</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>

            <div class="mb-3">
              <label for="service-name" class="col-form-label">الاٍسم:</label>
              <input type="text" class="form-control" id="service-name">
            </div>

            <div class="mb-3">
                <label for="service-price" class="col-form-label">السعر:</label>
                <input type="text" class="form-control" id="service-price">
              </div>

            <div class="mb-3">
                <label for="service-required_time" class="col-form-label">الوقت المطلوب:</label>
                <input type="text" class="form-control" id="service-required_time">
              </div>


            <div class="mb-3">
                <label for="service-required_documents" class="col-form-label">الوثائق المطلوبة:</label>
                <textarea class="form-control" id="service-required_documents" name="service-required_documents" rows="5" required ></textarea>
            </div>


            <div class="form-group">
                <label for="service-category" class="col-form-label">الدائرة:</label>

                <select class="form-select" id="service-category">
                   @foreach ($categories as $category)

                   <option value="{{$category->id}}">{{$category->name}}</option>

                   @endforeach
                </select>
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
