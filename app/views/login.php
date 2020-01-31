<?php
$this->layout('default', ['title' => 'Blog4All - Login page']); ?>

<h1 class="text-center">Login</h1>


<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="/trylogin" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">E-mail</label>
                    <input type="text" name="email" class="form-control"> <br>
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control"> <br>

                </div>
                <div class="form-group">
                    <button class="btn btn-success">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
