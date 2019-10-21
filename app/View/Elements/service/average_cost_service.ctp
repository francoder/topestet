<?php if (isset($average_cost)) : ?>
  <h4>Средняя стоимость операций </h4>
  <div class="list">
    <?php foreach ($average_cost as $cost) : ?>
      <div class="item">
        <a href="/clinic/profile/<?= $cost['User']['id'] ?>" class="img" >
          <img src="<?= $this->Element('image', array(
            'model' => 'user',
            "type"  => "main",
            "alias" => "avatar",
            'id'    => $cost['User']['id'],
          )) ?>"
               alt="" style="object-fit: cover; height: 50% ;width: 100%; text-align: center">
        </a>
        <div class="text">
          <div class="title"><?= $cost['User']['name'] ?></div>
          <p><?= $cost['User']['profession'] ?></p>
          <?php if (isset($cost['Service'][0])): ?>
            <div class="price">от <?= DisplayHelper::formatPrice($cost['Service'][0]['coast_avg']) ?> ₽</div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>