</div>
<div class="profile-page">
    <div class="reviews-page-1">
        <div class="inner">
            <div class="left">
                <div class="navigation">
                    <a href="/">Главная</a>
                    <span>Профиль пользователя</span>
                </div>
                <div class="profile-1">
                    <div class="img">
                        <img style="border-radius: 50%" src="<?= $this->Element("image", [
                            "id" => $profile['User']['id'],
                            "type" => "main",
                            "noimage" => true,
                            "alias" => "avatar",
                            "model" => "user",
                        ]) ?>" alt="">
                    </div>
                    <div class="text">
                        <h1>
                            <a href=""><?= $profile['User']['name'] ?></a>
                        </h1>
                        <p>c нами с <?= $this->Display->date("d.m.Y", strtotime($profile['User']['created'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tabs js-tabs ordinary-tabs">
        <ul>
            <li class="tab-link"><a href="#tab-1">Последние отзывы</a></li>
            <li class="tab-link"><a href="#tab-2">Комментарии</a></li>
            <?php if (isset($auth['id']) && $auth['id'] === $profile['User']['id']) { ?>
                <li><a href="/user/logout/<?= $auth['id'] ?>">Выйти из аккаунта</a></li>
            <?php } ?>
        </ul>
    </div>
    <div class="inner">
        <div class="reviews-list" id="tab-1">
            <?php foreach ($reviews as $review) : ?>
                <?= $this->Element('card_item_review', ['review' => $review]) ?>
            <?php endforeach; ?>
        </div>
        <div class="profile-2" id="tab-2">
            <?php foreach ($comments as $comment): ?>
                <?= $this->Element('card_item_comment', [
                    'comment' => $comment,
                    'profie' => $profile,
                    'showCommentUser' => true,
                ]) ?>
            <?php endforeach; ?>
        </div>
    </div>
