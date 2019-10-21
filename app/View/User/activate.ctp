<div class="page-404 page-good-registration">
    <div class="inner">
        <?php if (isset($done) && $done) { ?>
            <h1>Ваш аккаунт активирован!</h1>
            <p>У нас есть много другой полезной информации:</p>
        <?php } else { ?>
            <div class="error">
                Ошибка активации учетной записи! Проверьте правильность ссылки и повторите.
            </div>
        <?php } ?>
        <ul>
            <li><a href="/reviews/">Отзывы об операциях</a></li>
            <li><a href="/catalog/clinic/">Лучшие клиники</a></li>
            <li><a href="/forum/">Вопросы и помощь</a></li>
            <li><a href="/catalog/">Ответственные врачи</a></li>
        </ul>
    </div>
</div>

