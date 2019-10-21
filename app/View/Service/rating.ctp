</div>
<div class="reviews-page-1">
    <div class="inner">
        <div class="left">
            <div class="navigation">
                <a href="/">Главная</a>
                <span>Рейтинг услуг</span>
            </div>
            <h1>Рейтинг услуг</h1>
        </div>
    </div>
</div>
<div class="inner">
    <div class="content-with-aside rating">
        <div class="content">
            <div class="tabs js-tabs">
                <ul>

                    <?php $index = 1;
                    $alias = $this->request['alias'];
                    foreach ($rating_specializations as $spec) : ?>
                        <li>
                            <a class="<?= $spec['Specialization']['alias'] === $alias ? 'selected' : '' ?>"
                               href="/service/<?= $spec['Specialization']['alias'] ?>"><?= $spec['Specialization']['title'] ?></a>
                        </li>
                        <?php $index++;endforeach;
                    $index = 1; ?>
                </ul>
            </div>
            <div class="table">
                <div>
                    <div class="row top">
                        <div class="name">
              <span>
                Название процедуры
                <input style="display:none;" name="title" value="1">
              </span>
                        </div>
                        <div class="poultry">
              <span>Популярность
                <input style="display:none;" name="rate" value="1">
              </span>
                        </div>
                        <div class="price">
              <span>Средняя цена
              <input style="display:none;" name="coast_avg" value="1">
              </span>
                        </div>
                        <div class="review">
              <span>Отзывов
                <input style="display:none;" name="review_count" value="1">
              </span>
                        </div>
                    </div>
                    <div id="rows-content">
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
                                    redirectPost: function (location, args) {
                                        var form = '';
                                        $.each(args, function (key, value) {
                                            form += '<input type="hidden" name="' + key + '" value="' + value + '">';
                                        });
                                        $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo('body').submit();
                                    }
                                });

                            $('div .review a').click(function (e) {

                                e.preventDefault();
                                $.redirectPost('/reviews/', {'services[]': $(this).attr('href')})
                            });

                        </script>

                    </div>
                </div>
            </div>
        </div>

        <?php
        switch ($this->request['alias']) {
            case 'plastica':
                $bannerCode = 'mdylnktgnxamypmtufmwhuxwnkoodgwllc';
                break;
            case 'cosmetology';
                $bannerCode = 'fdepwklqixktlnsetftgwxbligqnwmjcln';
                break;
            default:
                $bannerCode = 'coidwblozqrsopuhneyhposwfmqqwsxwqy';
        }

        ?>
        <?= $this->Element('aside_with_banner', [
            'bannerCode' => $bannerCode,
                'elementList' => [
                    'last_responses'
            ],
        ]) ?>
    </div>

    <form id="filter-order">
    </form>

    <script>
        jQuery(document).ready(function ($) {
            const frm = $('#filter-order');

            // $.ajax( {
            //   url: '',
            //   type: 'POST',
            //   success: function ( data ) {
            //     $( '#rows-content' ).html( data );
            //   }
            // } );

            $('.rating .table .row.top span').on('click', function () {
                const inputOrder = $(this).find('input').clone();
                const clickThis = $(this);

                if (clickThis.hasClass('up')) {
                    clickThis.removeClass('up');
                } else {
                    $('.rating .table .row.top span').each(function (index, item) {

                        $(this).removeClass('up');

                    });

                    $(this).addClass('up');
                }

                if ($(this).hasClass('up')) {
                    //frmInput = frm.find('input[name=' + inputOrder.attr('name') + ']');
                    frmInput = frm.find('input');
                    frmInput.detach();
                    frm.append(inputOrder);
                    //frm.trigger('DOMNodeInserted');
                } else {
                    //frm.append(inputOrder);
                    frmInput = frm.find('input[name=' + inputOrder.attr('name') + ']');
                    frmInput.detach();
                    frm.trigger('DOMNodeInserted');
                }

            });


            frm.on('DOMNodeInserted', function () {
                $.ajax({
                    type: 'POST',
                    method: 'POST',
                    data: frm.serialize(),
                    success: function (data) {
                        $('#rows-content').html(data);
                    },
                    error: function (e) {
                        //console.log(e);
                    }
                });
                //$(this).submit();
            })


        });
    </script>
