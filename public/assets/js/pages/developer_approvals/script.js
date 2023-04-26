$(function() {
    $('#da-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: routeList,
        columns: [
            {
                data: 'rownum',
                name: 'rownum'
            },
            {
                data: 'developer_id',
                name: 'developer_id'
            },
            {
                data: 'imb',
                name: 'imb'
            },
            {
                data: 'phone_number',
                name: 'phone_number'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    $('#da-table').on('click', '.btn-delete[data-remote]', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = $(this).data('remote');
        console.log(url);
        // confirm then
        $.ajax({
            url: url,
            type: 'DELETE',
            dataType: 'json',
            data: {
                method: '_DELETE',
                submit: true
            }
        }).always(function(data) {
            $('#da-table').DataTable().draw(false);
        });
    })
});
