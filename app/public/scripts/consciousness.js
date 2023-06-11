!(function ($) {

    "use strict"; // jshint ;_;

    // select stream
    $('button#stream-select').on('click', function (e) {
        e.preventDefault();
        var stream = $('select#stream-list').val();
        window.location.href = '/' + stream;
    });

    // create stream
    $('button#stream-create').on('click', function (e) {
        e.preventDefault();
        var stream = $('input#stream-name').val();
        $.post('/api/' + stream + '/create')
            .done(function (data) {
                console.log(data);
                window.location.href = '/' + stream;
            });
    });

    // create note
    $('button#note-create').on('click', function (e) {
        e.preventDefault();
        var stream = $(this).data('stream');
        $.post('/api/' + stream + '/create/note', $('form#note-form').serialize())
            .done(function () { window.location.reload(true); });
    });

    $('div.delete-note').on('click', function (e) {
        var stream = $('select#stream-list').val();
        $.post('/api/' + stream + '/delete/note', { id: $(this).data('id') })
            .done(function () { window.location.reload(true); });
    });

}(window.jQuery));
