<?php

namespace app\controllers;

class AdminController extends AppController
{

    /**
     * @param null $message
     */
    public function admin($message = null)
    {
        if (array_key_exists('auth_logged_in', $_SESSION) && $_SESSION['auth_roles'] === 1) {


            $_SESSION['message'] = $message;
            $nums = $this->admin->getNumberRecords();
            echo $this->templates->render('admin/adminHomepage', ['nums' => $nums]);
        } else {

            $_SESSION['message'] = 'You are not admin, or not login yet. Please, login';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit;
        }
    }

    public function adminEditPost()
    {
        if (array_key_exists('auth_logged_in', $_SESSION) && $_SESSION['auth_roles'] === 1) {
            if (array_key_exists('id', $_GET)) {
                $id = $_GET['id'];
                $post = $this->post->getOnePost($id);
                if ($post['ID']) {

                    $categories = $this->categories->getAllCategories();
                    echo $this->templates->render('admin/adminEditPost', ['post' => $post, 'categories' => $categories]);
                } else {

                    $message = 'Post ID incorrect!';
                    $_SESSION['message_status'] = 1;
                    $this->admin($message);
                    exit;
                }

            } else {
                $message = 'Post ID incorrect!';
                $_SESSION['message_status'] = 1;
                $this->admin($message);

            }
        } else {

            $_SESSION['message'] = 'You are not admin, or not login yet. Please, login';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit;
        }
    }

    public function adminUsers()
    {
        if (array_key_exists('auth_logged_in', $_SESSION) && $_SESSION['auth_roles'] === 1) {
            $users = $this->user->getAllUsers();
            echo $this->templates->render('admin/adminUsers', ['users' => $users]);
        } else {

            $_SESSION['message'] = 'You are not admin, or not login yet. Please, login';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit;
        }
    }

    public function giveAdminRole()
    {
        if (array_key_exists('auth_logged_in', $_SESSION) && $_SESSION['auth_roles'] === 1) {
            $this->admin->setAsAdmin($_POST['id']);
        } else {

            $_SESSION['message'] = 'You are not admin, or not login yet. Please, login';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit;
        }
        // echo $this->templates->render('admin/adminUsers', ['users' => $users]);
    }

    public function removeAdminRole()
    {
        if (array_key_exists('auth_logged_in', $_SESSION) && $_SESSION['auth_roles'] === 1) {
            $this->admin->deSetAsAdmin($_POST['id']);
        } else {

            $_SESSION['message'] = 'You are not admin, or not login yet. Please, login';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit;
        }
    }

    public function adminPosts()
    {
        if (array_key_exists('auth_logged_in', $_SESSION) && $_SESSION['auth_roles'] === 1) {
            $posts = $this->post->getAllPosts();
            echo $this->templates->render('admin/adminPosts', ['posts' => $posts]);
        } else {

            $_SESSION['message'] = 'You are not admin, or not login yet. Please, login';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit;
        }
    }

    public function adminComments()
    {
        if (array_key_exists('auth_logged_in', $_SESSION) && $_SESSION['auth_roles'] === 1) {
            $comments = $this->comment->getAllCommentsJoin2PostsUsers();
            echo $this->templates->render('admin/adminComments', ['comments' => $comments]);
        } else {

            $_SESSION['message'] = 'You are not admin, or not login yet. Please, login';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit;
        }
    }

    public function adminCategories()
    {
        if (array_key_exists('auth_logged_in', $_SESSION) && $_SESSION['auth_roles'] === 1) {
            $categories = $this->categories->getAllCategories();
            echo $this->templates->render('admin/adminCategories', ['categories' => $categories]);
        } else {

            $_SESSION['message'] = 'You are not admin, or not login yet. Please, login';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit;
        }
    }


}
