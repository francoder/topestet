<?php  ?>
<div class="surlist2-page mainqa">
    <div class="h1"><?=$title_for_layout?></div>

    <?if (empty($questions)):?>
        <br>Вопросов пока нет.<br>
    <?else:?>
        <?foreach ($questions as $question):?>
            <?=$this->Element("question", array("question" => $question, 'show_service' => true, 'show_comments' => true))?>
        <?endforeach;?>
    <?endif;?>

    <div class="add-review">
            <a href="/forum/add/">Задать вопрос</a>
    </div>

    <?$pages = $this->Paginator->numbers(array("separator" => "", "model" => "Question", "modulus" => 6, "first" => 1, "last" => 1));?>
    <?if ($pages):?>
       <div class="pagination">
          <?=$this->Element("clear_first_page", array('pages' => $this->Paginator->prev("Предыдущая", array("model" => "Question"), " ")));?>
          <?=$this->Element("clear_first_page", array('pages' => $pages));?>
          <?=$this->Paginator->next("Следующая", array("model" => "Question"), " ")?>
       </div>
    <?endif;?>
</div>
