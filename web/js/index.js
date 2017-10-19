$(document).ready(() => {
    const navbar = $('.navbar'),
        cover = $('.search-block'),
        btnMobile = $('.navbar-toggler'),
        btnSearch = $('#btn-search'),
        searchBarBtn = $('#search-navbar-btn');

    navbar.removeClass("bg-primary");
    navbar.addClass("navbar-to-transparent");
    btnSearch.hide();
    searchBarBtn.addClass('invisible');

    $(window).scroll(() => {
        if ($(this).scrollTop() > cover.height()) {
            navbar.removeClass("navbar-to-transparent");
            navbar.addClass("navbar-to-primary");
            btnSearch.show();
            searchBarBtn.removeClass('invisible');
        }
        if ($(this).scrollTop() < cover.height()) {
            navbar.removeClass("navbar-to-primary");
            navbar.addClass("navbar-to-transparent");
            btnSearch.hide();
            searchBarBtn.addClass('invisible');
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
