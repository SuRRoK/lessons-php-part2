<?php

namespace app\controllers;

use app\models\PostsModel;
use app\models\UserModel;
use app\models\AdminModel;
use app\models\CommentModel;
use app\models\CategoriesModel;
use app\models\ImageModel;
use League\Plates\Engine;
use Cake\Chronos\Chronos;



class AppController

{
    protected $templates;
    protected $post;
    protected $user;
    protected $time;
    protected $admin;
    protected $comment;
    protected $categories;
    protected $image;

    public function __construct(Engine $engine,
                                PostsModel $post,
                                UserModel $user,
                                AdminModel $admin,
                                CommentModel $comment,
                                CategoriesModel $categories,
                                ImageModel $image,
                                Chronos $time)
    {
        $this->templates = $engine;
        $this->post = $post;
        $this->user = $user;
        $this->comment = $comment;
        $this->categories = $categories;
        $this->image = $image;
        $this->admin = $admin;
        $this->time = $time;
        // d($engine);
    }

/*    public function checkIncomingData ($key, $array) {

        if (array_key_exists($key,$array)) {
            return true;

        } return false;
    }

    public function checkUserRights ($postId, $postUserID)
    {

        if ($postId &&
            (($postUserID == $_SESSION['auth_user_id']) || ($_SESSION['auth_roles'] === 1))) {
            return true;
        } else return false;
    }*/
}