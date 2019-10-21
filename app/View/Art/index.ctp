<?php ?>
<div class="article">
	<?if (!empty($text_block)):?>
		<h1><?=$text_block['Block']['title']?></h1>
		<p><?=$text_block['Block']['content']?></p>
	<?endif;?>
	<?if (isset($category)):?>
		<h1><?=$category['PostCategory']['title']?></h1>
		<p><?=$category['PostCategory']['description']?></p>
	<?endif;?>
    <?foreach ($entries as $entry):?>
        <?=$this->element('post_preview', array('entry' => $entry))?>
    <?endforeach;?>
    <?$pages = $this->Paginator->numbers(array("separator" => "", "model" => "Post", "modulus" => 6, "first" => 1, "last" => 1));?>
    <?if ($pages):?>
        <div class="pagination">
            <?=$this->Element("clear_first_page", array('pages' => $this->Paginator->prev("Предыдущая", array("model" => "Post"), " ")));?>
            <?=$this->Element("clear_first_page", array('pages' => $pages));?>
            <?=$this->Paginator->next("Следующая", array("model" => "Post"), " ")?>
        </div>
    <?endif;?>
</div>