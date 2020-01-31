<?php

$this->layout('default', ['title' => 'Blog4all']) ?>

<h1 class="text-center">Blog4all</h1>
<div class="content">
    Добро пожаловать, дорогие собратья по обучению. <br>
    <hr>
    Прошу кажого, кому не трудно, зарегистрироваться на сайте, <br>
    подтвердить свою почту и оставить 1-2 сообщения.<br>
    Если есть возможность, то с прикрепленным фото.<br>
    Если будут какие-нибудь ошибки, делайте принт скрин. <br>
    Так же не обработаны многие исключения, просто выводятся сообщения без редиректа. <br>
    <hr>


    <div class="newposts">
        <div class="newposts__title">
            <div class="newposts__title__name"><h3>New Posts</h3></div>
            <div class="newposts__title__name"><h3><a href="/posts">All posts</a></h3></div>
        </div>

        <?php
        foreach ($posts as $p) {
            //d($posts);
            ?>


            <div class="newposts__content">
                <hr>
                <?php if ($p['image'] != '') { ?>
                    <div class="newposts__content__picture">
                        <img src="/images/<?= $p['image'] ?> "
                             alt="<?= html_entity_decode($p['title']) ?>"
                             class="img-fluid img-thumbnail">
                    </div>
                <?php } else { ?>
                    <div class="nopicture_">

                    </div>
                <?php } ?>

                <div class="newposts__content__main">
                    <div class="newposts__content__main__title">
                        <h3><a href="/post?id=<?= $p['ID'] ?>"><?= html_entity_decode($p['title']) ?></a>
                            <h3>
                    </div>
                    <div class="newposts__content__main__bottom">
                        <?= "Author: " . $p['username'] ?>
                    </div>
                </div>
            </div>


        <?php } ?>


    </div>

</div>
