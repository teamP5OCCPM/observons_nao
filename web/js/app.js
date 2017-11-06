$(document).ready(function () {
    const searchBox =  $('#search-box'),
        searchBtnCover = $('#btn-search-cover'),
        searchBtn = $('#btn-search'),
        overlay = $('.overlay'),
        overlayNavbar = $('.overlay-search-navbar'),
        searchNavbarBtn = $('#search-navbar-btn'),
        searchNavbar = $('#searchbar-navbar'),
        searchNavbarInput = $('#search-navbar-input'),
        sidenav = $('.sidenav'),
        sidenavItems = $('.sidenav-items'),
        reduceIco = $('.reduce-ico'),
        reduceSidenav = $('.reduce-sidenav');

    searchBtn.click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        overlay.toggleClass("invisible");
        searchBox.addClass("d-block");
    });

    searchBtnCover.click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        overlay.toggleClass("invisible");
        searchBox.addClass("d-block");
    });

    overlay.click(function () {
        overlay.toggleClass("invisible");
        searchBox.toggleClass("d-block");
    });

    searchNavbarBtn.click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        if(searchNavbar.hasClass("reply")) {
            searchNavbar.removeClass("reply")
        }
        searchNavbar.addClass("deploy");
        overlayNavbar.removeClass("invisible");
        searchNavbarInput.focus();
    });

    overlayNavbar.click(function () {
        overlayNavbar.toggleClass("invisible");
        if(searchNavbar.hasClass("deploy")) {
            searchNavbar.removeClass("deploy");
            searchNavbar.addClass("reply");
        }
    });

    reduceSidenav.click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        sidenav.toggleClass('isReduced');
        sidenavItems.toggleClass('d-lg-inline-block');
        reduceIco.toggleClass('rotate-90');

        if (sidenav.hasClass('isReduced')) {
            $('.admin-box').css('padding-left', '4rem');
        } else {
            $('.admin-box').css('padding-left', '19rem');
        }
    })
});