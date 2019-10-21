<?php ?>
<div class="article">
    <?=$this->Element("service_maininfo", array("service" => $service, 'hide_description' => $this->Paginator->hasPrev()))?>
    <h2>Рейтинг специалистов по <?=$this->Display->case_field($service['Service'], "dative")?>:</h2>
    <?foreach ($specialists as $specialist):?>
    	<?$account_url = 'specialist';
		if ($specialist['User']['is_specialist'] == 2){
			$account_url = 'clinic';
		}?>
		<div class="specialist <?if ($specialist['User']['is_adv']):?> adv<?endif;?>">
		    <div class="avatar left"><a href="/<?=$account_url?>/profile/<?=$specialist['User']['id']?>/"><?=$this->Element("image", array("model" => "user", "type" => "mini", "alias" => "avatar", "id" => $specialist['User']['id'], "noimage" => true))?></a></div>
		    <a href="/<?=$account_url?>/profile/<?=$specialist['User']['id']?>/" class="name"><?=$specialist['User']['name']?></a>
		    <br><br>
		    <span><?=$specialist['User']['profession']?><br><?=$specialist['User']['address']?></span>
		    
		    <div class="ufo">
		    	<?if ($specialist['User']['is_top']):?>
		    		<img src="/img/top.png" height="32" width="32" class="for_hint">
		    	<?endif;?>
		    </div>
		    <div class="rate">
		        <div class="note_result">
		        	<?for ($i = 1; $i < 6; $i++):?>
		        		<div class="star <?if (round($specialist['User']['rate']) >= $i):?>active<?endif;?>"></div>
		        	<?endfor;?>
		        </div>
		        <span class="text"><?=$specialist['User']['response_count']?> ответ<?=$this->Display->cas($specialist['User']['response_count'], array("", "а", "ов"))?></span>
		    </div>
		    Рейтинг: <?=$specialist['SpecialistService']['rate']?> (голосов: <?=$specialist['SpecialistService']['rate_count']?>). Общий рейтинг: <?=$specialist['SpecialistService']['rating'];?>
		</div>
    <?endforeach;?>
</div>
