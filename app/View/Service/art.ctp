<?php ?>
<div class="article qa">
    <?=$this->Element('service_maininfo', array('service' => $service, 'description_field' => 'description_forum', 'hide_description' => $this->Paginator->hasPrev()))?>
    <h2>Материалы:</h2>
    <?foreach ($entries as $entry):?>
    	<?=$this->element('post_preview', array('entry' => $entry))?>
    <?endforeach;?>
    <?$pages = $this->Paginator->numbers(array("separator" => "", "model" => "Post", "modulus" => 6, "first" => 1, "last" => 1));?>
    <?if ($pages):?>
        <div class="pagination">
            <?=$this->Element("clear_first_page", array('pages' => $this->Paginator->prev("Предыдущая", array("model" => "Question"), " ")));?>
            <?=$this->Element("clear_first_page", array('pages' => $pages));?>
            <?=$this->Paginator->next("Следующая", array("model" => "Question"), " ")?>
        </div>
    <?endif;?>
</div>