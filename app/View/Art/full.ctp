<?$image = $this->Element("image", array("model" => "post", "id" => $entry['Post']['id'], "alias" => "image", "type" => "entity"));?>
<div class="entry page">
	<div><?if ($image && !$entry['Post']['hide_pic']):?>
		<div class="image left"><?=$image?></div>
	<?endif;?>
	<h1><?=$entry['Post']['title']?></h1>
	<span class="review" style="border:none;"><span class="info">
    	<?=$this->Display->date("d %m Y", strtotime($entry['Post']['created']))?>
    	<?if (!empty($entry['PostCategory']['id'])):?>
    		| <a href="/art/category/<?=$entry['PostCategory']['alias']?>/"><?=$entry['PostCategory']['title']?></a>
    	<?endif;?>
    </span>
    </span>
    
    <?if (!empty($services)):?>
    	<div class="postinf"><span>О чем:</span>
    		<?foreach ($services as $i => $service):?>
    		<a href="/service/info/<?=$service['Service']['alias']?>/"><?=$service['Service']['title']?></a><?if ($i + 1 < count($services)):?>,<?else:?><?endif;?>
    		<?endforeach;?>
	</div>
    <?endif;?>
    <?if (!empty($specialists)):?>
    	<div class="postinf"><span>О ком:</span>
    		<?foreach ($specialists as $i => $specialist):?>
    			<a href="/<?=(($specialist['User']['is_specialist'] == 1)?"specialist":"clinic")?>/profile/<?=$specialist['User']['id']?>/"><?=$specialist['User']['name']?></a><?if ($i + 1 < count($specialists)):?>,<?else:?><?endif;?>
    		<?endforeach;?>
	</div>
    <?endif;?>
<br class="clear">
<?if ($auth && $auth['is_admin']):?>
    <a href="/admin/self_item/Post/<?=$entry['Post']['id']?>/" style="color:red;" target="_blank">редактировать</a>
<?endif;?>
</div>
	<p><?=$entry['Post']['content']?></p>
	<span class="starter">
    	Просмотров: <?=$page_show['Show']['count']?>
    </span><br><br>
	<?if (!empty($entry['Opinion'])):?>
		<br><h3>Мнение специалиста</h3>
		<div class="surlist2-page">
			<?foreach ($entry['Opinion'] as $opinion):?>
				<div class="specialist">
					<div class="avatar left"><?=$this->Element('image', array('model' => 'user', 'noimage' => true, 'id' => $opinion['specialist_id'], 'type' => 'thumbnail', 'alias' => 'avatar'))?></div>
					<a href="/specialist/profile/<?=$opinion['specialist_id']?>/" class="name"><?=$opinion['Specialist']['name']?></a><br>
					<?=$opinion['Specialist']['profession']?><br><br>
					<p><?=$opinion['content']?></p>
				</div>
				<div class="clear"></div>
			<?endforeach;?>
		</div>
	<?endif;?>
	
	<div class="comments">
        <a name="comments"></a>
        <h2>Комментарии:</h2>
        <?=$this->Element('comments_block', array('comments' => $comments, 'belongs' => 'Post', 'belongs_id' => $entry['Post']['id']));?>
    </div>
    <br>
    <h3>Популярные посты</h3>
    <?foreach ($popular as $post):?>  
	<a href="/art/full/<?=$post['Post']['alias']?>/"><?=$post['Post']['title']?></a><br><br>
    <?endforeach;?>
</div>