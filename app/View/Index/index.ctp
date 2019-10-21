<!--#include file="header.html" -->
</div>
<div class="main">
    <div class="inner">
        <div class="text">
            <h1>Информационный портал о пластической
                хирургии и косметологии</h1>
            <p>Все о главном тренде сезона: лучшие хирурги, операции и цены, фото до и после</p>
            <!-- <a href="/maintenance/" class="btn">Подробнее</a> -->
        </div>
        <div class="img"><img src="/images/face.png" alt=""></div>
        <?= $this->Element('slider_last_problems', ['last_problems' => $last_problems]) ?>
    </div>
</div>
<?= $this->Element('slider_services') ?>

<div class="search-review">
    <div class="inner">
        <h2>Находите только проверенные отзывы
            по интересующим вас услугам</h2>
        <p>Тысячи пациентов по всей стране размещают здесь честные отзывы!</p>
        <form class="input" id="frm-main-search" action="/reviews/" method="get">
            <input type="text" id="input-main-search" type="text" name="procedure"
                   placeholder="Какая услуга вас интересует?">
            <button></button>
        </form>
        <p class="example">например, <a href="/reviews/plastica/abdominoplastica/">абдоминопластика</a> или <a
                    href="/reviews/plastica/uvelichenie-grudi/">увеличение груди</a></p>
    </div>
    <div class="list-of-reviews">
        <a href="/reviews/cosmetology/" class="item">
            <img src="/images/review-1.png" alt="">
            <div class="text">
                <h3>Отзывы о косметологических
                    процедурах</h3>
                <button class="btn">все отзывы</button>
            </div>
        </a>
        <a href="/reviews/plastica/" class="item">
            <img src="/images/review-2.png" alt="">
            <div class="text">
                <h3>Отзывы о пластических
                    операциях</h3>
                <button class="btn">все отзывы</button>
            </div>
        </a>
    </div>
</div>

<div class="list-of-doctors-on-main">
    <h2>Находите <span>проверенных врачей и клиники</span> с рекомендациями</h2>
    <p>Среди тысячи специалистов по всей России</p>
    <div class="list-of-doctors-on-main-slider">
        <? foreach ($top_specialists_all as $specialist): ?>
            <div class="item">
                <div class="position">Топ 10</div>
                <div class="top">
                    <a class="img"
                       href="/specialist/profile/<?= $specialist['User']['id'] ?>/">
                        <img src="<?= $this->Element("image",
                            [
                                "model" => "user",
                                "id" => $specialist['User']['id'],
                                "alias" => "avatar",
                                "type" => "mini",
                                "noimage" => true,
                                "onlyurl" => true,
                            ]) ?>" style="border-radius: 50%; ">
                    </a>
                    <?php if(false != $specialist['User']['rate']) { ?>
                    <div class="text">
                        <div class="up">
                            <p><?= DisplayHelper::formatRating($specialist['User']['rate']) ?></p>
                            <a href="/specialist/profile/<?= $specialist['User']['id'] ?>/#yak-3">
                            <?= DisplayHelper::pluralReview(count($specialist['Review'])) ?></a>
                        </div>
                        <div class="down">рейтинг</div>
                    </div>
                    <?php } ?>
                </div>

                <a href="/specialist/profile/<?= $specialist['User']['id'] ?>/">
                    <div class="name">
                        <?= $specialist['User']['name'] ?>
                    </div>
                    <div class="info">
                        <p><?= $specialist['User']['profession'] ?></p>
                    </div>
                </a>
                <div class="address">
                    <?php if (isset($specialist['Clinic'])) : ?>
                        <a href="/clinic/profile/<?= $specialist['Clinic']['id'] ?>"><?= $specialist['Clinic']['name'] ?></a>
                        <p><?= $specialist['Clinic']['address'] ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>

<div class="reviews">
    <div class="inner">
        <div class="slider">
            <?= $this->Element('slider_last_interest', ['last_interest' => $last_interest]) ?>
        </div>
        <?= $this->Element('last_reviews', ['last_reviews' => $last_reviews]) ?>
    </div>
</div>
<div class="inner">
    <div class="news">
        <h2><a href="/article/">Новости и полезные статьи</a></h2>
        <div class="news-slider">
            <? foreach ($last_publications as $post): ?>
                <div>
                    <a href="/article/<?= $post['Post']['alias'] ?>/">
                        <img src="<?= $this->Element("image",
                            [
                                "model" => "post",
                                "id" => $post['Post']['id'],
                                "alias" => "image",
                                "type" => "main",
                                "onlyurl" => true,
                            ]) ?>" style="height: 200px; width: 280px" alt="">
                    </a>
                    <div class="text">
                        <a href="/article/#tab-2-<?= $post['PostCategory']['id'] ?>" class="theme" style="min-height:
                        auto;
"><?=
                            $post['PostCategory']['title'] ?></a>
                        <a href="/article/<?= $post['Post']['alias'] ?>/"><?= $post['Post']['title'] ?></a>
                        <p><?= DisplayHelper::short($post['Post']['description'], 10); ?></p>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
    <!--#include file="footer.html" -->
