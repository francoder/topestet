<?php if (!isset($removeInner)) { ?>
    </div>
<?php } ?>
</div>
<footer id="footer">
    <div class="inner">
        <div class="footer-top">
            <div class="lists-1">
                <ul>
                    <li class="title">Услуги</li>
                    <?php foreach ($specializations as $spec) : ?>
                        <li>
                            <a href="/service/<?= $spec['Specialization']['alias'] ?>"><?= $spec['Specialization']['title'] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul>
                    <li class="title"><a href="/article/">Статьи</a></li>
                    <li class="title"><a href="/reviews/">Отзывы</a></li>
                    <li class="title"><a href="/forum/">Вопросы</a></li>
                </ul>
                <ul>
                    <li class="title"><a href="/catalog/">Специалисты</a></li>
                    <li class="title"><a href="/search/clinics/">Клиники</a></li>
                    <li class="title"><a href="/photo/">Результаты работ</a></li>
                </ul>
            </div>
            <div class="list-2">
                <ul>
                    <?php if ($auth): ?>
                        <li><a href="/profile/<?= $auth['id'] ?>">личный кабинет</a></li>
                    <?php else: ?>
                        <li><a class="ajax-mfp">войти</a></li>
                    <?php endif; ?>
                    <li>&nbsp;</li>
                    <li><a href="/privacy">Политика конфиденциальности</a></li>
                </ul>
            </div>
            <div class="mailing">
                <div class="title">Подпишитесь на нашу рассылку</div>
                <div class="input">
                    <input type="text" placeholder="Ваша электронная почта" id="email-subscribe">
                    <img id="img-subscribe" src="/images/mail.svg" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="inner">
            <a href="/" class="logo"><img src="/images/logo.svg" alt=""></a>
            <p>Информационный портал о пластической
                хирургии и косметологии</p>
        </div>
    </div>
</footer>
</div>

<div id="template-registration" class="popup callback zoom-anim-dialog mfp-hide">
    <div class="popup-inner">
        <h3>Регистрация</h3>
        <!--    <p>войти через Cоц.сети:</p>-->
        <!--    <div class="social-networks">-->
        <!--      <a href="">-->
        <!--        <img src="/images/facebook.svg" alt="">-->
        <!--      </a>-->
        <!--      <a href="">-->
        <!--        <img src="/images/vk.svg" alt="">-->
        <!--      </a>-->
        <!--    </div>-->
        <p class="with-line">
            <span>через Email</span>
        </p>
        <form id="form-registration" class="popup-form" action="/user/registration/" method="post">
            <input type="text" placeholder="Как вас зовут?" name="data[User][name]" autocomplete="off">
            <input type="text" placeholder="E-mail" name="data[User][mail]" autocomplete="off">
            <input type="password" placeholder="Придумайте пароль" name="data[User][password]" autocomplete="off">
            <input type="password" placeholder="Повторите пароль" name="data[User][password_repeat]" autocomplete="off">
            <p id="response-text-r"></p>
            <button class="btn-1">Регистрация</button>
        </form>
        <button class="btn-2 btn-login">Войти</button>
    </div>
    <button title="Close (Esc)" type="button" class="mfp-close" style="color: #42415E">x</button>
</div>


<div id="template-login" class="popup callback zoom-anim-dialog mfp-hide">
    <div class="popup-inner">
        <h3>Личный кабинет</h3>
        <!--    <p>войти через Cоц.сети:</p>-->
        <!--    <div class="social-networks">-->
        <!--      <a href="/user/auth_social/fb/">-->
        <!--        <img src="/images/facebook.svg" alt="">-->
        <!--      </a>-->
        <!--      <a href="/user/auth_social/vk/">-->
        <!--        <img src="/images/vk.svg" alt="">-->
        <!--      </a>-->
        <!--    </div>-->
        <p class="with-line"><span>через Email</span></p>
        <form id="form-login" class="popup-form" method="post" action="/user/login/">
            <input type="hidden" name="_method" value="POST">
            <div class="reply-field">
                <input type="text" placeholder="Логин" name="data[User][mail]">
            </div>
            <div class="reply-field">
                <input type="password" placeholder="Пароль" name="data[User][password]">
            </div>
            <input name="data[User][remember]" value="0" type="hidden">
            <p id="response-text"></p>
            <button type="submit" class="btn-1">Войти</button>
        </form>
        <button id="btn-registration" type="reset" class="btn-2 btn-registration">регистрация</button>
    </div>
    <button title="Close (Esc)" type="button" class="mfp-close" style="color: #42415E">&#215;</button>
</div>

<div id="template-subscribe" class="popup callback zoom-anim-dialog mfp-hide">
    <div class="popup-inner">
        <h3>Вы подписались <br>на рассылку</h3>
    </div>
    <button title="Close (Esc)" type="button" class="mfp-close" style="color: #42415E">&#215;</button>
</div>

<div id="template-maintenance" class="popup callback zoom-anim-dialog mfp-hide">
    <div class="popup-inner">
        <h3>Данная функция временно недоступна.<br>Приносим извинения</h3>
    </div>
    <button title="Close (Esc)" type="button" class="mfp-close" style="color: #42415E">&#215;</button>
</div>


<script>

    $('.btn-login').click(function (e) {
        e.preventDefault();

        $.magnificPopup.open({
            items: {src: '#template-login'},
            type: 'inline',
            overflowY: 'scroll',
            mainClass: 'my-mfp-zoom-in',

        });

        return false;
    });

    $('#btn-registration').click(function (e) {
        e.preventDefault();
        //$.magnificPopup.close();
        $.magnificPopup.open({
            items: {src: '#template-registration'},
            type: 'inline',
            overflowY: 'scroll',
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in',
            closeOnBgClick: true,
            callbacks: {
                open: function () {

                }
            }
        });

        return false;
    });

    const emailSubscribe = $('#email-subscribe');

    emailSubscribe.on('focus', function (e) {
        $(this).css('border', '1px solid #EAEEFE');
    });

    $('#img-subscribe').click(function (e) {
        e.preventDefault();

        if (validateEmail(emailSubscribe.val())) {
            $.magnificPopup.open({
                items: {src: '#template-subscribe'},
                type: 'inline',
                overflowY: 'scroll',
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in',
                closeOnBgClick: true,
            });

            emailSubscribe.val('');

        } else {
            emailSubscribe.css('border-color', 'red');
        }


        return false;
    });

    $('form input').on('focus', function (e) {
        $(this).css('border-color', '#EAEEFE');
        $('input[name="data[User][password]"]').css('border-color', '#EAEEFE');
        $('input[name="data[User][password_repeat]"]').css('border-color', '#EAEEFE');
    });


    $('#form-login').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: '/user/login/',
            type: 'POST',
            method: 'POST',
            data: $('#form-login').serialize(),
            dataType: 'json',
            success: function (response) {
                //const response = $.parseJSON(data);
                console.log(response);
                $('#response-text').html(response.message);
                if (response.error === 'true') {
                    $('#form-login input').css('border-color', 'red');
                } else {
                    location = response.redirect;
                }
            }
        })
    });


    $('#form-registration').submit(function (e) {
        e.preventDefault();

        const nameElem = $('input[name="data[User][name]"]');
        const passwordElem = $('input[name="data[User][password]"]');
        const passwordRepeatElem = $('input[name="data[User][password_repeat]"]');
        const email = $('input[name="data[User][mail]"]');

        if (!validateEmail(email.val())) {
            email.css('border-color', 'red');
            return;
        }

        if (nameElem.val().length < 2) {
            nameElem.css('border-color', 'red');
            return;
        }

        if (passwordElem.val().length === 0 || passwordElem.val() !== passwordRepeatElem.val()) {
            passwordElem.css('border-color', 'red');
            passwordRepeatElem.css('border-color', 'red');
            return;
        }


        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            method: $(this).attr('method'),
            data: $('#form-registration').serialize(),
            dataType: 'json',
            success: function (response) {
                //const response = $.parseJSON(data);
                console.log(response);
                $('#response-text-r').html(response.message);
                if (response.error === 'true') {
                    $('#form-login input').css('border-color', 'red');
                } else {
                    location = response.redirect;
                }
            }
        })
    });


    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }


</script>


<script defer src="/js/slick.min.js"></script>
<script defer src="/js/tabs.js"></script>
<script defer src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.jquery.min.js"></script>
<script defer src="/js/jquery.formstyler.min.js"></script>
<script defer src="/js/jquery.magnific-popup.min.js"></script>
<script defer src="/js/jquery.fancybox.min.js"></script>
<script defer src="/js/jquery.barrating.min.js"></script>
<script defer src="/js/dropzone.js"></script>
<script defer src="/js/script.js?v=3"></script>

</body>
</html>
