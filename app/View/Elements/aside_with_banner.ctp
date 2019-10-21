<aside>
    <?php
    if (isset($bannerCode)) {
        ?>
        <div id="<?= $bannerCode ?>"></div>
        <script type="text/javascript">
            (function (a, e, f, g, b, c, d) {
                a[b] || (a.FintezaCoreObject = b, a[b] = a[b] || function () {
                    (a[b].q = a[b].q || []).push(arguments)
                }, a[b].l = 1 * new Date, c = e.createElement(f), d = e.getElementsByTagName(f)[0], c.async = !0, c.defer = !0, c.src = g, d && d.parentNode && d.parentNode.insertBefore(c, d))
            })
            (window, document, "script", "https://topestet.ru/core.js", "fz");
            fz("show", "<?= $bannerCode ?>");

            var brnInited = false;
            $('#<?=$bannerCode?>').bind("DOMSubtreeModified", function () {
                if (brnInited === false) {
                    brnInited = true;
                    $('#<?=$bannerCode?>').addClass('aside-bnr');
                }
            });
        </script>
    <?php } ?>


    <div class="aside-button-mobile">Полезные ссылки</div>
    <?php if (isset($elementList)) {
        foreach ($elementList as $elementName) { ?>
            <?= $this->Element($elementName) ?>
        <?php }
    } ?>
</aside>
