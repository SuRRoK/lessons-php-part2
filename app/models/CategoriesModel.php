<?php

namespace app\models;

class CategoriesModel extends AppModel

{

    public function deleteCategoryByID($id,$image)
    {

        $table = 'categories';
        $idCol = 'ID';
        $this->query->delete($id, $table, $idCol);
        $this->image->delete($image);
        $_SESSION['message'] = 'Category deleted successful!';
        header("Location: /admin/categories");
        exit();


    }

    public function saveCategory()
    {
        $table = 'categories';
        $name = htmlentities($_POST['name']);
        $description = htmlentities($_POST['description']);

        $image_name = $this->image->isImageSet($_FILES);


        $data = [

            'name'        => $name,
            'description' => $description,
            'image'       => $image_name,
        ];

        $this->query->insert($data, $table);
        $_SESSION['message'] = 'Category added successful!';
        header("Location: /admin/categories");
        exit();

    }

    public function updateCategory($id, $name, $description, $file)
    {
        $table = 'categories';

        $name = htmlentities($name);
        $description = htmlentities($description);

        if ($file != null) {
            $image_name = $this->image->isImageSet($_FILES);
            $data = [
                'name'        => $name,
                'description' => $description,
                'image'       => $image_name,
            ];
        } else {

            $data = [
                'name'        => $name,
                'description' => $description,
            ];
        }

        $bindValues = ['ID' => $id];

        $idCol = 'ID';

        $this->query->update($data, $table, $bindValues, $idCol);
        $_SESSION['message'] = 'Category updated successful!';
        header("Location: /admin/categories");
        exit();

    }

    public function getAllCategories()
    {

        $table = 'categories';
        return $this->query->getAll($table);

    }

    public function getCountPosts()
    {

        $table = 'posts';
        $data =['categoryID'];
        $array = $this->query->getColumns($data,$table);
        return array_count_values($array);

    }

}
