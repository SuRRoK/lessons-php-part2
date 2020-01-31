<?php

namespace app\models;

//use Cake\Chronos\Chronos;

use Cake\Chronos\Chronos;

class PostsModel extends AppModel

{
    /**
     * @param int $status
     * @return array
     */
    public function getAllPostsByStatus($status = 1)
    {

        $table = 'posts';
        $data = [
            'posts.*',
            'users.username' => 'username',
            'categories.name' => 'category'
        ];
        $join1 = ['LEFT', 'users', 'users.id=posts.userID'];
        $join2 = ['LEFT', 'categories', 'categories.id=posts.categoryID'];

        $idCol = 'posts.status';
        $idColEasy = 'status';


        return $this->query->getColumnsJoin2Where($status, $data, $table, $join1, $join2, $idCol, $idColEasy);


    }

    public function getAllPostsByCategoryStatus($category, $status = 1)
    {

        $table = 'posts';
        $data = [
            'posts.*',
            'users.username' => 'username',
            'categories.name' => 'category'
        ];
        $join1 = ['LEFT', 'users', 'users.id=posts.userID'];
        $join2 = ['LEFT', 'categories', 'categories.id=posts.categoryID'];

        $idCol1 = 'posts.status';
        $idCol1Easy = 'status';
        $idCol2 = 'posts.categoryID';
        $idCol2Easy = 'categoryID';


        return $this->query->getColumnsJoin2Where2($status, $category, $data, $table, $join1, $join2, $idCol1, $idCol2, $idCol1Easy, $idCol2Easy);


    }

    public function getAllPostsByUser($userID)
    {

        $table = 'posts';
        $data = [
            'posts.*',
            'users.username' => 'username',
            'categories.name' => 'category'
        ];
        $join1 = ['LEFT', 'users', 'users.id=posts.userID'];
        $join2 = ['LEFT', 'categories', 'categories.id=posts.categoryID'];

        $idCol = 'posts.userID';
        $idColEasy = 'user';

        return $this->query->getColumnsJoin2Where($userID, $data, $table, $join1, $join2, $idCol, $idColEasy);

    }

    public function getAllPosts()
    {

        $table = 'posts';
        $data = [
            'posts.*',
            'users.username' => 'username',
            'categories.name' => 'category'
        ];
        $join1 = ['LEFT', 'users', 'users.id=posts.userID'];
        $join2 = ['LEFT', 'categories', 'categories.id=posts.categoryID'];
        return $this->query->getColumnsJoin2($data, $table, $join1, $join2);


    }

    public function getOnePost($id)
    {
        $table = 'posts';

        return $this->query->getOne($id, $table);
    }


    /**
     *
     */
    public function savePost(): void
    {
        //d($_POST);
        $table = 'posts';
        $title = htmlentities(strip_tags($_POST['title']));
        $content = htmlentities($_POST['content']);

        $image_name = $this->image->isImageSet($_FILES);

        $userId = UserModel::getUserIdIfLoggedIn();

        $date = new Chronos();
        $today = $date->toDateTimeString();
        if ($_POST['category'] != '0') {
            $category = $_POST['category'];
        } else {
            $category = 1;
        }

        $data = [
            'userID' => $userId,
            'categoryID' => $category,
            'title' => $title,
            'content' => $content,
            'date' => $today,
            'image' => $image_name,
        ];

        // d($data);
        $lastId = $this->query->insert($data, $table);
        $_SESSION['message'] = 'add_successful';
        header("Location: /post?id=$lastId");
        exit();

    }

    public function updatePost($id, $category, $title, $content, $file)
    {
        $table = 'posts';
        if ($file['image']['name'] != '') {
            $image_name = $this->image->isImageSet($_FILES);
            $data = [
                'categoryID' => strip_tags($category),
                'title' => strip_tags($title),
                'content' => $content,
                'image' => $image_name,
            ];
        } else {
            $data = [
                'categoryID' => strip_tags($category),
                'title' => strip_tags($title),
                'content' => $content,
            ];
        }

        $bindValues = ['ID' => $id];

        $idCol = 'ID';
        $this->query->update($data, $table, $bindValues, $idCol);
        $_SESSION['message'] = 'Post updated successful!';
        header("Location: /post?id=$id");
        exit();

    }

    public function changeStatus($id, $status)
    {
        $table = 'posts';

        $data = [
            'status' => $status,
        ];

        $bindValues = ['ID' => $id];

        $idCol = 'ID';
        $this->query->update($data, $table, $bindValues, $idCol);
        $_SESSION['message'] = 'Post updated successful!';
        header("Location: /post?id=$id");
        exit();

    }

    public function deletePostByID($id, $image)
    {

        $table = 'posts';
        $idCol = 'ID';
        $this->query->delete($id, $table, $idCol);
        $this->image->delete($image);
        $_SESSION['message'] = 'Post deleted successful!';
        header("Location: /admin/posts");
        exit();


    }

}
