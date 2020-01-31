<?php

$this->layout('default', ['title' => 'Registration']) ?>

<h1 class="text-center">Registration</h1>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="/registeruser" method="POST">
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="username" class="form-control"> <br>
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control"> <br>
                    <label for="">Password confirm</label>
                    <input type="password" name="passwordconf" class="form-control"> <br>
                    <label for="">E-mail</label>
                    <input type="text" name="email" class="form-control"> <br>
                </div>
                <div class="form-group">
                    <button class="btn btn-success">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
