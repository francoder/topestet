<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <title>
        <?= $title_for_layout ?>
    </title>
    <? if (isset($page_description)): ?>
        <meta name="description" content="<?= $page_description ?>"/>
    <? endif; ?>
    <? if (isset($page_keywords)): ?>
        <meta name="keywords" content="<?= $page_keywords ?>"/>
    <? endif; ?>
    <meta name="yandex-verification" content="a82fd06fedb5ddfa"/>
    <?php
    if (isset($this->request->params['named']['page'])
    ) { ?>
        <meta name="robots" content="noindex, nofollow"/>
    <?php } ?>

    <meta http-equiv='x-dns-prefetch-control' content='on'>
    <link rel='dns-prefetch' href='https://content.mql5.com'/>

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png?v=xQdK82Pwmw">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png?v=xQdK82Pwmw">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png?v=xQdK82Pwmw">
    <link rel="manifest" href="/favicon/site.webmanifest?v=xQdK82Pwmw">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg?v=xQdK82Pwmw" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon/favicon.ico?v=xQdK82Pwmw">
    <meta name="apple-mobile-web-app-title" content="TopEstet">
    <meta name="application-name" content="TopEstet">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="/css/style.css?v=1" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/normalize.css?v=1" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/fonts.css?v=1" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/slick.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/jquery.formstyler.theme.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/jquery.formstyler.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/jquery.fancybox.min.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/magnific-popup.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/css-stars.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/resp.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/basic.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="/css/front.css" type="text/css" media="all"/>

    <script src="/js/jquery-1.12.4.min.js"></script>
    <script async src='https://www.google.com/recaptcha/api.js'></script>

    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MB7SQ82');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MB7SQ82" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="wrapper">
    <header id="header">
        <div class="header-pic-block" id="kritklxfpgrixdxtdinxlavmsumrffmzmm" align="center"></div>
        <script type="text/javascript">
            (function (a, e, f, g, b, c, d) {
                a[b] || (a.FintezaCoreObject = b, a[b] = a[b] || function () {
                    (a[b].q = a[b].q || []).push(arguments)
                }, a[b].l = 1 * new Date, c = e.createElement(f), d = e.getElementsByTagName(f)[0], c.async = !0, c.defer = !0, c.src = g, d && d.parentNode && d.parentNode.insertBefore(c, d))
            })
            (window, document, "script", "https://topestet.ru/fz/core.js", "fz");
            fz("show", "kritklxfpgrixdxtdinxlavmsumrffmzmm");

            var headerInited = false;
            $('.header-pic-block').bind("DOMSubtreeModified", function () {
                if (headerInited === false) {
                    headerInited = true;
                    $('header').addClass('with-header-banner');
                    $('#middle').addClass('with-header-banner');
                }
            });
        </script>

        <div class="header-nav">
            <div class="inner">
            <a href="/" class="logo">
                <img src="/images/logo.svg" alt="">
            </a>
            <nav>
                <div class="dropdown-menu">
                    <div class="line-1"></div>
                    <div class="line-2"></div>
                    <div class="line-3"></div>
                </div>
                <ul>
                    <li class="services-list">
							<span>
								<span class="icon">
									<span class="line-1"></span>
									<span class="line-2"></span>
									<span class="line-3"></span>
								</span>
								<a href="/service/">Услуги</a>
							</span>
                        <ul>
                            <?php foreach ($specializations as $spec) : ?>
                                <li><a
                                            href="/service/<?= $spec['Specialization']['alias'] ?>/"><?= $spec['Specialization']['title'] ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li><a href="/reviews/">Отзывы</a></li>
                    <li><a href="/forum/">Вопросы</a></li>
                    <li><a href="/catalog/clinic/">Клиники</a></li>
                    <li><a href="/catalog/">Специалисты</a></li>
                    <li><a href="/article/">Блог</a></li>
                </ul>
            </nav>
            <div class="add-review">
                <a href="/reviews/add_review/">Оставить отзыв</a>
            </div>
            <div class="phone">
                <a href="tel:88005515079">8 800 551 50 79</a>
            </div>
            <div class="login">
                <?php if (!$auth) { ?>
                    <a href="javascript:void(0)" class="ajax-mfp " data-href="/popup-login.html">
                        <img src="/images/login.svg" alt="" class="not-authorized active">
                    </a>
                <?php } else { ?>
                    <a href="/profile/<?= $auth['id'] ?>/">
                        <img src="/images/login-active.svg" alt="" class="logged-in active">
                        <ul>
                            <li>
                                <a href="/profile/<?= $auth['id'] ?>/">Профиль</a>
                            </li>
                            <?php if ($auth['is_admin'] == 2) { ?>
                                <li>
                                    <a href="/admin/">Админ панель</a>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="/user/logout/<?= $auth['id'] ?>">Выйти</a>
                            </li>
                        </ul>
                    </a>
                <?php } ?>
            </div>
        </div>
        </div>
    </header>
    <div id="middle">
        <?php if (!isset($removeInner)) { ?>
        <div class="inner">
            <?php } ?>
