$(document).ready(function () {
    $('#search-toggle').on('click', function (e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $(target).toggle("slide", {direction: "right"}, 400);
    });

    $('#show-filter').on('click', function (e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $(target).slideToggle(200);
    });

    var editor = CKEDITOR.replace('review', {
        filebrowserUploadUrl: '/uploader/img/upload?_token=' + $('meta[name="csrf-token"]').attr('content')
    });

    $('#editor a').on( 'click', function( e ) {
        e.preventDefault();
            console.log(CKEDITOR.instances.review.getData());
    });
});
