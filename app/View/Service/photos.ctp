<?php
$this->Paginator->options([
    'url' => [
        'alias' => $service['Service']['alias'],
    ],
]);
?>
<?php
//Debugger::dump($photos);
?>
<div class="request-verification">
    <div class="inner">
        <div class="navigation">
            <a href="/">Главная</a>
            <span>Фотографии работ по <?= $service['Service']['title_dative'] ?></span>
        </div>
        <h1>Фотографии работ по <?= $service['Service']['title_dative'] ?></h1>
    </div>
</div>
<div class="inner">
    <div class="content-with-aside">
        <div class="content">
            <div class="work-results-service">
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
                        <a class="work-results-service-item-text"
                           href="/specialist/profile/<?= $photo['User']['id'] ?>/">
                            <div class="work-results-service-item-text-top">
                                <div class="work-results-service-item-text-top-img">
                                    <img src="<?= $this->Element('image',
                                        [
                                            'model' => 'user',
                                            'id' => $photo['User']['id'],
                                            'alias' => 'avatar',
                                            'type' => 'main',
                                            'onlyurl' => true,
                                        ]) ?>" alt="">
                                </div>
                                <div
                                        class="work-results-service-item-text-top-about-doctor">
                                    <div class="work-results-service-item-text-top-about-doctor-name">
                                        <?= $photo['User']['name'] ?>
                                    </div>
                                    <div class="work-results-service-item-text-top-about-doctor-profession">
                                        <?= $photo['User']['profession'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="work-results-service-item-text-description">
                                <?= $photo['Photospec']['content'] ?>
                            </div>
                        </a>
                    </div>
                <?php } ?>
                <div class="bottom">
                    <div class="pagination">
                        <?= $this->Paginator->numbers([
                            'tag' => false,
                            'separator' => '',
                            'currentTag' => 'span', 'model' => 'Photospec', 'modulus' => 6, 'first' => 1, 'last' => 1,
                        ]) ?>
                    </div>
                </div>
            </div>

        </div>

        <?php
        $currentSpecializationAlias = $service['Service']['specialization_id'] === '7' ? 'plastica' : 'cosmetology';
        switch ($currentSpecializationAlias) {
            case 'plastica':
                $bannerCode = 'yqxpujhaxryzooqmgzoocjvpyhmmxveolc';
                break;
            case 'cosmetology';
                $bannerCode = 'opiqojfzinxhdzpvuisyuikbhmbxperzrg';
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
