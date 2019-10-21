<?php foreach ($reviews as $question) : ?>
<?php //Debugger::dump($question) ?>
<div class="item">
  <div class="top">
    <div class="date"><?= $this->Display->date("d.m.Y", strtotime($question['Question']['created'])) ?></div>
    <a href="/profile/<?= h($question['User']['id']) ?>"><?= h($question['User']['name']) ?></a>
    <div class="theme"><?= h($question['Service']['title']) ?></div>
  </div>
  <div class="title"><?= h($question['Question']['subject']) ?></div>
  <p><?= h($question['Question']['content']) ?></p>
  <div class="bottom">
    <img src="/images/comment-2.svg" alt="">
    <a href="/forum/answer/<?= h($question['Question']['id']) ?>"><?= DisplayHelper::pluralComment(h($question['Question']['response_count'])) ?></a>
  </div>
</div>
<?php endforeach; ?>
<div class="bottom">
<!--  <div class="pagination">-->
<!--    --><?//= $this->Paginator->numbers(array(
//      'tag' => false,
//      'separator' => '',
//      'currentTag' => 'span'
//    )) ?>
<!--  </div>-->
  <a href="/forum/add" class="btn btn-blue">Задать вопрос</a>
</div>

<script>
  jQuery(document).ready(function ( $ ) {
    $('.pagination a').click(function(e){
      e.preventDefault();

      var frm = $('#form-filter-data');
      const href = $(this).attr('href');

      $.ajax({
        data: {
          'services': frm.serialize()
        },
        dataType: 'json',
        url: href,
        success: function(data) {
          $('#content').html(data);
        },
        error: function(e) {
          $('#content').html(e.responseText);

        }
      });
    });
  });

</script>
