<?php if (isset($post)) { ?>
    <div class="item">
        <div class="img">
            <img src="<?= $this->Element('image',
                [
                    'model' => 'post',
                    'id' => $post['Post']['id'],
                    'alias' => 'image',
                    'type' => 'entity',
                ]) ?>" alt="">
        </div>
        <div class="text">
            <div class="title">
                <?= $post['PostCategory']['title'] ?>
            </div>
            <div class="theme">
                <a href="/article/<?= $post['Post']['alias'] ?>"><?= $post['Post']['title'] ?></a>
            </div>
            <p>
                <?= CakeText::truncate(
                    $post['Post']['description'],
                    172,
                    [
                        'ellipsis' => '...',
                        'exact' => false,
                    ]);
                ?>
            </p>
        </div>
    </div>
<?php } ?>
