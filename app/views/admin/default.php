<?php
//d($_SESSION);
//d($_SERVER);?>
<html>
<head>
    <link rel="shortcut icon" href="../../public/images/favicon.png" type="image/png">
    <title><?= $this->e($title) ?></title>

    <script
            src="../../../public/js/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="../../../public/css/styleAdmin.css">

    <!--<script type="text/javascript" src="../../../public/js/ckeditor/adapter.js"></script>-->
    <script src="https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js"></script>
    <script src="../../public/js/pop_up_message.js"></script>
    <script src="../../public/js/on_top.js"></script>

</head>
<body>
<?php
if (($_SESSION['message'] != '') && ($_SESSION['message_status'] == 1)) { ?>

    <div class="pop_message msg_fail"><?php echo $_SESSION['message']; ?></div>

<?php } else { ?>
    <div class="pop_message msg_success"><?php echo $_SESSION['message']; ?></div> <?php
}
$_SESSION['message'] = '';
$_SESSION['message_status'] = 0; ?>


<div class="container">


    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Blog4all - admin</a>

        <div class="navbar-brand">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item"><a class="nav-link" href="/admin">Home-Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/users">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/posts">Posts</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/comments">Comments</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/categories">Categories</a></li>
            </ul>
        </div>
        <div class="navbar-brand">
            <ul class="navbar-nav mr-auto">
                <?php if (!array_key_exists('auth_logged_in', $_SESSION)) { ?>
                    <li class="nav-item"><a class="nav-link" href="/register">Registration</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link"
                                            href="#">Hello, <?php echo $_SESSION['auth_username'] ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
                <?php } ?>
            </ul>
        </div>

    </nav>

    <?= $this->section('content') ?>

</div>


<footer>
    <hr>
    Футер ради футера
    <div class="up">UP</div>
</footer>


</body>

<script>
    $(document).ready(function () {
        $('.up').on('click', function () {
            $(window).scrollTop(0);
        });
    })
</script>

</html>
