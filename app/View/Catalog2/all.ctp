<?php ?>
<div class="surlist-page">
    
    <?php if (isset($service) && $service): ?>
        <h1><?=$specialization['Specialization']['specialist_plural']?>, специализация &mdash; <?=$service['Service']['title']?></h1>
    <?php else: ?>
        <h1><?=$specialization['Specialization']['specialist_plural']?></h1>
    <?php endif; ?>

    <?=$this->Element("catalog_regions");?>

    <?php if (isset($services) && $services): ?>
        <?=$this->Element("catalog_services");?>
    <?php endif; ?>

    <?=$this->Element("catalog_specialists");?>
</div>