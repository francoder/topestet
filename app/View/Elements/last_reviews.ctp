<? if (!empty($last_reviews)): ?>
    <div class="reviews-from-followers">
        <div class="text">
            <h4>Последние отзывы от подписчиков</h4>
            <?php foreach ($last_reviews as $review) { ?>
                <div class="item">
                    <div class="top">
                        <?php $doctorId = $review['Review']['specialist_id'] ? $review['Review']['specialist_id'] : $review['Specialist']['id'];
                        ?>
                        <a href="/profile/<?= $review['User']['id'] ?>/">
                            <?= $review['User']['name'] ?>
                        </a>
                        <?php $date = date_create($review['Review']['created']); ?>
                        <div class="date"><?= date_format($date, 'd.m.Y') ?></div>
                    </div>
                    <a href="/reviews/<?= $review['Review']['id'] ?>">
                        <div class="title"><?= $review['Review']['subject'] ?></div>
                        <p>
                            <?= CakeText::truncate(
                                $review['Review']['comment_note'],
                                92,
                                [
                                    'ellipsis' => '...',
                                    'exact' => false,
                                ]);
                            ?>
                        </p>
                    </a>
                </div>
            <?php } ?>
            <div class="button">
                <a href="/reviews/" class="btn">Все отзывы</a>
            </div>
        </div>
    </div>
<? endif; ?>
