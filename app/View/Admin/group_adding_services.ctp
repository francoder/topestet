<h1 style="margin-top:0;"><img src="/img/admin/key.png">Массовое добавление услуг</h1>
<?if (isset($done) && $done):?>
	<?=$this->element("message", array("ok" => true, "message" => "Добавлено"));?>
<?endif;?>
<?=$this->Form->create("Group", array("url" => $this->here));?>
	<table width="500" style="margin:0 auto;">
		<tr>
			<td>Для:</td>
			<td><?=$this->Form->select('is_specialist', array('1' => 'Врач', '2' => 'Клиника'))?></td>
		</tr>
		<tr>
			<td>У которых:</td>
			<td><?=$this->Form->select('have', array('0' => 'не имеется', '2' => 'имеется'))?></td>
		</tr>
		<tr>
			<td>Услуга:</td>
			<td><?=$this->Form->select('service_have_id', $services)?></td>
		</tr>
		<tr>
			<td>Добавить услугу:</td>
			<td><?=$this->Form->select('service_id', $services)?></td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<?=$this->Form->submit("Сохранить");?>
			</td>
		</tr>
	</table>
<?=$this->Form->end();?>