function edit_event_ajax(id, date_at, time_at, time_end) {
    var params = {
        "id": id,
        "date_at": date_at,
        "time_at": time_at,
        "time_end": time_end
    };
    if (date_at) {
        $.ajax({
            data: params,
            url: 'index.php?action=update.reservation.ajax',
            type: 'POST'
        });
    }
}