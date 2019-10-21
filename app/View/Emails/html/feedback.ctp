Поступило новое обращения с сайта <a href="http://<?=$_SERVER['SERVER_NAME']?>"><?=$_SERVER['SERVER_NAME']?></a><br>
<?if ($user):?>
	От зарегистрированного пользователя: <b><?=$user['name']?> (<?=$user['mail']?>)</b>
<?else:?>
	От незарегистрированного пользователя: <?=$message['mail']?>
<?endif;?>
<br>
&laquo;<?=$message['subject'];?>&raquo;<br><br>
<?=$message['content']?>
