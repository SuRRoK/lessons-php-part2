<?php

namespace app\models;

//use Cake\Chronos\Chronos;

use Cake\Chronos\Chronos;

class AdminModel extends AppModel

{


    public function getOneUser($id)
    {
        $table = 'users';

        return $this->query->getOne($id, $table);
    }


    public function setAsAdmin($userId)
    {
        try {
            $this->auth->admin()->addRoleForUserById($userId, \Delight\Auth\Role::ADMIN);
            $_SESSION['msg'] = 'now_user_is_admin';
            header('Location: /admin/users');
        } catch (\Delight\Auth\UnknownIdException $e) {
            die('Unknown user ID');
        }
    }

    public function deSetAsAdmin($userId)
    {
        try {
            $this->auth->admin()->removeRoleForUserById($userId, \Delight\Auth\Role::ADMIN);
            $_SESSION['msg'] = 'now_user_is_admin';
            header('Location: /admin/users');
        } catch (\Delight\Auth\UnknownIdException $e) {
            die('Unknown user ID');
        }
    }

    public function getNumberRecords()
    {

        $data = ['COUNT(*)'];
        $table = 'posts';
        foreach ($this->query->getColumns($data, $table) as $num) {
            $numbers['Posts'] = $num;
        }
        $table = 'users';
        foreach ($this->query->getColumns($data, $table) as $num) {
            $numbers['Users'] = $num;
        }
        $table = 'comments';
        foreach ($this->query->getColumns($data, $table) as $num) {
            $numbers['Comments'] = $num;
        }
        $table = 'categories';
        foreach ($this->query->getColumns($data, $table) as $num) {
            $numbers['Categories'] = $num;
        }
        return $numbers;
    }

    /*    public function savePost ()
        {
            $table = 'posts';
            $title = htmlentities($_POST['title']);
            $content = htmlentities($_POST['content']);

            if  ($_FILES['image']['name'] != '')
            {
                $image_name = $this->uploadImage($_FILES['image']);
            }
            else {
                $image_name = '';
            }

            if ($_SESSION['auth_logged_in']) {
                $userId = $_SESSION['auth_user_id'];
            }
            else {
                $userId = '0';
            }
            $date = new Chronos();
            $today = $date->toDateTimeString();
            $category = 1;

            $data = [
                'userID'=>$userId,
                'categoryID'=>$category,
                'title'=>$title,
                'content'=>$content,
                'date' =>$today,
                'image' =>$image_name
            ];

            $this->query->insert($data, $table);
            $_SESSION['message']='add_successful';
            header('Location: /addpost');
            exit();



        }    */

}
