jQuery(document).ready(function($) {

        // When we click on response button
        $('.reply-comment').click(function(e) {
            e.preventDefault();

            let $form = $('#form_add_comment');

            let $this = $(this);

            let parentId = $this.attr('data-id');

            let $comment = $('#div-comment-' + parentId);

            let $dataLevel = parseInt($comment.attr('data-level'));

            console.log($dataLevel);

            let $level = $('#appbundle_comment_level');

            $level.val($dataLevel + 1);

            $('#appbundle_comment_parentId').val(parentId);

        $comment.after($form);


        })



});
