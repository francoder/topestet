<?php  ?>
<h3><span class="dashed" id="regions_title">Город и регион</span></h3>
<div id="regions" style="display:none;">
    <?foreach ($catalog as $i => $item):?>

<?php
        $without_child = array();
        $with_child    = array();
        $column_count  = 0;

        if (!empty($item['Region']['childs'])){

            foreach ($item['Region']['childs'] as $subitem) {

                if (!empty($subitem['Region']['childs'])) {
                    $with_child[] = $subitem;
                } else {
                    $without_child[] = $subitem;
                }
            }
        }    ?>

        <?if (count($with_child) < 2):?>
            <div class="block">
        <?endif;?>
        <div class="country"><?if (empty($item['Region']['childs'])):?><a href="/<?=$catalog_url;?>/region/<?=$item['Region']['alias']?>/"><?endif;?><?=$item['Region']['title']?><?if (empty($item['Region']['childs'])):?></a><?endif;?></div>
        <div class="direct">
            <?foreach ($without_child as $item):?>
                <a href="/<?=$catalog_url;?>/region/<?=$item['Region']['alias']?>/"><b><?=$item['Region']['title']?></b></a><br>
            <?endforeach;?>
        </div>
        <?foreach ($with_child as $i => $item):?>
            <div class="block">
                <h3><?=$item['Region']['title']?></h3>
                <?foreach ($item['Region']['childs'] as $subsubitem):?>
                    <a href="/<?=$catalog_url;?>/region/<?=$subsubitem['Region']['alias']?>"><?=$subsubitem['Region']['title']?></a><br>
                <?endforeach;?>
            </div>
            <?if (($i + 1) % 2 == 0):?>
                <div class="clear"></div>
            <?endif;?>
        <?endforeach;?>
        <?if (count($with_child) < 2):?>
            </div>
        <?else:?>
            <div class="clear"></div>
        <?endif;?>
    <?endforeach;?>
	<div style="clear:both"></div>
</div>
