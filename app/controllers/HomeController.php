<?php

namespace app\controllers;

class HomeController extends AppController

{
    public function index()
    {


        $posts = $this->post->getAllPostsByStatus();

        $posts = array_slice($posts, -5, 5, true);
        $posts = array_reverse($posts);

        echo $this->templates->render('homepage', ['posts' =>$posts]);

    }

    public function about()
    {

        echo $this->templates->render('about');

    }
    public function notFound()
    {

        echo $this->templates->render('404');

    }    public function notAllowed()
    {

        echo $this->templates->render('405');

    }
}