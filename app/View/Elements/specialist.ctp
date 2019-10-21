<? $account_url = 'specialist';
if ($specialist['User']['is_specialist'] == 2) {
  $account_url = 'clinic';
} ?>
<div class="specialist<? if ($first): ?> first<? endif; ?><? if ($specialist['User']['is_adv']): ?> adv<? endif; ?>">
  <div class="avatar left">
    <a href="/<?= $account_url ?>/profile/<?= $specialist['User']['id'] ?>/"><?= $this->Element("image", array(
        "model" => "user",
        "type" => "main",
        "alias" => "avatar",
        "id" => $specialist['User']['id'],
        "noimage" => true,
      )) ?></a></div>
  <div class="ufo">
    <? if ($specialist['User']['is_top']): ?>
      <img src="/img/top.png" class="for_hint">
    <? endif; ?>
  </div>
  <a href="/<?= $account_url ?>/profile/<?= $specialist['User']['id'] ?>/"
     class="name"><?= $specialist['User']['name'] ?></a>
  <br><br>
  <span><?= $specialist['User']['profession'] ?><br><?= $specialist['User']['address'] ?></span>


  <div class="rate">
    <div class="note_result">
      <? for ($i = 1; $i < 6; $i++): ?>
        <div class="star <? if (round($specialist['User']['rate']) >= $i): ?>active<? endif; ?>"></div>
      <? endfor; ?>
    </div>
    <span class="text">Ответ<?= $this->Display->cas($specialist['User']['response_count'],
        array("", "а", "ов")) ?>: <?= $specialist['User']['response_count'] ?></span>
  </div>
</div>