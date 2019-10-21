<? if ( ! isset($without_user)) {
  $without_user = false;
} ?>
<div class="before-after-slider">
  <? foreach ($photos as $i => $photo): ?>
    <? if ( ! isset($photo['Photospec'])) {
      $photo['Photospec'] = $photo;
    }
    $imgB = $this->Element("image", array(
      "id"    => $photo['Photospec']['id'],
      "model" => "photospec",
      'alias' => 'before',
      "type"  => "main",
    ));

    $imgA = $this->Element("image", array(
      "id"    => $photo['Photospec']['id'],
      "model" => "photospec",
      'alias' => 'after',
      "type"  => "main",
    ));



    /*
    $imgBefore = "/image/photospec/before_{$photo['Photospec']['id']}_middle.jpg";
    $imgAfter  = "/image/photospec/after_{$photo['Photospec']['id']}_middle.jpg";
    */
    ?>
    <?php if ( ! empty($imgA) && ! empty($imgB)) : ?>
      <div>
        <div class="text">
          <div class="title">
            <?= $photo['Photospec']['title'] ?>
          </div>
          <p><?= $photo['Photospec']['content'] ?></p>
        </div>
        <div class="before">
          <img alt="" src="<?= $imgB ?>">
        </div>
        <div class="after">
          <img alt="" src="<?= $imgA ?>">
        </div>
      </div>
    <?php endif; ?>
  <? endforeach; ?>
</div>