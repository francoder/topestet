<div class="specialist-page userpage">
    <div class="article">
        <div class="info">
            <div class="image left">
            	<?=$this->Element("image", array("id" => $user['User']['id'], "type" => "main", "noimage" => true, "alias" => "avatar", "model" => "user"))?>
            </div>
            <div class="info-block">
                <h1 style="margin:0;"><?=h($user['User']['name'])?></h1>
                <?if ($user['User']['is_admin']):?>
                	модератор,
                <?endif;?>
                с нами с <?=date("d.m.Y", strtotime($user['User']['created']))?>
                <?if (!$auth || $auth['id'] != $user['User']['id']):?>
                	<div class="add-comment"><input type="submit" value="Написать личное сообщение" onclick="return document.location='/message/send/<?=$user['User']['id']?>/'"></div>
                <?endif;?>
            </div>
        </div>
        <div class="clear"></div>
        <?if (!empty($user['Review'])):?>
	        <h3 class="spec-rew">Последние обзоры</h3>
	        <?foreach ($user['Review'] as $review):?>
	        	<?=$this->Element("review", array("review" => array("Review" => $review, "Region" => $review['Region'], "User" => $review['User']), "shownote" => true));?>
	        <?endforeach;?>
	    <?endif;?>
        
        <?if (!empty($user['Comment'])):?>
	        <h3 class="spec-rew">Последние комментарии</h3>
	        <?foreach ($user['Comment'] as $comment):?>
	        	<?=$this->Element("comment_item", array("comment" => array("Comment" => $comment, "User" => $user['User']), "simple" => true));?>
	        <?endforeach;?>
		<?endif;?>
		
		<?if ($auth && $auth['is_admin'] && !empty($questions)):?>
	        <h3 class="spec-rew">Вопросы, заданные пользователем</h3>
	        <?foreach ($questions as $question):?>
	        	<?=$this->Element("question", array("question" => $question));?>
	        <?endforeach;?>
		<?endif;?>
    </div>
</div>
	    