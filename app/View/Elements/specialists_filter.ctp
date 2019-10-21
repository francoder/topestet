<div class="h1">
	<?/*
	<?if (isset($service) && !empty($service)):?>
		<?if (!$region):?>
			<?=$service['Specialization']['specialist_plural']?>, специализация &mdash; <?=$service['Service']['title']?>
		<?else:?>
			<?=$service['Service']['title']?>
		<?endif;?>
	<?elseif (isset($specialization) && !empty($specialization)):?>
		<?=$specialization['Specialization']['specialist_plural']?>
	<?elseif (!empty($region)):?>
		Специалисты
	<?endif;?>
	<?if (isset($region) && !empty($region)):?>
		<?if (!empty($region['Region']['title_with_preposition'])):?>
			<?=$region['Region']['title_with_preposition']?>
		<?else:?>
			в <?=$this->Display->case_field($region['Region'], "genitive", "title")?>
		<?endif;?>
	<?endif;?>
	*/?>
	<!-- <?=$title_for_layout?> -->
</div>
<div class="performed spec">
    <?if (isset($specialization) && !empty($specialization)):?>
	    <?/*<h3>Специализация &laquo;<?=$specialization['Specialization']['title']?>&raquo;</h3>*/?>
    <?elseif (!empty($specializations)):?>
        <h3>Специализация <span id="spec_hide"></span></h3>
        <ul id="specialize">
        	<?foreach ($specializations as $specialization):?>
        		<?if ($region){
        			$url = "/catalog".(($specialist_type == 2)?"/clinic":"")."/region/{$region['Region']['alias']}/{$specialization['Specialization']['alias']}/";
        		} else {
        			$url = "/catalog".(($specialist_type == 2)?"/clinic":"")."/all/{$specialization['Specialization']['alias']}/";
				}?>
	            <li><a href="<?=$url?>"><?=$specialization['Specialization']['title']?></a></li>
	        <?endforeach;?>
        </ul>
    <?endif;?>
</div>
<div class="performed">
	<?if (isset($service) && !empty($service)):?>
    	
    <?elseif (!empty($services)):?>
        <h3>Услуги <span id="service_hide"></span></h3>
        <ul id="servicebox">
        	<?foreach ($services as $service):?>
        		<?if ($region){
        			$url = "/catalog".(($specialist_type == 2)?"/clinic":"")."/region/{$region['Region']['alias']}/{$service['Specialization']['alias']}/{$service['Service']['alias']}/";
        		} else {
        			$url = "/catalog".(($specialist_type == 2)?"/clinic":"")."/all/{$service['Specialization']['alias']}/{$service['Service']['alias']}/";
				}?>
	            <li><a href="<?=$url?>"><?=$service['Service']['title']?></a></li>
	        <?endforeach;?>
        </ul>
    <?endif;?>
    <br>
    <?/*<div class="all"><a href="#">Все услуги</a></div>*/?>
</div>