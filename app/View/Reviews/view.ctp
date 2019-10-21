</div>
<div class="page-of-review">
    <div class="reviews-page-1">
        <div class="inner">
            <div class="left">
                <div class="navigation">
                    <a href="/">Главная</a>
                    <a href="/reviews/">Отзывы</a>
                    <span>Отзыв</span>
                </div>
                <div class="page-of-review-1">
                    <h1><?= $review['Review']['subject'] ?></h1>
                    <div class="bottom">
                        <div class="item">
                            <span>Стоимость:</span>
                            <p><?= DisplayHelper::formatPrice($review['Review']['coast']) ?> ₽</p>
                        </div>
                        <div class="item">
                            <span>Регион:</span>
                            <?php if (!empty($review['Region'])) : ?>
                                <p><?= $review['Region']['title'] ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="item">
                            <?php if (!empty($review['Clinic']['id'])) : ?>
                                <span>Клиника:</span>
                                <a href="/clinic/profile/<?= $review['Clinic']['id'] ?>"><?= $review['Clinic']['name'] ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right">
                <h4>Вам есть, что рассказать?</h4>
                <p>Оставляейте отзывы о своем опыте
                    и результатах операций и процедур, чтобы помощь другим.</p>
                <!--                <button class="btn">Оставить отзыв</button>-->
            </div>
        </div>
    </div>
    <div class="inner">
        <div class="page-of-review-2">
            <div class="reviews-list" id="tab-1">
                <div class="item">
                    <div class="top">
                        <div class="left">
                            <div class="date"><?= $this->Display->date("d.m.Y", strtotime($review['Review']['edited'])) ?></div>
                            <a href="/profile/<?= $review['User']['id'] ?>"><?= $review['User']['name'] ?></a>
                            <div class="section"><?= $review['Service']['title'] ?></div>
                        </div>
                        <div class="right">
                            <?php if (!empty($review['Clinic'])) : ?>
                                <a href="/clinic/profile/<?= $review['Clinic']['id'] ?>"><?= $review['Clinic']['name'] ?></a>
                            <?php endif; ?>
                            <?php if (!empty($review['Specialist'])) : ?>
                                <a href="/specialist/profile/<?= $review['Specialist']['id'] ?>"
                                   class="name"><?= $review['Specialist']['name'] ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p><?= $review['Review']['description'] ?></p>

                    <div class="images ">
                        <? foreach ($review['Photo'] as $i => $photo): ?>
                            <?php $imgUrl = $this->Element("image", [
                                "id" => $photo['id'], "model" => "photo", "alias" => "picture", "onlyurl" => true,
                            ]) ?>
                            <a class="fancybox" rel="gallery1" href="<?= $imgUrl ?>" style="border: none; opacity: 1">
                                <img style="width: 99px; height: 85px" src="<?= $imgUrl ?>" alt="">
                            </a>
                        <? endforeach; ?>
                    </div>

                    <?php if ($review['Review']['note_specialist'] !== null) { ?>
                        <div class="assessment">
                            <p><?= DisplayHelper::formatRating($review['Review']['note_specialist']) ?></p>
                            <span>Оценка</span>
                        </div>
                    <?php } ?>
                    <a href="" class="comment">
                        <img src="/images/comment.svg" alt="">
                        <span><?= $review['Review']['comment_count'] ?></span>
                    </a>
                </div>
                <?php if (!empty($review['ReviewAdd'])): ?>
                    <div class="additionally">
                        <?php foreach ($review['ReviewAdd'] as $reviewAdd) : ?>
                            <div class="date">
                                <span>Дополнено: </span>
                                <div><?= $this->Display->date("d.m.Y", strtotime($reviewAdd['created'])) ?></div>
                            </div>
                            <p><?= $reviewAdd['content'] ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <h3>Комментарии (<?= $review['Review']['comment_count'] ?>):</h3>
            <div class="profile-2" id="tab-2">
                <?php foreach ($comments as $comment): ?>
                    <?= $this->Element('card_item_comment', [
                        'comment' => $comment, 'showCommentUser' => true, 'isReview' => true, 'with_reviews' => true,
                    ]) ?>
                <?php endforeach; ?>
            </div>
            <?php if ($auth) : ?>
                <button class="btn btn-blue review-comment">Оставить комментарий</button>
            <?php else : ?>
                <button class="btn btn-blue ajax-mfp">Оставить комментарий</button>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->Element('forms/create_comment'); ?>
