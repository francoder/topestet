<?php ?>
<div class="surlist2-page">
<?php if (isset($specialists) && $specialists): ?>

    <?foreach ($specialists as $i => $specialist):?>
        <?=$this->Element("specialist", array("specialist" => $specialist, "first" => ($i == 0)?true:false));?>
    <?endforeach;?>
    
    <?$pages = $this->Paginator->numbers(array("separator" => "", "model" => "User", "modulus" => 6, "first" => 1, "last" => 1));?>
    <?if ($pages):?>
        <div class="pagination">
            <?=$this->Element("clear_first_page", array('pages' => $this->Paginator->prev("Предыдущая", array("model" => "User"), " ")));?>
            <?=$this->Element("clear_first_page", array('pages' => $pages));?>
            <?=$this->Paginator->next("Следующая", array("model" => "User"), " ")?>
        </div>
    <?endif;?>
<?php else: ?>
    <h3>Специалистов не найдено</h3>
<?php endif; ?>
</div>
