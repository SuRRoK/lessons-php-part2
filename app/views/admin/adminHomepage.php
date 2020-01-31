<?php

$this->layout('admin/default', ['title' => 'Blog4all - Admin area']);
?>

<h1 class="text-center">Blog4all - Admin area</h1>
<div class="content">
    Добро пожаловать, тут вы царь и бог! <br>
    <hr>


    <div class="our-base">
        <table class="table">
            <thead>
            <tr>
                <th>Table</th>
                <th>Count</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($nums as $key => $value) { ?>

                <tr>

                    <td><a href="/admin/<?php echo strtolower($key); ?>"><?php echo $key ?></a></td>
                    <td><?php echo $value ?></td>

                </tr>
            <?php } ?>
            </tbody>
        </table>


    </div>

</div>
