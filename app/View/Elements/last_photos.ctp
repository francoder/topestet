<?if (!empty($last_photos)):?>
	<div class="b-img">
		<div style="padding:5px;">
			<div class="title"><h4>Последние фото</h4></div>
			<?foreach ($last_photos as $photo):?>
				<div class="photo"><a href="/<?if ($photo['Photo']['alias'] == 'review'):?>service/review<?else:?>forum/answer<?endif;?>/<?=$photo['Photo']['parent_id']?>/"><?=$this->Element('image', array('model' => 'photo', 'id' => $photo['Photo']['id'], 'type' => 'thumbnail', 'alias' => 'picture'))?></a></div>
			<?endforeach;?>
		</div>
	</div>
<?endif;?>