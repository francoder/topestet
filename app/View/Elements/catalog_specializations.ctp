<?php ?>
<div class="performed spec">
    <?if (isset($specializations) && $specializations):?>
        <h3>Поиск по специализации</h3>
        <ul>
            <?foreach ($specializations as $specialization):?>
                <?if ($region) {
                    $url = "/{$catalog_url}/region/{$region['Region']['alias']}/{$specialization['Specialization']['alias']}";
                } else {
                    $url = "/{$catalog_url}/all/{$specialization['Specialization']['alias']}/";
                } ?>
                <li><a href="<?=$url?>"><?=$specialization['Specialization']['title']?></a></li>
            <?endforeach;?>
        </ul>
    <?endif;?>
</div>
