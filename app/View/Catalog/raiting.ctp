<?php ?>
<div class="surlist-page">
    <div class="surlist2-page">
		<?$cur_page = $this->Paginator->params();
			$count = $cur_page['limit'];
			$cur_page = $cur_page['page'];
		?>
        <?foreach ($specialists as $i => $specialist):?>
            <?$account_url = 'specialist';
			if ($specialist['User']['is_specialist'] == 2){
				$account_url = 'clinic';
			}?>
			<div class="specialist<?if ($i == 0):?> first<?endif;?><?if ($specialist['User']['is_adv']):?> adv<?endif;?>">
			    <div class="avatar left"><a href="/<?=$account_url?>/profile/<?=$specialist['User']['id']?>/"><?=$this->Element("image", array("model" => "user", "type" => "mini", "alias" => "avatar", "id" => $specialist['User']['id'], "noimage" => true))?></a></div>
			    <?=($cur_page - 1) * $count + $i + 1?>. <a href="/<?=$account_url?>/profile/<?=$specialist['User']['id']?>/" class="name"><?=$specialist['User']['name']?></a>
			    <br><br>
			    <span><?=$specialist['User']['profession']?><br><?=$specialist['User']['address']?></span>
			    
			    <div class="ufo">
			    	<?if ($specialist['User']['is_top']):?>
			    		<img src="/img/top.png" height="32" width="32" class="for_hint">
			    	<?endif;?>
			    </div>
			    <div class="rate">
			        Отзывов: <?=$specialist['User']['review_count']?>
			    </div>
			</div>
        <?endforeach;?>
        <div class="block_border hint">
	        Статус «Топ» свидетельствует о высокой оценке работы данного специалиста со стороны пациентов. Им награждаются специалисты, получившие наибольшее количество положительных оценок в отзывах, благодарностей за ответы на вопросы, а также регулярно посвящающие время консультированию пользователей нашего сайта.
	    </div>
        		<div class="empt"><!-- Яндекс.Директ -->
<script type="text/javascript">
//<![CDATA[
yandex_partner_id = 116479;
yandex_site_bg_color = 'FFFFFF';
yandex_site_charset = 'utf-8';
yandex_ad_format = 'direct';
yandex_font_size = 1.2;
yandex_font_family = 'tahoma';
yandex_direct_type = 'flat';
yandex_direct_limit = 2;
yandex_direct_title_font_size = 3;
yandex_direct_title_color = '3B5998';
yandex_direct_url_color = '777777';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = 'CC0000';
yandex_direct_favicon = true;
yandex_stat_id = 2;
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc'+'ript>');
//]]>
</script></div>
		<?$this->Paginator->options(array(
    		'url' => array(
    			'controller' => 'catalog',
    			'action' => 'raiting/' . ($specialist_type == 1?'specialists':'clinics')
    		)));?>
        <?$pages = $this->Paginator->numbers(array("separator" => "", "model" => "User", "modulus" => 6, "first" => 1, "last" => 1));?>
        <?if ($pages):?>
            <div class="pagination">
                <?=$this->Element("clear_first_page", array('pages' => $this->Paginator->prev("Предыдущая", array("model" => "User"), " ")));?>
                <?=$this->Element("clear_first_page", array('pages' => $pages));?>
                <?=$this->Paginator->next("Следующая", array("model" => "User"), " ")?>
            </div>
        <?endif;?>
        <br><br>
        
        <?if ($specialist_type == 1):?>
        	<?$url = str_replace('/catalog/', '/catalog/clinic/', $this->here);?>
        	<a href="<?=$url?>">Каталог клиник</a>
        <?else:?>
        	<a href="<?=str_replace('', '', str_replace('/clinic/', '/', $this->here))?>">Каталог специалистов</a>
        <?endif;?>
        
	</div>
</div>