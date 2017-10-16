$(document).ready(() => {
    const navbar = $('.navbar');
    const cover = $('.search-block');
    const btnMobile = $('.navbar-toggler');
    const btnSearch = $('#btn-search');

    navbar.removeClass("bg-primary");
    navbar.addClass("navbar-to-transparent");
    btnSearch.hide();

    $(window).scroll(() => {
        console.log($(this).scrollTop());
        if ($(this).scrollTop() > cover.height()) {
            navbar.removeClass("navbar-to-transparent");
            navbar.addClass("navbar-to-primary");
            btnSearch.show();
        }
        if ($(this).scrollTop() < cover.height()) {
            navbar.removeClass("navbar-to-primary");
            navbar.addClass("navbar-to-transparent");
            btnSearch.hide();
        }
    });

    btnMobile.click(() => {
        if ($(this).scrollTop() < cover.height()) {
            if (navbar.hasClass('navbar-to-transparent')) {
                navbar.removeClass("navbar-to-transparent");
                navbar.addClass("navbar-to-primary");
            } else {
                navbar.removeClass("navbar-to-primary");
                navbar.addClass("navbar-to-transparent");
            }
        }
    })
});
