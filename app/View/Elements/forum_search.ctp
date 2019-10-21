<div class="inner">
    <div class="navigation">
        <a href="/">Главная</a>
        <span>Поиск вопросов</span>
    </div>
    <h1><?=$h1?></h1>
    <div class="tabs">
        <ul>
            <li><a href="/reviews/">Отзывы</a></li>
            <li><a href="/catalog/">Специалисты</a></li>
            <li><a href="/search/clinics/">Клиники</a></li>
            <li><a href="/forum/" class="selected">Ответы специалистов</a></li>
        </ul>
    </div>
</div>
<div class="bottom">
    <div class="inner">
        <div class="selects">
            <select class="styler white" data-placeholder="Выберите категорию" id="categoryChanger" name="category">
                <option></option>
                <?php
                $currentCategoryId = $currentSpecialization ? $currentSpecialization['id'] : '';
                foreach ($specializations as $specialization) { ?>
                    <option <?= $currentCategoryId === $specialization['Specialization']['id'] ? 'selected' : '' ?>
                            value="<?= $specialization['Specialization']['alias'] ?>"><?= $specialization['Specialization']['title'] ?>
                    </option>
                <?php } ?>


            </select>
            <select class="styler white" data-placeholder="Выберите процедуру" id="serviceChanger" name="procedure">
                <option></option>
                <?php
                foreach ($services as $service) { ?>
                    <?php $currentServiceId = $currentService ? $currentService['id'] : ''; ?>
                    <option <?= $currentServiceId === $service['Service']['id'] ? 'selected' : '' ?>
                            data-specalias="<?=$service['Service']['specialization_id'] === '7' ? 'plastica' : 'cosmetology'?>"
                            value="<?= $service['Service']['alias'] ?>"><?= $service['Service']['title'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
<?php
?>

<script>
    $('#categoryChanger').on('change', function () {
        let categoryAlias = $('#categoryChanger').val();
        location.href = '/forum/' + categoryAlias;
    });

    $('#serviceChanger').on('change', function () {
        let serviceAlias = $('#serviceChanger').val();
        let serviceSpecialization = $('.selected[data-specalias]').attr('data-specalias');
        location.href = '/forum/' + serviceSpecialization + '/' + serviceAlias + '/';
    });
</script>
