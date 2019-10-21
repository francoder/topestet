<div class="messages">
    <h1>Между мной и <a href="/user/page/<?=$reciver['User']['id']?>/"><?=$reciver['User']['name']?></a></h1>
    <?if (isset($done) && $done):?>
    	<p>Сообщение успешно отправлено.</p>	
    <?endif;?>
    <?foreach ($messages as $message):?>
	    <div class="review">
	        <div class="user left"><?=$this->Element("image", array("noimage" => true, "id" => $message['Sender']['id'], "model" => "user", "alias" => "avatar", "type" => "mini"))?></div>
	        <div class="other">
	            <h3><a href="/user/page/<?=$message['Sender']['id']?>/"><?=$message['Sender']['name']?></a> <?=$this->Display->date("d %m Y, H:i", strtotime($message['Message']['created']))?></h3>
	            <?=$this->Display->format($message['Message']['content'])?>
	        </div>
	        <a href="/message/del/<?=$message['Message']['id']?>/"><div class="delete">X</div></a>
	        <div class="clear"></div>
	    </div>
    <?endforeach;?>
    <?$pages = $this->Paginator->numbers(array("separator" => "", "model" => "Message", "modulus" => 6, "first" => 1, "last" => 1));?>
	<?if ($pages):?>
		<div class="pagination">
			<?=$this->Paginator->prev("Предыдущая", array("model" => "Review"), " ")?>
			<?=$pages;?>
			<?=$this->Paginator->next("Следующая", array("model" => "Review"), " ")?>
		</div>
	<?endif;?>
    <div class="add-comment">
    	<?$errors = $this->Display->errors($this->validationErrors);?>
    	<?if ($errors):?>
    		<div class="error"><?=$errors?></div>
    	<?endif;?>
        <?=$this->Form->create("Message");?>
            <label for="text">Текст сообщения*</label><br>
            <?=$this->Form->textarea("content");?>
            <input type="submit" value="Отправить">
        <?=$this->Form->end();?>
    </div>

</div> <!--/ End mainbar -->