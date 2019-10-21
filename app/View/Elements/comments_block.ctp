<?if (isset($done) && ($done === true || $done === 'comment')):?>
    Ваш комментарий успешно размещен!
<?endif;?>
<?=$this->Element("comments", array("comments" => $comments, "level" => 0))?>
<a name="add_comment"></a>
<div class="add-comment">
    <h3>Добавить комментарий</h3>
    <?if ($auth):?>
        <div class="error"><?=$this->Display->errors($this->validationErrors)?></div>
        <?=$this->Form->create("Comment");?>
            <?=$this->Form->hidden("parent_id", array("id" => "comment_parent_id"));?>
            <?=$this->Form->hidden("belongs", array("value" => $belongs));?>
            <?=$this->Form->hidden("belongs_id", array("value" => $belongs_id));?>
            <div id="comment_to" style="display:none;">В ответ пользователю: <b><span style="margin:0;"></span></b> (<a href="#" id="comment_clear">очистить</a>)</div>
            <!--label for="comment_content">Текст комментария*</label><br-->
            <?=$this->Form->textarea("content", array("id" => "comment_content"));?></textarea>
            <input type="submit" value="Отправить">
        <?=$this->Form->end();?>            
    <?else:?>
        Оставлять комментарии могут только пользователи сайта. Пожалуйста, <a href="/user/registration/">зарегистрируйтесь</a> или <a href="/user/login/">авторизуйтесь</a> на сайте.
    <?endif;?>
</div>
<script>
$('textarea').attr('placeholder', 'Текст комментария*');
</script>