<?php if (!isset($simple)) $simple = false;?>
<div class="comment">
    <div class="top">
        <a name="comment_<?=$comment['Comment']['id'];?>"></a>
        <div class="avatar left"><?=$this->Element("image", array("model" => "user", "id" => $comment['User']['id'], "type" => "profile", "alias" => "avatar", 'noimage' => true))?></div>
        <div class="left">
            <span><a href="/user/page/<?=$comment['User']['id']?>/" class="nick" id="comment_<?=$comment['Comment']["id"]?>"><?=$comment['User']['name']?></a> <?=date("d.m.Y", strtotime($comment['Comment']['created']))?></span>
        </div>
        <?if ($auth && !$simple):?>
            <div class="replay right">
                <a href="#" class="comment_response">Ответить</a>
            </div>
        <?endif;?>
        <div class="clear"></div>
    </div>
    <p>
        <?if (!empty($parent)):?>
            [<b><?=$parent['User']['name']?></b>]
        <?endif;?>
        <?=$this->Display->format($comment['Comment']['content'])?></p>
        <?if ($simple):?>
	        <?if ($comment['Comment']['belongs'] == 'Review'):?>
	            <p>На обзор: <a href="/service/review/<?=$comment['Comment']['Parent']['Review']['id']?>/"><?=$comment['Comment']['Parent']['Review']['subject']?></a></p>
	        <?elseif ($comment['Comment']['belongs'] == 'Question'):?>
	        	<p>На вопрос: <a href="/forum/answer/<?=$comment['Comment']['Parent']['Question']['id']?>/"><?=$comment['Comment']['Parent']['Question']['subject']?></a></p>
	        <?elseif ($comment['Comment']['belongs'] == 'Post'):?>
	        	<p>На запись блога: <a href="/art/full/<?=$comment['Comment']['Parent']['Post']['alias']?>/"><?=$comment['Comment']['Parent']['Post']['title']?></a></p>
	        <?else:?>
	        	<p>На странице: <a href="/catalog/region/<?=$comment['Comment']['Parent']['Region']['alias']?>/<?=$comment['Comment']['Parent']['Specialization']['alias']?>/<?=$comment['Comment']['Parent']['Service']['alias']?>/"><?=$comment['Comment']['Parent']['Service']['title']?> <?=((!empty($comment['Comment']['Parent']['Region']['title_with_preposition']))?$comment['Comment']['Parent']['Region']['title_with_preposition']:'в ' . $comment['Comment']['Parent']['Region']['title_genitive'])?></a></p>
	        <?endif;?>
	    <?endif;?>
        <?if ($auth && $auth['is_admin']):?>
            <a href="" class="edit" style="color:red;">редактировать</a>,
            <a href="/service/comment_del/<?=$comment['Comment']['id']?>/" style="color:red;">удалить</a>
        <?endif;?>
        <?if ($auth && $auth['is_admin']):?>
            <div class="comment_edit add-page" style="display:none;border:1px solid gray;width:500px;padding:15px;">
                <?=$this->Form->create("Comment", array("url" => "/service/comment_edit/"))?>
                <?=$this->Form->hidden("id", array("value" => $comment['Comment']['id']))?>
                <?=$this->Form->textarea("content", array("value" => $comment['Comment']['content'], "style" => "width:95%;"))?>
                <?=$this->Form->end("Сохранить")?>
                <a href="" class="hide">скрыть</a>
            </div>
        <?endif;?>
    <?if (!empty($comment['children'])):?>
        <div class="subcomment" <?if ($level == 1):?>style="margin-left:25px;"<?endif;?>>
            <?=$this->Element("comments", array("comments" => $comment['children'], "level" => $level, "parent" => $comment));?>
        </div>
    <?endif;?>
</div>