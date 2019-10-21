<? if ( ! isset($full)) {
  $full = false;
} ?>
<? if ( ! isset($shownote)) {
  $shownote = false;
} ?>
<div
    class="review<? if ($review['Review']['is_adv']): ?> adv<? endif; ?> <? if ($review['Review']['is_translated']): ?> translated<? endif; ?>"
    itemscope itemtype="http://schema.org/Review">
  <? if ($full): ?>
  <a href="/service/review/<?= $review['Review']['id'] ?>/">
    <div class="user left">
      <img
          src="/img/<? if ($review['Review']['note_result'] == 1): ?>th_ora<? elseif ($review['Review']['note_result'] == 2 || $review['Review']['note_result'] == 0): ?>undecided<? else: ?>th_gre<? endif; ?>.png"
          alt="">
      <span>
            	<? $notes = $review_notes; ?>
              <?= $notes[$review['Review']['note_result']]; ?>
            </span><br>
      <span
          class="count <? if ($review['Review']['thank_all_count'] > 0): ?>pos<? endif; ?>"><? if ($review['Review']['thank_all_count'] > 0): ?>+<? endif; ?><span
            itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
          <span itemprop="ratingValue" content="<?= $review['Review']['thank_all_count'] ?>">
            <?= $review['Review']['thank_all_count'] ?>
          </span>
        </span>
      </span>
    </div>
  </a>
  <div class="other">
    <? endif; ?>
    <h3 itemprop="name"><a itemprop="url"
                           href="/service/review/<?= $review['Review']['id'] ?>/"><?= $review['Review']['subject'] ?></a>
    </h3>
    <span class="info"><meta itemprop="datePublished" content="<?= $this->Display->date("Y-m-d",
        strtotime($review['Review']['edited'])) ?>"><?= $this->Display->date("d.m.Y",
        strtotime($review['Review']['edited'])) ?>  <span itemprop="author"><?= $review['User']['name'] ?></span>, <span
          class="marked"><?= $review['Region']['title'] ?></span>  Стоимость: <span class="pricelable" itemprop="offers"
                                                                                    itemscope
                                                                                    itemtype="http://schema.org/Offer"><span
            itemprop="price"
            class="marked"><?= $this->Display->number($review['Review']['coast']) ?> р.</span><? if ($review['Review']['is_translated']): ?>
          <b>перевод</b><? endif; ?></span></span>
    <? if ($shownote && ! empty($review['Review']['note_specialist'])): ?>
      <div class="rate">
        <div class="note_result">
          <? for ($i = 1; $i < 6; $i++): ?>
            <div class="star <? if ($i <= $review['Review']['note_specialist']): ?>active<? endif; ?>"></div>
          <? endfor; ?>
        </div>
      </div>
    <? endif; ?>
    <p>
      <span itemprop="description"><?= $this->Display->short($review['Review']['description'], 50) ?></span>
      <!--a href="/service/review/<?= $review['Review']['id'] ?>/" class="readmore">Читать полностью</a-->
    </p>
    <? if ($full): ?>
    <? foreach ($review['Photo'] as $photo): ?>
      <div class="photo"><a href="/service/review/<?= $review['Review']['id'] ?>/"><?= $this->Element("image", array(
            "id"    => $photo['id'],
            "model" => "photo",
            "alias" => "picture",
            "type"  => "thumbnail",
            "also"  => array("title" => $photo['content']),
          )) ?></a></div>
    <? endforeach; ?>
    <a href="/service/review/<?= $review['Review']['id'] ?>/#comments" class="more-user-comments">Комментарии
      (<?= $review['Review']['comment_count'] ?>)</a>
  </div>
  <div class="clear"></div>
<? endif; ?>
</div>