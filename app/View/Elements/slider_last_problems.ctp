<div class="slider">
    <div class="problems-slider">
        <?php $index = 0;
        foreach ($last_problems as $item) : ?>
            <div class="<?= $index % 2 === 0 ? 'blue' : 'red' ?>">
                <a href="/article/#tab-2-<?= $item['PostCategory']['id'] ?>">
                    <div class="theme"><?= $item['PostCategory']['title'] ?></div>
                </a>
                <div class="title">
                    <a href="/article/<?= $item['Post']['alias'] ?>"><?= $item['Post']['title'] ?></a>
                </div>
                <p><?= DisplayHelper::short($item['Post']['page_description'], 10) ?></p>
            </div>
            <?php $index++; endforeach; ?>
    </div>
</div>
