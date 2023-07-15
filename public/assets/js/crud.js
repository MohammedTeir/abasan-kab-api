
// Start Create Item
function postRequest(url, data,redirectUrl = null) {
    axios.post(url, data)
    .then(function (response) {
        // handle success
        toastr.success(response.data.message);

        setTimeout(function() {
            if (redirectUrl) {
                window.location.href = redirectUrl;
            }
        }, 1000);

    })
    .catch(function (error) {
        // handle error
        toastr.error(error.response.data.message);
    })
}
// End Create Item




// Start Update Item
function putRequest(url, data,redirectUrl = null) {
    axios.put(url, data).then(function (response) {
        // handle success
        toastr.success(response.data.message);

        setTimeout(function() {
            if (redirectUrl) {
                window.location.href = redirectUrl;
            }
        }, 1000);

    }).catch(function (error) {
        // handle error
        toastr.error(error.response.data.message);
    })
}
// End Update Item


// Start Delete Item
function confirmDeleteRequest(url, reference, redirectUrl = null) {

    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: 'لن تتمكن من التراجع عن هذا!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم، احذفه!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteRequest(url, reference, redirectUrl);
        }
    })
}


function confirmDeleteManyRequest(url , {data} , reference,redirectUrl = null) {

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteManyRequest(url, {data} , reference,redirectUrl);
        }
    })
}

function deleteManyRequest(url, {data} , reference,redirectUrl = null) {
    axios.delete(url,{data}).then(function (response) {
        // handle success

        toastr.success(response.data.message);

        // Delay the redirection by 3 seconds
        setTimeout(function() {
            if (redirectUrl) {
                window.location.href = redirectUrl;
            }
        }, 100);

        if (redirectUrl=='/dashboard/roles') {
            reference.closest('.card').remove();
        } else {
            reference.closest('tr').remove();
        }

    }).catch(function (error) {
        // handle error
        toastr.error(error.response.data.message);
    });
}

function deleteRequest(url, reference,redirectUrl = null) {
    axios.delete(url).then(function (response) {
        // handle success

        toastr.success(response.data.message);

        // Delay the redirection by 3 seconds
        setTimeout(function() {
            if (redirectUrl) {
                window.location.href = redirectUrl;
            }
        }, 100);

        if (redirectUrl=='/dashboard/roles') {
            reference.closest('.card').remove();
        } else {
            reference.closest('tr').remove();
        }

    }).catch(function (error) {
        // handle error
        toastr.error(error.response.data.message);
    });
}

// End Delete Item
function confirmAccept(url, data = {} ,redirectUrl = null) {
    // Show confirmation message
    Swal.fire({
        title: 'تأكيد القبول',
        text: 'هل أنت متأكد أنك تريد قبول هذا الطلب؟',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم',
        cancelButtonText: 'إلغاء',
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform the accept request
            putRequest(url, data,redirectUrl);
        }
    });
}

function confirmReject(url, data = {}, redirectUrl = null) {
    Swal.fire({
        title: 'تأكيد الرفض',
        text: 'هل أنت متأكد أنك تريد رفض هذا الطلب؟',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم',
        cancelButtonText: 'إلغاء',
        input: 'textarea', // Add an input field for the rejection reason
        inputLabel: 'سبب الرفض',
        inputPlaceholder: 'أدخل سبب الرفض',
        inputAttributes: {
            'aria-label': 'سبب الرفض'
        },
        inputValidator: (value) => {
            // Validate that the rejection reason is not empty
            if (!value) {
                return 'يرجى إدخال سبب الرفض';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Get the rejection reason from the Swal input field
            const rejectionReason = result.value;

            // Add the rejection_reason to the data object
            data = {
                rejection_reason: rejectionReason
            };

            // Perform the reject request
            putRequest(url, data, redirectUrl);
        }
    });
}

