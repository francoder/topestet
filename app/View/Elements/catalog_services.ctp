<?php ?>
<div class="performed">
    <?if (isset($services) && $services):?>
        <h3>Поиск по услугам</h3>
        <ul>
            <?foreach ($services as $service):?>
                <?if ($region){
                    $url = "/{$catalog_url}/region/{$region['Region']['alias']}/{$service['Specialization']['alias']}/{$service['Service']['alias']}/";
                } else {
                    $url = "/{$catalog_url}/all/{$service['Specialization']['alias']}/{$service['Service']['alias']}/";
                }?>
                <li><a href="<?=$url?>"><?=$service['Service']['title']?></a></li>
            <?endforeach;?>
        </ul>
    <?endif;?>
    <br>
</div>