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

    function formDataToObject(param)
    {
        param = param.split('&');
        let arr = [];
        param.forEach((el) => {
            if (el){
                el = el.split('=');
                let params = el[el.length - 1];
                params = params.split(',');
                let name = el[0];
                arr.push({name: name, value: params!= false  ? params : []});
            }

        });
        return arr;
    }

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    function parseDate(date) {
        var date = new Date(date);
        var formatedDate = date.getDate() + "-" + (date.getMonth() > 10 ? date.getMonth() : '0' + date.getMonth()) + "-" + date.getFullYear();
        return formatedDate;
    }


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
        e.preventDefault();
        var id = $('input[name=id]').val();
        if (id) {
            $.ajax({
                url: '/edit/review/' + id + '?_token=' + csrfToken,
                method: 'put',
                data: {
                    title: $('#editor input[type=text]').val(),
                    content: CKEDITOR.instances.review.getData(),
                    genres: $('input[type=checkbox]').serializeArray()
                },
                success: function (data) {
                    alert(data.message);
                },
                error: function (data) {
                    var errors = data.responseJSON.errors.content;
                    var error;
                    for (error in errors) {
                        alert(errors[error]);
                    }
                }
            })
        }
        else {
            $.ajax({
                url: 'uploader/review/upload?_token=' + csrfToken,
                method: 'post',
                data: {
                    title: $('#editor input').val(),
                    content: CKEDITOR.instances.review.getData(),
                    genres: $('input[type=checkbox]').serializeArray()
                },
                success: function (data) {
                    alert(data.message);
                },
                error: function (data) {
                    var errors = data.responseJSON.errors.content;
                    var error;
                    for (error in errors) {
                        alert(errors[error]);
                    }
                }
            })
        }

    });

    $('#content').delegate('.post .footer .like', 'click', function () {
        var el = $(this);
        var id = el.parent().parent().attr('id');
        var like = el.siblings('.like-count');
        $.ajax({
            url: 'http://reviewwa/like/' + id,
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

    $('#send-comment').on('click', function (el) {
        el.preventDefault();
        var data = $('#comment-form textarea').val();
        $.ajax({
            url: '../comment/' + $('.post').attr('id') + '?_token=' + csrfToken,
            method: 'post',
            data: {content: data},
            success: function (data) {
                $('#comments').append('<div data-id="' + data.id + '" class="box-comment border-bottom bg-gray-light">\n' +
                    '                            <!-- User image -->\n' +
                    '                            <span >\n' +
                    '                                <img class=" img-comment img-circle img-sm" src="../dist/img/user3-128x128.jpg" alt="User Image" style="width: 50px">\n' +
                    '                                        <div class="float-right">\n' +
                    '                                            <div>\n' +
                    '                                            <li class="del-comment fas fa-trash"></li>\n' +
                    '                                            </div>\n' +
                    '                                            <div>\n' +
                    '                                                <a class="float-right edit-comment">изменить</a>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                   <p class="mb-1">' + data.name + '\n' +
                    '                                    <span class="text-muted pull-right">' + data.created_at + '</span>\n' +
                    '                                </p>\n' +
                    '                            </span>\n' +
                    '                            <div class="comment-text">\n' +
                    '                                ' + data.content + '\n' +
                    '\n' +
                    '                            </div>\n' +
                    '                            <!-- /.comment-text -->\n' +
                    '                        </div>')
            },
            error: function (data) {
                var errors = data.responseJSON.errors.content;
                var error;
                for (error in errors) {
                    alert(errors[error]);
                }
            }
        });
        $('#comment-form textarea').val('');
    })
    var page = 'http://reviewwa/comments/';
    var commentPage = '?page=2';
    $('#more').on('click', function (el) {
        el.preventDefault();
        var post = $('.post').attr('id');
        $.ajax({
            url: page + post + commentPage,
            success: function (originData) {
                originData.comments.data.forEach((data) => {
                    var formatedDate = parseDate(data.created_at);
                    var commentAction = '';
                    if (originData.canUpdate && originData.canDelete) {
                        commentAction = '<div class="float-right">\n' +
                            '                                    \n' +
                            '                                            <div>\n' +
                            '                                            <li class="del-comment float-right fas fa-trash"></li>\n' +
                            '                                            </div>\n' +
                            '                                                                                                                                    <div>\n' +
                            '                                                <a class="float-right edit-comment">изменить</a>\n' +
                            '                                            </div>\n' +
                            '\n' +
                            '                                                                    </div>'
                    } else if (!originData.canUpdate && originData.canDelete) {
                        commentAction = '<div class="float-right">\n' +
                            '                                    \n' +
                            '                                            <div>\n' +
                            '                                            <li class="del-comment float-right fas fa-trash"></li>\n' +
                            '                                            </div>\n' +
                            '\n' +
                            '                                                                    </div>';
                    } else if (originData.canUpdate && !originData.canDelete) {
                        commentAction = '<div class="float-right">\n' +
                            '                                                                                                                                    <div>\n' +
                            '                                                <a class="float-right edit-comment">изменить</a>\n' +
                            '                                            </div>\n' +
                            '\n' +
                            '                                                                    </div>'
                    }

                    $('#comments').append('<div data-id="' + data.id + '" class="box-comment border-bottom bg-gray-light">\n' +
                        '                            <span>\n' +
                        '                                <img class="img-circle img-comment img-sm" src="../dist/img/user3-128x128.jpg" alt="User Image" style="width: 50px">\n' +
                        commentAction +
                        '                                <p class="mb-1">' + data.user.name + '\n' +
                        '                                    <span class="text-muted pull-right">' + formatedDate + '</span>\n' +
                        '                                </p>\n' +
                        '                            </span>\n' +
                        '                            <div class="comment-text">\n' + data.content + '\n' + '</div>\n' +
                        '                        </div>')
                });
                if (originData.next_page_url) {
                    commentPage = originData.next_page_url
                } else {
                    $('#more').remove();
                }
            },
            error: function (data) {
                alert('ошибка');
            }
        });
    })

    $('#comments').delegate('.box-comment span div div .del-comment', 'click', function () {
        var el = $(this);
        if (confirm('Вы уверены что хотите удалить коментарий?')) {
            $.ajax({
                url: '/delete/comment/' + el.parent().parent().parent().parent().data('id') + '?_token='
                + csrfToken,
                method: 'delete',
                success: function () {
                    el.parent().parent().parent().parent().remove();
                },
                error: function () {
                    alert('ошибка');
                }
            });
        }

    })

    $('.textarea').on('input', function (el) {
        $(this).height(0).height(this.scrollHeight);
    })

    $('#comments').delegate('.box-comment span div div .edit-comment', 'click', function (e) {
        e.preventDefault();
        var el = $(this);
        $.fancybox.open({
            src: '#edit-form',
            type: 'inline',
            opts: {
                afterShow: function (instance, current) {
                    $('#edit-form input').val(el.parent().parent().parent().parent().data('id'));
                    $('#edit-form div textarea').val(el.parent().parent().parent().siblings('.comment-text').html().replace(/ +/g, ' ').trim())
                }
            }
        });
    })

    // edit review
    $('#edit-btn').on('click', function (e) {
        e.preventDefault();
        var el = $(this);
        $.ajax({
            url: '/edit/comment/' + el.siblings('input').val() + '?_token=' + csrfToken,
            method: 'put',
            data: el.parent().serialize(),
            success: function (data) {
                $('#comments div[data-id=' + el.siblings('input').val() + '] .comment-text').html(data.content);
            },
            error: function (data) {
                var errors = data.responseJSON.errors.content;
                var error;
                for (error in errors) {
                    alert(errors[error]);
                }
            }
        })
    });

    $('#content').delegate('.post .footer .del-review', 'click', function () {
        var reviewId = $(this).parent().parent().attr('id');
        if (confirm('Вы уверены что хотите удалить обзор?')) {
            $.ajax({
                url: '/delete/review/' + reviewId + '?_token=' + csrfToken,
                method: 'delete',
                success: function (data) {
                    $('#' + reviewId + '.post').remove()

                },
                error: function (data) {
                    alert('ошибка');
                }
            })
        }

    })

    $('#content').delegate('.post .footer .edit-review', 'click', function (el) {
        el.preventDefault();
        var id = $(this).parent().parent().parent().attr('id');
        window.location = 'http://reviewwa/editReview/' + id;
    })

    $('.change-auth').on('click', function (el) {
        el.preventDefault();
        if ($(this).attr('id') === 'reg') {
            var form = $('#form-reg');
            $('#form-auth').addClass('d-none');
            form.removeClass('d-none')
        } else if ($(this).attr('id') === 'auth') {
            var form = $('#form-auth');
            $('#form-reg').addClass('d-none');
            form.removeClass('d-none')
        }
    })
    $('.user-func-list li a').on('click', function (el) {
        el.preventDefault();
        var link = $(this).attr('href');
        $(this).parent().siblings('.active').removeClass('active');
        $(this).parent().addClass('active');
        $.ajax({
            url: '/' + link,
            success: function (data) {
                $('#user-func-content').html(data);
            },
            error: function (data) {
                console.log('ошибка')
            }
        })
    })

    $('#user-func-content').delegate('#changePass #changePassBtn', 'click', function (el) {
        el.preventDefault();
        var formData = $('#changePass').serialize();
        console.log(formData);
        $.ajax({
            url: '/user/changePass',
            method: 'put',
            data: formData,
            success: function (data) {
                alert('Пароль успешно изменен!');
            },
            error: function (data) {
                var errors = data.responseJSON.errors;
                var error;
                for (error in errors) {
                    alert(errors[error]);
                }
            }
        })
    })
    var userPageNumber = 2;

    $('#user-func-content').delegate('#showMoreUsers', 'click', function (el) {
        el.preventDefault();
        if (userPageNumber) {
            var usersPageUrl = '/user/' + $('#user').data('id') + '/' + $('#showMoreUsers').data('type') + '?page=';
            $.ajax({
                url: usersPageUrl + userPageNumber,
                success: function (data) {
                    if (data == false) {
                        userPageNumber = false;
                        usersPageUrl = false;
                    } else {
                        console.log($(data));
                        $('#showMoreUsers').remove();
                        $('#user-func-content').append($(data)[0]);
                        userPageNumber++;
                    }
                },
            })
        }
    });

    $('#subscribe-on-user').on('click', function (el) {
        el.preventDefault();
        var link = $(this).attr('href');
        el = $(this);
        var id = el.data('id');
        $.ajax({
            url: link,
            success: function (data) {
                console.log($(this));
                if (el.hasClass('btn-success')) {
                    el.removeClass('btn-success');
                    el.html('отписаться');
                    el.attr('href', '/unsubscribe/user/' + id);
                    el.addClass('btn-danger');
                } else {
                    el.removeClass('btn-danger');
                    el.html('Подписаться');
                    el.attr('href', '/subscribe/user/' + id);
                    el.addClass('btn-success');
                }
            },
            error: function (data) {
                alert(data.message);
            }
        })
    })

    //search
    $('#find').on('submit', function (el) {
        el.preventDefault();
        document.location.href = '/find?find=' + $(this).find('input').val();
    })

    var link = $('.infinite-more-link').attr('href');
    var infinite = new Waypoint.Infinite({
        element: $('#content')[0],
        items: '.post',
        onAfterPageLoad: function (data) {
            if(data.length == 0){
                $('.infinite-more-link').remove()
            }
            else{
                data.each((el) => {
                    if($(data[el]).find('.post-content').outerHeight() === 700) {
                        $(data[el]).find('.open-all').append('<a class="open-rev" href="#">' +
                            'Читать далее</a>')
                    }
                });
                link = link.split('&');
                if (link.length > 1) {
                    let pageLink = link[link.length-1];
                    pageLink = pageLink.split('=');
                    pageLink[1] = parseInt(pageLink[1]) + 1;
                    pageLink = pageLink.join('=');
                    link[link.length-1] = pageLink;
                    link = link.join('&');
                    $('.infinite-more-link').attr('href', link);
                } else {
                    link = link[0];
                    link = link.split('=');
                    link[1] = parseInt(link[1]) + 1;
                    link = link.join('=');
                    $('.infinite-more-link').attr('href', link);
                }

            }
        }
    });

    $('#user-func-content').delegate('#showMoreReviews', 'click', function (e) {
        e.preventDefault();
        var el = $(this);
        var link = el.attr('href');
        $.ajax({
            url: link,
            success: function (data) {
                $('#showMoreReviews').remove();
                $('#content').append($(data).find('#user-func-content').find('#content').html());
                $('#user-func-content').append($(data).find('#showMoreReviews')[0]);
            }
        })
    })

    $('.best-radio').on('click', function () {
        var val = $(this).attr('value');
        var link = val ? '/' + val : '';
        $.ajax({
            url: '/best' + link,
            success: function (data) {
                infinite.destroy();
                window.history.pushState({}, '', $(this)[0].url);
                $('.infinite-more-link').remove();
                $('#content').html($(data).find('#content').html());
                if ($(data).find('#content').data('more')){
                    $('#big-content').append('<a id="show-more-rew" class="infinite-more-link w-100 btn btn-light" href="?page=2">More</a>');
                    link = $('.infinite-more-link').attr('href');
                    infinite = new Waypoint.Infinite({
                        element: $('#content')[0],
                        items: '.post',
                        onAfterPageLoad: function (data) {
                            if(data.length == 0){
                                $('.infinite-more-link').remove()
                            }
                            else{
                                data.each((el) => {
                                    if($(data[el]).find('.post-content').outerHeight() === 700) {
                                        $(data[el]).find('.open-all').append('<a class="open-rev" href="#">' +
                                            'Читать далее</a>')
                                    }
                                });
                                link = link.split('=');
                                link[1] = parseInt(link[1]) + 1;
                                link = link.join('=');
                                $('.infinite-more-link').attr('href', link);
                            }
                        }
                    })
                }
            }
        })
    })

    $('.genre-main').on('click', function () {
        var options = window.location.search.substr(1);
        options = formDataToObject(decodeURI(options));
        if (window.location.pathname != '/find') {
            window.location.href =  window.location.origin + '/find?genre=' + $(this).attr('value')
        } else {
            let issetGenre = false;
            // window.location.search = decodeURIComponent($.param(options));
            options.forEach((el, index) => {
               if (el.name === 'genre') {
                   if (el.value.includes($(this).attr('value'))) {
                       el.value.splice(el.value.indexOf($(this).attr('value')), 1);
                       if(!el.value) {
                           options.splice(index, 1)
                       }
                   } else {
                       el.value.push($(this).attr('value'));
                   }
                    issetGenre = true;
               }
            });
            if (!issetGenre) {
                options.push({name: 'genre', value: $(this).attr('value')});
            }
            window.location.search = decodeURIComponent($.param(options));
        }
    })

    $('.sort-radio').on('click', function () {
        var options = window.location.search.substr(1);
        options = formDataToObject(decodeURI(options));
        let issetSort = false;
        options.forEach((el, index) => {
            if (el.name === 'sort') {
                if ($(this).attr('value')) {
                    el.value = $(this).attr('value');
                    issetSort = true;
                } else {
                    options.splice(index, 1);
                }
            }
        });
        if (!issetSort && $(this).attr('value')) {
            options.push({name: 'sort' , value: $(this).attr('value')});
        }
        window.location.search = decodeURIComponent($.param(options));
    })

    $('#file-input').on('change', function () {
        var val = new FormData($(this).parent()[0]);
        $.ajax({
            url:'/user/avatar/upload',
            method: 'post',
            processData: false,
            contentType: false,
            data: val,
            success: function (data) {
                console.log(val);
            }
        })
    })
});

