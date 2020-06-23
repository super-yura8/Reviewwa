import Pages from './pages';

$(document).ready(function () {
    var response;

    async function getData(url) {
        response = await Pages.getReview(url);
    }

    $('.post-content').each(function () {
        if ($(this).outerHeight() === 700) {
            $(this).siblings('.open-all').append('<a class="open-rev" href="#">Читать далее</a>')
        }
    });

    $('#content').delegate('.post .open-all .open-rev', 'click', function (e) {
        e.preventDefault();
        $(this).parent().siblings('.post-content').css('max-height', 'none');
        $(this).parent().remove();
    });

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


    $('#editor a').on('click', function (e) {
        var data = new FormData();
        data.append('content', CKEDITOR.instances.review.getData());
        e.preventDefault();
        $.ajax({
            url: 'uploader/review/upload?_token=' + $('meta[name="csrf-token"]').attr('content'),
            method: 'post',
            data: {
                title: $('#editor input').val(),
                content: CKEDITOR.instances.review.getData()
            },
            success: function (data) {
                alert(data.message);
            }
        })
    });
    var height = $('#content').height();
    var pageUrl = 'http://reviewwa/public/Reviews?page=2';
    $(document).on('scroll', function () {
        var url = new URL(window.location.href);
        if (url.pathname == '/') {

            if ($(document).height() - height < $(document).scrollTop()) {
                if (pageUrl) {
                    getData(pageUrl);
                    if (response) {
                        pageUrl = response.next_page_url;
                        var data = response.data;
                        var content = '';
                        data.map((el) => {
                            var date = new Date(el.created_at);
                            var formatted_date = date.getDate() + "-" + date.getMonth() + "-" + date.getFullYear();
                            content = content + '<div id="' + el.id + '" class="card mb-4 post">\n' +
                                '            <div class="card-body post-content">\n' +
                                '                <h2 class="card-title">' + el.title + '</h2>\n' +
                                '                <p class="card-text">\n' +
                                '                    ' + el.content + '\n' +
                                '                    <span style="display: none"></span>\n' +
                                '                </p>\n' +
                                '            </div>\n' +
                                '            <div class="card-body open-all">\n' +
                                '            </div>\n' +
                                '            <div class="card-footer text-muted">\n' +
                                '                <p class="float-left m-0">\n' +
                                '                    дата публикации: ' + formatted_date + '\n' +
                                '                </p>\n' +
                                '                <p class="float-left ml-1 mr-1 mb-0">\n' +
                                '                    цифра\n' +
                                '                </p>\n' +
                                '                <p class="float-left ml-1 mr-1 mb-0">\n' +
                                '                    <i font class="far fa-heart" style="font-size: 1.4em;"></i>\n' +
                                '                </p>\n' +
                                '                <p class="float-left ml-1 mr-1 mb-0">\n' +
                                '                    цифра\n' +
                                '                </p>\n' +
                                '                <p class="float-left ml-1 mr-1 mb-0">\n' +
                                '                    <i class="far fa-comment-alt" style="font-size: 1.4em;"></i>\n' +
                                '                </p>\n' +
                                '                <p class="float-right ml-1 mr-1 mb-0">' + el.user_id + '</p>\n' +
                                '            </div>\n' +
                                '        </div>'
                        });
                        $('#content').append(content);
                        data.forEach(el => {
                            if ($('div#' + el.id + '.post .post-content').outerHeight() === 700) {
                                $('div#' + el.id + '.post .open-all').append('<a class="open-rev" href="#">' +
                                    'Читать далее</a>')
                            }
                        });
                        content = '';
                        data = [];
                    }
                }

            }
        }
    });
});
