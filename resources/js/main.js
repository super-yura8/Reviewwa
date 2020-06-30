import Pages from './pages';

$(document).ready(function () {
    //add user function
    $('#addUser').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'addUser/add',
            method: 'post',
            data: $(this).serialize(),
            success: function (data) {
                alert('пользователь ' + data.userName + ' успешно создан');
            },
            error: function (data) {
                var errors = data.responseJSON.errors;
                var error;
                for (error in errors) {
                    alert(errors[error]);
                }
            }
        })
    });

    //filling out the ban form
    $('td').delegate('.banBtn', 'click', function () {
        var id = $(this).parent().parent().find('.user-id').html();
        $('#banForm').find('input[name=id]').attr('value', id);
    });

    //filling out the change form
    $('td').delegate('.changeBtn', 'click', function () {
        var id = $(this).parent().parent().find('.user-id').html();
        var name = $(this).parent().parent().find('.user-name').html();
        var email = $(this).parent().parent().find('.user-email').html();
        $('#changeForm').find('input[name=id]').attr('value', id);
        $('#changeForm').find('div input[name=name]').val(name);
        $('#changeForm').find('div input[name=email]').val(email);
    });

    //ban user function
    $('#banForm form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'ban/user',
            method: 'post',
            data: $(this).serialize(),
            success: function (data) {
                var button = $('td[class=user-id][data-id=' + data.userId + ']').parent().find('td a.banBtn');
                button.removeClass(['banBtn', 'btn-danger']);
                button.addClass(['unbanBtn', 'btn-success']);
                button.removeAttr('data-fancybox');
                button.removeAttr('data-src');
                button.removeAttr('data-modal');
                $.fancybox.close('#banForm');
            },
            error: function (data) {
                var errors = data.responseJSON.errors;
                var error;
                for (error in errors) {
                    alert(errors[error]);
                }
            }
        })
    });

    //unban user function
    $('td').delegate('.unbanBtn', 'click', function (e) {
        var button = $(this);
        e.preventDefault();
        var id = $(this).parent().parent().find('.user-id').html();
        $.ajax({
            url: 'unban/user/' + id,
            method: 'get',
            success: function (data) {
                button.addClass(['banBtn', 'btn-danger']);
                button.removeClass(['unbanBtn', 'btn-success']);
                button.attr({'data-fancybox': '', 'data-src': '#banForm', 'data-modal': 'true'});
                $.fancybox.close('#banForm');
            }
        })
    });

    //change user info function
    $('#changeForm form').on('submit', function (e) {
        e.preventDefault();
        var id = $(this).find('[name=id]').attr('value');
        $.ajax({
            url: 'update/user/' + id,
            method: 'put',
            data: $(this).serialize(),
            success: function (data) {
                var el;
                var tr = $('td[class=user-id][data-id=' + id + ']').parent();
                for (el in data) {
                    tr.find('td[class=user-' + el + ']').html(data[el]);
                }
                $.fancybox.close('#changeForm');
            },
            error: function (data) {
                alert('Ошибка');
                $.fancybox.close('#changeForm');
            }
        })
    });

    $('.user-reviews').on('click', function () {
        var userName = $(this).siblings('.user-name').html();
        $.ajax({
            url: 'reviews/' + userName,
            success: function (data) {
                window.history.pushState({}, '', 'reviews/' + userName);
                $('body').html(data);
            }
        });
        // var url = document.location;
        // url.pathname = '/admin/reviews/' + userName;

    });

    $.fancybox.defaults.hash = false;

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

    $('#content').delegate('.post .footer .like', 'click', function () {
        var el = $(this);
        var id = el.parent().parent().attr('id');
        var like = el.siblings('.like-count');
        $.ajax({
            url: 'like/' + id,
            success: function (data) {
                if (data.action == 'like') {
                    like.html(Number(like.html()) + 1);
                    el.find('i').attr('class', 'fa fa-heart')


                }
                else {
                    like.html(Number(like.html()) - 1);
                    el.find('i').attr('class', 'far fa-heart')
                }
            }
        });
    })
});

