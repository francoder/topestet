<?=__('Здравствуйте')?>, <?=$user['User']['name']?><br>
<?=__('Вам отправлено сообщение на сайте')?> &laquo;<a href="http://<?=$_SERVER['SERVER_NAME']?>"><?=$_SERVER['SERVER_NAME']?></a>&raquo;.<br><br>
<?=__('Для чтения перейдите в раздел личных сообщений');?> <a href="<?=$url = "http://".$_SERVER['SERVER_NAME']."/message/"?>"><?=$url?></a><br>
