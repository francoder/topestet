</div>
<form id="form-filter-data" class="search-form" method="get">
    <div class="request-verification reviews-page-1">
        <?= $this->Element('review_search') ?>
        <input class="filter-input" name="order" value="review" style="display: none;"/>
    </div>
</form>
<div class="inner">
    <div class="content-with-aside">
        <div class="content">
            <div id="search-results" class="reviews-list" style="position: relative">
                <?php foreach ($reviews as $key => $review) { ?>
                    <?php if ($key === 3) {
                        $bannerCode = 'jkiuklbmrspwoibwqjgtbtbxhfvvcrnfca';
                        ?>
                        <div id="<?= $bannerCode ?>" align="center"></div>
                        <script type="text/javascript">
                            (function (a, e, f, g, b, c, d) {
                                a[b] || (a.FintezaCoreObject = b, a[b] = a[b] || function () {
                                    (a[b].q = a[b].q || []).push(arguments)
                                }, a[b].l = 1 * new Date, c = e.createElement(f), d = e.getElementsByTagName(f)[0], c.async = !0, c.defer = !0, c.src = g, d && d.parentNode && d.parentNode.insertBefore(c, d))
                            })
                            (window, document, "script", "https://topestet.ru/core.js", "fz");
                            fz("show", "<?= $bannerCode ?>");
                        </script>
                    <?php } ?>

                    <?= $this->Element('card_item_review', ['review' => $review, 'showReviewUser' => true]) ?>
                <?php } ?>

                <?php if (empty($reviews)) { ?>
                    <p>
                        По выбранному запросу, пока нет отзывов.
                    </p>
                    <p>
                        Однако, если вы всегда можете оставить отзыв по ссылке выше
                    </p>
                <?php } ?>

                <div class="bottom" style="display: flex; justify-content: space-between;">
                    <div class="pagination">
                        <?= $this->Paginator->numbers([
                            'tag' => false,
                            'separator' => '',
                            'currentTag' => 'span',
                        ]) ?>
                    </div>
                    <a href="/reviews/add_review/" class="btn btn-blue">Оставить отзыв</a>
                </div>
            </div>
        </div>

        <?php
        $currentSpecializationAlias = isset($currentSpecialization) ? $currentSpecialization['alias'] : '';
        switch ($currentSpecializationAlias) {
            case 'plastica':
                $bannerCode = 'uonnchczfeefezuqpfrbykhsuiecrsvabb';
                break;
            case 'cosmetology';
                $bannerCode = 'fdepwklqixktlnsetftgwxbligqnwmjcln';
                break;
            default:
                $bannerCode = 'tbvbnumxngtwijnrxfozkinypifcgjowhf';
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

<?= $this->Element('slider_services') ?>

