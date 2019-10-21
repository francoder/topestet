<h1 style="margin-top:0;"><img src="/img/admin/mail.png">CSV-файл с адресами e-mail</h1>
<?if (isset($done) && $done):?>
	<?=$this->element("message", array("ok" => true, "message" => "Файл сгенерирован"));?><br>
	<center>
		Найдено: <b><?=$cnt?></b><br>
		<?if ($cnt > 0):?>
			Для скачивания <a href="/<?=$fname?>">используйте ссылку</a>.<br>
		<?endif;?><br>
	</center>
<?endif;?>
<?=$this->Form->create("Mail", array("url" => $this->here));?>
	<table width="500" style="margin:0 auto;">
		<tr>
			<td>Маска поиска (вкл):</td>
			<td><?=$this->Form->text('mail')?><br><span class="note">Используйте % для замещения нескольких символов, ? &mdash; одного</span></td>
		</tr>
		<tr>
			<td>Маска поиска (искл):</td>
			<td><?=$this->Form->text('mail_not')?><br><span class="note">Используйте % для замещения нескольких символов, ? &mdash; одного</span></td>
		</tr>
		<tr>
			<td>Тип аккаунта:</td>
			<td><?=$this->Form->select('is_specialist', array('0' => 'просто пользователь', '1' => 'специалист', '2' => 'Клиника'))?></td>
		</tr>
		<tr>
			<td>Активированный аккаунт:</td>
			<td><?=$this->Form->select('active', array('0' => 'неактивированные', '1' => 'активированные'))?></td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<?=$this->Form->submit("Сгенерировать");?>
			</td>
		</tr>
	</table>
<?=$this->Form->end();?>