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
        filebrowserUploadUrl: '/uploader/img/upload?_token=' + $('meta[name="csrf-token"]').attr('content'),
        filebrowserWindowWidth : '1000',
        filebrowserWindowHeight : '700'
    });

    $('#editor a').on( 'click', function( e ) {
        var data = new FormData();
        data.append('content',CKEDITOR.instances.review.getData());
        e.preventDefault();
            console.log(CKEDITOR.instances.review.getData());
            $.ajax({
                url: 'uploader/review/upload?_token=' + $('meta[name="csrf-token"]').attr('content'),
                method: 'post',
                data: {
                    title: '<h2>'+$('#editor input').val()+'</h2>',
                    content: CKEDITOR.instances.review.getData()},
                success: function (data) {
                    alert('success');
                }
            })
    });
});
