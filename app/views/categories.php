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
                                <img src="/images/<?php echo $cat['image'] ?> "
                                     alt="<?php echo html_entity_decode($cat['name']) ?>"
                                     class="img-fluid img-cat-thumbnail pic<?php echo $id; ?>">
                            </div>
                        <?php } else { ?>
                            <div class="cat_list__picture">
                                <img src="/images/no_image.png"
                                     class="img-fluid img-cat-thumbnail pic<?php echo $id; ?>">
                            </div>
                        <?php } ?></th>
                    <td class="align-middle name<?php echo $id; ?>"><a
                                href="/category?id=<?php echo $id; ?>"><?php echo html_entity_decode($cat['name']); ?>
                            (<?php
                            if ($values[$id] > 0) {
                                echo $values[$id];
                            } else {
                                echo '0';
                            }
                            ?>)</a></td>
                    <td class="align-middle desc<?php echo $id; ?>"><?php echo html_entity_decode($cat['description']); ?></td>

                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>


