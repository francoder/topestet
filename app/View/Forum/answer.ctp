<div class="page-of-question">
    <div class="reviews-page-1">
        <div class="inner">
            <div class="left">
                <div class="navigation">
                    <a href="/">Главная</a>
                    <a href="/forum/">Форум</a>
                    <span><?= $question['Question']['subject'] ?></span>
                </div>
                <div class="page-of-review-1">
                    <h1><?= $question['Question']['subject'] ?></h1>
                    <div class="bottom">
                        <div class="item">
                            <span>Услуга:</span>
                            <p><?= $question['Service']['title'] ?></p>
                        </div>
                        <?php if (isset($question['User']['id'])) { ?>
                            <div class="item">
                                <span>Пользователь:</span>
                                <a href="/profile/<?= $question['User']['id'] ?>/"><?= $question['User']['name'] ?></a>
                            </div>
                        <?php } ?>
                        <div class="item">
                            <span>25.12.2018</span>
                        </div>


                        <? if ($auth && $auth['is_admin']) { ?>
                            <div class="item">
                                <a href="/admin/self_item/Question/<?= $question['Question']['id'] ?>/"
                                   style="color:red;"
                                   target="_blank">Редактировать</a>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="text">
                        <?= $this->Display->format($question['Question']['content'], false) ?>
                        <div class="photo">
                            <?php foreach ($question['Photo'] as $i => $photo) { ?>
                                <a href="<?= $this->Element("image", [
                                    "model" => "photo", "alias" => "picture", "id" => $photo['id'],
                                    "onlyurl" => true,
                                ]) ?>"
                                   target="_blank">
                                    <img alt="" src="<?= $this->Element("image", [
                                        "model" => "photo", "alias" => "picture", "id" => $photo['id'],
                                        "type" => "mini",
                                    ]) ?>">
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="inner">
    <div class="content-with-aside">
        <div class="content">
            <div class="page-of-question-1">
                <h4>Ответы специалистов(<?= $question['Question']['response_count'] ?>):</h4>


                <?php foreach ($question['Response'] as $response) { ?>
                    <div class="item">
                        <div class="top">
                            <a href="/specialist/profile/<?= $response['Specialist']['id'] ?>/" class="img">
                                <img src="<?= $this->Element("image", [
                                    "id" => $response['Specialist']['id'], "model" => "user", "noimage" => true,
                                    "alias" => "avatar", "type" => "mini",
                                ]) ?>" alt="Доктор <?= $response['Specialist']['name'] ?>" style="border-radius: 50%">
                            </a>
                            <div class="text">
                                <div class="name">
                                    <?= $response['Specialist']['name'] ?>
                                </div>
                                <p><?= $response['Specialist']['profession'] ?></p>
                            </div>
                        </div>
                        <div class="comment">
                            <?= nl2br($response['content']); ?>

                        </div>
                        <div class="date fedit" id="fedit_<?= $response['id'] ?>">
                            <?= DateTime::createFromFormat('Y-m-d H:i:s', $response['created'])->format('d. m. Y') ?>
                            <?php if ($auth && $auth['is_admin']) { ?>
                                <a href="/forum/response_del/<?= $response['id'] ?>/"
                                   style="color:red; float:right;"
                                   class="f_response_del"
                                   target="_blank">Удалить </a>
                                <a href="/forum/response_edit/<?= $response['id'] ?>/"
                                   class="f_response_edit"
                                   style="color:red; float:right; margin-right: 10px;"
                                   target="_blank">Редактировать </a>
                                <div class="fedit_form" id="fedit_form_<?= $response['id'] ?>" style="display:none;">
                                    <form action="" method="post">
                                        <textarea class="mytextarea" id="edit_text_<?= $response['id'] ?>"
                                                  name="edit_text_<?= $response['id'] ?>" cols="40"
                                                  rows="5"><?= $response['content']; ?></textarea><br/>
                                        <div class="add-rewiev"><input type="submit" value="сохранить"/></div>
                                    </form>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?= $this->Element('aside_with_banner', [
            'bannerCode' => 'xanyejtqgysvdmpcxxeacbrulggunhptex',
            'elementList' => [
                'aside/what_need_know',
                'aside/most_answers',
            ],
        ]) ?>
    </div>
</div>

<div class="other-articles">
    <div class="inner">
        <?php $this->set('sliderTitle', 'Новости и полезные статьи'); ?>
        <?= $this->Element('useful_posts') ?>
    </div>
</div>

<script type="text/javascript" src="/js/forum.js"></script>
<style>
    .mytextarea {
        border: 1px solid grey;
        width: 100%;
    }
</style>
