<div class="article">
    <?=$this->Element("service_maininfo", array("service" => $service, 'hide_description' => $this->Paginator->hasPrev()))?>
    <h2>Фото до и после <?=$this->Display->case_field($service['Service'], "genitive")?>:</h2>
    <!-- div class="filter">
        <span class="head">Фильтр фото:</span>
        <br>
        <br>
        <form action="#" class="photo_filters" method="GET">
        	<?if (!empty($filters['age']['values'])):?>
	            <b>Возраст пациента:</b>
	            <?foreach ($filters['age']['values'] as $value => $title):?>
	            	<input type="checkbox" id='v_<?=$value?>' value="<?=$value?>" name="age[]" <?if (isset($_GET['age']) && in_array($value, $_GET['age'])):?>checked<?endif;?>> <label for="v_<?=$value?>"><?=$title?></label>
	            <?endforeach;?>
	        <?endif;?>
            <br>
            <br>
            <b>Пол пациента:</b>
            <input type="checkbox" id='male' value="1" name="sex[]" <?if (isset($_GET['sex']) && in_array(1, $_GET['sex'])):?>checked<?endif;?>> <label for="male">Мужской</label>
            <input type="checkbox" id='female' value="2" name="sex[]" <?if (isset($_GET['sex']) && in_array(2, $_GET['sex'])):?>checked<?endif;?>> <label for="female">Женский</label>
        </form>
    </div -->
    <?if (empty($photos)):?>
    	<br>Фотографий пока нет.
    <?else:?>
	    <table class="photos catalog">
	    	<?foreach ($photos as $i => $photo):?>
	    		<?if ($i % 3 == 0):?>
	    			<tr>
	    		<?endif;?>
	    		<td align="right">
	    			<div class="photo left">
	    				<a href="/service/review/<?=$photo['Photo']['parent_id']?>/"><?=$this->Element("image", array("id" => $photo['Photo']['id'], "model" => "photo", "alias" => "picture", "type" => "mini", "also" => array("title" => $photo['Photo']['content'])))?></a>
	    			</div>
	    		</td>
	    		<?if (($i + 1) % 3 == 0 || ($i + 1) == count($photos)):?>
	    			
</tr>
	    		<?endif;?>
	    	<?endforeach;?>
	    </table>
	<?endif;?>

    <div class="add-review">
        <a href="/service/add_review/service:<?=$service['Service']['id']?>/">Добавить отзыв</a>
        <span class="ie7"><?=$service['Service']['title']?>: поделитесь своим опытом!</span>
    </div>
    <?$this->Paginator->options(array('convertKeys' => array("sex[]", "age[]")));?>

    <?$pages = $this->Paginator->numbers(array("separator" => "", "model" => "Photo", "modulus" => 6, "first" => 1, "last" => 1));?>
	<?if ($pages):?>
		<div class="pagination">
			<?=$this->Paginator->prev("Предыдущая", array("model" => "Photo"), " ")?>
			<?=$pages;?>
			<?=$this->Paginator->next("Следующая", array("model" => "Photo"), " ")?>
		</div>
	<?endif;?>
</div>