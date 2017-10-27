$(document).ready(function () {
    // Gestion dynamique de l'affichage de l'image
    //------------------------------------------------------------
    const inputImgUp = $('#appbundle_article_imageFile_file'),
        imageBox = $('#add-article-img');

    function readURL(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imageBox.attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    inputImgUp.change(function () {
        readURL(this);
    });

});
