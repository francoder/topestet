<div class="inner">
    <div class="navigation">
        <a href="/">Главная</a>
        <span>Поиск</span>
    </div>
    <h1>Давайте уточним запрос</h1>
    <div class="tabs">
        <ul>
            <?php
                $path = parse_url($_SERVER['REQUEST_URI'])['path'];
            ?>
            <li><a href="/reviews/">Отзывы</a></li>
            <li><a <?=$path === '/catalog/' ? 'class="selected"' : ''?> href="/catalog/">Специалисты</a></li>
            <li><a <?=$path === '/search/clinics/' ? 'class="selected"' : ''?> href="/search/clinics/">Клиники</a></li>
            <li><a href="/forum/">Ответы специалистов</a></li>
        </ul>
    </div>
</div>
<div class="bottom">
    <div class="inner">
        <div class="selects">
            <select class="styler white" data-placeholder="Выберите процедуру" id="select-operation" name="procedure">
                <option></option>
                <?php foreach ($services as $service): ?>
                    <?php $currentProcedure = isset($_GET['procedure']) ? $_GET['procedure'] : ''; ?>
                    <option <?= $currentProcedure === $service['Service']['title'] ? 'selected' : '' ?>
                            value="<?= $service['Service']['title'] ?>"><?= $service['Service']['title'] ?></option>
                <?php endforeach; ?>
            </select>
            <select class="styler white" data-placeholder="Выберите город" id="select-city" name="city">
                <option></option>
                <?php foreach ($cities as $city): ?>
                    <?php $currentCity = isset($_GET['city']) ? $_GET['city'] : ''; ?>
                    <option <?= $currentCity === $city['Region']['alias'] ? 'selected' : '' ?>
                            value="<?= $city['Region']['alias'] ?>"><?= $city['Region']['title'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="budget">
            <p>Бюджет:</p>
            <div class="list-of-budgets">
                <div class="active" data-coast="min">
                    ₽
                </div>
                <div data-coast="mid">
                    ₽₽
                </div>
                <div data-coast="max">
                    ₽₽₽
                </div>
            </div>
        </div>
        <div class="checkboxs">
            <label>
                <?php $isReview = isset($_GET['isReviews']) ? $_GET['isReviews'] : ''; ?>
                <input type="checkbox" name="isReviews"
                       class="styler <?= $isReview === 'on' ? 'checked ' : '' ?>" <?= $isReview === 'on' ? 'checked' : '' ?> >
                <span>Только с отзывами</span>
            </label>
            <label>
                <?php $isHighRate = isset($_GET['isHighRate']) ? $_GET['isHighRate'] : ''; ?>
                <input type="checkbox" class="styler <?= $isHighRate === 'on' ? 'checked ' : '' ?>"
                       name="isHighRate" <?= $isHighRate === 'on' ? 'checked' : '' ?>>
                <span>Высший рейтинг</span>
            </label>
        </div>
    </div>
</div>
