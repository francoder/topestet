<?php ?>
<h1 class="orange"><img src="/img/admin/news.png"><?=$page_title?></h1>
<table border="0" width="100%" class="list">
    <?php foreach($items as $key => $value): ?>
    <tr valign="top">
        <td><?=$value['Comment']['id']; ?></td>
        <td><?=$value['Comment']['created']; ?></td>
        <td><?=$value['User']['name']; ?> <br />
            <?=$value['User']['mail']; ?>
        </td>
        <td width="60%"><?=$value['Comment']['content']; ?><hr />
            <a href="/service/review/<?=$value['Comment']['review_id']; ?>/#comment_<?=$value['Comment']['id']; ?>" target="_blank">Перейти к правке комментария к отзыву <?=$value['Comment']['review_id']; ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<div style="text-align:right;width:100%;margin-top:15px;">
    <?=$this->Paginator->numbers(array("separator" => " | ", "modulus" => 6, "first" => 1, "last" => 1));?>
</div>
