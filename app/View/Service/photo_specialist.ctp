<div class="request-verification">
    <div class="inner">
        <div class="navigation">
            <a href="/">Главная</a>
            <a href="/photo">Результаты работы</a>
            <span><?= $specialist['User']['name'] ?></span>
        </div>
        <div class="about-doctor">
            <a href="/specialist/profile/<?= $specialist['User']['id'] ?>/">
                <div class="img">
                    <img src="<?= $this->Element('image',
                        [
                            'model' => 'user',
                            'id' => $specialist['User']['id'],
                            'alias' => 'avatar',
                            'type' => 'main',
                            'onlyurl' => true,
                        ]) ?>" alt="">
                </div>
            </a>
            <div class="text">
                <a href="/specialist/profile/<?= $specialist['User']['id'] ?>/">
                    <h3>Результаты работ.<br>
                            <?= $specialist['User']['name_genitive'] ?>
                    </h3>
                </a>
                <p><?= $specialist['User']['profession'] ?></p>
            </div>
        </div>
    </div>
</div>
<div class="inner">
    <div class="content-with-aside">
        <div class="content">
            <div class="work-results-service">
                <?php if (empty($photos)) { ?>
                    <br><br>Фотографий пока нет.
                <?php } else { ?>
                    <?php foreach ($photos as $photo) {
                        $imgBefore = $this->Element('image', [
                            'id' => $photo['Photospec']['id'],
                            'model' => 'photospec',
                            'alias' => 'before',
                            'type' => 'mini',
                            'also' => ['title' => $photo['Photospec']['content']],
                        ]);

                        $imgAfter = $this->Element('image', [
                            'id' => $photo['Photospec']['id'],
                            'model' => 'photospec',
                            'alias' => 'after',
                            'type' => 'mini',
                            'also' => ['title' => $photo['Photospec']['content']],
                        ]);

                        ?>
                        <div class="work-results-service-item">
                            <div class="work-results-service-item-images">
                                <?php if ($imgAfter !== '' && $imgBefore !== '') { ?>
                                    <img src="<?= $imgBefore ?>" alt="">
                                    <img src="<?= $imgAfter ?>" alt="">
                                <?php } else { ?>
                                    <img class="image-both" src="<?= $this->Element('image', [
                                        'id' => $photo['Photospec']['id'],
                                        'model' => 'photospec',
                                        'alias' => 'both',
                                        'type' => 'mini',
                                        'also' => ['title' => $photo['Photospec']['content']],
                                    ]); ?>" alt="">
                                <?php } ?>
                            </div>
                            <div class="work-results-service-item-text">
                                <div class="work-results-service-item-text-description">
                                    <?= $photo['Photospec']['content'] ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="bottom">
                        <div class="pagination">
                            <?= $this->Paginator->numbers([
                                'tag' => false,
                                'separator' => '',
                                'currentTag' => 'span', 'model' => 'Photospec', 'modulus' => 6, 'first' => 1,
                                'last' => 1,
                            ]) ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>

        <?php
        $specialistSpecialization = mb_strpos($specialist['User']['profession'], 'хирург') ? 'plastica' : 'cosmetology';
        switch ($specialistSpecialization) {
            case 'plastica':
                $bannerCode = 'ijrrukbbpmbdsfidhwxifdksfxizlpatgr';
                break;
            case 'cosmetology';
                $bannerCode = 'tdzuvelppfdewrdsczmgyizfennwjiftkx';
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
