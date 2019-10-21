</div>
<form id="form-filter-data" class="search-form" method="get">
    <div class="request-verification">
        <?= $this->Element('clinic_search') ?>
        <input class="filter-input" name="order" value="review" style="display: none;"/>
        <input class="filter-coast" type="hidden" name="coast" value="">
    </div>
</form>
<div class="inner">
    <div class="content-with-aside page-of-search">
        <div class="content">
            <!--            <div class="top-block">-->
            <!--                <div class="left">-->
            <!--                    <span class="filter-order -->
            <? //= $this->request->query('order') === 'rate' ? 'active-filter-order' :
            //                        '' ?><!--">-->
            <!--                        <input id="order-by-rate" type="radio" class="filter-input" name="order" value="rate"/>-->
            <!--                        <label for="order-by-rate">-->
            <!--                            Рейтинг-->
            <!--                        </label>-->
            <!--                    </span>-->
            <!--                    <span class="filter-order -->
            <? //= $this->request->query('order') !== 'rate' ? 'active-filter-order' : '' ?><!--">-->
            <!--                        <input id="order-by-reviews" type="radio" class="filter-input" name="order" value="reviews"/>-->
            <!--                        <label for="order-by-reviews">-->
            <!--                            Отзывы-->
            <!--                        </label>-->
            <!--                    </span>-->
            <!--                </div>-->
            <!--            </div>-->
            <div id="search-results">
                <?php foreach ($clinicList as $key => $clinic) { ?>
                    <?php if ($key === 3) {
                        $bannerCode = 'eoqyptllqsqcnyeciqrzbxmhmnxdwmltlf';
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

                    <?= $this->Element('card_clinic', ['clinic' => $clinic]) ?>
                <?php } ?>
                <?php if (empty($clinicList)) { ?>
                    По выбранному запросу, пока нет клиник нужного профиля.Однако,
                    если вы знаете настоящих профи своего дела, напишите нам на почту topestet@ya.ru и мы добавим их
                    на наш портал
                <?php } ?>
                <div class="pagination">
                    <?= $this->Paginator->numbers([
                        'tag' => false,
                        'separator' => '',
                        'currentTag' => 'span',
                    ]) ?>
                </div>
            </div>
        </div>
        <?php
        $currentSpecializationAlias = isset($currentSpecialization) ? $currentSpecialization['alias'] : '';
        switch ($currentSpecializationAlias) {
            case 'plastica':
                $bannerCode = 'ofdzwszhoekaulslofiasosxfpjqndmsgr';
                break;
            case 'cosmetology';
                $bannerCode = 'qdzveczfxffoahcmsccmbbjyqizpgzyqyw';
                break;
            default:
                $bannerCode = 'hywqcmgmwqfguaizcfrohqkkmjoeivuiqh';
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
