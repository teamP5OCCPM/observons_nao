jQuery(document).ready(function($) {

        // When we click on response button
        $('.reply-comment').click(function(e) {
            e.preventDefault();




            // On récupère la div du formulaire
            let $form = $('#form_add_comment');

            let $this = $(this);

            let parentId = $this.attr('data-id');

            let $comment = $('#div-comment-' + parentId);

            let $dataLevel = parseInt($comment.attr('data-level'));


            let $level = $('#appbundle_comment_level');


            $level.val($dataLevel + 1);

            $('#appbundle_comment_parentId').val(parentId);

            $form.find('h3').text('Répondre au commentaire');


            $comment.after($form);
            

        })



});
