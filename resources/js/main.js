$(document).ready(function () {
    $('#search-toggle').on('click', function (e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $(target).toggle("slide", { direction: "right" }, 400);
    });

    $('#show-filter').on('click', function (e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $(target).slideToggle(200);
    });
});
