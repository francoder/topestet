<?=__('Здравствуйте')?>, <?=$user['User']['name']?><br>
<?=__('Кто-то, возможно вы, зарегистрировался на сайте')?> &laquo;<a href="http://<?=$_SERVER['SERVER_NAME']?>"><?=$_SERVER['SERVER_NAME']?></a>&raquo;.<br><br>
<?=__('Пожалуйста');?>, <a href="<?=$url = "http://".$_SERVER['SERVER_NAME']."/user/activate/{$user['User']['mail']}/".md5($_SERVER['SERVER_NAME'] . $user['User']['mail'])."/"?>"><?=__('активируйте учетную запись');?></a>:<br>
<?=$url?>
