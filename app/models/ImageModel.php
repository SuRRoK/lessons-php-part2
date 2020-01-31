<?php

namespace app\models;


use Delight\Auth\Auth;

class ImageModel

{
    /**
     * @param $image
     * @return string
     */
    public function upload($image): string
    {
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $new_name = Auth::createRandomString(16);
        $pic_name = $new_name . '.' . $extension;
        $tmp_name = $image['tmp_name'];
        move_uploaded_file($tmp_name, "images/" . $pic_name);
        return $pic_name;
    }

    /**
     * @param $imageFileArray
     * @return string
     */
    public function isImageSet($imageFileArray): ?string
    {
        if ($imageFileArray['image']['name'] != '') {
            return $this->upload($imageFileArray['image']);
        } else {
            return '';
        }
    }

    /**
     * @param $image
     */
    public function delete($image): void
    {
        if (is_file('images/' . $image)) {
            unlink('images/' . $image);
        }

    }

    public function changeImage($current_image, $new_image)
    {
        if ($current_image != '' && $new_image != '') {
            $this->delete($current_image);
        }
    }

}
