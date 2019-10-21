</div>
<div class="page-article-1">
    <div class="inner">
        <div class="navigation">
            <a href="/">Главная</a>
            <a href="/article/">Блог</a>
            <span>
          <?= DisplayHelper::short($post['Post']['title'], 14) ?>
      </span>
        </div>
        <div class="left">
            <h1><?= $post['Post']['page_title'] ?></h1>
            <div class="bottom">
                <a href="/article/?category=<?= $post['PostCategory']['alias'] ?>" class="theme">
                    <?= $post['PostCategory']['title'] ?>
                </a>
                <?php $date = date_create($post['Post']['updated']); ?>
                <span><?= date_format($date, 'd.m.Y') ?></span>
            </div>
        </div>
        <div class="right">
            <?php if (!$post['Post']['hide_pic']): ?>
                <img src="<?= $this->Element('image',
                    [
                        'model' => 'post',
                        'id' => $post['Post']['id'],
                        'alias' => 'image',
                        'type' => 'main',
                    ]) ?>" style="height: 100%; width: 280px" alt="">
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="inner">
    <div class="content-with-aside page-article">
        <div class="content">
            <?php echo $post['Post']['content'] ?>
            <div class="page-service-2">
            </div>
            <?php if (isset($usefullArticles)): ?>
                <div class="page-article-2">
                    <h4>Полезные статьи</h4>
                    <div class="list">
                        <?php $index = 1;
                        foreach ($usefullArticles as $article): ?>
                            <a href="/article/<?= $article['Post']['alias'] ?>" class="item">
                                <div class="img">
                                    <img src="/images/icon-<?= $index ?>.svg" alt="">
                                </div>
                                <div class="text">
                                    <div class="theme"><?= $article['PostCategory']['title'] ?></div>
                                    <p><?= $article['Post']['title'] ?></p>
                                </div>
                            </a>
                            <?php $index++; endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($last_interest)): ?>
                <?= $this->Element('slider_last_interest', ['last_interest' => $last_interest]) ?>
            <?php endif; ?>
            <div class="page-clinic-3">
                <?php if (isset($best_for_service)) : ?>
                    <?= $this->Element('best_specialists_service') ?>
                <?php endif; ?>
            </div>
        </div>

        <?= $this->Element('aside_with_banner', [
            'bannerCode' => 'hvdvbtpojktkayxvttnooxbrxtuccdvmkr',
            'elementList' => [
                'last_reviews',
            ],
        ]) ?>
    </div>
</div>
<div class="other-articles">
    <div class="inner">
        <?= $this->Element('useful_posts') ?>
    </div>
</div>
