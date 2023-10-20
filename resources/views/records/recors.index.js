$('.record-status').on('click', function () {
    const checkbox = $(this);
    const recordId = checkbox.data('record-id');
    const isChecked = checkbox.is(':checked');

    updateRecordStatus(recordId, isChecked)
        .then(() => logRecordStatusChange(recordId, isChecked))
        .catch((error) => handleAjaxError(error));

    checkbox.prop('checked', isChecked);
});

function updateRecordStatus(recordId, isChecked) {
    const updateUrl = checkbox.data('update-url');
    const data = {
        record_id: recordId,
        record_status: isChecked ? 1 : 0,
    };

    return makeAjaxRequest('POST', updateUrl, data);
}

function logRecordStatusChange(recordId, isChecked) {
    const data = {
        record_id: recordId,
        new_status: isChecked ? 1 : 0,
        action: 'Status changed',
    };

    return makeAjaxRequest('POST', '{{ route('log.add') }}', data);
}

function makeAjaxRequest(type, url, data) {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    return $.ajax({
        type: type,
        url: url,
        data: {
            ...data,
            _token: csrfToken,
        },
    });
}

function handleAjaxError(error) {
    console.error(error);
}
