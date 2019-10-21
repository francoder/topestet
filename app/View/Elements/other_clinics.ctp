<?php if (isset($other_clinics)) : ?>
    <div class="other-clinics-slider">
        <?php foreach ($other_clinics as $clinic): ?>
            <div>
                <a href="/clinic/profile/<?= $clinic['User']['id'] ?>">
                    <?php $imgUrl = $this->Element('image', [
                        "model" => "user",
                        "type" => "main",
                        "alias" => "avatar",
                        "id" => $clinic['User']['id'],
                    ]); ?>
                    <img style="width: 100%; height: 190px; object-fit: cover;"
                         src="<?= $imgUrl ? $imgUrl : '/img/clinic_404.jpg' ?>" alt="">
                </a>
                <div class="text">
                    <div class="title"><?= $clinic['User']['name'] ?></div>
                    <p><?= $clinic['User']['profession'] ?></p>
                    <div class="address"><?= $clinic['User']['address'] ?></div>
                    <div class="phone"><?= $clinic['User']['phone'] ?></div>
                    <a href="<?= $clinic['User']['site'] ?>"><?= $clinic['User']['name'] ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<!--    <div class="other-clinics-slider">-->
<!--        <div>-->
<!--            <img src="/image/user/avatar_36684.jpg" alt="">-->
<!--            <div class="text">-->
<!--                <div class="title">FrauKlinik</div>-->
<!--                <p>Клиника пластической хирургии и косметологии</p>-->
<!--                <div class="address">Москва, ул. Гиляровского, д. 55</div>-->
<!--                <div class="phone">7 495 120 06 10</div>-->
<!--                <a href="">www.frauklinik.ru</a>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div>-->
<!--            <img src="/image/user/avatar_36684.jpg" alt="">-->
<!--            <div class="text">-->
<!--                <div class="title">FrauKlinik</div>-->
<!--                <p>Клиника пластической хирургии и косметологии</p>-->
<!--                <div class="address">Москва, ул. Гиляровского, д. 55</div>-->
<!--                <div class="phone">7 495 120 06 10</div>-->
<!--                <a href="">www.frauklinik.ru</a>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div>-->
<!--            <img src="/image/user/avatar_36684.jpg" alt="">-->
<!--            <div class="text">-->
<!--                <div class="title">FrauKlinik</div>-->
<!--                <p>Клиника пластической хирургии и косметологии</p>-->
<!--                <div class="address">Москва, ул. Гиляровского, д. 55</div>-->
<!--                <div class="phone">7 495 120 06 10</div>-->
<!--                <a href="">www.frauklinik.ru</a>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div>-->
<!--            <img src="/image/user/avatar_36684.jpg" alt="">-->
<!--            <div class="text">-->
<!--                <div class="title">FrauKlinik</div>-->
<!--                <p>Клиника пластической хирургии и косметологии</p>-->
<!--                <div class="address">Москва, ул. Гиляровского, д. 55</div>-->
<!--                <div class="phone">7 495 120 06 10</div>-->
<!--                <a href="">www.frauklinik.ru</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?php endif; ?>
