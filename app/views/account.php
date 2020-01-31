<?php

$this->layout('default', ['title' => 'Blog4all - Personal Area']) ?>

<h1 class="text-center">Personal Area</h1>
<div class="content">


    <div class="private_info">
        <div>
            <table class="table col-md-4">

                <tbody>
                <tr>
                    <th scope="row">Your username:</th>
                    <td><?= $_SESSION['auth_username'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Your e-mail:</th>
                    <td><?= $_SESSION['auth_email'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Your id in our system:</th>
                    <td>#<?= $_SESSION['auth_user_id'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Your posts here:</th>
                    <td><?= count($posts); ?></td>
                </tr>
                <tr>
                    <th scope="row">Your comments here:</th>
                    <td><?= count($comments); ?></td>
                </tr>

                </tbody>
            </table>
        </div>

        <div class="switcher">
            <div class="switcher__header">
                <div class="post_label" id="selected_label">Posts</div>
                <div class="comment_label" id="">Comments</div>
            </div>

            <div class="user_comments">
                <div class="comment_content">
                    <table class="table_comments">
                        <tbody>
                        <?php
                        $current_id = 0;

                        foreach ($comments as $comment) {

                            if ($current_id != $comment['postID']) {
                                $current_id = $comment['postID']; ?>
                                <tr>
                                    <td colspan="3" class="comment_post_title"><?= $comment['title']; ?></td>
                                </tr>

                                <tr>
                                    <th class="comment_content_block">Content</th>
                                    <th class="comment_date_block">Date</th>
                                    <!-- <th class="comment_delete_block">Delete</th>-->
                                </tr>

                            <?php } ?>

                            <tr>
                                <td class="align-middle"><?= html_entity_decode($comment['content']); ?></td>
                                <td class="align-middle"><?= html_entity_decode($comment['date']); ?></td>
                            </tr>

                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php foreach ($posts as $p) { ?>

                <div class="user_posts">

                    <?php if ($p['image'] != '') { ?>
                        <div class="posts__content__picture">
                            <img src="/images/<?= $p['image'] ?> "
                                 alt="<?= html_entity_decode($p['title']) ?>"
                                 class="img-fluid img-thumbnail">
                        </div>
                    <?php } else { ?>
                        <div class="posts__content__picture nopicture_">

                        </div>
                    <?php } ?>

                    <div class="posts__content__main">
                        <div class="posts__content__main__title">
                            <h3>
                                <a href="/post?id=<?= $p['ID'] ?>"><?= html_entity_decode($p['title']) ?></a>
                                <h3>
                        </div>
                        <div class="posts__content__main__text">
                            <?= html_entity_decode($p['content']) ?>
                        </div>
                        <div class="posts__content__main__bottom">
                            <?= '' ?>
                        </div>
                    </div>
                </div>
                <div class="user_posts_editors">
                    <p class="foreach activepost btn btn-light" id="<?= $p['ID']; ?>"
                       status="<?= $p['status']; ?>" title="Deactivate post"> Active </p>
                    <p class="foreach notactivepost btn btn-light" id="<?= $p['ID']; ?>"
                       status="<?= $p['status']; ?>"

                       title="Activate post"> Not active </p>

                    <form action="/editpost">
                        <input type="hidden" name="id" value="<?= $p['ID'] ?>">
                        <button class="btn btn-warning">Edit</button>
                    </form>

                </div>
            <?php } ?>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var foreach = $('.foreach');
        foreach.each(function () {
            if ($(this).attr('status') === 1 && $(this).attr('class') === 'foreach notactivepost btn btn-light') {
                $(this).hide();
            }
            if ($(this).attr('status') === 0 && $(this).attr('class') === 'foreach activepost btn btn-light') {
                $(this).hide();
            }
        });

        $('p.activepost').click(function () {
            var idValue = $(this).attr('id');
            var current = $(`p#${idValue}`);
            var notactive = $(`p#${idValue} + `);
            $.ajax({
                method: "POST",
                url: "/deactivatepost",
                data: {'id': idValue},
                beforeSend: function () {
                    current.text('Processing...');
                },
                complete: function () {
                    current.text('Active');
                    current.hide();
                    notactive.show();
                }
            });
        });

        $('p.notactivepost').click(function () {
            var idValue = $(this).attr('id');
            var notactive = $(`p#${idValue}`);
            var current = $(`p#${idValue}+ p`);
            $.ajax({
                method: "POST",
                url: "/activatepost",
                data: {'id': idValue},
                beforeSend: function () {
                    current.text('Processing...');
                },
                complete: function () {
                    current.text('Not active');
                    current.hide();
                    notactive.show();
                }
            });
        });

        const comments_btn = $('.comment_label');
        const comments = $('.user_comments');
        const posts_btn = $('.post_label');
        const posts = $('.user_posts');
        const upeditors = $('.user_posts_editors');

        comments_btn.click(function () {

            if (comments_btn.attr('id') === '') {
                posts.hide();
                upeditors.hide();
                comments.show();
                comments_btn.attr('id', 'selected_label');
                posts_btn.attr('id', '');
            }

        });

        posts_btn.click(function () {

            if (posts_btn.attr('id') === '') {
                posts.show();
                upeditors.show();
                comments.hide();
                comments_btn.attr('id', '');
                posts_btn.attr('id', 'selected_label');
            }

        })
    })
</script>

