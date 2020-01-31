<?php
//d($users);
//d($posts)
$this->layout('admin/default', ['title' => 'Blog4all - Admin area']);
?>

<h1 class="text-center">Blog4all - Admin area</h1>
<div class="content">
    <br>
    <hr>


    <div class="newposts">
        <div class="newposts__title">
            <div class="newposts__title__name"><h3>List of the posts!</h3></div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Date</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($posts as $post) { ?>

                <tr>
                    <th scope="row"><?php echo $post['ID']; ?></th>
                    <td class="posttitle"><a href="/post?id=<?php echo $post['ID'] ?>"><?php echo $post['title']; ?></a>
                    </td>
                    <td><?php echo $post['category']; ?></td>
                    <td><?php echo $post['username']; ?></td>
                    <td><?php echo $post['date']; ?></td>
                    <td>
                        <p class="foreach activepost" id="<?php echo $post['ID']; ?>"
                           status="<?php echo $post['status']; ?>" title="Deactivate post"> Active </p>

                        <p class="foreach notactivepost" id="<?php echo $post['ID']; ?>"
                           status="<?php echo $post['status']; ?>" title="Activate post"> Not active </p>
                    </td>

                    <td><a class="btn btn-warning edit" href="/admin/editpost?id=<?php echo $post['ID'] ?>">Edit</a>
                    </td>
                    <td><a class="btn btn-danger delete"
                           href="/deletepost?id=<?php echo $post['ID'] ?>&image=<?php echo $post['image']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>


    </div>

</div>

<script>
    $(document).ready(function () {
        var foreach = $('.foreach');
        foreach.each(function () {
            if ($(this).attr('status') == 1 && $(this).attr('class') == 'foreach notactivepost') {
                $(this).hide();
            }
            if ($(this).attr('status') == 0 && $(this).attr('class') == 'foreach activepost') {
                $(this).hide();
            }
        })

        $('p.activepost').click(function () {
            var idValue = $(this).attr('id');
            var current = $(`p#${idValue}`);
            var notactive = $(`p#${idValue} + *`);
            console.log(notactive.text());
            $.ajax({
                method: "POST",
                url: "/deactivatepost",
                data: {'id': idValue},
                beforeSend: function () {
                    current.text('Processing...');
                },
                complete: function () {
                    current.text('Active');
                    current.hide();
                    notactive.show();

                    // alert("Post deactivated!");
                }
            });
        })

        $('p.notactivepost').click(function () {
            var idValue = $(this).attr('id');
            var current = $(`p#${idValue}+ *`);
            var notactive = $(`p#${idValue}`);
            console.log(notactive.text());
            $.ajax({
                method: "POST",
                url: "/activatepost",
                data: {'id': idValue},
                beforeSend: function () {
                    current.text('Processing...');
                },
                complete: function () {
                    current.text('Not active');
                    current.hide();
                    notactive.show();

                }
            });
        })

    })

</script>
