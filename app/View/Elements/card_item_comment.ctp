<?php if (isset($comment)) {
    $lvlClass = '';
    if (isset($lvl) && $lvl === 1) {
        $lvlClass .= 'comment-1';
    }
    if (isset($lvl) && $lvl > 1){
        $lvlClass .= 'comment-2';
    }
    ?>
    <div class="item <?= $lvlClass ?>">
        <div class="img">
            <img style="border-radius: 50%" src="<?= $this->Element("image", [
                "id" => $comment['User']['id'],
                "type" => "main",
                "noimage" => true,
                "alias" => "avatar",
                "model" => "user",
            ]) ?>" alt="">
        </div>
        <div class="text">
            <div class="name">
                <?php if (isset($showCommentUser)) { ?>
                    <a href="/profile/<?= $comment['User']['id'] ?>"><?= $comment['User']['name'] ?></a>
                <?php } ?>
            </div>
            <div class="date"><?= $this->Display->date("d.m.Y", strtotime($comment['Comment']['created'])) ?></div>
            <p><?= strip_tags($comment['Comment']['content']) ?></p>
            <?php if (!empty($comment['Comment']['Parent']['Review'])) { ?>
                <div class="bottom">
                    <?php if (isset($with_reviews)) : ?>
                        <?php if (!empty($auth)):
                            ?>
                            <button class="btn-blue-letters review-comment"
                                    data-commentname="<?= $comment['User']['name'] ?>"
                                    data-comment="<?= $comment['Comment']['id'] ?>">Комментировать
                            </button>
                        <?php else: ?>
                            <button class="btn-blue-letters ajax-mfp" data-comment="<?= $comment['Comment']['id'] ?>">
                                Комментировать
                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <span>В ответ на : </span>
                        <a href="/reviews/<?= $comment['Comment']['Parent']['Review']['id'] ?>" class="answer"><?=
                            $comment['Comment']['Parent']['Review']['subject'] ?></a>
                    <?php endif; ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php if (isset($comment['children']) && !empty($comment['children'])) { ?>
        <?php foreach ($comment['children'] as $subComment) { ?>
            <?= $this->Element('card_item_comment', [
                'comment' => $subComment,
                'showCommentUser' => true,
                'isReview' => true,
                'with_reviews' => true,
                'lvl' => isset($lvl) ? ++$lvl : 1,
            ]) ?>
        <?php } ?>
    <?php } ?>
<?php } ?>
