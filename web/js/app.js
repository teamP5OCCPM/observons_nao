$(document).ready(function () {
    const searchBox =  $('#search-box');
    const searchBtnCover = $('#btn-search-cover');
    const searchBtn = $('#btn-search');
    const overlay = $('.overlay');

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
    })
});