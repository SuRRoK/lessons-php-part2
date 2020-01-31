<?php
$this->layout('admin/default', ['title' => 'Edit post by Admin']);
if (array_key_exists('auth_logged_in', $_SESSION) && ($_SESSION['auth_roles'] === 1)) { ?>

    <h1 class="text-center">Edit post here</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="/updatepost" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                               value="<?php echo html_entity_decode($post['title']) ?>"> <br>
                        <label for="category">Category</label>
                        <select name="category" id="category">
                            <option value="0">Choose post category</option>
                            <?php
                            foreach ($categories as $cat) {
                                if ($post['categoryID'] == $cat['ID']) { ?>
                                    <option selected value="<?= $cat['ID'] ?>"><?= $cat['name'] ?></option>
                                <?php } else { ?>

                                    <option value="<?= $cat['ID'] ?>"><?= $cat['name'] ?></option>
                                <?php }
                            } ?>
                        </select>
                        <textarea rows="8" cols="120" name="content" class="form-control"
                                  id="editor"> <?php echo html_entity_decode($post['content']) ?></textarea> <br>
                        <script>
                            ClassicEditor
                                .create(document.querySelector('#editor'))
                                .catch(error => {
                                    console.error(error);
                                });
                        </script>
                        <label for="image">Updates picture if already exist or set image if not yet</label>
                        <input type="file" name="image" id="image">
                        <input type="hidden" name="id" value="<?php echo $post['ID'] ?>">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning">Edit post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>

    <h1 class="text-center">You can't edit this post. <br>
        Please, <a href="/login">login</a> or <a href="/register">register</a</h1>

<?php }
