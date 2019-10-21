<div class="add-page">
	<h2>Мой профиль</h2>
	<?if (isset($done) && $done):?>
		<br><br>
		Спасибо, данные успешно сохранены!
	<?endif;?>
	<?=$this->Form->create("User", array("type" => "file"));?>
		<div class="error"><?=$this->Display->errors($this->validationErrors)?></div>
		<table class="comment-form-add">
			<tr>
				<td>Ваше имя*:</td>
				<td>
					<?=$this->Form->text("name", array("class" => "short"));?><br>
					<span>Будет отображаться в ваших комментариях.</span>
				</td>
			</tr>
			<tr>
				<td>Пол:</td>
				<td>
					<?=$this->Form->radio("sex", array("1" => "мужской", "2" => "женский"), array("legend" => false));?><br>
				</td>
			</tr>
			<tr>
				<td>Дата рождения:</td>
				<td>
					<?=$this->Form->day("birthday");?>
					<?=$this->Form->month("birthday", array("monthNames" => array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря")));?>
					<?=$this->Form->year("birthday", 
						date('Y') - 90,
    					date('Y') - 10
					);?>
					<?//=$this->Form->input("birthday")?>
					<br>
					<span>На сайте не отображается.</span>
				</td>
			</tr>
			<tr>
				<td>Ваш e-mail*:</td>
				<td>
					<?=$this->Form->text("mail", array("class" => "short"));?><br>
					<span>Используется для авторизации на сайте.</span>
				</td>
			</tr>
			<tr>
				<td>Ваш личный e-mail:</td>
				<td>
					<?=$this->Form->text("personal_mail", array("class" => "short"));?><br>
					<span>Для контакта с вами пользователей сайта.</span>
				</td>
			</tr>
			
			<tr>
				<td>Пароль*:</td>
				<td>
					<?=$this->Form->password("password", array("class" => "short", "value" => "", "autocomplete" => "off"));?><br>
					<span>Укажите новый, если хотите сменить.</span>
				</td>
			</tr>
			<tr>
				<td>Повторение пароля*:</td>
				<td>
					<?=$this->Form->password("password_repeat", array("class" => "short", "value" => ""));?><br>
				</td>
			</tr>
			<tr>
				<td>Ссылка на профиль в соц.сети:</td>
				<td>
					<?=$this->Form->text("social_page", array("class" => "short"));?><br>
				</td>
			</tr>
			<tr>
				<td>Аватар:</td>
				<td>
					<?$img = $this->Element("image", array("model" => "user", "id" => $auth['id'], "type" => "main", "alias" => "avatar"))?><br>
					<?if ($img):?>
						<div class="avatar left"><?=$img?></div>
						<div class="clear"></div><br>
					<?endif;?>
					<?=$this->Form->file("avatar");?><br>
				</td>
			</tr>
			<?if (!empty($child_accounts)):?>
				<tr>
					<td>Подчиненные аккаунты:</td>
					<td>
						<table width="60%">
							<?foreach ($child_accounts as $id => $name):?>
								<tr align="left">
									<td width="50%"><?=$name?></td>
									<td width="50%"><a href="/user/simulate/<?=$id?>/">симулировать &rarr;</a></td>
								</tr>
							<?endforeach;?>
						</table>
					</td>
				</tr>
			<?endif;?>
			<?if ($auth['is_specialist']):?>
				<tr>
					<td></td><td align="left" style="text-align:left;"><h2>Информация как о специалисте</h2></td>
				</tr>
				<tr>
					<td>Профессия:</td>
					<td>
						<?=$this->Form->text("profession", array("class" => "short"));?><br>
					</td>
				</tr>
				<tr>
					<td>Адрес:</td>
					<td>
						<?=$this->Form->text("address");?><br>
					</td>
				</tr>
				<tr>
					<td>Телефон:</td>
					<td>
						<?=$this->Form->text("phone", array("class" => "short"));?><br>
					</td>
				</tr>
				<tr>
					<td>Сайт:</td>
					<td>
						<?=$this->Form->text("site", array("class" => "short"));?><br>
						<span>Указывается без http://. Например: <i>yandex.ru</i></span>
					</td>
				</tr>
				<?/*
				<tr>
					<td>Описание:</td>
					<td>
						<?=$this->Form->textarea("description", array("cols" => 30, "rows" => 10));?><br>
					</td>
				</tr>
				*/?>
				<tr>
					<td>Оказываемые услуги:</td>
					<td>
						<table width="60%" class="services_list">
							<?$i = 0;?>
							<?foreach ($services as $title => $specialisation):?>
								<?if ($i % 2 == 0):?>
									<tr valign="top">
								<?endif;?>
									<td width="50%">
										<b><?=$title?></b><br>
										<?$services_selected = array();?>
										<?if (isset($this->data['Service'])){
											foreach ($this->data['Service'] as $service){
												$services_selected[] = $service['id'];
											}
										}?>
										<?foreach ($specialisation as $id => $service_title):?>
											<?$attributes = array()?>
											<?if (in_array($id, $services_selected)){
												$attributes['checked'] = "checked";
											}?>
											<?=$this->Form->checkbox("SpecialistService.service.$id", $attributes);?>
											<?=$this->Form->label("SpecialistService.service.$id", $service_title);?><br>
										<?endforeach;?>
										<br>
									</td>
								<?if (($i + 1) % 2 == 0 || ($i + 1) == count($services)):?>
									</tr>
								<?endif;?>
								<?$i++;?>
							<?endforeach;?>
						</table>
					</td>
				</tr>
			<?elseif(empty($auth['specialist_request'])):?>
				<tr>
					<td></td><td align="left" style="text-align:left;"><h2>Желаете стать специалистом?</h2></td>
				</tr>
				<tr>
					<td>Заявка:</td>
					<td>
						<?=$this->Form->textarea("specialist_request", array("cols" => 30, "rows" => 10));?><br>
						<span>Представьтесь, пожалуйста, и сообщите основную информацию о себе как о специалисте</span>
					</td>
				</tr>
			<?endif;?>
		</table>
		<div class="add-rewiev"><input type="submit" value="Отправить"></div>
	<?=$this->Form->end();?>
</div>