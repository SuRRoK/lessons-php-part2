<?php

$this->layout('default', ['title' => 'Blog4all - All categories']) ?>

<h1 class="text-center">All categories</h1>
<div class="content">


    <div class="categories">
        <table class="table">
            <thead>
            <tr>

                <th>Image</th>
                <th>Name</th>
                <th>Description</th>

            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $cat) {
                $id = $cat['ID']; ?>

                <tr>

                    <th class="align-middle" scope="row"><?php if ($cat['image'] != '') { ?>
                            <div class="cat_list__picture">
                                <img src="/images/<?= $cat['image'] ?> "
                                     alt="<?= html_entity_decode($cat['name']) ?>"
                                     class="img-fluid img-cat-thumbnail pic<?= $id; ?>">
                            </div>
                        <?php } else { ?>
                            <div class="cat_list__picture">
                                <img src="/images/no_image.png"
                                     class="img-fluid img-cat-thumbnail pic<?= $id; ?>">
                            </div>
                        <?php } ?></th>
                    <td class="align-middle name<?= $id; ?>"><a
                                href="/category?id=<?= $id; ?>"><?= html_entity_decode($cat['name']); ?>
                            (<?php
                            if ($values[$id] > 0) {
                                echo $values[$id];
                            } else {
                                echo '0';
                            }
                            ?>)</a></td>
                    <td class="align-middle desc<?= $id; ?>"><?= html_entity_decode($cat['description']); ?></td>

                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>


