<div class="photo-inner">
    <h2>Фото до и после <?=$this->Display->case_field($photo['Service'], 'genitive')?><br><small>портфолио специалистов</small></h2>
    <div class="wrapper">
        <h1 class="left"><?=$photo['Photospec']['title']?></h1>
        <div class="right switcher">
        	<?if (!empty($nav['prev'])):?>
            	<a class="prev" href="/service/pic/<?=$nav['prev']['Photospec']['id']?>/">&laquo;</a>
            <?endif;?>
            <?if (!empty($nav['next'])):?>
          		<a href="/service/pic/<?=$nav['next']['Photospec']['id']?>/" class="next">Следующая &raquo;</a>
          	<?endif;?>
        </div>
        <div class="clear"></div>
	    <?$both = $this->Element("image", array("id" => $photo['Photospec']['id'], "model" => "photospec", "alias" => "both", "type" => "middle", "also" => array("title" => $photo['Photospec']['content'])));?>
        <?if (empty($both)):?>
	        <table class="photos">
	            <tr>
	                <td>
	                    <div class="photo">
	                        <a href="<?=$url = $this->Element("image", array("id" => $photo['Photospec']['id'], "model" => "photospec", "alias" => "before", "onlyurl" => true))?>" target="_blank"><?=$this->Element("image", array("id" => $photo['Photospec']['id'], "model" => "photospec", "alias" => "before", "type" => "middle", "also" => array("title" => $photo['Photospec']['content'])))?></a>
	                    </div>
	                    <span><a href="<?=$url?>" target="_blank">Полный размер</a> &mdash; фото &laquo;до&raquo;</span>
	                </td>
	                <td>
	                    <div class="photo">
	                        <a href="<?=$url = $this->Element("image", array("id" => $photo['Photospec']['id'], "model" => "photospec", "alias" => "after", "onlyurl" => true))?>"  target="_blank"><?=$this->Element("image", array("id" => $photo['Photospec']['id'], "model" => "photospec", "alias" => "after", "type" => "middle", "also" => array("title" => $photo['Photospec']['content'])))?></a>
	                    </div>
	                    <span><a href="<?=$url?>" target="_blank">Полный размер</a> - фото &laquo;после&raquo;</span>
	                </td>
	            </tr>
	        </table>
	    <?else:?>
	    	<table class="photos">
	            <tr>
	                <td>
	                    <div class="photo">
	                        <a href="<?=$url = $this->Element("image", array("id" => $photo['Photospec']['id'], "model" => "photospec", "alias" => "both", "onlyurl" => true))?>"  target="_blank"><?=$this->Element("image", array("id" => $photo['Photospec']['id'], "model" => "photospec", "alias" => "both", "type" => "middle", "also" => array("title" => $photo['Photospec']['content'])))?></a>
	                    </div>
	                    <span><a href="<?=$url?>">Полный размер</a> &mdash; фото &laquo;до&raquo; и &laquo;после&raquo;</span>
	                </td>
	        	</tr>
	        </table>
	    <?endif;?>
	    <?if ($auth && $auth['is_admin']):?>
	    	<a href="/admin/self_item/Photospec/<?=$photo['Photospec']['id']?>/" class="edit" style="color:red;">Редактировать</a>
	    <?endif;?>
        <p><?=$this->Display->format($photo['Photospec']['content'])?>
        </p>
        <div class="specialist">
            <div class="avatar left"><a href="/specialist/profile/<?=$photo['User']['id']?>/"><?=$this->Element("image", array("id" => $photo['User']['id'], "model" => "user", "alias" => "avatar", "type" => "mini", "noimage" => true))?></div>
            <a href="/specialist/profile/<?=$photo['User']['id']?>/"><?=$photo['User']['name']?></a> <br>
            <span><?=$photo['User']['profession']?></span>
            <br>
            <a href="/service/photo_specialist/<?=$photo['User']['id']?>/" class="uniq">Cмотреть все фото<br>от этого специалиста</a>

            <div class="rate photospec">
            	<?if (!$auth || $auth['id'] != $photo['Photospec']['user_id']):?>
                	<?if ($voted !== false  && !$auth['is_admin']):?>
                		<?if ($voted == -1):?>
                			<img src="/img/th_red_2.png" alt="" width="32" height="32">
                		<?else:?>
                			<img src="/img/th_down_gre.png" alt="" width="32" height="32">
                		<?endif;?>
                	<?else:?>
                	   	<a href="/service/vote_photo/<?=$photo['Photospec']['id']?>/-1/"  class="vote_neg"><img src="/img/th_down_gre.png" alt="" width="32" height="32"></a>
                	<?endif;?>
                <?else:?>
                	<img src="/img/th_down_gre.png" title="Вы не можете голосовать за своё фото" width="32" height="32">
                <?endif;?>
            
            	<span><?if ($photo['Photospec']['rate'] > 0):?>+<?endif;?><?=$photo['Photospec']['rate']?></span>	
            
            	<?if (!$auth || $auth['id'] != $photo['Photospec']['user_id']):?>
                	<?if ($voted !== false && !$auth['is_admin']):?>
                		<?if ($voted == 1):?>
                			<img src="/img/th_gre_2.png" alt="" width="32" height="32">
                		<?else:?>
                			<img src="/img/th_up_gre.png" alt="" width="32" height="32">
                		<?endif;?>
                	<?else:?>
                		<a href="/service/vote_photo/<?=$photo['Photospec']['id']?>/1/" class="vote_pos"><img src="/img/th_up_gre.png" alt="" width="32" height="32"></a>
                	<?endif;?>
                <?else:?>
                	<img src="/img/th_up_gre.png" title="Вы не можете голосовать за своё фото" width="32" height="32">
                <?endif;?>
            </div>
        </div>
    </div>
</div>
<script>
if (window.matchMedia('(max-width: 400px)').matches)
{
$(document).ready(function() {
$('table.photos .photo img').removeAttr('width').removeAttr('height').addClass('img-responsive');
});
}
</script>