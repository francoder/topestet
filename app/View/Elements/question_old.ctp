<?if (!isset($show) || !$show) $show = 'answer';?>
<div class="review <?if ($question['Question']['is_main']):?>adv<?endif;?>">
    <div class="other"  style="margin-left:0;">
        <h3><a href="/forum/answer/<?= $question['Question']['id'] ?>/"><?= $question['Question']['subject'] ?></a></h3>
        <span class="info">
        	<?if ($show == 'response'):?>
        		<a href="/service/info/<?=$question['Question']['Service']['alias']?>"><?=$question['Question']['Service']['title']?></a>
        	<?else:?>
        		<?=$this->Display->date("d %m Y", strtotime($question['Question']['created'])) ?>
        	<?endif;?>
            
            <? if (isset($show_username) and $show_username) : ?>
                | <?= $question['User']['name'] ?>
            <? endif; ?>
            <? if (isset($show_service) and $show_service) : ?>
                | <a href="/service/info/<?= $question["Service"]['alias'] ?>/"><?= $question["Service"]['title'] ?></a>
            <? endif; ?>
            <? if (isset($show_specialist) && $show_specialist) : ?>
                | <?= $question['Specialist']['name'] ?>
            <? endif; ?>
        </span>
		<?
			if ($show == 'response'){
				$content = $question['Response']['content'];
			} else {
				$content = $question['Question']['content'];
			}
			//!!!!!
			$content = $question['Question']['content'];
		?>
        <p>
            <?= $this->Display->short($content, 50) ?>
            <? if (str_word_count($content) > 50) : ?>
                <a class="readmore" href="/forum/answer/<?= $question['Question']['id'] ?>/">Читать полностью</a>
            <? endif; ?>
        </p>

            <a  href="/forum/answer/<?= $question['Question']['id'] ?>/"><?= $question['Question']['response_count'] ?> ответ<?= $this->Display->cas($question['Question']['response_count'], array("", "а", "ов")); ?></a>
            <? if (isset($show_comments) and $show_comments) : ?>
                /
                <a href="/forum/answer/<?= $question['Question']['id'] ?>/#comments">
                    <?= $question['Question']['comment_count'] ?> комментари<?= $this->Display->cas($question['Question']['comment_count'], array("й", "я", "ев")); ?>
                </a>
            <? endif; ?>
    </div>
    <? ?>
    <div class="clear"></div>
</div>