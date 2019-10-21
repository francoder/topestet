<div class="col-md-12">
    <div class="row text-right">
        <div class="block-content block-content-full bg-gray-lighter">
            <a href="/admin/self_item/Post/" class="btn btn-hero btn-sm btn-rounded btn-noborder btn-success"><b>Новая
                    запись в Блог</b></a>
        </div>
    </div>
    <table width="80%" style="margin: 0 auto;">
        <div class="row">
            <?php foreach ($menu as $i => $element) {
                if ($i === 0) {
                    continue;
                }
                ?>
                <div class="col-md-4 col-xl-2">
                    <div class="block block-link-pop block-rounded block-bordered text-center">
                        <div class="block-header block-content-full bg-gray-lighter">
                            <a href="<?= $url = key($element); ?>"><?= $element[$url] ?></a>
                        </div>
                        <div class="block-content">
                            <?php if (isset($element['sub'])) { ?>
                                <?php foreach ($element['sub'] as $url => $title) { ?>
                                    <div class="text-left mb-10">
                                        <a href="<?= $url ?>">
                                            <?= $title ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </table>
</div>
