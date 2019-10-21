<div class="add-page">
	<h2>Регистрация на сайте</h2>
	<?if (isset($done) && $done):?>
		<br><br>
		Спасибо за регистрацию. На ваш адрес электронной почты отправлена инструкция для активации учетной записи.
	<?else:?>
		<?=$this->Form->create('User', array('type' => 'file'));?>
			<div class="error"><?=$this->Display->errors($this->validationErrors)?></div>
			<table class="comment-form-add">
				<tr>
					<td>Ваше имя*:</td>
					<td>
						<?=$this->Form->text('name', array('class' => 'short'));?><br>
						<span>Будет отображаться в ваших комментариях.</span>
					</td>
				</tr>
				<tr>
					<td>Ваш e-mail*:</td>
					<td>
						<?=$this->Form->text('mail', array('class' => 'short'));?><br>
						<span>Используется для авторизации на сайте.</span>
					</td>
				</tr>
				<tr>
					<td>Пароль*:</td>
					<td>
						<?=$this->Form->password('password', array('class' => 'short'));?><br>
						<span>Используется для авторизации на сайте.</span>
					</td>
				</tr>
				<tr>
					<td>Повторение пароля*:</td>
					<td>
						<?=$this->Form->password('password_repeat', array('class' => 'short'));?><br>
					</td>
				</tr>
				<tr>
					<td>Аватар:</td>
					<td>
						<?=$this->Form->file('avatar');?><br>
					</td>
				</tr>
			</table>
			<div class="add-rewiev"><input type="submit" value="Отправить"></div>
		<?=$this->Form->end();?>
	<?endif;?>
</div>
