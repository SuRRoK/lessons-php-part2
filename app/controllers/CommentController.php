<?php

namespace app\controllers;

class CommentController extends AppController
{
    public function deleteComment()
    {
        if (array_key_exists('id', $_GET)) {
            $id = $_GET['id'];
            $comment = $this->comment->getOneComment($id);
            if ($comment['ID'] &&
                (($comment['userID'] == $_SESSION['auth_user_id']) || ($_SESSION['auth_roles'] === 1))) {



                $this->comment->deleteCommentByID($id);
            }


        } else {
            $_SESSION['message'] = 'Несанкционированное действие!';
            $_SESSION['message_status'] = 1;
            header("Location: /");
            exit();
        }


    }
}