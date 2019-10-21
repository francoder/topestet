<?=__('Здравствуйте')?><br>
<?=__('На сайте')?> &laquo;<a href="http://<?=$_SERVER['SERVER_NAME']?>"><?=$_SERVER['SERVER_NAME']?></a>&raquo; имеется новая заявка в специалисты.<br>
От пользователя: <a href="http://<?=$_SERVER['SERVER_NAME']?>/user/page/<?=$user_id?>/"><?=$user['User']['name']?></a><br>
Пояснение: <?=$user['User']['specialist_request']?><br>
<a href="http://<?=$_SERVER['SERVER_NAME']?>/admin/self_item/User/<?=$user_id?>/">Редактирование профиля пользователя</a>
