<?php if (isset($service['Service'])) : ?>
<h4>Лучшие специалисты по <?= $service['Service']['title_dative'] ?> </h4>
<?php else: ?>
  <h4>Лучшие специалисты</h4>
<?php endif; ?>
<div class="list-of-doctors">
  <?php foreach ($best_for_service as $doctor): ?>
    <div class="item">
      <a href="/specialist/profile/<?= $doctor['User']['id'] ?>" class="img">
        <img style="border-radius: 50%" src="<?= $this->Element('image', array(
          'model' => 'user',
          "type"  => "main",
          "alias" => "avatar",
          'id'    => $doctor['User']['id'],
        )) ?>"
             alt="">
      </a>
      <div class="text">
        <div class="title">
          <a href="/specialist/profile/<?= $doctor['User']['id'] ?>"><?= $doctor['User']['name'] ?></a>
        </div>
        <?php if (isset($doctor['Clinic'][0])): ?>
          <a href="/clinic/profile/<?= $doctor['Clinic'][0]['id'] ?>"><?= $doctor['Clinic'][0]['name'] ?></a>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php if (isset($alias) ): ?>
  <a href="/catalog/" class="btn">Показать всех</a>
<?php else: ?>
  <a href="/catalog/" class="btn">Показать всех</a>
<?php endif; ?>
