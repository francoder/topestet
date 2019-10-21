<?php if (!empty($popularPosts)) { ?>
    <div class="inner">
        <h4>Популярные статьи</h4>
        <div class="list-of-articles">
            <?php $index = 0;
            foreach ($popularPosts as $popular) : ?>
                <?php //Debugger::dump($popular['PostCategory']) ?>
                <?php if ($index === 0) : ?>
                    <a href="/article/<?= $popular['Post']['alias'] ?>" class="item big-item">
                        <img src="<?= $this->Element("image",
                            [
                                "model" => "post",
                                "id" => $popular['Post']['id'],
                                "alias" => "image",
                                "type" => "main",
                            ]) ?>" alt="">
                        <div class="text">
                            <div class="theme"><?= $popular['PostCategory']['title'] ?></div>
                            <h4><?= DisplayHelper::short($popular['Post']['page_title'], 10) ?></h4>
                            <p><?= DisplayHelper::short($popular['Post']['description'], 10) ?></p>
                        </div>
                    </a>
                <?php else: ?>
                    <a href="/article/<?= $popular['Post']['alias'] ?>" class="item">
                        <img src="<?= $this->Element("image",
                            [
                                "model" => "post",
                                "id" => $popular['Post']['id'],
                                "alias" => "image",
                                "type" => $popular['Post']['id'] == 17 || 26 ? 'h' : "main",
                            ]) ?>" alt="">
                        <div class="text">
                            <div class="theme"><?= $popular['PostCategory']['title'] ?></div>
                            <h4><?= DisplayHelper::short($popular['Post']['page_title'], 4) ?></h4>
                            <p><?= DisplayHelper::short($popular['Post']['description'], 5) ?></p>
                        </div>
                    </a>
                <?php endif; ?>
                <?php $index++; endforeach; ?>
        </div>
    </div>
<?php } ?>
