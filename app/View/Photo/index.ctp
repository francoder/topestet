<div class="request-verification">
    <div class="inner">
        <div class="navigation">
            <a href="/">Главная</a>
            <span>Фотографии до и после</span>
        </div>
        <h1>Фотографии до и после пластических операций, косметологических и иных эстетических процедур</h1>
    </div>
</div>
<?php
    $currentCategory = isset($this->request->query['category']) ? $this->request->query['category'] : null;
?>
<div class="inner">
    <div class="content-with-aside">
        <div class="content">
            <div class="work-results-main">
                <div class="questions-page-1">
                    <div class="tabs">
                        <ul>
                            <li>
                                <a href="?category=cosmetology"
                                   class="<?= $currentCategory === 'cosmetology' ? 'selected' : '' ?>"
                                   rel="nofollow">
                                    Косметология
                                </a>
                            </li>
                            <li>
                                <a href="?category=plastica"
                                   class="<?= $currentCategory === 'plastica' ? 'selected' : '' ?>"
                                   rel="nofollow">
                                    Пластическая хирургия
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="right">
                        <input type="text" placeholder="Быстрый поиск" id="search-photo">
                        <button>
                            <img src="/images/search-2.svg" alt="">
                        </button>
                    </div>
                </div>
                <div class="work-results-main-list">
                    <?php foreach ($services as $service) {
                        ?>
                        <?php
                        if ($service['Photo']['count'] === null) {
                            continue;
                        }
                        $img = $this->Element('image', [
                            'model' => 'service',
                            'id' => $service['Service']['id'],
                            'alias' => 'image',
                            'type' => 'thumbnail',
                        ]);

                        $appendedClass = '';
                        $specialization_id = $service['Service']['specialization_id'];
                        if ($currentCategory === 'cosmetology' && $specialization_id === '7') {
                            $appendedClass .= ' hidden';
                        }
                        if ($currentCategory === 'plastica' && $specialization_id === '6') {
                            $appendedClass .= ' hidden';
                        }
                        ?>
                        <a href="/service/photo/<?= $service['Service']['alias'] ?>/"
                           class="work-results-main-list-item <?= $appendedClass ?>">
                            <img src="<?= $img ?>" alt=""
                                 class="work-results-main-list-item-img">
                            <div class="work-results-main-list-item-text">
                                <div class="work-results-main-list-item-text-title"><?= $service['Service']['title'] ?></div>
                                <div class="work-results-main-list-item-text-quantity"><?= $service['Photo']['count'] ?>
                                    фото
                                </div>
                            </div>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?= $this->Element('aside_with_banner', [
            'bannerCode' => 'vhorwlxkgakkewggkwgqvmrqztcopnihro',
            'elementList' => [
                'last_reviews',
            ],
        ]) ?>
    </div>
</div>
