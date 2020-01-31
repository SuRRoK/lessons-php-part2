<?php
// Start a Session
if (!session_id()) {
    @session_start();
}

if (!array_key_exists('message',$_SESSION)) {
    $_SESSION['message'] = '';
    $_SESSION['message_status'] = 0;
}

require_once '../vendor/autoload.php';
include_once '../app/config-db.php';
include_once '../app/config-mail.php';


use app\{
    controllers\AdminController,
    controllers\HomeController,
    controllers\PostController,
    controllers\UserController,
    controllers\CategoriesController,
    controllers\CommentController,
    models\UserModel,
    models\PostsModel,
    models\CommentModel,
    models\CategoriesModel
};
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\ContainerBuilder;
use League\Plates\Engine;

//Initialise PHP-DI
$builder = new ContainerBuilder();

//Exceptions for PHP-DI
$builder->addDefinitions([
    Engine::class => function () {
        return new Engine('../app/views');
    },

    PDO::class => function () use ($password, $username, $db_name, $host, $driver) {
        return new PDO("$driver:host=$host;dbname=$db_name", $username, $password);
        //d(PDO::class);
    },

    QueryFactory::class => function () {
        return new QueryFactory('mysql');
    },

    Auth::class => function ($container) {
        return new Auth($container->get('PDO'));
    },

    Swift_SmtpTransport::class =>  function () use ($smtp_host,$smtp_port,$protocol) {
        return new Swift_SmtpTransport ($smtp_host,$smtp_port, $protocol);
    }

]);

$container = $builder->build();


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
//Routes
    $r->addRoute('GET', '/home',        [HomeController::class, 'index']);
    $r->addRoute('GET', '/',            [HomeController::class, 'index']);
    $r->addRoute('GET', '/about',       [HomeController::class, 'about']);
    $r->addRoute('GET', '/404',       [HomeController::class, 'notFound']);
    $r->addRoute('GET', '/405',       [HomeController::class, 'notAllowed']);
    $r->addRoute('GET', '/login',       [UserController::class, 'login']);
    $r->addRoute('GET', '/register',    [UserController::class, 'register']);
    $r->addRoute('GET', '/account',     [UserController::class, 'account']);
    $r->addRoute('GET', '/addpost',     [PostController::class, 'addPost']);
    $r->addRoute('POST', '/updatepost',     [PostController::class, 'updatePost']);
    $r->addRoute('GET', '/editpost',     [PostController::class, 'editPost']);
    $r->addRoute('POST', '/savepost',   [PostsModel::class, 'savePost']);
    $r->addRoute('POST', '/deactivatepost',   [PostController::class, 'setAsInactive']);
    $r->addRoute('POST', '/activatepost',   [PostController::class, 'setAsActive']);
    $r->addRoute('GET', '/deletepost',   [PostController::class, 'deletePost']);
    $r->addRoute('GET', '/post',       [PostController::class, 'viewPost']);
    $r->addRoute('GET', '/posts',       [PostController::class, 'allPosts']);
    $r->addRoute('POST', '/registeruser', [UserController::class, 'tryRegister']);
    $r->addRoute('GET', '/confirmreg',  [UserModel::class, 'confirmReg']);
    $r->addRoute('POST', '/trylogin',   [UserModel::class, 'tryLogin']);
    $r->addRoute('GET', '/logout',      [UserModel::class, 'logOut']);
    $r->addRoute('POST', '/savecategory',   [CategoriesModel::class, 'saveCategory']);
    $r->addRoute('GET', '/deletecategory',   [CategoriesController::class, 'deleteCategory']);
    $r->addRoute('POST', '/updatecategory',   [CategoriesController::class, 'updateCategory']);
    $r->addRoute('GET', '/categories',   [CategoriesController::class, 'allCategories']);
    $r->addRoute('GET', '/category',   [CategoriesController::class, 'viewCategory']);
    $r->addRoute('GET', '/admin',       [AdminController::class, 'admin']);
    $r->addRoute('GET', '/admin/users', [AdminController::class, 'adminUsers']);
    $r->addRoute('GET', '/admin/posts', [AdminController::class, 'adminPosts']);
    $r->addRoute('GET', '/admin/editpost', [AdminController::class, 'adminEditPost']);
    $r->addRoute('GET', '/admin/comments', [AdminController::class, 'adminComments']);
    $r->addRoute('GET', '/admin/categories', [AdminController::class, 'adminCategories']);
    $r->addRoute('POST', '/admin/giveadminrole', [AdminController::class, 'giveAdminRole']);
    $r->addRoute('POST', '/admin/removeadminrole', [AdminController::class, 'removeAdminRole']);
    $r->addRoute('POST', '/savecomment',      [CommentModel::class, 'saveComment']);
    $r->addRoute('GET', '/deletecomment',      [CommentController::class, 'deleteComment']);
});


// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
// d($routeInfo);
switch ($routeInfo[0]) {

    case FastRoute\Dispatcher::NOT_FOUND:
        header("Location: /404");
        exit();

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        header("Location: /405");
        exit();

    //Success request
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        //$container->call($routeInfo[1],$routeInfo[2]);
        $container->call($handler, ['vars' => $vars]);

        //Before DI
//         $controller = new $handler[0];
//         $controller->{$handler[1]}($vars);
        break;


}

