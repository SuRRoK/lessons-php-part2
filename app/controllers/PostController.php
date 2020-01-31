<?php

namespace app\controllers;

class PostController extends AppController


{

    public function addPost()
    {
        $categories = $this->categories->getAllCategories();
        echo $this->templates->render('addpost', ['categories' => $categories]);
    }


    public function viewPost()
    {
        if (array_key_exists('id', $_GET)) {
            $id = $_GET['id'];
            $post = $this->post->getOnePost($id);
            if ($post['ID']) {
                $post['username'] = $this->user->getUserName($post['userID']);
                $comments = $this->comment->getAllCommentsForPosts($post['ID']);
                $datePost = strtotime($post['date']);
                foreach ($comments as $key => $comment) {
                    $dateComment = strtotime($comment['date']);
                    $comments[$key]['date'] = date("d.m.Y H:i", $dateComment);

                }
                $post['time'] = date("d.m.Y H:i", $datePost);

            } else {

                $message = 'Post ID incorrect!';
                $_SESSION['message_status'] = 1;
                $this->allPosts($message);
                exit;
            }

            echo $this->templates->render('post', ['post' => $post, 'comments' => $comments]);
        } else {
            $this->allPosts();
        }
    }

    public function allPosts($message = null)
    {

        $posts = $this->post->getAllPostsByStatus();
        $posts = array_reverse($posts);

        $_SESSION['message'] = $message;
        $_SESSION['message_status'] = 1;

        echo $this->templates->render('posts', ['posts' => $posts]);
    }

    public function allPostsByCategory()
    {

    }

    public function editPost()
    {

        if (array_key_exists('id', $_GET)) {
            $id = $_GET['id'];
            $post = $this->post->getOnePost($id);
            if ($post['ID'] &&
                (($post['userID'] == $_SESSION['auth_user_id']) || ($_SESSION['auth_roles'] === 1))) {
                $post['username'] = $this->user->getUserName($post['userID']);

            } else {

                $message = 'Post ID incorrect!';
                $this->allPosts($message);

                exit;
            }
            $categories = $this->categories->getAllCategories();
            echo $this->templates->render('editpost', ['post' => $post, 'categories' => $categories]);
        } else {
            $message = 'Post ID incorrect!';
            $this->allPosts($message);

        }
    }

    public function updatePost()
    {
        if (array_key_exists('id', $_POST)) {
            $id = $_POST['id'];
            $post = $this->post->getOnePost($id);
            if ($post['ID'] &&
                (($post['userID'] == $_SESSION['auth_user_id']) || ($_SESSION['auth_roles'] === 1))) {

                $this->image->changeImage($post['image'], $_FILES['image']['name']);

                $this->post->updatePost($_POST['id'], $_POST['category'], $_POST['title'], $_POST['content'], $_FILES);
            }


        } else {
            $_SESSION['message'] = 'Несанкционированное действие!';
            $_SESSION['message_status'] = 1;
            header("Location: /");
            exit();
        }


    }

    public function setAsInactive()
    {

        if (array_key_exists('id', $_POST)) {
            $id = $_POST['id'];
            $post = $this->post->getOnePost($id);
            if ($post['ID'] &&
                (($post['userID'] == $_SESSION['auth_user_id']) || ($_SESSION['auth_roles'] === 1))) {

                $this->post->changeStatus($_POST['id'], 0);
            }
        } else {
            $_SESSION['message'] = 'Несанкционированное действие!';
            $_SESSION['message_status'] = 1;
            header("Location: /");
            exit();
        }
    }

    public function setAsActive()
    {

        if (array_key_exists('id', $_POST)) {
            $id = $_POST['id'];
            $post = $this->post->getOnePost($id);
            if ($post['ID'] &&
                (($post['userID'] == $_SESSION['auth_user_id']) || ($_SESSION['auth_roles'] === 1))) {

                $this->post->changeStatus($_POST['id'], 1);
            }
        } else {
            $_SESSION['message'] = 'Несанкционированное действие!';
            $_SESSION['message_status'] = 1;
            header("Location: /");
            exit();
        }
    }


    public function deletePost()
    {
        if (array_key_exists('auth_logged_in', $_SESSION) && $_SESSION['auth_roles'] === 1) {
            $image = $_GET['image'];
            $id = $_GET['id'];

            $this->post->deletePostByID($id, $image);
        }  else {
            $_SESSION['message']='Несанкционированное действие!';
            $_SESSION['message_status'] = 1;
            header("Location: /");
            exit();
        }

    }
}
