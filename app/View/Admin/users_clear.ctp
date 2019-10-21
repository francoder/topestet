<h1 style="margin-top:0;"><img src="/img/admin/users.png">Удаление неактивированных пользователей</h1>
<?if (isset($done) && $done):?>
	<?=$this->element("message", array("ok" => true, "message" => "Очистка выполнена"));?><br>
	<center>
		Найдено: <b><?=$cnt?></b><br>
	</center>
<?endif;?>
<?=$this->Form->create("User", array("url" => $this->here));?>
	<table width="500" style="margin:0 auto;">
		<tr>
			<td align="center" colspan="2">
				<?=$this->Form->submit("Очистить");?>
			</td>
		</tr>
	</table>
<?=$this->Form->end();?>