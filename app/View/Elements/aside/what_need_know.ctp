<?php if (isset($serviceTitle, $relativePosts)) { ?>
    <div class="articles">
        <h4>Что нужно знать о <?= $serviceTitle ?>?</h4>
        <?php foreach ($relativePosts as $relativePost) { ?>
            <div>
                <a href="/article/<?= $relativePost['Post']['alias'] ?>/">
                    <?= $relativePost['Post']['title'] ?>
                </a>
            </div>
        <?php } ?>
    </div>
<?php } ?>
