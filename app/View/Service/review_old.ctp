<?php ?>
<div class="inner-article">
<h1><?=$review['Review']['subject']?></h1>
    <h2 class="left">Отзывы <?=$this->Display->case_field($review['Service'], "prepositional")?>:<br><small>истории и мнения пациентов</small></h2>
    <div class="add-review right">
        <a href="/service/add_review/service:<?=$review['Service']['id']?>/">Добавить отзыв</a>
    </div>
    <div class="clear"></div>

<div class="review_resultbox botmargin2"><img src="/img/<?if ($review['Review']['note_result'] == 1):?>th_ora<?elseif ($review['Review']['note_result'] == 2 || $review['Review']['note_result'] == 0):?>undecided<?else:?>th_gre<?endif;?>.png" alt="<?=$notes[$review['Review']['note_result']]?>" title="<?=$notes[$review['Review']['note_result']]?>" class="left">
            <span><b><?=$notes[$review['Review']['note_result']]?></b><br>Стоимость: <b><?=$this->Display->number($review['Review']['coast']);?> руб.</b> Регион: <b><?=$review['Region']['title']?></b></span>
<br class="clear">
</div>
<!-- spec -->

    <div class="inner-article-info">
        
        <!--div class="avatar left">
            <?=$this->Element("image", array("model" => "user", "id" => $review['Review']['user_id'], "type" => "mini", "alias" => "avatar", "noimage" => true));?>
        </div-->
        <div class="main left">
            <a href="/user/page/<?=$review['User']['id']?>/" class="nick"><?=$review['User']['name']?></a> 
            <?if ('0000-00-00 00:00:00' != $review['Review']['edited'] && (date("Y-m-d", strtotime($review['Review']['edited'])) != date("Y-m-d", strtotime($review['Review']['created'])))):?>
                <span><?=date("d.m.Y", strtotime($review['Review']['edited']))?></span>
            <?endif;?>
            <span><?=date("d.m.Y", strtotime($review['Review']['created']))?></span>
            <span><img src="/img/eye.png" alt="Просмотров" ><?=$page_show['Show']['count']?></span>
		<span><a href="#comments"><img src="/img/add.png" alt="Комментарии" ><?=$review['Review']['comment_count']?></a></span>
            <br>
            <div class="clear"></div>
            <?$notes = $review_notes;?>
            
        </div>
        <div class="secondary right">
            <?if ($auth && ($auth['is_admin'] || ((date("U") - strtotime($review['Review']['created'])) < 30*60))):?>
                <a href="/service/review_edit/<?=$review['Review']['id']?>/">Редактировать отзыв</a><br>
            <?endif;?>
            <?if ($auth && $auth['id'] == $review['Review']['user_id']):?>
                <a href="/service/review_add/<?=$review['Review']['id']?>/">Дополнить отзыв</a><br>
            <?endif;?>
            
            
        </div>
        <div class="clear"></div>
    </div>
    <p><?=$this->Display->format($review['Review']['description']);?></p>
    <?foreach ($review['ReviewAdd'] as $add):?>
        <span class="updated">Дополнено <?=date("d.m.Y", strtotime($add['created']))?>:</span>
        <p><?=$this->Display->format($add['content']);?></p>
    <?endforeach;?>
    <?if ($auth && $auth['is_admin']):?>
        <a href="/admin/self_item/Review/<?=$review['Review']['id']?>/" style="color:red;" target="_blank">редактировать отзыв</a>
        <a href="/admin/self_list/Photo/alias:review/parent_id:<?=$review['Review']['id']?>/" style="color:red">редактировать фото</a>
    <?endif;?>
    
    
    <?if (!empty($review['Photo'])):?>
        <table class="holder">
            <?foreach ($review['Photo'] as $i => $photo):?>
                <?if ($i % 3 == 0):?>
                    <tr>
                <?endif;?>
                <td><div class="photo left"><a href="<?=$this->Element("image", array("id" => $photo['id'], "model" => "photo", "alias" => "picture", "onlyurl" => true))?>" target="_blank"><?=$this->Element("image", array("id" => $photo['id'], "model" => "photo", "alias" => "picture", "type" => "mini", "also" => array("title" => h($photo['content']))))?></a></div></td>
                <?if (($i + 1) % 3 == 0 || ($i + 1) == count($review['Photo'])):?>
                    <?if (($i + 1) == count($review['Photo']) && $i <2):?>
                        <td width="33%"></td>
                    <?endif;?>
                    </tr>
                <?endif;?>
            <?endforeach;?>
        </table>
        <?if ($auth && $auth['is_admin']):?>
        	
        <?endif;?>
    <?endif;?>
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
    <?if (!$auth || $auth['id'] != $review['Review']['user_id']):?>
        <table class="add-review thanks">
            <tr>
                <td>
                    <?if (!$thank || $auth['is_admin']):?>
                        <a href="/service/review_thanks/<?=$review['Review']['id']?>/">Сказать спасибо</a>
                    <?endif;?>
                </td>
                <td>
                    <span>
                        <?if ($thank && !$auth['is_admin']):?>
                            <div class="thanked">Сказать спасибо</div> Вы уже поблагодарили автора за этот отзыв.<br/>
                        <?else:?>
                            Понравился отзыв? Поблагодарите автора! <span class="hint-small">Это повысит общий рейтинг отзыва, благодаря чему с ним смогут ознакомиться больше посетителей</span>
                        <?endif;?>
                    </span>
                </td>
            </tr>
        </table>
    <?endif;?>
    
    <?if (!empty($review['Clinic']['id']) || !empty($review['Review']['clinic_name'])):?>
        <div class="specialist">
            <?if (!empty($review['Clinic']['id'])):?>
                <div class="avatar left">
                    <?=$this->Element("image", array("model" => "user", "id" => $review['Review']['clinic_id'], "type" => "mini", "alias" => "avatar", "noimage" => true));?>
                </div>
            <?else:?>
            	 <div class="avatar left">
                    <?=$this->Element("image", array("model" => "user", "id" => 0, "type" => "mini", "alias" => "avatar", "noimage" => true));?>
                </div>
            <?endif;?>
            <span><?if (!empty($review['Clinic']['id'])):?><a href="/clinic/profile/<?=$review['Clinic']['id']?>/"><?endif;?><?if (!empty($review['Clinic']['id'])):?><?=$review['Clinic']['name']?><?else:?><?=$review['Review']['clinic_name']?><?endif;?><?if (!empty($review['Clinic']['id'])):?></a><?endif;?></span>
            <div class="clear"></div>
        </div>
    <?endif;?>
    
    <?if (!empty($review['Specialist']['id']) || !empty($review['Review']['specialist_name'])):?>
        <div class="specialist botmargin2">
            <?if (!empty($review['Specialist']['id'])):?>
                <div class="avatar left">
                    <?=$this->Element("image", array("model" => "user", "id" => $review['Review']['specialist_id'], "type" => "mini", "alias" => "avatar", "noimage" => true));?>
                </div>
            <?else:?>
            	 <div class="avatar left">
                    <?=$this->Element("image", array("model" => "user", "id" => 0, "type" => "mini", "alias" => "avatar", "noimage" => true));?>
                </div>
            <?endif;?>
            <span><?if (!empty($review['Specialist']['id'])):?><a href="/specialist/profile/<?=$review['Specialist']['id']?>/"><?endif;?><?if (!empty($review['Specialist']['id'])):?><?=$review['Specialist']['name']?><?else:?><?=$review['Review']['specialist_name']?><?endif;?><?if (!empty($review['Specialist']['id'])):?></a><?endif;?></span>
            <?if (!empty($review['Review']['note_specialist'])):?>
                <div class="note_result">
                    Оценка: 
                    <?for ($i = 1; $i < 6; $i++):?>
                        <div class="star <?if ($i <= $review['Review']['note_specialist']):?>active<?endif;?>"></div>
                    <?endfor;?>
                </div>
            <?endif;?>
            <p><?=$this->Display->format($review['Review']['comment_note'])?>
            </p>
            <div class="clear"></div>
        </div>
    <?endif;?>

    <div class="comments">
        <a name="comments"></a>
        <h2>Комментарии (<?=$review['Review']['comment_count']?>):</h2>
        <?=$this->Element('comments_block', array('comments' => $comments, 'belongs' => 'Review', 'belongs_id' => $review['Review']['id']))?>
    </div>
</div>