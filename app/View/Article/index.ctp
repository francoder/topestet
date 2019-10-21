</div>
<div class="blog-1">
    <div class="inner">
        <div class="left">
            <div class="navigation">
                <a href="/">Главная</a>
                <span>Блог</span>
            </div>
            <h1><?= $h1 ?></h1>
        </div>
        <div class="right">
            <img src="/images/gazeta.svg" alt="">
        </div>
    </div>
</div>
<div class="blog-2">
    <?= $this->Element('popular_articles') ?>
</div>
<div class="blog-2 other-mb">
    <div class="tabs js-tabs">
        <ul>
            <?php foreach ($postCategoryList as $categoryPost) {
                $class = isset($currentCategory) && $currentCategory['id'] === $categoryPost['PostCategory']['id'] ? 'selected' : '';
                ?>
                <li>
                    <a class="<?= $class ?>" href="/article/?category=<?= $categoryPost['PostCategory']['alias'] ?>">
                        <?= $categoryPost['PostCategory']['title'] ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="blog-6">
    <div class="inner">
        <div class="content-with-aside">
            <div class="content">
                <div class="list-of-news">
                    <?php foreach ($postList as $post) { ?>
                        <?= $this->Element('card_item_post', ['post' => $post]); ?>
                    <?php } ?>
                </div>

                <div class="bottom" style="margin-bottom: 20px;">
                    <div class="pagination">
                        <?= $this->Paginator->numbers([
                            'tag' => false,
                            'separator' => '',
                            'currentTag' => 'span',
                        ]) ?>
                    </div>
                </div>
            </div>

            <?= $this->Element('aside_with_banner', [
                'bannerCode' => 'hjhzhbkmfplwxawsxahvtyjhgxrqfxbvyo',
                'elementList' => [
                    'last_reviews',
                ],
            ]) ?>
        </div>
    </div>
</div>
