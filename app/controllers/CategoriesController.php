<?php

namespace app\controllers;

class CategoriesController extends AppController
{
    public function allCategories () {
        $categories = $this->categories->getAllCategories();
        $values = $this->categories->getCountPosts();

        echo $this->templates->render('categories', ['categories' => $categories, 'values' => $values]);

    }

    public function viewCategory () {

        $posts = $this->post->getAllPostsByCategoryStatus($_GET['id'], 1);
        $posts = array_reverse($posts);


        echo $this->templates->render('category', ['posts' => $posts]);

    }

    public function deleteCategory()
    {
        if (array_key_exists('auth_logged_in', $_SESSION) && $_SESSION['auth_roles'] === 1) {
            $image = $_GET['image'];
            $id = $_GET['id'];
            
            $this->categories->deleteCategoryByID($id, $image);
        }  else {
            $_SESSION['message']='Несанкционированное действие!';
            $_SESSION['message_status'] = 1;
            header("Location: /");
            exit();
        }

    }

    public function updateCategory()
    {
        if (array_key_exists('auth_logged_in', $_SESSION) && $_SESSION['auth_roles'] === 1) {

            $this->categories->updateCategory($_POST['id'], $_POST['name'], $_POST['description'], $_FILES);
        }  else {
            $_SESSION['message']='Несанкционированное действие!';
            $_SESSION['message_status'] = 1;
            header("Location: /");
            exit();
        }

    }
}