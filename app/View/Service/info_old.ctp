<?php ?>
<div class="article">
    <?=$this->Element("service_maininfo", array("service" => $service, 'hide_description' => $this->Paginator->hasPrev()))?>
    <!-- h2>Отзывы пациентов <?=$this->Display->case_field($service['Service'], "prepositional")?>:</h2 -->
     <a name="reviews"></a>
    <?foreach ($reviews as $review):?>
        <?=$this->Element("review", array("review" => $review, "full" => true))?>
    <?endforeach;?>
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
    <div class="add-review">
        <a href="/service/add_review/service:<?=$service['Service']['id']?>/">Добавить отзыв</a>
        <span class="ie7"><?=$service['Service']['title']?>: поделитесь своим опытом!</span>
    </div>
    <?$pages = $this->Paginator->numbers(array("separator" => "", "model" => "Review", "modulus" => 6, "first" => 1, "last" => 1));?>
    <?if ($pages):?>
        <div class="pagination">
            <?=$this->Element("clear_first_page", array('pages' => $this->Paginator->prev("Предыдущая", array("model" => "Review"), " ")));?>
            <?=$this->Element("clear_first_page", array('pages' => $pages));?>
            <?=$this->Paginator->next("Следующая", array("model" => "Review"), " ")?>
        </div>
    <?endif;?>
</div>