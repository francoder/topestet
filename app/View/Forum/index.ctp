</div>
<form id="form-filter-data" class="search-form" method="get">
    <div class="request-verification">
        <?= $this->Element('forum_search') ?>
        <input class="filter-input" name="order" value="review" style="display: none;"/>
    </div>
</form>
<div class="inner">
    <div class="content-with-aside">
        <div class="content">
            <div id="search-results" class="list-of-questions" style="position: relative">
                <a href="/forum/add/" class="btn btn-blue"
                   style="position: absolute; top: -34px; right: 0; ">
                    Задать вопрос
                </a>

                <?php foreach ($questions as $key => $question) { ?>
                    <?php if ($key === 3) {
                        $bannerCode = 'zmzirlwrmygdkscyutrxpcsommlyhwvwln';
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
                    <?= $this->Element('card_item_question', ['question' => $question, 'showReviewUser' => true]) ?>
                <?php } ?>

                <?php if (empty($questions)) { ?>
                    <p>
                        По выбранному запросу, пока нет вопросов.
                    </p>
                    <p>
                        Однако, если вы всегда можете задать его специалистам по ссылке выше
                    </p>
                <?php } ?>

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
                'last_responses',
                'best_specialists',
            ],
        ]) ?>
    </div>
</div>

<?= $this->Element('slider_services') ?>

