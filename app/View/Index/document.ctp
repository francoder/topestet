<div class="page">
	<h1><?=$page['Page']['title']?></h1>
	<p><?=$page['Page']['content']?></p>
	<?if ($auth && $auth['is_admin'] > 1):?>
		<a href="/admin/self_item/Page/<?=$page['Page']['id']?>/" style="color:red;">редактировать</a>
	<?endif;?>
</div>