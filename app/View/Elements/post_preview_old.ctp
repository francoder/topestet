<div class="review entry">
    <?$image = $this->Element("image", array("model" => "post", "id" => $entry['Post']['id'], "alias" => "image", "type" => "thumbnail"));?>
    <?if ($image):?>
        <div class="image left"><a href="/art/full/<?=$entry['Post']['alias']?>/"><?=$image?></a></div>
    <?endif;?>
    <h3><a href="/art/full/<?=$entry['Post']['alias']?>/"><?=$entry['Post']['title']?></a></h3>
    <span class="info">
    	<?=$this->Display->date("d %m Y", strtotime($entry['Post']['created']))?>
    	<?if (!empty($entry['PostCategory']['id'])):?>
    		| <a href="/art/category/<?=$entry['PostCategory']['alias']?>/"><?=$entry['PostCategory']['title']?></a>
    	<?endif;?>
    </span>
    <p>
        <?=$entry['Post']['description']?>
        <!--a href="/blog/post/<?=$entry['Post']['alias']?>/">Читать полностью...</a-->
    </p>
    <div class="clear"></div>
</div>