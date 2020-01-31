<?php

namespace app\controllers;

//use app\controllers\AppController;


class UserController extends AppController
{


    public function login()
    {
        if (!array_key_exists('auth_logged_in', $_SESSION)) {

            echo $this->templates->render('login');

        } else {
            $_SESSION['message'] = 'You are already logged in!';
            $_SESSION['message_status'] = 1;
            header('Location: /');
            exit;
        }
    }

    public function register()
    {
        if (!array_key_exists('auth_logged_in', $_SESSION)) {

            echo $this->templates->render('register');

        } else {
            $_SESSION['message'] = 'You are already registered!';
            $_SESSION['message_status'] = 1;
            header('Location: /');
            exit;
        }

    }

    public function tryRegister()
    {
        if (mb_strlen($_POST['username']) > 2) {
            $usernamecheck = true;
        } else {
            $_SESSION['message'] = 'Username too short!' . mb_strlen($_POST['username']);

            $_SESSION['message_status'] = 1;
            header('Location: /register');
            exit;
        }

        if (($_POST['password'] === $_POST['passwordconf']) && mb_strlen($_POST['password']) > 2) {
            $passcheck = true;
        } else {
            $_SESSION['message'] = 'Password incorrect';
            $_SESSION['message_status'] = 1;
            header('Location: /register');
            exit;
        }
        if ($usernamecheck && $passcheck) {

            $this->user->registerUser($_POST['email'], $_POST['password'], $_POST['username']);
        } else {

            $_SESSION['message'] = 'Something wrong!';
            $_SESSION['message_status'] = 1;
            header('Location: /register');
            exit;
        }
    }

    public function account()
    {
        if (array_key_exists('auth_logged_in', $_SESSION)) {
            $posts = $this->post->getAllPostsByUser($_SESSION['auth_user_id']);
            $comments = $this->comment->getAllCommentsByUser($_SESSION['auth_user_id']);
            echo $this->templates->render('account', ['posts' => $posts, 'comments' => $comments]);
        } else {
            $_SESSION['message'] = 'You are not logged in!';
            $_SESSION['message_status'] = 1;
            header('Location: /');
            exit;
        }
    }
}
