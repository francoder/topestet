<div id="popup-comment" class="popup callback zoom-anim-dialog mfp-hide">
    <div class="popup-inner">
        <h3>Оставить комментарий</h3>
        <br>
        <?php
        $options = [
            'label' => 'Отправить',
            'class' => 'btn-1',
        ];
        ?>
        <?= $this->Form->create('Comment', [
            'inputDefaults' => [
                'label' => false,
                'div' => false,
            ],
            'class' => 'popup-form',
            'id' => 'form-comment',
        ]); ?>
        <?= $this->Form->input('user_id', ['type' => 'hidden', 'value' => $auth['id']]); ?>
        <?= $this->Form->input('belongs', ['type' => 'hidden', 'value' => 'Review']); ?>
        <?= $this->Form->input('ip', ['type' => 'hidden', 'value' => $_SERVER['REMOTE_ADDR']]); ?>
        <?= $this->Form->input('url', ['type' => 'hidden', 'value' => $_SERVER['REQUEST_URI']]); ?>
        <?= $this->Form->input('belongs_id', ['type' => 'hidden', 'value' => $review['Review']['id']]); ?>
        <?= $this->Form->input('content', ['placeholder' => 'Введите комментарий', 'minlength' => 10]); ?>
        <?php echo $this->Form->end($options); ?>
        <p id="response-text"></p>
    </div>
    <button title="Close (Esc)" type="button" class="mfp-close">x</button>
</div>


<script>

    const frm = $('#form-comment');

    frm.submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            data: frm.serialize(),
            dataType: 'json',
            success: function (response) {
                $('#response-text').html(response.message);
                if (response.error === 'true') {
                } else {
                    location = response.redirect;
                }

            },
            error: function (data) {
                console.log(data);
            }

        })
    });


    $('.review-comment').click(function (e) {
        const parentId = $(this).data('comment');
        const commentName = $(this).attr('data-commentname');
        frm.find($('input[name="data[Comment][parent_id]]"]')).remove();
        $('#popup-comment .userName').remove();

        if (parentId) {
            $('#popup-comment h3').after('<p class="userName">Пользователю ' + commentName + '</p>');
            frm.append('<input hidden name="data[Comment][parent_id]]" value="' + parentId + '" >');
        }

        $.magnificPopup.open({
            //items: { src: a.attr( 'data-href' ) },
            items: {src: '#popup-comment'},
            type: 'inline',
            overflowY: 'scroll',
            //removalDelay: 300,
            closeMarkup: '<button title="Close (Esc)" type="button" class="mfp-close" style="color: #42415E">&#215;</button>',
            mainClass: 'my-mfp-zoom-in',
        });


        return false;
    })
</script>
