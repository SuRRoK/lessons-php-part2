<?php
//d($users);
$this->layout('admin/default', ['title' => 'Blog4all - Admin area']) ?>

<h1 class="text-center">Blog4all - Admin area</h1>
<div class="content">
    <br>
    <hr>


    <div class="newposts">
        <div class="newposts__title">
            <div class="newposts__title__name"><h3>List of the users!</h3></div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>E-mail</th>
                <th>Is Admin</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user) { ?>

                <tr>
                    <th scope="row"><?php echo $user['id']; ?></th>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php if ($user['roles_mask'] == 0) { ?>
                            <p class="giveadmin" id="<?php echo $user['id'] ?>">No. Give Admin role</p>

                        <?php } elseif ($user['roles_mask'] == 1) { ?>
                            <p class="removeadmin" id="<?php echo $user['id'] ?>">Yes. Remove Admin role</p>
                        <?php } ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>


    </div>

</div>

<script>


    $(document).ready(function () {
        $('p.giveadmin').click(function () {
            var idValue = $(this).attr('id');

            $.ajax({
                method: "POST",
                url: "/admin/giveadminrole",
                data: {id: idValue},
                beforeSend: function () {
                    $(`p#${idValue}`).text('Processing...');
                },
                complete: function () {
                    $(`p#${idValue}`).text('Yes. Remove Admin role');
                    $(`p#${idValue}`).attr('class', 'removeadmin');
                    alert("Admin role received!");
                }
            });


        })
        $('p.removeadmin').click(function () {
            var idValue = $(this).attr('id');

            $.ajax({
                method: "POST",
                url: "/admin/removeadminrole",
                data: {id: idValue},
                beforeSend: function () {
                    $(`p#${idValue}`).text('Processing...');
                },
                complete: function () {
                    $(`p#${idValue}`).text('No. Give Admin role');
                    $(`p#${idValue}`).attr('class', 'giveadmin');
                    alert("Admin role deleted!")
                }
            });

        })
    })


</script>
