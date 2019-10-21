<div class="add-page">
	<h2>Восстановление пароля</h2>
	<br>Если у вас нет логина и пароля от сайта, то <a href="/user/registration/">зарегистрируйтесь</a>.
	<div class="error"><?echo $this->Session->flash('auth');?></div>
	<?if (isset($done) && $done):?>
		<br><br><b>Ваш новый пароль успешно выслан</b>
	<?else:?>
		<?=$this->Form->create("User");?>
			<div class="error"><?=$this->Display->errors($this->validationErrors)?></div>
			
			<table class="comment-form-add">
				<tr>
					<td>E-mail*:</td>
					<td>
						<?=$this->Form->text("mail", array("class" => "short"));?><br>
					</td>
				</tr>
			</table>
			<div class="add-rewiev"><input type="submit" value="Выслать новый"></div>
		<?=$this->Form->end();?>
	<?endif;?>
</div>