<?php
$this->layout('default', ['title' => 'Blog4all - Add post']);
if (array_key_exists('auth_logged_in', $_SESSION)) { ?>

    <h1 class="text-center">You can add your post here</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="/savepost" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Заголовок</label>
                        <input type="text" name="title" id="title" class="form-control"> <br>
                        <label for="category">Category</label>
                        <select name="category" id="category">
                            <option value="0">Choose post category</option>
                            <?php
                            foreach ($categories as $cat) { ?>
                                <option value="<?= $cat['ID'] ?>"><?= $cat['name'] ?></option>
                                <?php
                            } ?>
                        </select>
                        <textarea rows="8" cols="120" name="content" class="form-control" id="editor"> Enter your content :)</textarea>
                        <br>
                        <script>
                            ClassicEditor
                                .create(document.querySelector('#editor'))
                                .catch(error => {
                                    console.error(error);
                                });
                        </script>
                        <label for="image">Выберите главную картинку для статьи</label>
                        <input type="file" name="image" id="image">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success">Добавить запись</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>

    <h1 class="text-center">You can't add your post. <br>
        Please, <a href="/login">login</a> or <a href="/register">register</a></h1>

<?php }
