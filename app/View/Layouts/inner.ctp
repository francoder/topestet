<?=$this->element("header", array("title_for_layout"));?>
	<div class="content container">
		<div class="row">
		<div class="mainbar col-xs-12 col-sm-8">
		<?=$this->Element("fast_nav");?>
			<?=$content_for_layout?>
		</div>
		
		<div class="sidebar-right col-xs-12 col-sm-4">
		


			<?$cnt = 1;?>
			<?$show_after = 2;?>
			<?$hot_links = $this->Element("hot_links");?>
			
			<?=$this->Element('banner', array('banner' => @$info_banners[0]))?>
			<?=$this->Element('banner', array('banner' => @$info_banners[1]))?>
			
			<?if ($cnt < $show_after):?>
				<?=$hot_links?>
			<?endif;?>
			<?if (!empty($best_specialists)):?>
				<?=$this->Element('best_specialists')?>
			<?endif;?>
			<?if (!empty($top_specialists)):?>
				<!-- ������.������ -->
<script type="text/javascript">
//<![CDATA[
yandex_partner_id = 116479;
yandex_site_bg_color = 'FFFFFF';
yandex_site_charset = 'utf-8';
yandex_ad_format = 'direct';
yandex_font_size = 1.2;
yandex_font_family = 'tahoma';
yandex_direct_type = 'flat';
yandex_direct_limit = 3;
yandex_direct_title_font_size = 3;
yandex_direct_title_color = '3B5998';
yandex_direct_url_color = '777777';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = 'CC0000';
yandex_direct_favicon = true;
yandex_stat_id = 1;
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc'+'ript>');
//]]>
</script>	     			
				<div class="active-spec">
				<!-- Tabs -->
		<h4>Самые активные специалисты</h4>
	<div class="wrapper tabbox">
	<div id="tabsholder2">
		<ul class="tabs js-tabs">
		<li id="tabz1" class="tab-link"><a href="#"><span>За последний месяц</span></a></li>
		<li id="tabz2" class="tab-link"><a href="#"><span>За всё время</span></a></li>
		</ul>
	<div class="clear tabtopshadow"></div>
	<div class="tabshadow">
	<div class="contents">
		<div id="contentz1" class="tabscontent">
		
        <?foreach ($top_specialists as $specialist):?>
	    	<div class="tabitem">
			<div class="avatar left"><a href="/specialist/profile/<?=$specialist['Specialist']['id']?>/"><?=$this->Element("image", array("model" => "user", "id" => $specialist['Specialist']['id'], "alias" => "avatar", "type" => "mini", "noimage" => true))?></a></div>
	        <span><a href="/specialist/profile/<?=$specialist['Specialist']['id']?>/"><?=$specialist['Specialist']['name']?></a></span>
	        <p><?=$specialist['Specialist']['profession']?></p>
	        <div class="clear"></div>
			</div>
        <?endforeach;?>
        <a href="/catalog/" class="more">Все специалисты</a>
		
        </div>
		
		<div id="contentz2" class="tabscontent">
			<?foreach ($top_specialists_all as $specialist):?>
				<div class="tabitem">
				<div class="avatar left"><a href="/specialist/profile/<?=$specialist['Specialist']['id']?>/"><?=$this->Element("image", array("model" => "user", "id" => $specialist['Specialist']['id'], "alias" => "avatar", "type" => "mini", "noimage" => true))?></a></div>
				<span><a href="/specialist/profile/<?=$specialist['Specialist']['id']?>/"><?=$specialist['Specialist']['name']?></a></span>
				<p><?=$specialist['Specialist']['profession']?></p>
				<div class="clear"></div>
				</div>
			<?endforeach;?>
			<a href="/catalog/" class="more">Все специалисты</a>
		</div>
	</div>
	</div>
	</div>
	</div>
	<script type="text/javascript">
	<!--
	$(document).ready(function(){
		$("#tabsholder2").tytabs({
								prefixtabs:"tabz",
								prefixcontent:"contentz",
								tabinit:"1",
								fadespeed:"fast"
								});
	});
	-->
	</script>
	<script type="text/javascript" src="/js/tabs.min.js"></script>
	<link href="/css/sidetabs.css" type="text/css" rel="stylesheet" />
	
				</div><!-- /Tabs -->
			<?endif;?>
	    </div><!--/ End sidebar-right -->
		</div>
        <div class="clear"></div>
    </div><!--/ End content -->
<?=$this->element("footer");?>
<?=$this->element("sql_dump");?>
