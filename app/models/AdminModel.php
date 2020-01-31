<?php

namespace app\models;

use Cake\Chronos\Chronos;
use Delight\Auth\Role;
use Delight\Auth\UnknownIdException;

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
            $this->auth->admin()->addRoleForUserById($userId, Role::ADMIN);
            $_SESSION['msg'] = 'now_user_is_admin';
            header('Location: /admin/users');
        } catch (UnknownIdException $e) {
            die('Unknown user ID');
        }
    }

    public function deSetAsAdmin($userId)
    {
        try {
            $this->auth->admin()->removeRoleForUserById($userId, Role::ADMIN);
            $_SESSION['msg'] = 'now_user_is_admin';
            header('Location: /admin/users');
        } catch (UnknownIdException $e) {
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
}
