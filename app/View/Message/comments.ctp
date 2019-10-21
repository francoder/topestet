<div class="mainbar message-page">
    <h1>Комментарии вам</h1>
    <?foreach ($comments as $comment):?>
    	<?=$this->Element('comment_item', array('comment' => $comment, 'simple' => true))?>
    <?endforeach;?>
    <?$pages = $this->Paginator->numbers(array("separator" => "", "model" => "Comment", "modulus" => 6, "first" => 1, "last" => 1)); ?>
    <?if ($pages):?>
	    <div class="pagination">
	        <?= $this->Element("clear_first_page", array('pages' => $this->Paginator->prev("Предыдущая", array("model" => "Comment"), " "))); ?>
	        <?= $this->Element("clear_first_page", array('pages' => $pages)); ?>
	        <?= $this->Paginator->next("Следующая", array("model" => "Comment"), " "); ?>
	    </div>
	<?endif;?>
	
</div> <!--/ End mainbar -->