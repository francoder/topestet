</div>
<div class="page-clinic-1">
    <div class="inner">
        <div class="left">
            <div class="navigation">
                <a href="/">Главная</a>
                <a href="/search/clinics/">Клиники</a>
                <span>Клиника</span>
            </div>
            <div class="about-clinic">
                <div class="logo">
                    <img src="<?= $this->Element('image',
                        [
                            'model' => 'user',
                            'type' => 'mini',
                            'alias' => 'avatar',
                            'id' => $specialist['User']['id'],
                        ]) ?>" alt="">
                </div>
                <div>
                    <h1 class="title"><?= $specialist['User']['name'] ?></h1>
                    <p><?= $specialist['User']['profession'] ?></p>
                    <div class="address"><?= $specialist['User']['address'] ?></div>
                    <div class="phone"><?= $specialist['User']['phone'] ?></div>
                    <?php if ($specialist['User']['site']): ?>
                        <a href="<?= $specialist['User']['site'] ?>"><?= $specialist['User']['name'] ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="right">
            <?php //Debugger::dump($specialist); ?>
            <?php if (isset($specialist['Photospec'])) : ?>
                <div class="clinic-slider">
                    <?php foreach ($specialist['Photospec'] as $photo) : ?>
                        <div>
                            <img src="/images/frauklinik-2.jpg" alt="">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="inner">
    <div class="content-with-aside page-clinic">
        <div class="content">
            <div class="blog-2 scrolled-element-for-fixed">
                <div class="anchors">
                    <ul>
                        <li><a href="#yak-1" class="yak">Общая информация</a></li>
                        <li><a href="#yak-2" class="yak">Профиль работ</a></li>
                        <li><a href="#yak-3" class="yak">Специалисты клиники</a></li>
                        <li><a href="#yak-5" class="yak">Отзывы <?= $specialist['User']['review_count'] ?> </a></li>
                        <li><a href="#yak-4" class="yak">Другие клиники</a></li>
                    </ul>
                </div>
            </div>
            <div class="page-clinic-2" id="yak-1">
                <h4>Общая информация</h4>
                <?= $specialist['User']['description'] ?>
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
            <div class="page-clinic-3" id="yak-3">
                <h4>Специалисты клиники</h4>
                <p></p>
                <?php if (!empty($specialistes)) { ?>
                    <div class="list-of-doctors">
                        <?php foreach ($specialistes as $keyIndex => $spec) { ?>
                            <div class="item <?= $keyIndex >= 6 ? 'display-none' : '' ?>">
                                <a href="/specialist/profile/<?= $spec['Specialist']['id'] ?>/" class="img">
                                    <img style="border-radius: 50%" src="<?= $this->Element('image',
                                        [
                                            'model' => 'user',
                                            'type' => 'mini',
                                            'alias' => 'avatar',
                                            'id' => $spec['Specialist']['id'],
                                        ]) ?>" alt="">
                                </a>
                                <div class="text">
                                    <div class="title">
                                        <a href="/specialist/profile/<?= $spec['Specialist']['id'] ?>/"><?= $spec['Specialist']['name'] ?></a>
                                    </div>
                                    <a href="/clinic/profile/<?= $specialist['User']['id'] ?>/"><?= $specialist['User']['name'] ?></a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if (count($specialistes) > 6) { ?>
                    <button class="btn">Показать всех</button>
                <?php } ?>
            </div>

            <div class="doctor-page-5" id="yak-5">
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
                    <?php if ($pr['prevPage']) : ?>
                        <?= $this->Paginator->prev('предыдущие 5 отзывов', [
                            'tag' => false,
                            'disabledTag' => true,
                            'class' => 'btn',
                        ],
                            null, null) ?>
                    <?php endif; ?>
                    <?php if ($pr['nextPage']) {
                        ?>
                        <?=  $this->Paginator->next('следующие 5 отзывов', [
                            'tag' => false,
                            'disabledTag' => true,
                            'class' => 'btn',
                        ],
                            null, null) ?>
                    <?php } ?>
                    <a href="/reviews/add_review/" class="btn btn-blue">Оставить отзыв</a>
                </div>
            </div>
            <div class="page-clinic-4" id="yak-4">
                <h4>Другие клиники</h4>
                <?= $this->Element('other_clinics', ['other_clinics' => $other_clinics]); ?>
            </div>
        </div>

        <?= $this->Element('aside_with_banner', [
            'bannerCode' => 'hshmumegobcodacfawbxmyssrqcfxdxfnu',
            'elementList' => [
            ],
        ]) ?>
    </div>
</div>
</div>
<?= $this->Element('forms/create_review', ['isClinic' => true]); ?>
