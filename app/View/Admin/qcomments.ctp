<?php ?>
<h1 class="orange"><img src="/img/admin/news.png"><?=$page_title?></h1>
<table border="0" width="100%" class="list">
    <?php foreach($items as $key => $value): ?>
    <tr valign="top">
        <td><?=$value['Qcomment']['id']; ?></td>
        <td><?=$value['Qcomment']['created']; ?></td>
        <td><?=$value['User']['name']; ?> <br />
            <?=$value['User']['mail']; ?>
        </td>
        <td width="60%"><?=$value['Qcomment']['content']; ?><hr />
            <a href="/forum/answer/<?=$value['Qcomment']['question_id']; ?>/#comment_<?=$value['Qcomment']['id']; ?>" target="_blank">Перейти к правке комментария к вопросу <?=$value['Qcomment']['question_id']; ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<div style="text-align:right;width:100%;margin-top:15px;">
    <?=$this->Paginator->numbers(array("separator" => " | ", "modulus" => 6, "first" => 1, "last" => 1));?>
</div>
