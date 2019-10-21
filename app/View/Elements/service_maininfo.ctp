<?php ?>
<? if (!isset($description_field)) {
    $description_field = "description";
} ?>
    <div itemscope itemtype="http://schema.org/Product">
	<h1 itemprop="name"><?= $service['Service']['title'] ?></h1>
    <div class="info row">
        <? $img = $this->Element("image",
                                 array(
                                      "model" => "service",
                                      "id"    => $service['Service']['id'],
                                      "type"  => "thumbnail",
                                      "alias" => "image",
                                      'also'  => array("alt" => $service['Service']['title'], "title" => $service['Service']['title'])
                                 )); ?>
        <? if ($img): ?>
            <div class="image left col-xs-12 col-sm-4"><?= $img ?></div>
        <? endif; ?>
        <div class="info-block col-xs-12 col-sm-8">
            <div class="rate" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                <div class="for_hint">
					<meta itemprop="bestRating" content="100">
                    <img src="/img/th_blu.png" alt=""  >
					<span><span itemprop="ratingValue"  content="<?= $service['Service']['rate'] ?>"><?= $service['Service']['rate'] ?></span>%</span>
                </div>
                <div class="detail-rate">
                    <a class="revvv" href="/service/info/<?= $service['Service']['alias'] ?>/#reviews">Оценок:<?= $this->Display->cas($service['Service']['review_count'],
                                                                                                                      array("", "", "")) ?> <span itemprop="reviewCount"><?= $service['Service']['review_count'] ?></span></a><br>
                    <span>Рейтинг популярности</span><img src="/img/quest.png" alt="" class="for_hint">
                </div>
            </div>
            <div class="block_border hint">
                Рейтинг популярности формируется на основе добавленных пользователями отзывов, в зависимости от того, насколько положительно оценивают их
                авторы результаты той или иной процедуры. Вы можете <a href="/service/">посмотреть рейтинги всех процедур</a> или <a
                    href="/service/add_review/">добавить свой отзыв с оценкой</a>.
            </div>
            
   
            <ul class="details">
                <li><a href="/service/price/<?= $service['Service']['alias'] ?>/" ><img src="/img/price.png">Средняя цена</a>:
                    <span class="blackprice"><?= $this->Display->number($service['Service']['coast_avg']) ?> р.</span></li>
				<li><a href="/forum/add/service:<?= $service['Service']['id'] ?>/"><img src="/img/addquest.png">Задать вопрос специалисту</a></li>
                <li><a href="/service/add_review/service:<?= $service['Service']['id'] ?>/"><img src="/img/addrew.png">Добавить отзыв</a></li>
                <!--li><a href="/service/photo/<?= $service['Service']['alias'] ?>/">Фото до и после</a></li-->
                
            </ul>
        </div>
    </div>
	</div>
    <div class="clear"></div>
    <? if (!isset($hide_description) or !$hide_description) : ?>
        <p><?= $service['Service'][$description_field] ?></p>
    <? endif; ?>
    
    <?if (!empty($child_services)):?>
    	<h2>Дочерние услуги:</h2>
    	<br><br>
    	<div class="rating-page">
	    	<table width="100%" cellspacing="0" <?if (count($child_services) > 1):?>class="sortable"<?endif;?>>
		    	<thead>
			        <tr class="thead">
			            <th><span>Процедура</span></th><th><span>Популярность</span></th><th class="{sorter: 'int'}"><span>Средняя цена</span></th><th><span>Отзывов</span></th><th class="last"><i style="text-decoration:none !important;">&nbsp;</i></td>
			        </tr>
			    </thead>
			    <tbody>
			        <?foreach ($child_services as $child):?>
				        <tr>
				            <td><a href="/service/info/<?=$child['Service']['alias']?>/"><?=$child['Service']['title']?></a></td>
				            <td data-value="<?=$child['Service']['rate']?>"><?=$child['Service']['rate']?> %</td>
				            <td data-value="<?=$child['Service']['coast_avg']?>"><a href="/service/price/<?=$child['Service']['alias']?>"><?=$this->Display->number($child['Service']['coast_avg'])?> руб.</a></td><td><a href="/service/info/<?=$child['Service']['alias']?>/"><?=$child['Service']['review_count']?></a></td><td class="last"><a href="/service/info/<?=$child['Service']['alias']?>/"><?=$this->Element("image", array("model" => "service", "id" => $child['Service']['id'], "alias" => "image", "type" => "mini"))?></a></td>
				        </tr>
				    <?endforeach;?>
			    </tbody>
		    </table>
		</div>
    <?endif;?>
    
    <ul class="inner-menu" style="margin-left:0;">
        <?$inner_menu = array(
            "/service/info/{$service['Service']['alias']}/"                                      => "Отзывы (".$service['Service']['review_count'] . ')',
            "/forum/service/{$service['Service']['alias']}/"                                     => "Вопросы и ответы (".$service['Service']['question_count'] . ')',
            "/service/photo/{$service['Service']['alias']}/"                                     => "Фото до и после (".$service['Service']['photospec_count'] . ')',
            "/catalog/all/{$service['Specialization']['alias']}/{$service['Service']['alias']}/" => "Специалисты (".$service['Service']['specialist_service_count'] . ')',
            "/service/art/{$service['Service']['alias']}/"									 => 'Статьи (' . $service['Service']['article_count'] . ')',
            "/service/add_review/service:{$service['Service']['id']}/"                           => "Добавить отзыв"/*,
            "/forum/add/service:{$service['Service']['id']}/"                                    => "Задать вопрос",*/
        );?>

        <? foreach ($inner_menu as $url => $item): ?>
            <li <? if (mb_substr($this->here, 0, mb_strlen($url)) == $url): ?>class="active"<? endif; ?>><a href="<?= $url ?>"><?= $item ?></a></li>
        <? endforeach; ?>
    </ul>
<? if ($auth && $auth['is_admin'] > 1): ?>
    <br><br><a href="/admin/self_item/Service/<?= $service['Service']['id'] ?>/" style="color:red;" target="_blank">редактировать</a><br>
    <a href="/service/raiting/<?=$service['Service']['alias']?>/">Рейтинг</a>
<? endif; ?>