<div class="reviews-slider">
    <?php foreach ($last_interest as $item): ?>
        <div>
            <a href="/article/<?= $item['Post']['alias'] ?>">
                <img src="<?= $this->Element("image",
                    [
                        "model" => "post",
                        "id" => $item['Post']['id'],
                        "alias" => "image",
                        "type" => "main",
                        "onlyurl" => true,
                    ]) ?>" alt="">
            </a>
            <div class="slider-text">
                <a href="/article/?category=<?= $item['PostCategory']['alias'] ?>">
                    <div class="who"><?= $item['PostCategory']['title'] ?></div>
                </a>
                <a href="/article/<?= $item['Post']['alias'] ?>">
                    <div class="title"><?= $item['Post']['page_title'] ?></div>
                </a>

                <a href="/article/<?= $item['Post']['alias'] ?>"><p><?= $item['Post']['description'] ?></p></a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
