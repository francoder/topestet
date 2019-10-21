<?php if (!empty($review)) { ?>
    <?php
    $themeUrl = '';
    if (isset($review['Service']['specialization_id'])) {
        $themeUrl = '/reviews/' .
            $specializations[$review['Service']['specialization_id']]['Specialization']['alias'] .
            '/' .
            $review['Service']['alias'];
    }
    ?>
    <div class="item">
        <div class="top">
            <div class="left">
                <div class="date"><?= $this->Display->date("d.m.Y", strtotime($review['Review']['edited'])) ?></div>
                <?php if (isset($showReviewUser, $review['User']['id'])): ?>
                    <a href="/profile/<?= $review['User']['id'] ?>/"><?= $review['User']['name'] ?></a>
                <?php endif; ?>
                <?php if (isset($review['Service']['title'])) { ?>
                    <a href="<?= $themeUrl ?>" class="section"><?= h($review['Service']['title']) ?></a>
                <?php } ?>
            </div>
            <div class="right">
                <?php if (isset($review['Clinic']['id'])) { ?>
                    <a href="/clinic/profile/<?= $review['Clinic']['id'] ?>/"><?= $review['Clinic']['name'] ?></a>
                <?php }
                if (isset($review['Specialist']['id'])) { ?>
                    <a href="/specialist/profile/<?= $review['Specialist']['id'] ?>/"
                       class="name"><?= $review['Specialist']['name'] ?></a>
                <?php } else { ?>
                    <a class="name"><?= $review['Review']['specialist_name'] ?></a>
                <?php } ?>
            </div>
        </div>
        <a href="/reviews/<?= $review['Review']['id'] ?>/">
            <div class="title">
                <?= $review['Review']['subject'] ?>
            </div>
            <div class="price"><?= DisplayHelper::formatPrice($review['Review']['coast']) ?> ₽</div>
            <p>
                <?= CakeText::truncate(
                    $review['Review']['description'],
                    400,
                    [
                        'ellipsis' => ' ...',
                        'exact' => false,
                    ]);
                ?>
            </p>
            <div class="images">
                <? foreach ($review['Photo'] as $i => $photo): ?>
                    <?php $imgUrl = $this->Element("image", [
                        "id" => $photo['id'], "model" => "photo", "alias" => "picture", "onlyurl" => true,
                    ]) ?>
                    <a class="fancybox" rel="gallery1" href="<?= $imgUrl ?>" style="border: none; opacity: 1">
                        <img style="width: 99px; height: 85px" src="<?= $imgUrl ?>" alt="">
                    </a>
                <? endforeach; ?>
            </div>
            <?php if ($review['Review']['note_specialist'] !== null) {
                ?>
                <div class="assessment">
                    <p>
                        <?= CakeText::truncate(
                            DisplayHelper::formatRating($review['Review']['note_specialist']),
                            92,
                            [
                                'ellipsis' => '...',
                                'exact' => false,
                            ]);
                        ?>
                    </p>
                    <span>Оценка</span>
                </div>
            <?php } ?>
            <a href="/reviews/<?= $review['Review']['id'] ?>" class="comment">
                <img src="/images/comment.svg" alt="">
                <?php if ($review['Review']['comment_count'] !== '0') { ?>
                    <span>
                        <?= $review['Review']['comment_count'] ?>
                    </span>
                <?php } ?>
            </a>
    </div>
<?php } ?>
