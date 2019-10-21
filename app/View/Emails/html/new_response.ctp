<?=__('Здравствуйте')?>, <?=$user['User']['name']?><br>
<?=__('На ваш вопрос')?> &laquo;<a href="http://<?=$_SERVER['SERVER_NAME']?>/forum/answer/<?=$question['Question']['id']?>"><?=$question['Question']['subject']?></a>&raquo;. получен новый ответ специалиста или комментарий пользователя.<br><br>
<?=__('Просмотре ответ вы можете по ссылке:');?> <a href="<?=$url = "http://".$_SERVER['SERVER_NAME']."/forum/answer/{$question['Question']['id']}/"?>"><?=$url?></a><br>
