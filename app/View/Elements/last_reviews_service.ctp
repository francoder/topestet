<?if (!empty($last_reviews)):?>
  <h4>Последние отзывы от подписчиков</h4>
  <? foreach ($last_reviews as $review): ?>
    <div class="item">
      <div class="top">
        <a href="/profile/<?= $review['User']['id'] ?>/">
          <?= $review['User']['name'] ?>
        </a>
        <?php $date = date_create($review['Review']['created']); ?>
        <div ><?= date_format($date, 'd.m.Y') ?></div>
      </div>
      <div class="title"><?= $review['Review']['subject'] ?></div>
      <p><?= $review['Review']['comment_note'] ?></p>
    </div>
  <? endforeach; ?>
    <a href="/reviews/" class="btn">Все отзывы</a>
<?endif;?>
