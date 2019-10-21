<div class="add-page">
        <h3>Связь с редакцией</h3>
		<?if (isset($done) && $done):?>
			<br><br>Спасибо, ваше обращение отправлено. Мы ответим Вам в ближайшее время.
		<?else:?>
	        <?=$this->Form->create("Feedback");?>
	        	<div class="error"><?=$this->Display->errors($this->validationErrors)?></div>
	            <table class="comment-form-add">
	                <tr>
	                    <td>Тема обращения*</td>
	                    <td><?=$this->Form->text("subject")?><span>Суть обращения в нескольких словах.</span></td>
	                </tr>
	                <tr>
	                    <td>Суть обращения*</td>
	                    <td>
	                    	<?=$this->Form->textarea("content", array("cols" => 30, "rows" => 10))?>
	                    	<span>О чем Вы хотели бы с нами пообщаться..?</span></td>
	                </tr>
	                <?if (!$auth):?>
	                	<tr>
		                    <td>Ваш e-mail*</td>
		                    <td><?=$this->Form->text("mail", array("class" => "short"))?><br><span>Укажите свой адрес электронной почты, чтобы мы могли связаться с вами.</span></td>
		                </tr>
	                <?endif;?>
	            </table>
	            <div class="add-rewiev"><input type="submit" value="Отправить"></div>
	       <?=$this->Form->end();?>
	<?endif;?>
</div>