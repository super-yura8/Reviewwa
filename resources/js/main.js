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

    $.fancybox.defaults.hash = false;

    $('#date').datepicker();
});
