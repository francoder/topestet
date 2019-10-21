<div class="article add-page" style="margin-top:0;">
    <?=$this->Element("service_maininfo", array("service" => $service))?>
    <h2>Добавление фото к услуге &laquo;<?=$service['Service']['title']?>&raquo;:</h2>
    <br>
    <?if (isset($done) && $done):?>
    	<br>Спасибо! Ваши фотографии успешно размещены.<br>
    	Ссылка на фотографии: <a href="<?=$url = "/service/pic/$photospec_id/"?>">http://<?=$_SERVER['SERVER_NAME'].$url?></a>
    <?else:?>
	    <?=$this->Form->create("Photospec", array("type" => "file", "novalidate" => true));?>
	    <div class="error"><?=$this->Display->errors($this->validationErrors['Photospec'])?></div>
		<table class="comment-form-add">
			<tr>
	            <td>Заголовок к фотографиям*</td>
	            <td><?=$this->Form->text("title");?></td>
	        </tr>
	        <tr>
	        	<td></td>
	        	<td class="photospec_select">
	        	<?
	        		$options = array("legend" => false, "separator" => "<br/>");
	        		if (!isset($this->data['Photospec']['type']) || empty($this->data['Photospec']['type'])){
	        			$options['value'] = 2;
	        		}
	        	?>
	        	<?=$this->Form->radio("type", array("2" => "Два изображения (&laquo;до&raquo; и &laquo;после&raquo;)", "1" => "Одно изображение (Фото &laquo;до&raquo; и &laquo;после&raquo; совмещены)"),
	        		$options
	        	);?></td>
	        </tr>
	        <tr class="photo_one">
	            <td>Фотография*</td>
	            <td><?=$this->Form->file("both");?></td>
	        </tr>
			<tr class="photo_two">
	            <td>Фотография до*</td>
	            <td><?=$this->Form->file("before");?></td>
	        </tr>
	        <tr class="photo_two">
	            <td>Фотография после*</td>
	            <td><?=$this->Form->file("after");?></td>
	        </tr>
			<tr>
	            <td>Ваш комментарий к добавляемым фото*</td>
	            <td><?=$this->Form->textarea("content", array("cols" => 30, "rows" => 10));?></td>
	        </tr>
		</table>
		<div class="add-rewiev"><input type="submit" value="Отправить"></div>
		<?=$this->Form->end();?>
	<?endif;?>
</div>