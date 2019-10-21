<div class="inner">
    <div class="navigation">
        <a href="/">Главная</a>
        <span>Поиск</span>
    </div>
    <h1><?= $h1 ?></h1>
    <div class="tabs">
        <ul>
            <li><a href="/reviews/">Отзывы</a></li>
            <li><a href="/catalog/">Специалисты</a></li>
            <li><a class="selected" href="/catalog/clinics/">Клиники</a></li>
            <li><a href="/forum/">Ответы специалистов</a></li>
        </ul>
    </div>
</div>
<div class="bottom">
    <div class="inner">
        <div class="selects">
            <select class="styler white" data-placeholder="Выберите процедуру" id="serviceChanger" name="procedure">
                <option data-specalias="all"></option>
                <?php
                foreach ($services as $service) { ?>
                    <?php $currentServiceId = $currentService ? $currentService['id'] : ''; ?>
                    <option <?= $currentServiceId === $service['Service']['id'] ? 'selected' : '' ?>
                            data-specalias="<?= $service['Service']['specialization_id'] === '7' ? 'plastica' : 'cosmetology' ?>"
                            value="<?= $service['Service']['alias'] ?>"><?= $service['Service']['title'] ?></option>
                <?php } ?>
            </select>
            <select class="styler white" data-placeholder="Выберите город" id="cityChanger" name="city">
                <option></option>
                <?php foreach ($cities as $city): ?>
                    <option <?= $currentRegion['id'] === $city['Region']['id'] ? 'selected' : '' ?>
                            value="<?= $city['Region']['alias'] ?>"
                    >
                        <?= $city['Region']['title'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="budget">
            <p>Бюджет:</p>
            <div class="list-of-budgets">
                <div <?= isset($_GET['coast']) && $_GET['coast'] === 'min' ? 'class="active"' : '' ?> data-coast="min">
                    ₽
                </div>
                <div <?= isset($_GET['coast']) && $_GET['coast'] === 'mid' ? 'class="active"' : '' ?> data-coast="mid">
                    ₽₽
                </div>
                <div <?= isset($_GET['coast']) && $_GET['coast'] === 'max' ? 'class="active"' : '' ?> data-coast="max">
                    ₽₽₽
                </div>
            </div>
        </div>
        <div class="checkboxs">
            <label>
                <?php $with_reviews = isset($_GET['with_reviews']) ? 'on' : ''; ?>
                <input type="checkbox" name="with_reviews"
                       class="styler <?= $with_reviews === 'on' ? 'checked ' : '' ?>"
                    <?= $with_reviews === 'on' ? 'checked ' : '' ?>
                >
                <span>Только с отзывами</span>
            </label>
<!--            <label>-->
<!--                --><?php //$onlyHighRate = isset($_GET['only_high_rate']) ? 'on' : ''; ?>
<!--                <input type="checkbox" class="styler --><?//= $onlyHighRate === 'on' ? 'checked ' : '' ?><!--"-->
<!--                       name="only_high_rate" --><?//= $onlyHighRate === 'on' ? 'checked' : '' ?>
<!--                <span>Высший рейтинг</span>-->
<!--            </label>-->
        </div>
    </div>
</div>

<script>
    $(function () {
        function makeRegionUrlPath() {
            let regionAlias = $('#cityChanger').val();
            if (regionAlias === '') {
                return 'all/';
            }
            return 'region/' + regionAlias + '/';
        }

        function makeServiceUrlPath() {
            let serviceAlias = $('#serviceChanger').val();
            let serviceSpecialization = $('.selected[data-specalias]').attr('data-specalias');
            if (serviceAlias === '') {
                return '';
            }
            return serviceSpecialization + '/' + serviceAlias + '/';
        }

        function makeFilterParams() {
            let params = {};

            let order = $('input[type=radio][name=order]:checked').val();
            if (order !== undefined && order !== 'reviews') {
                params.order = order;
            }

            let coast = $('.list-of-budgets .active');
            if (coast.length > 0) {
                params.coast = coast.attr('data-coast');
            }

            let with_reviews = $('input[name=with_reviews]').is(":checked");
            if (with_reviews) {
                params.with_reviews = 1;
            }

            // let only_high_rate = $('input[name=only_high_rate]').is(":checked");
            // if (only_high_rate) {
            //     params.only_high_rate = 1;
            // }

            let paramUrl = encodeQueryData(params);
            return paramUrl !== '' ? '?' + paramUrl : '';
        }

        function redirectToPage() {
            location.href = '/catalog/clinic/' + makeRegionUrlPath() + makeServiceUrlPath() + makeFilterParams();
        }

        $('#serviceChanger').on('change', redirectToPage);
        $('#cityChanger').on('change', redirectToPage);
        $('input[type=radio][name=order]').on('change', redirectToPage);
        $(document).on('click', '.list-of-budgets div', function () {
            $('.list-of-budgets div').removeClass('active');
            $(this).addClass('active');
            redirectToPage();
        });
        $('input[name=with_reviews]').on('change', redirectToPage);
        $('input[name=only_high_rate]').on('change', redirectToPage);

        function encodeQueryData(data) {
            const ret = [];
            for (let d in data) ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
            return ret.join('&');
        }
    });
</script>
