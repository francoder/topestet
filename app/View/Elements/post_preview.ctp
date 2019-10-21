<?php
$image = $this->Element("image",
  array("model" => "post", "id" => $entry['Post']['id'], "alias" => "image", "type" => "main"));

?>
<div>
  <a href="" class="big-article">
    <img src="<?= $image ?>" alt="">
    <div class="text">
      <div class="theme">СОВЕТЫ</div>
      <div class="title"><?= $entry['Post']['title'] ?></div>
      <p><?= $entry['Post']['description'] ?></p>
    </div>
  </a>
  <div class="medium-article">
    <div class="item">
      <div class="theme">технологии</div>
      <div class="link"><a href="">Фотоомоложение Quantum Lumenis</a></div>
      <p>Перед самой процедурой начиталась противоречивых отзывов и опасалась, что мне будет, как мертвому
        припарка</p>
    </div>
    <div class="item">
      <div class="theme">технологии</div>
      <div class="link"><a href="">Фотоомоложение Quantum Lumenis</a></div>
      <p>Перед самой процедурой начиталась противоречивых отзывов и опасалась, что мне будет, как мертвому
        припарка</p>
    </div>
  </div>
  <div class="small-article">
    <div class="item">
      <div class="theme">мЕДИКАМЕНТЫ</div>
      <a href="">Cколько стоит дом
        построить?</a>
    </div>
    <div class="item">
      <div class="theme">мЕДИКАМЕНТЫ</div>
      <a href="">Cколько стоит дом
        построить?</a>
    </div>
    <div class="item">
      <div class="theme">Советы</div>
      <a href="">По каким критериям определять качество имплантов?</a>
    </div>
    <div class="item">
      <div class="theme">технологии</div>
      <a href="">Фотоомоложение Quantum Lumenis</a>
    </div>
  </div>
</div>