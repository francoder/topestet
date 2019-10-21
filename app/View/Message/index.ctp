<div class="mainbar message-page">
    <h1>Мои сообщения</h1>
    <?foreach ($list as $message):?>
    	<?if ($message['Message']['sender_id'] == $auth['id']) {
    		$sender = $message['User'];
    	} else {
    		$sender = $message['Sender'];
    	}?>
    	<a href="/message/send/<?=$sender['id']?>/">
		    <div class="review message_link" style="cursor:pointer;">
		        <div class="user left">
		            <?=$this->Element("image", array("model" => "user", "id" => $sender['id'], "type" => "mini", "alias" => "avatar", "noimage" => true))?>
		        </div>
		        <div class="other">
		            <h3><a href="/user/page/<?=$sender['id']?>/"><?=$sender['name']?></a></h3>
		            <?if ($message['Message']['sender_id'] == $auth['id']){
		            	$from = "<b>Вы</b>:";
		            } else {
		            	$from = "<b>{$message['Sender']['name']}</b>:";
		            }?>
		            <?=$this->Display->short($from." ".$message['Message']['content'])?>
		        </div>
		        <span class="date"><?=$this->Display->date("d %m Y H:i:s", strtotime($message['Message']['created']))?></span>
		        <span class="number"><?=$message[0]['cnt']?> <?if($message[0]['cnt_new'] > 0):?><b>(<?=$message[0]['cnt_new']?>)</b> <?endif;?>сообщени<?=$this->Display->cas($message[0]['cnt'], array("е", "я", "й"))?></span>
		        <div class="clear"></div>
		    </div>
	    </a>
    <?endforeach;?>
    <?/*
    <div class="pagination">
        <a class="prev" href="#">Предыдущая</a>
        <a href="#">1</a>
        <a href="#" class="active">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">6</a>
        <a href="#">7</a>
        <a href="#">8</a>
        <a href="#">9</a>
        <a href="#" class="next">Следующая</a>
    </div>*/?>
</div> <!--/ End mainbar -->