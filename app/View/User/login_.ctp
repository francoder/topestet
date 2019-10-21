<div class="add-page">
	<h2>Авторизация на сайте</h2>
	<br>Если у вас нет логина и пароля от сайта, то <a href="/user/registration/">зарегистрируйтесь</a>.
	<div class="error"><?echo $this->Session->flash('auth');?></div>
	<?=$this->Form->create("User", array("type" => "file"));?>
		<div class="error"><?=$this->Display->errors($this->validationErrors)?></div>
		<table class="comment-form-add">
			<tr>
				<td>E-mail*:</td>
				<td>
					<?=$this->Form->text("mail", array("class" => "short"));?><br>
				</td>
			</tr>
			<tr>
				<td>Пароль*:</td>
				<td>
					<?=$this->Form->password("password", array("class" => "short"));?><br>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;">Запомнить меня:</td>
				<td style="padding-top:10px;padding-bottom:10px;">
					<?=$this->Form->checkbox("remember");?><br>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;"></td>
				<td style="padding-top:10px;">
					<a href="/user/remind/">Забыли пароль?</a>
				</td>
			</tr>
		</table>
		<div class="add-rewiev"><input type="submit" value="Войти"></div>
	<?=$this->Form->end();?>
</div>