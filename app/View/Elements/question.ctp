<? if ( ! isset($show) || ! $show) {
  $show = 'answer';
} ?>
<div>
  <a href="/forum/answer/<?= $question['Question']['id'] ?>/"><?=$question['Question']['Service']['title']?></a>
</div>
