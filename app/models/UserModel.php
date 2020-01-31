<?php

namespace app\models;
//require_once '../config-mail-accounts.php';

class UserModel extends AppModel

{

    public function registerUser($email, $password, $username)
    {
        try {
            $this->auth->register($email, $password, $username, function ($selector, $token) use ($email) {

                $mail_content = 'To confirm e-mail, follow link: http://blog.web4all.tech/confirmreg?selector=' . $selector . '&token=' . $token . ' <br> Good luck!';
                $mailer = $this->mail_send->InitTransport('no_reply@web4all.tech', '6675208ae');
                $message = $this->mail_send->newMail('no_reply@web4all.tech', 'no_reply Blog4all', $email, 'Verificate you e-mail', $mail_content);

                $mailer->send($message);
                $_SESSION['message'] = 'You are successfully register! Check your e-mail to confirm registration';
                header('Location: /');
                exit();
            });

            // echo 'We have signed up a new user with the ID ' . $userId;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $_SESSION['message'] = 'Invalid e-mail address. Please, check it.,';
            $_SESSION['message_status'] = 1;
            header('Location: /register');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $_SESSION['message'] = 'Invalid password. Please, check it.';
            $_SESSION['message_status'] = 1;
            header('Location: /register');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $_SESSION['message'] = 'Current e-mail already use. Please, use another';
            $_SESSION['message_status'] = 1;
            header('Location: /register');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $_SESSION['message'] = 'You are trying register too often. Try again in an hour.';
            $_SESSION['message_status'] = 1;
            header('Location: /register');
        }
    }

    public function confirmReg()
    {
        try {
            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);
            $_SESSION['message'] = 'You are successfully confirm your e-mail!';
            header('Location: /login');
            exit();
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            $_SESSION['message'] = 'Invalid token';
            $_SESSION['message_status'] = 1;
            header('Location: /');
            exit();
        } catch (\Delight\Auth\TokenExpiredException $e) {
            $_SESSION['message'] = 'Token expired';
            $_SESSION['message_status'] = 1;
            header('Location: /');
            exit();
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $_SESSION['message'] = 'Email address already exists';
            $_SESSION['message_status'] = 1;
            header('Location: /');
            exit();
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $_SESSION['message'] = 'Too many requests';
            $_SESSION['message_status'] = 1;
            header('Location: /');
            exit();
        }
    }

    public function tryLogin()
    {
        try {
            $this->auth->login($_POST['email'], $_POST['password']);
            //$_SESSION['name']=$_POST['email'];
            $_SESSION['message'] = 'You are successfully logged in!';
            header('Location: /');
            exit();
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $_SESSION['message'] = 'Wrong email address!';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit();
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $_SESSION['message'] = 'Wrong password';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit();
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $_SESSION['message'] = 'Email not verified yet';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit();
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $_SESSION['message'] = 'Too many requests';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit();
        }
    }


    public function logOut()
    {
        try {
            $this->auth->logOutEverywhere();
            $this->auth->destroySession();

            header('Location: /?msg=logout');
            exit();
        } catch (\Delight\Auth\NotLoggedInException $e) {
            $_SESSION['message'] = 'You are not logged in';
            $_SESSION['message_status'] = 1;
            header('Location: /login');
            exit();
        }
    }

    public function getAllUsers()
    {

        $table = 'users';
        return $this->query->getAll($table);
    }

    public static function getUserIdIfLoggedIn()
    {

        if ($_SESSION['auth_logged_in']) {
            return $_SESSION['auth_user_id'];
        } else {
            return '0';
        }

    }

    public function getUserName($id)
    {
        $table = 'users';
        $name = ['username' => 'username'];

        return $this->query->getNameById($name, $id, $table);
    }


}
