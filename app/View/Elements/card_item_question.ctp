<?php if (!empty($question)) { ?>
    <?php //Debugger::dump($question) ?>
    <?php $themeUrl = '/forum/' .
        $specializations[$question['Service']['specialization_id']]['Specialization']['alias'] .
        '/' .
        $question['Service']['alias']; ?>
    <div class="item">
        <div class="top">
            <div class="date"><?= $this->Display->date("d.m.Y", strtotime($question['Question']['created'])) ?></div>
            <a href="/profile/<?= h($question['User']['id']) ?>"><?= h($question['User']['name']) ?></a>
            <a href="<?= $themeUrl ?>" class="theme"><?= h($question['Service']['title']) ?></a>
        </div>
        <a href="/forum/answer/<?= h($question['Question']['id']) ?>">
            <div class="title"><?= h($question['Question']['subject']) ?></div>
            <p><?= h($question['Question']['content']) ?></p>
        </a>
        <div class="bottom">
            <img src="/images/comment-2.svg" alt="">
            <a href="/forum/answer/<?= h($question['Question']['id']) ?>"><?= DisplayHelper::pluralComment(h($question['Question']['response_count'])) ?></a>
        </div>
    </div>
<?php } ?>
