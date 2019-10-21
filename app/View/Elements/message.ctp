<?if (!isset($ajax)) $ajax = false;?>
<?if ($ajax) $ok = true;?>
<?if (!isset($ok)) $ok = true;?>
<div class="<?=($ok)?"ok":"error"?>" style="text-align:center; <?=($ajax)?"display:none":""?>" id="block_message_<?=($ok)?"ok":"error"?>"><img style="vertical-align:middle" src="/img/admin/<?=($ok)?"success":"fail"?>.png"> <span id="message_<?=($ok)?"ok":"error"?>"><?=$message?></span>!</div>
<?if ($ajax): $ok = false;?>
	<div class="<?=($ok)?"ok":"error"?>" style="text-align:center; <?=($ajax)?"display:none":""?>" id="block_message_<?=($ok)?"ok":"error"?>"><img style="vertical-align:middle" src="/img/admin/<?=($ok)?"success":"fail"?>.png"> <span id="message_<?=($ok)?"ok":"error"?>"><?=$message?></span>!</div>
<?endif;?>
