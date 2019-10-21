<div id="popup-comment" class="popup callback zoom-anim-dialog mfp-hide">
  <div class="popup-inner">
    <h3>Добавить отзыв</h3>
    <?php
    $options = array(
      'label' => 'Отправить',
      'class' => 'btn btn-blue',
    );
    ?>
    <?= $this->Form->create('Review', array(
      'inputDefaults' => array(
        'label' => false,
        'div'   => false,
      ),
      'class'         => 'popup-form',
      'id'            => 'form-comment',
    )); ?>
    <?= $this->Form->input('user_id', ['type' => 'hidden', 'value' => $auth['id']]); ?>
    <?= $this->Form->input('thank_count', ['type' => 'hidden', 'value' => 1]); ?>
    <?= $this->Form->input('specialist_name', ['type' => 'hidden', 'value' => $specialist['User']['name']]); ?>
    <?= $this->Form->input('service_title', ['type' => 'hidden', 'value' => ' ']); ?>
    <?php if(isset($isClinic)): ?>
    <?= $this->Form->input('clinic_id', ['type' => 'hidden', 'value' => $specialist['User']['id']]); ?>
    <?php else: ?>
    <?= $this->Form->input('specialist_id', ['type' => 'hidden', 'value' => $specialist['User']['id']]); ?>
    <?php endif; ?>
    <?= $this->Form->input('comment_image', ['type' => 'hidden', 'value' => ' ']); ?>
    <?= $this->Form->input('remind', ['type' => 'hidden', 'value' => '0']); ?>
    <?= $this->Form->input('edited', ['type' => 'hidden', 'value' => date("Y-m-d H:i:s")]); ?>

    <?= $this->Form->input('subject', ['placeholder' => 'Тема отзыва']); ?>
    <h4>Проведенная операция</h4>
    <div class="selects">
      <?= $this->Form->select('service_id', $services ,['class' => 'styler']); ?>
    </div>
    <?= $this->Form->input('coast', ['placeholder' => 'Цена операции', 'type' => 'text']); ?>
    <?= $this->Form->input('comment_note', ['placeholder' => 'Дополнительный комментарий']); ?>
    <?= $this->Form->input('description', ['placeholder' => 'Описание', 'minlength' => 500]); ?>

    <h4>Оценка специалиста</h4>
    <div class="selects">
      <?= $this->Form->select('note_specialist', array(1, 2, 3, 4, 5),
        ['class' => 'styler']); ?>
    </div>
    <h4>Оценка результат</h4>
    <div class="selects">
      <?= $this->Form->select('note_result', array(1, 2, 3),
        ['class' => 'styler']); ?>
    </div>
    <h4>Город проведения операции</h4>
    <div class="selects">
      <?= $this->Form->select('region_id', $cities,
        ['class' => 'styler']); ?>
    </div>
    <?php echo $this->Form->end($options); ?>
    <p id="response-text"></p>
  </div>
  <button title="Close (Esc)" type="button" class="mfp-close">x</button>
</div>


<script>

  const frm = $( '#form-comment' );

  frm.submit( function ( e ) {
    e.preventDefault();

    $.ajax( {
      type: 'POST',
      data: frm.serialize(),
      dataType: 'json',
      success: function ( response ) {
        $( '#response-text' ).html( response.message );
        if ( response.error === 'true' ) {
        } else {
          location = response.redirect;
        }

      },
      error: function ( data ) {
        console.log( data );
      }

    } )
  } );


  $( '.review-comment' ).click( function ( e ) {
    alert('dfs');
    $.magnificPopup.open( {
      //items: { src: a.attr( 'data-href' ) },
      items: { src: '#popup-comment' },
      type: 'inline',
      overflowY: 'scroll',
      //removalDelay: 300,
      closeMarkup: '<button title="Close (Esc)" type="button" class="mfp-close" style="color: #42415E">&#215;</button>',
      mainClass: 'my-mfp-zoom-in',
      callbacks: {
        beforeClose: function ( e ) {
          console.log( $( this ) );
        },
        close: function ( e ) {
          console.log( e );
        }
      }
    } );


    return false;
  } )
</script>
