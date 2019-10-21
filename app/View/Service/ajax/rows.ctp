<?php foreach ($services as $service): ?>
  <div class="row">
    <div class="name">
      <a href="/service/<?= $service['Service']['alias'] ?>"><?= $service['Service']['title'] ?></a>
    </div>
    <div class="poultry">
      <a href=""><?= $service['Service']['rate'] ?> %</a>
    </div>
    <div class="price">
      <a href=""><?= $this->Display->number($service['Service']['coast_avg']) ?> руб.</a>
    </div>
    <div class="review">
      <a href="<?= $service['Service']['id'] ?>"><?= $service['Service']['review_count'] ?></a>
    </div>
  </div>
<?php endforeach; ?>

<script>

  $.extend(
    {
      redirectPost: function ( location, args ) {
        var form = '';
        $.each( args, function ( key, value ) {
          form += '<input type="hidden" name="' + key + '" value="' + value + '">';
        } );
        $( '<form action="' + location + '" method="POST">' + form + '</form>' ).appendTo( 'body' ).submit();
      }
    } );

  $( 'div .review a' ).click( function ( e ) {

    e.preventDefault();
    $.redirectPost( '/reviews/', { 'services[]': $( this ).attr( 'href' ) } )
  } );

</script>
