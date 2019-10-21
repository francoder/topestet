</div>
<div class="page-service-1">
    <div class="inner">
        <div class="left">
            <div class="navigation">
                <a href="/">Главная</a>
                <a href="/service/<?= $specialization['Specialization']['alias'] ?>"><?= $specialization['Specialization']['title'] ?></a>
                <span><?= $service['Service']['title'] ?></span>
            </div>
            <h1><?= $service['Service']['title'] ?></h1>
        </div>
        <div class="right">
            <div>
                <p>Средняя стоимость</p>
                <span><?= DisplayHelper::formatPrice($service['Service']['coast_avg']) ?> ₽</span>
            </div>
        </div>
    </div>
</div>
<div class="inner">
    <div class="content-with-aside page-service">
        <div class="content">
            <div class="page-service-2">
                <?= $service['Service']['description'] ?>
            </div>
            <div class="doctor-page-4" style="display: none">
                <?php if (count($service['Photospec']) > 1000) { ?>
                    <h4>Результаты операций</h4>
                    <?= $this->Element('photospecs', ['photos' => $service['Photospec'], 'without_user' => false]); ?>
                <?php } ?>
            </div>

            <div class="page-service-3">
                <?php $this->Element('service/average_cost_service') ?>
            </div>
            <div class="doctor-page-5">
                <h4>Последние отзывы</h4>
                <div class="reviews-list">
                    <?php foreach ($reviews as $review) { ?>
                        <?= $this->Element('card_item_review', ['review' => $review, 'showReviewUser' => true]) ?>
                    <?php } ?>
                </div>

                <a href="/reviews/<?= $specialization['Specialization']['alias'] ?>/<?= $service['Service']['alias'] ?>/"
                   class="btn">Все
                    отзывы</a>
            </div>
            <?= $this->Element('slider_last_interest', ['last_interest' => $last_interest]) ?>
            <div class="page-clinic-3">
                <?php if (isset($best_for_service)) : ?>
                    <?= $this->Element('best_specialists_service') ?>
                <?php endif; ?>
            </div>
        </div>
        <?php
        $currentSpecializationAlias = $service['Service']['specialization_id'] === '7' ? 'plastica' : 'cosmetology';
        switch ($currentSpecializationAlias) {
            case 'plastica':
                $bannerCode = 'srphgvadpjdlifnrwfnkasqtnoszwpserf';
                break;
            case 'cosmetology';
                $bannerCode = 'mfqlxiggqlcuhhiownatzrccanwheewbes';
                break;
        }

        ?>
        <?= $this->Element('aside_with_banner', [
            'bannerCode' => $bannerCode,
            'elementList' => [
                'last_reviews_service',
            ],
        ]) ?>
    </div>
</div>
<?= $this->Element('slider_services') ?>
