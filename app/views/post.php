<?php

$this->layout('default', ['title' => $post['title']]);
?>

<h1 class="text-center"><?php echo html_entity_decode($post['title']) ?></h1>
<div class="content">
    <hr>
    <?php if ($post['image'] != '') { ?>
        <div class="content__picture">
            <img src="/images/<?php echo $post['image'] ?> " alt="<?php echo html_entity_decode($post['title']) ?>"
                 class="img-fluid img-thumbnail">
        </div>
        <hr>
    <?php } ?>

    <div class="content__main__text">
        <?php echo html_entity_decode($post['content']) ?>
    </div>
    <hr>
    <div class="content__main__bottom">
        Posted by <?php echo $post['username'] ?>  <?php echo $post['time'] ?>
    </div>
</div>
<?php if (array_key_exists('auth_logged_in', $_SESSION)) {

    if ($post['userID'] == $_SESSION['auth_user_id']) { ?>
        <hr>
        <div class="edit_block">
            <div class="edit_notification">
                It is you post. You can edit its!
            </div>

            <div class="post_buttons">
                <form action="/editpost">
                    <input type="hidden" name="id" value="<?php echo $post['ID'] ?>">
                    <button class="btn btn-warning">Edit</button>
                </form>
                <div>
                    <button class="btn btn-danger deactivate_post">Cancel publication</button>
                    <button class="btn btn-success activate_post">Publish</button>
                </div>
            </div>

        </div>

    <?php }
} ?>
<div class="comments">
    <div class="comments__title">
        <hr>
        <h3>Комментарии <a name="comments"></a>

            <?php
            $count = count($comments);
            if ($count > 0) {
                echo '(' . $count . ')';
            } else echo '(0)' ?> </h3>

        <?php if (array_key_exists('auth_logged_in', $_SESSION)) { ?>


            <div class="edit_block">

                <form action="/savecomment" method="POST">
                    <div class="form-group">

                        <textarea rows="4" cols="60" name="content" class="form-control"
                                  id="editor"> Enter your comment</textarea> <br>

                        <input type="hidden" id="postId" name="postId" value="<?php echo $post['ID'] ?>">
                        <input type="hidden" id="status" name="status" value="<?php echo $post['status'] ?>">
                    </div>
                    <button class="btn btn-success">Add comment</button>
                </form>
            </div>

        <?php } else { ?>
        <div class="edit_notification">
            <h3 class="text-center">You can't add your comment. <br>
                Please, <a href="/login">login</a> or <a href="/register">register</a></h3>
        </div>
    </div> <?php } ?>

    <div class="view-comments">

        <?php
        if ($count > 0) {
            foreach ($comments as $comment) { ?>
                <hr>
                <div class="one-comment">
                    <div class="comment-author-date">
                        Posted by <span><?php echo $comment['username'] ?> </span> <?php echo $comment['date'] ?>
                    </div>
                    <div class="comment-content">
                        <?php echo html_entity_decode($comment['content']) ?>
                    </div>
                </div>


            <?php }

        } else {
            echo 'Еще никто не комментировал запись';
        } ?>

    </div>

</div>


<script>


    $(document).ready(function () {
        var postStatus = $('#status').attr('value');
        var buttonact = $('button.activate_post');
        var buttondeact = $('button.deactivate_post');

        if (postStatus == 1) {
            buttonact.hide();
        }
        if (postStatus == 0) {
            buttondeact.hide();
        }


        buttondeact.click(function () {
            var idValue = $('#postId').attr('value');

            console.log(idValue);

            $.ajax({
                type: "POST",
                url: "/deactivatepost",
                data: {'id': idValue},

                beforeSend: function () {
                    buttondeact.text('Processing...');
                },
                complete: function () {
                    buttondeact.hide();
                    buttondeact.text('Cancel publication');
                    buttonact.show();
                }
            })
        })

        buttonact.click(function () {
            var idValue = $('#postId').attr('value');

            console.log(idValue);

            $.ajax({
                type: "POST",
                url: "/activatepost",
                data: {'id': idValue},

                beforeSend: function () {
                    buttonact.text('Processing...');
                },
                complete: function () {
                    buttonact.hide();
                    buttonact.text('Publish');
                    buttondeact.show();
                }
            })
        })
    })


</script>
