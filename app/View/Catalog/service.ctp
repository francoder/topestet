<?php ?>
<div class="surlist2-page">
    <div class="h1">Специалисты по <?=$this->Display->case_field($service['Service'], "dative")?></div>
    Выберите город:<br>
    <?=$this->Form->select("region_id", $regions, array("id" => "specialist_region"))?>
    <?=$this->Form->hidden("specialization", array("id" => "specialization", "value" => $service['Specialization']['alias']))?>
    <?=$this->Form->hidden("service", array("id" => "service", "value" => $service['Service']['alias']))?>
    <?foreach ($specialists as $i => $specialist):?>
        <?=$this->Element("specialist", array("specialist" => $specialist, "first" => ($i == 0)?true:false));?>
    <?endforeach;?>
    <div class="block_border hint">
        Статус «Топ» свидетельствует о высокой оценке работы данного специалиста со стороны пациентов. Им награждаются специалисты, получившие наибольшее количество положительных оценок в отзывах, благодарностей за ответы на вопросы, а также регулярно посвящающие время консультированию пользователей нашего сайта.
    </div>
    <?$pages = $this->Paginator->numbers(array("separator" => "", "model" => "User", "modulus" => 6, "first" => 1, "last" => 1));?>
    <?if ($pages):?>
        <div class="pagination">
            <?=$this->Element("clear_first_page", array('pages' => $this->Paginator->prev("Предыдущая", array("model" => "User"), " ")));?>
            <?=$this->Element("clear_first_page", array('pages' => $pages));?>
            <?=$this->Paginator->next("Следующая", array("model" => "User"), " ")?>
        </div>
    <?endif;?>
</div>