<?php
if(!empty($top_services)) :?>
<div class="questions-slider">
  <?php foreach ($top_services as $service): ?>
  <div>
    <a href="/reviews/<?=$service['Specialization']['alias']?>/<?= $service['Service']['alias'] ?>/">
        <div class="text">
            <p><?= $service['Service']['title'] ?></p>
            <div class="title"><?=$service['Service']['review_count']?> отзыва</div>
        </div>
    </a>
  </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
