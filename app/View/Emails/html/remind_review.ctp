<?=__('Здравствуйте')?>, <?=$review['User']['name']?><br>
Вы размещали отзыв на сайте &laquo;<a href="http://<?=$_SERVER['SERVER_NAME']?>"><?=$_SERVER['SERVER_NAME']?></a>&raquo; под названием 
&laquo;<a href="http://<?=$_SERVER['SERVER_NAME']?>/service/review/<?=$review['Review']['id']?>/"><?=$review['Review']['subject']?></a>&raquo;. <br><br>
Вы получили это письмо, потому что просили нас уведомить о том, что желаете дополнить свой отзыв.
