<?php

$this->layout('admin/default', ['title' => 'Blog4all - Admin area']) ?>

<h1 class="text-center">Blog4all - Admin area</h1>
<div class="content">
    <br>
    <hr>


    <div class="newposts">
        <div class="newposts__title">
            <div class="newposts__title__name"><h3>List of the categories!</h3></div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $cat) { ?>

                <tr>
                    <th class="align-middle"><?php echo $cat['ID']; ?></th>
                    <th class="align-middle" scope="row"><?php if ($cat['image'] != '') { ?>
                            <div class="cat_list__picture">
                                <img src="/images/<?php echo $cat['image'] ?> "
                                     alt="<?php echo html_entity_decode($cat['name']) ?>"
                                     class="img-fluid img-cat-thumbnail pic<?php echo $cat['ID']; ?>">
                            </div>
                        <?php } else { ?>
                            <div class="cat_list__picture">
                                <img src="/images/no_image.png"
                                     class="img-fluid img-cat-thumbnail pic<?php echo $cat['ID']; ?>">
                            </div>
                        <?php } ?></th>
                    <td class="align-middle name<?php echo $cat['ID']; ?>"><?php echo html_entity_decode($cat['name']); ?></td>
                    <td class="align-middle desc<?php echo $cat['ID']; ?>"><?php echo html_entity_decode($cat['description']); ?></td>
                    <td class="align-middle">
                        <p class="edit_cat btn btn-warning" id="<?php echo $cat['ID']; ?>">Edit</p>
                        <a href="/deletecategory?id=<?php echo $cat['ID'] ?>&image=<?php echo $cat['image']; ?>"
                           class="btn btn-danger">Delete</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>


    </div>
    <hr>
    <h3 class="edit_add_block">Add new category!</h3>

    <form action="/savecategory" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Category name</label>
            <input type="text" name="name" id="name" class="form-control"> <br>
            <textarea rows="8" cols="120" name="description" class="form-control" id="editor"> Enter description the category</textarea>
            <br>

            <label for="image">Updates picture if already exist or set image if not yet</label>
            <input type="file" name="image" id="image">
        </div>
        <div class="form-group">
            <button class="btn btn-success add_cat">Add category</button>
        </div>
    </form>
    <div class="modify_cat" id="botDiv">
        <button class="btn btn-warning modify" id="0">Modify category</button>
    </div>
    <div>
        <p class="response">

        </p>

    </div>

</div>


<script>


    $(document).ready(function () {

        $('p.edit_cat').click(function () {
            var idValue = $(this).attr('id');
            var nameValue = $('.name' + idValue).text();
            var descValue = $('.desc' + idValue).text();
            var picValue = $('.pic' + idValue).attr('src');
            $('.edit_add_block').text('Edit category #' + idValue);
            $('input#name').val(nameValue);
            $('textarea#editor').val(descValue);
            $('button.add_cat').hide();
            $('.modify_cat').show();
            $('button.modify').attr('id', idValue);

            console.log(picValue);
            if (picValue == '/images/no_image.png') {

                $('input#image, label[for=image]').show();
                $('input#image').val('');
            } else {
                // $('input#image, label[for=image]').hide();
            }

            $('html, body').animate({scrollTop: $('.modify_cat').height() + 2000}, "slow");
        })

        $('button.modify').click(function () {

            var formData = new FormData();

            var idValue = $(this).attr('id');
            var nameValue = $('input#name').val();
            var descValue = $('textarea#editor').val();
            var file = $('#image')[0].files[0];

            formData.append('id', idValue);
            formData.append('name', nameValue);
            formData.append('description', descValue);
            formData.append('image', file);
            //console.log(file) ;
            console.log(formData);
            $.ajax({
                type: "POST",
                url: "/updatecategory",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('button.modify').text('Processing...');
                },
                complete: function () {
                    $('button.modify').text('Modify category ');
                },
                success: function () {
                    alert('Success');
                }
            })
        })

    })


</script>
