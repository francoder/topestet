</div>
<div class="doctor-page-1">
    <div class="inner">
        <div class="left">
            <div class="navigation">
                <a href="/">Главная</a>
                <a href="/catalog/">Специалисты</a>
                <span>Врач</span>
            </div>
            <div class="about-doctor">
                <div class="img">
                    <img style="border-radius: 50%"
                         src="<?= $this->Element("image", [
                             "id" => $specialist['User']['id'],
                             "type" => "main",
                             "noimage" => true,
                             "alias" => "avatar",
                             "model" => "user",
                             'onlyurl' => true,
                         ]); ?>"
                         alt="">
                </div>
                <div class="text">
                    <h1><?= $specialist['User']['name'] ?></h1>
                    <p><?= $specialist['User']['profession'] ?></p>
                    <p></p>
                </div>
                <div class="date">
                    <div class="top">
                        <p><?= DisplayHelper::formatRating($specialist['User']['rate']) ?></p>
                        <a href="#review"><?= DisplayHelper::pluralReview($review_count) ?></a>
                    </div>
                    <p>рейтинг</p>
                    <?php
                    if ($specialist['User']['coast_avg'] <= 30000) {
                        $coast = '₽';
                    } else if ($specialist['User']['coast_avg'] > 30000 && $specialist['User']['coast_avg'] <= 100000) {
                        $coast = '₽₽';
                    } else {
                        $coast = '₽₽₽';
                    }
                    ?>
                    <span><?= $coast ?></span>
                </div>
            </div>
        </div>
        <div class="right">
            <?php if (!empty($clinics)) : ?>
                <div class="place-of-work-slider">
                    <? foreach ($clinics as $spec): ?>
                        <div>
                            <div class="name"><?= $spec['Clinic']['name'] ?></div>
                            <p><?= $spec['Clinic']['profession'] ?></p>
                            <div class="address"><?= $spec['Clinic']['address'] ?></div>
                            <div class="phone"><?= $spec['Clinic']['phone'] ?></div>
                            <a href="/clinic/profile/<?= $spec['Clinic']['id'] ?>/">Подробнее о клинике</a>
                            <div class="logo">
                                <img src="<?= $this->Element("image", [
                                    "model" => "user",
                                    "type" => "mini",
                                    "alias" => "avatar",
                                    "id" => $spec['Clinic']['id'],
                                    "noimage" => true,
                                    'onlyurl' => true,
                                ]) ?>" alt=""></div>
                        </div>
                    <? endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="blog-2 scrolled-element-for-fixed">
    <div class="anchors">
        <ul>
            <li><a href="#yak-1" class="yak">Общая информация</a></li>
            <li><a href="#yak-2" class="yak">Профиль работ</a></li>
            <li><a href="#yak-3" class="yak">Результаты работ</a></li>
            <li><a href="#yak-4" class="yak">Статьи и советы</a></li>
            <li><a href="#review" class="yak">Отзывы <?= $review_count ?></a></li>
        </ul>
    </div>
</div>
<div class="inner">
    <div class="content-with-aside">
        <div class="content">
            <div class="doctor-page-2" id="yak-1">
                <h4>Общая информация</h4>
                <?= $this->Display->format($specialist['User']['description']) ?>
            </div>
            <div class="doctor-page-3" id="yak-2">
                <h4>Выполняемые операции и процедуры</h4>
                <div class="list">
                    <ul>
                        <?php foreach ($specialist['Service'] as $service): ?>
                            <li>
                                <a href="/service/<?= $service['alias'] ?>/"><?= $service['title'] ?></a>
                                <?php $service['SpecialistService']['rate_count'] > 0 ? '<span>' . $service['SpecialistService']['rate_count'] . '</span>' : '' ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php if (!empty($specialist['Photospec'])) : ?>
                <div class="doctor-page-4" id="yak-3">
                    <h4>Результаты работ</h4>
                    <?= $this->Element("photospecs", [
                        "photos" => $specialist['Photospec'], "without_user" => false,
                    ]); ?>
                    <div class="doctor-page-4-all-work">
                        <a href="/service/photo_specialist/<?= $specialist['User']['id'] ?>" class="btn"
                           target="_blank" rel="nofollow noopener">Все работы</a>
                    </div>
                </div>
            <?php endif; ?>
            <div class="doctor-page-5" id="review">
                <h4>Последние отзывы</h4>
                <div class="reviews-list">
                    <?php foreach ($reviews as $review) : ?>
                        <?= $this->Element('card_item_review', ['review' => $review, 'showReviewUser' => true]) ?>
                    <?php endforeach; ?>
                </div>
                <div class="bottom">
                    <?php $pr = $this->Paginator->params('Review');
                    $this->Paginator->options(['url' => [$specialist['User']['id'], 'review'], 'model' => 'Review']);
                    ?>
                    <?php if ($pr['nextPage']) : ?>
                        <?=
                        str_replace(
                            '/" class="btn"',
                            '/#yak-3" class="btn"',
                            str_replace(
                                "/doctors/{$specialist['User']['id']}/review/",
                                "/specialist/profile/{$specialist['User']['id']}/",
                                $this->Paginator->next(
                                    'следующие 5 отзывов',
                                    [
                                        'tag' => false,
                                        'disabledTag' => true,
                                        'class' => 'btn',
                                    ],
                                    null,
                                    null
                                )
                            )
                        );
                        ?>
                    <?php endif; ?>
                    <?php if ($pr['prevPage']) : ?>
                        <?=
                        str_replace(
                            '/" class="btn"',
                            '/#yak-3" class="btn"',
                            str_replace(
                                "/doctors/{$specialist['User']['id']}/review/",
                                "/specialist/profile/{$specialist['User']['id']}/",
                                $this->Paginator->prev(
                                    'предыдущие 5 отзывов',
                                    [
                                        'tag' => false,
                                        'disabledTag' => true,
                                        'class' => 'btn',
                                    ],
                                    null,
                                    null
                                )
                            )
                        );
                        ?>
                    <?php endif; ?>
                    <a href="/reviews/add_review/" class="btn btn-blue">Оставить отзыв</a>
                </div>
            </div>
        </div>

        <?php
        $specialistSpecialization = mb_strpos($specialist['User']['profession'], 'хирург') ? 'plastica' : 'cosmetology';
        switch ($specialistSpecialization) {
            case 'plastica':
                $bannerCode = 'mokbklchsomokbyjgtgxdhsjroejqktekj';
                break;
            case 'cosmetology';
                $bannerCode = 'glducdfkkwidmorobftjxbqsexruvnpmuu';
                break;
        }
        ?>

        <?= $this->Element('aside_with_banner', [
            'bannerCode' => $bannerCode,
            'elementList' => [
                'last_reviews',
            ],
        ]) ?>
    </div>
</div>
<div class="other-articles" id="yak-4">
    <div class="inner">
        <?= $this->Element('useful_posts') ?>
    </div>
</div>
<?= $this->Element('forms/create_review'); ?>
