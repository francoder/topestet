<?php foreach ($reviews as $review) : ?>
  <?= $this->Element('card_item_review' , array('review' => $review, 'showReviewUser' => true)) ?>
<?php endforeach; ?>
</div>
<div class="bottom">
  <div class="pagination">
    <?= $this->Paginator->numbers(array(
      'tag' => false,
      'separator' => '',
      'currentTag' => 'span'
    )) ?>
  </div>
  <!--
  <a class="btn btn-blue maintenance">Оставить отзыв</a>
  -->
<script>
  jQuery(document).ready(function ( $ ) {

    $('.maintenance').click(function(){

      $.magnificPopup.open( {
        //items: { src: a.attr( 'data-href' ) },
        items: { src: '#template-maintenance' },
        type: 'inline',
        overflowY: 'scroll',
        //removalDelay: 300,
        closeMarkup: '<button title="Close (Esc)" type="button" class="mfp-close" style="color: #42415E">&#215;</button>',
        mainClass: 'my-mfp-zoom-in',
        callbacks: {
          beforeClose: function(e) {
            console.log($(this));
          },
          close: function (e) {
            console.log(e);
          }
        }
      } );

      return false;

    });

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
