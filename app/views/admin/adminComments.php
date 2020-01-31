<?php
//d($comments);

$this->layout('admin/default', ['title' => 'Blog4all - Admin area']) ?>

<h1 class="text-center">Blog4all - Admin area</h1>
<div class="content">
    <br>
    <hr>


    <div class="newposts">
        <div class="newposts__title">
            <div class="newposts__title__name"><h3>List of the comments!</h3></div>
        </div>


        <div class="all_comments">
            <div class="comment_content">
                <table class="table_comments">
                    <tbody>
                    <?php
                    $current_id = 0;

                    foreach ($comments as $comment) {

                        if ($current_id != $comment['postID']) {
                            $current_id = $comment['postID']; ?>
                            <tr>
                                <td colspan="5" class="comment_post_title"><a
                                            href="/post?id=<?php echo $comment['postID'] ?>"><?php echo $comment['title']; ?></a>
                                </td>
                            </tr>

                            <tr>
                                <th>#</th>
                                <th>Content</th>
                                <th>Author</th>
                                <th class="comment_date_block">Date</th>
                                <th>Delete</th>
                            </tr>

                        <?php } ?>

                        <tr>
                            <th class="align-middle"><?php echo $comment['ID']; ?></th>
                            <td class="align-middle"><?php echo html_entity_decode($comment['content']); ?></td>
                            <td class="align-middle"><?php echo html_entity_decode($comment['username']); ?></td>
                            <td class="align-middle"><?php echo html_entity_decode($comment['date']); ?></td>
                            <td class="align-middle"><!--<a href="/editcommentid=<?php /*echo $comment['ID']; */ ?>"
                                                class="btn btn-warning">Edit</a>-->
                                <a href="/deletecomment?id=<?php echo $comment['ID'] ?>"
                                   class="btn btn-danger">Delete</a>
                            </td>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


</div>
