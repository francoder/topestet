<?if (!isset($edit)) $edit = false;?>
<div class="add-page">
	<?if ($edit):?>
		<h3>Редактирование своего же отзыва</h3>
	<?elseif(empty($service) && empty($specialist)):?>
    	<h3>Новый отзыв:</h3>
    <?elseif(empty($specialist) && !empty($service)):?>
    	<h3>Новый отзыв на услугу &laquo;<?=$service['Service']['title']?>&raquo;</h3>
    <?elseif(empty($service) && !empty($specialist)):?>
    	<h3>Новый отзыв для специалиста <?=$specialist['User']['name']?></h3>
    <?elseif (!empty($clinic)):?>
    	<h3>Новый отзыв для клиники <?=$specialist['User']['name']?></h3>
    <?endif;?>
	<?if (isset($done) && $done):?>
		<br><br>Ваш отзыв успешно <?if($edit):?>отредактирован<?else:?>добавлен<?endif;?>. Спасибо!<br>
		<?if (!$edit):?>
			Вы можете <a href="<?=$url = "/service/review_edit/$review_id/"?>">отредактировать его</a> в течение 30 минут<br>
			Ссылка на отзыв: <a href="<?=$url = "/service/review/$review_id/"?>">http://<?=$_SERVER['SERVER_NAME'].$url?></a>
		<?endif;?>
	<?else:?>
	    <?=$this->Form->create("Review", array("type" => "file"));?>
	    	<?=$this->Form->hidden("id");?>
	    	<div class="error"><?=$this->Display->errors($this->validationErrors['Review'])?></div>
	        <table class="comment-form-add">
	        	<?if (empty($service)):?>
		        	<tr>
		                <td>Оказанная услуга*</td>
		                <td><?=$this->Form->select("service_id", array_merge($services, array("0" => "нет в списке")), array("class" => "service_list"));?><br><span>Выберите, пожалуйста, оказанную Вам услугу из списка. Если Вы не нашли нужную услугу – выберите пункт «Нет в спике».</span></td>
		            </tr>
		            <tr class="additional_field" style="display:none;"> 
		                <td>Название услуги*</td>
		                <td><?=$this->Form->text("service_title");?><br><span>Укажите, пожалуйста, услугу если её нет в списке.</span></td>
		            </tr>
	            <?else:?>
	            	<?=$this->Form->hidden("service_id", array("value" => $service['Service']['id']));?>
	            <?endif;?>
	            <tr>
	                <td>Заголовок отзыва*</td>
	                <td><?=$this->Form->text("subject");?><span>Суть отзыва в нескольких словах. Постарайтесь передать в заголовке основную информацию, чтобы читателям было проще понять содержание отзыва. Хороший заголовок: «Ринопластика и ее результаты через 3 месяца после операции, Москва». Плохой заголовок «Я так рада, все просто супер!»</span></td>
	            </tr>
	            <tr>
	                <td>Стоимость*</td>
	                <td><?=$this->Form->text("coast", array("class" => "short"));?><br><span>Общая сумма, потраченная на процедуру (в российских рублях)</span></td>
	            </tr>
	            <tr>
	                <td>Текст отзыва*</td>
	                <td><?=$this->Form->textarea("description", array("cols" => 30, "rows" => 10));?><span>Минимум 500 знаков. Расскажите, для чего вы делали процедуру, ваши за и против, ваш опыт и выводы. <b>Внимание!</b> Не указывайте здесь информацию о специалисте или клинике – используйте для этого специальное поле ниже.</span></td>
	            </tr>
	            <tr>
	                <td>Город проведения*</td>
	                <td><?=$this->Form->select("region_id", $regions);?></td>
	            </tr>
	            <tr>
	                <td class="nonpad">Оцените результат*</td>
	                <td>
	                    <?=$this->Form->radio("note_result", $review_notes, array("legend" => "", "separator" => "<br>"))?>
	                </td>
	            </tr>
	            <?if (empty($specialist)):?>
		            <tr>
		                <td>Специалист<br>(необязательно)</td>
		                <td>
		                	<?=$this->Form->hidden("specialist_id", array("id" => "specialist_id"));?>
		                	<?=$this->Form->text("specialist_name", array("id" => "specialist_list"));?><span>Укажите имя специалиста</span>
		                </td>
		            </tr>
		        <?else:?>
		        	<?=$this->Form->hidden("specialist_id", array("value" => $specialist['User']['id']));?>
		        <?endif;?>
		        
		        <?if (empty($clinic)):?>
		            <tr>
		                <td>Клиника <br>(необязательно)</td>
		                <td>
		                	<?=$this->Form->hidden("clinic_id", array("id" => "clinic_id"));?>
		                	<?=$this->Form->text("clinic_name", array("id" => "clinic_list"));?><span>Укажите название клиники</span>
		                </td>
		            </tr>
		        <?else:?>
		        	<?=$this->Form->hidden("specialist_id", array("value" => $specialist['User']['id']));?>
		        <?endif;?>
		        
	            <tr>
	                <td class="nonpad">Оценка специалиста</td>
	                <td class="rate">
	                	<?//=$this->Form->radio("note_specialist", array(1 => "Ужасно", 2 => "Плохо", 3 => "Удовлетворительно", 4 => "хорошо", 5 => "отлично"), array("legend" => ""))?>
	                	<?=$this->Form->hidden("note_specialist", array("class" => "note_specialist"));?>
	                	<div class="note">
		                	<div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div><div class="star"></div>
		                	<div class="clear"></div>
		                </div>
		                <div class="note_comment"></div>
	                </td>
	            </tr>
	            <tr>
	                <td>Ваши впечатления о специалисте, которые помогут другим читателям сделать правильный выбор</td>
	                <td><?=$this->Form->textarea("comment_note", array("cols" => 30, "rows" => 10));?></td>
	            </tr>
	            <tr>
	                <td style="text-align: left" colspan="2">
	                    <h3>Добавление фото <br><small>Фотографии помогают лучше оценить полученный результат, поэтому по возможности добавьте свои фото до и после процедуры через эту форму</small></h3>
	                </td>
	            </tr>
	            <tr>
	                <td>Фото</td>
	                <td class="list_photo">
	                	<div id="photos">
	                		<div id="photo_ex" class="photo_item">
	                			<?if ($this->data && isset($this->data['Photo'][0]['id'])):?>
	                				<?=$this->Element("image", array("model" => "photo", "alias" => "picture", "type" => "thumbnail", "id" => $this->data['Photo'][0]['id']))?><br>
	                				<?=$this->Form->hidden("Photo.0.id", array("value" => $this->data['Photo'][0]['id'], "class" => "photo_id"))?>
	                			<?endif;?>
			                    <?=$this->Form->file("Photo.0.picture", array('required' => 'no'))?>
			                    <a href="#" class="image_delete" style="display:none;">Удалить</a> <br>
			                    <?=$this->Form->textarea("Photo.0.content", array("cols" => 30, "rows" => 10))?>
			                    <?=$this->Form->hidden("Photo.0.alias", array("value" => "review"))?>
			                    <span>Ваш комментарий изображения</span><br>
			                    <?=$this->Form->checkbox("Photo.0.is_adult")?>
					            <?=$this->Form->label("Photo.0.is_adult", '18+ (изображение содержит материалы, предназначенные для категории 18+)')?>
			            	</div>
			            	<?if ($edit):?>
			            		<?foreach ($this->data['Photo'] as $i => $photo):?>
			            			<?if ($i == 0) continue;?>
			            			<div id="photo_ex" class="photo_item">
			                			<?=$this->Element("image", array("model" => "photo", "alias" => "picture", "type" => "thumbnail", "id" => $photo['id']))?><br>
			                			<?=$this->Form->hidden("Photo.$i.id", array("value" => $this->data['Photo'][0]['id']))?>
					                    <?=$this->Form->file("Photo.$i.picture")?>
					                    <?=$this->Form->textarea("Photo.$i.content", array("cols" => 30, "rows" => 10))?>
					                    <?=$this->Form->hidden("Photo.$i.alias", array("value" => "review"))?>
					                    <span>Ваш комментарий изображения</span><br>
					                    <?=$this->Form->checkbox("Photo.$i.is_adult")?>
					                    <?=$this->Form->label("Photo.$i.is_adult", '18+')?>
					            	</div>
			            		<?endforeach;?>
			            	<?endif;?>
		                </div>
	                    <a href="#" class="add-photo">Добавить еще фото</a>
	                </td>
	            </tr>
	        </table>
	        <table class="last">
	            <tr>
	                <td>Я планирую обновить отзыв через...</td>
	                <td>
	                	<?=$this->Form->select("remind", array("1 WEEK" => "1 неделя", "1 MONTH" => "1 месяц", "3 MONTH" => "3 месяца", "6 MONTH" => "6 месяцев", "1 YEAR" => "1 год", 0 => "никогда"), array("value" => "1 WEEK", "style" => "width:150px !important;"))?>
	                </td>
	            </tr>

	        </table>
	        <div class="add-rewiev"><input type="submit" value="Отправить"></div>
	    </form>
	<?endif;?>
</div><!--/ End content -->