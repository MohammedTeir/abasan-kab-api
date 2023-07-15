<html>
<head>
    <style>
        /* CSS styles here */
    </style>
</head>
<body>
    <h2 class="font-monospace" style="text-align: center; font-weight: bold; background: var(--bs-light-border-subtle); border-width: 0px;">&quot;نموذج &quot;تقديم شكوى أو طلب</h2>
    <figure class="font-monospace" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
        <blockquote class="blockquote">
            <p style="text-align: right;">السيد / رئيس دائرة {{$complaint->department->name}}  المحترم في بلدية عبسان الكبيرة</p>
        </blockquote>
        <figcaption class="blockquote-footer" style="text-align: center;">..السلام عليكم ورحمة الله وبركاته</figcaption>
    </figure>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0" style="text-align: right;"> : بيانات المواطن</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <p style="text-align: right; display: block;"><strong>: الاسم</strong> {{$complaint->user->name }}</p>
                    <p style="text-align: right; display: block;"><strong> : التاريخ</strong> {{ $complaint->created_at }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p style="text-align: right; display: block;"><strong>:الهاتف</strong> {{ $complaint->user->phone }}</p>
                    <p style="text-align: right; display: block;"><strong>:رقم الهوية</strong> {{ $complaint->user->pin }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p style="text-align: right; display: block;"><strong>:العنوان</strong> {{ $complaint->user->address }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0" style="text-align: right;">تفاصيل الشكوى / الطلب</h5>
        </div>
        <div class="card-body">
            <p style="text-align: right;" class="break-word">{{ $complaint->complaint_content }}</p>
        </div>
    </div>
</body>
</html>
