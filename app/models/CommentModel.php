<?php

namespace app\models;

use Cake\Chronos\Chronos;

class CommentModel extends AppModel

{
    public function getAllCommentsForPosts($id)
    {
        $table = 'comments';
        $data = [
            'comments.*',
            'users.username' => 'username',
        ];
        $join1 = ['LEFT', 'users', 'users.id=comments.userID'];
        return $this->query->getColumnsJoinWhere($data, $table, $join1, $id);
    }

    public function getOneComment($id)
    {
        $table = 'comments';

        return $this->query->getOne($id, $table);
    }

    public function getAllCommentsByUser($userID)
    {

        $table = 'comments';

        $data = [
            'comments.*',
            'posts.title' => 'title',
        ];

        $idCol = 'comments.userID';
        $idColEasy = 'userID';

        $order_by = ['postID', 'ID'];

        $join1 = ['LEFT', 'posts', 'posts.ID=comments.postID'];

        return $this->query->getColumnsJoinWhereOrder($userID, $data, $table, $join1, $order_by, $idCol, $idColEasy);

    }

    public function getAllCommentsJoin2PostsUsers()
    {

        $table = 'comments';

        $data = [
            'comments.*',
            'posts.title' => 'title',
            'users.username' => 'username',
        ];


        $order_by = ['postID', 'ID'];

        $join1 = ['LEFT', 'posts', 'posts.ID=comments.postID'];
        $join2 = ['LEFT', 'users', 'users.id=comments.userID'];

        return $this->query->getColumnsJoin2Order($data, $table, $join1, $join2, $order_by);

    }

    public function saveComment()
    {
        $table = 'comments';


        $userId = UserModel::getUserIdIfLoggedIn();

        $postId = htmlentities(strip_tags($_POST['postId']));
        $content = htmlentities(strip_tags($_POST['content'], '<a><p>'));

        $min_length = 6;

        if (!strpos($content, 'Enter your comment') && strlen($content) > $min_length) {
            $date = new Chronos();
            $today = $date->toDateTimeString();

            $data = [
                'userID' => $userId,
                'postID' => $postId,
                'content' => $content,
                'date' => $today,
            ];

            $this->query->insert($data, $table);
            $_SESSION['message'] = 'Comment successfully added!';
            header("Location: /post?id=$postId#comments");
            exit();
        } else {
            $_SESSION['message'] = 'Comment is too short.';
            $_SESSION['message_status'] = 1;
            header("Location: /post?id=$postId#comments");
        }


    }

    public function getAllComments()
    {

        $table = 'comments';
        return $this->query->getAll($table);

    }

    public function deleteCommentByID($id)
    {

        $header = $_SERVER['HTTP_REFERER'];
        $table = 'comments';
        $idCol = 'ID';
        $this->query->delete($id, $table, $idCol);
        $_SESSION['message'] = 'Comment deleted successful!';
        header("Location: $header");
        exit();


    }

}
