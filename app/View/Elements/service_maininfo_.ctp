<?if (!isset($description_field)) $description_field = "description";?>
<h1><?=$service['Service']['title']?></h1>
<div class="info">
	<?$img = $this->Element("image", array("model" => "service", "id" => $service['Service']['id'], "type" => "thumbnail", "alias" => "image", 'also' => array("alt" => $service['Service']['title'], "title" => $service['Service']['title'])));?>
	<?if ($img):?>
    	<div class="image left"><?=$img?></div>
    <?endif;?>
    <div class="info-block">
        <div class="rate">
        	<div class="for_hint">
	            <span><?=$service['Service']['rate']?> %</span>
	            <img src="/img/th_blu.png" alt="" width="32" height="32">
	        </div>
            <div class="detail-rate">
                <a href="/service/info/<?=$service['Service']['alias']?>/#reviews"><?=$service['Service']['review_count']?> отзыв<?=$this->Display->cas($service['Service']['review_count'], array("", "а", "ов"))?></a><br>
                <span>Рейтинг популярности</span>
                <img src="/img/quest.png" alt="" width="16" height="16" class="for_hint">
            </div>
        </div>
        <div class="block_border hint">
        	Рейтинг популярности формируется на основе добавленных пользователями отзывов, в зависимости от того, насколько положительно оценивают их авторы результаты той или иной процедуры. Вы можете <a href="http://www.topestet.ru/service/">посмотреть рейтинги всех процедур</a> или <a href=" http://www.topestet.ru/service/add_review/">добавить свой отзыв с оценкой</a>.
        </div>
        <ul class="details">
            <li><a href="/service/photo/<?=$service['Service']['alias']?>/"><img src="/img/spec.png">Фото до и после</a></li>
            <li><a href="/service/add_review/service:<?=$service['Service']['id']?>/"><img src="/img/add.png">Добавить отзыв</a></li>
            <li><img src="/img/price.png">Средняя цена: <span><?=$this->Display->number($service['Service']['coast_avg'])?> руб.</span></li>
            <li><a href="/forum/add/service:<?=$service['Service']['id']?>/"><img src="/img/addquest.png">Задать вопрос специалисту</a></li>
        </ul>
    </div>
</div>
<div class="clear"></div>
<p><?=$service['Service'][$description_field]?></p>
<ul class="inner-menu">
	<?$inner_menu = array(
		"/service/info/{$service['Service']['alias']}/" => "Отзывы", 
		"/forum/service/{$service['Service']['alias']}/" => "Вопросы и ответы",
		"/service/photo/{$service['Service']['alias']}/" => "Фото до и после",
		"/catalog/service/{$service['Service']['alias']}/" => "Каталог специалистов",
		"/service/add_review/service:{$service['Service']['id']}/" => "Добавить отзыв",
		"/forum/add/service:{$service['Service']['id']}/" => "Задать вопрос",
	);?>
	<?foreach ($inner_menu as $url => $item):?>
		<li <?if ($this->here == $url):?>class="active"<?endif;?>><a href="<?=$url?>"><?=$item?></a></li>
	<?endforeach;?>
</ul>