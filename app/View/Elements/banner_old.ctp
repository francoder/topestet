<? if ( ! empty($banner)): ?>
  <div class="b-img">
    <? if ($banner['Info']['type'] == 0): ?>
      <div style="padding:5px;">
        <div class="title"><h4><?= $banner['Info']['title'] ?></h4></div>
        <?= $banner['Info']['description'] ?>
      </div>
    <? elseif ($banner['Info']['type'] == 1): ?>
      <div class="wrapper">
        <a href="<?= $banner['Info']['link'] ?>"
           target="<?= $banner['Info']['link_target'] ?>"><?= $this->Element("image",
            array("model" => "info", "id" => $banner['Info']['id'], "type" => "main", "alias" => "img")) ?></a>
      </div>
    <? else: ?>
      <div class="wrapper">
        <a href="<?= $banner['Info']['link'] ?>"
           target="<?= $banner['Info']['link_target'] ?>"><?= $this->Element("image",
            array("model" => "info", "id" => $banner['Info']['id'], "type" => "main", "alias" => "img")) ?></a>

        <div class="info">
          <a href="<?= $banner['Info']['link'] ?>" target="<?= $banner['Info']['link_target'] ?>">
            <span class="h1"><?= $banner['Info']['title'] ?></span>
            <span><?= $banner['Info']['description'] ?></span>
          </a>
        </div>
      </div>
    <? endif; ?>
  </div>
<? endif; ?>