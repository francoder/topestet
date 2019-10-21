<div class="article add-page" style="margin-top:0;">
    <h2>Дополнение к вашему отзыву &laquo;<?=$service['Review']['subject']?>&raquo;:</h2>
    <br>
    <?if (isset($done) && $done):?>
    	<br>Спасибо! Ваше дополнение размещено.
    <?else:?>
	    <?=$this->Form->create("Review", array("type" => "file"));?>
	    <div class="error"><?=$this->Display->errors($this->validationErrors['ReviewAdd'])?></div>
		<table class="comment-form-add">
			<tr>
	            <td>Заголовок отзыва*</td>
	            <td><?=$this->Form->text("Review.subject", array("cols" => 30, "rows" => 10));?></td>
	        </tr>
	        <tr>
                <td>Стоимость*</td>
                <td><?=$this->Form->text("coast", array("class" => "short"));?><br><span>Общая сумма, потраченная на процедуру (в российских рублях)</span></td>
            </tr>
            <tr>
                <td class="nonpad">Оценка результата*</td>
                <td>
                    <?=$this->Form->radio("note_result", $review_notes, array("legend" => "", "separator" => "<br>"))?>
                </td>
            </tr>
            <tr>
            	<td class="nonpad">Исходный отзыв</td>
            	<td>
            		<p><?=$this->Display->format($review['Review']['description']);?></p>
            		<?foreach ($review['ReviewAdd'] as $add):?>
						<span class="updated">Дополнено <?=date("d.m.Y", strtotime($add['created']))?>:</span>
						<p><?=$this->Display->format($add['content']);?></p>
					<?endforeach;?>
            	</td>
            </tr>
            <?if (!empty($review['Photo'])):?>
            	<tr>
            		<td></td>
            		<td>
            			<table class="holder">
					    	<?foreach ($review['Photo'] as $i => $photo):?>
					    		<?if ($i % 2 == 0):?>
					    			<tr>
					    		<?endif;?>
					    		<td><div class="photo left"><a href="<?=$this->Element("image", array("id" => $photo['id'], "model" => "photo", "alias" => "picture", "onlyurl" => true))?>" target="_blank"><?=$this->Element("image", array("id" => $photo['id'], "model" => "photo", "alias" => "picture", "type" => "mini", "also" => array("title" => $photo['content'])))?></a></div></td>
					    		<?if (($i + 1) % 2 == 0 || ($i + 1) == count($review['Photo'])):?>
					    			<?if (($i + 1) == count($review['Photo']) && $i <2):?>
					    				<td width="50%"></td>
					    			<?endif;?>
					    			</tr>
					    		<?endif;?>
					    	<?endforeach;?>
					    </table>
            		</td>
            	</tr>
            <?endif;?>
			<tr>
	            <td>Текст дополнения*</td>
	            <td><?=$this->Form->textarea("ReviewAdd.0.content", array("cols" => 30, "rows" => 10));?></td>
	        </tr>
	        <tr>
                <td style="text-align: left" colspan="2">
                    <h3>Добавление фото <br><small>Фотографии помогают лучше оценить результаты, поэтому по возможности добавьте свои фото до и после процедуры через эту форму</small></h3>
                </td>
            </tr>
            <tr>
                <td>Фото</td>
                <td class="list_photo">
                	<div id="photos">
                		<div id="photo_ex" class="photo_item">
                			<?if ($this->data && isset($this->data['Photo'][0]['id'])):?>
                				<?//=$this->Element("image", array("model" => "photo", "alias" => "picture", "type" => "thumbnail", "id" => $this->data['Photo'][0]['id']))?><br>
                				<?=$this->Form->hidden("Photo.0.id", array("value" => $this->data['Photo'][0]['id']))?>
                			<?endif;?>
		                    <?=$this->Form->file("Photo.0.picture")?>
		                    <a href="#" class="image_delete" style="display:none;">Удалить</a> <br>
		                    <?=$this->Form->textarea("Photo.0.content", array("cols" => 30, "rows" => 10))?>
		                    <?=$this->Form->hidden("Photo.0.alias", array("value" => "review"))?>
		                    <span>Ваш комментарий изображения</span><br>
		            	</div>
	                </div>
                    <a href="#" class="add-photo">Добавить еще фото</a>
                </td>
            </tr>
		</table>
		<div class="add-rewiev"><input type="submit" value="Отправить"></div>
		<?=$this->Form->end();?>
	<?endif;?>
</div>