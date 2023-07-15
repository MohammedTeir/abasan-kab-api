<html>
<head>
    <style>
        /* CSS styles here */
    </style>
</head>
<body>
    <h2 class="font-monospace" style="text-align: center; font-weight: bold; background: var(--bs-light-border-subtle); border-width: 0px;">"Complaint or Request Form"</h2>
    <figure class="font-monospace" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
        <blockquote class="blockquote">
            <p style="text-align: left;">Mr./Respected Head of {{$complaint->department->name}} Department in Abasan Al-Kabira Municipality</p>
        </blockquote>
        <figcaption class="blockquote-footer" style="text-align: center;">..Peace be upon you and God's mercy and blessings</figcaption>
    </figure>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0" style="text-align: left;">Citizen Information:</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <p style="text-align: left; display: block;"><strong>Name:</strong> {{$complaint->user->name }}</p>
                    <p style="text-align: left; display: block;"><strong>Date:</strong> {{ $complaint->created_at }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p style="text-align: left; display: block;"><strong>Phone:</strong> {{ $complaint->user->phone }}</p>
                    <p style="text-align: left; display: block;"><strong>Personal id Number:</strong> {{ $complaint->user->pin }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p style="text-align: left; display: block;"><strong>Address:</strong> {{ $complaint->user->address }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0" style="text-align: left;">Complaint / Request Details:</h5>
        </div>
        <div class="card-body">
            <p style="text-align: left;" class="break-word">{{ $complaint->complaint_content }}</p>
        </div>
    </div>
</body>
</html>
