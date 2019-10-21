<div class="mainbar message-page">
    <h1>Все ответы специалиста: <?=$specialist['User']['name']?></h1>
    <?foreach ($responses as $response):?>
    	<?=$this->element('question', array('show' => 'response', 'question' => $response))?>
    <?endforeach;?>
    <?$pages = $this->Paginator->numbers(array("separator" => "", "model" => "Response", "modulus" => 6, "first" => 1, "last" => 1)); ?>
    <?if ($pages):?>
	    <div class="pagination">
	        <?= $this->Element("clear_first_page", array('pages' => $this->Paginator->prev("Предыдущая", array("model" => "Response"), " "))); ?>
	        <?= $this->Element("clear_first_page", array('pages' => $pages)); ?>
	        <?= $this->Paginator->next("Следующая", array("model" => "Comment"), " "); ?>
	    </div>
	<?endif;?>
	
</div> <!--/ End mainbar -->