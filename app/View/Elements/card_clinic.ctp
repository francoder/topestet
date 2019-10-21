<?php if (!empty($clinic)) {
    ?>
    <?php
    $clinicName = isset($clinic['Clinic'][0]) ? $clinic['Clinic'][0]['name'] : '';
    $clinicDescription = $clinic['User']['description'];
    $coast = '₽';

    if ($clinic['User']['coast_avg'] <= 30000) {
        $coast = '₽';
    } else if ($clinic['User']['coast_avg'] > 30000 && $clinic['User']['coast_avg'] <= 100000) {
        $coast = '₽₽';
    } else {
        $coast = '₽₽₽';
    }

    ?>
    <div class="block">
        <div class="left">
            <a href="/clinic/profile/<?= $clinic['User']['id'] ?>">
                <img src="<?= $this->Element("image",
                    [
                        "model" => "user",
                        "id" => $clinic['User']['id'],
                        "alias" => "avatar",
                        "type" => "main",
                        "onlyurl" => true,
                    ]) ?>" style="width: 50%; margin-left: 20%; margin-top: 16px; object-fit: cover" alt="">
            </a>
            <div class="title"><?= $clinic['User']['name'] ?></div>
            <p><?= $clinic['User']['profession'] ?></p>
            <div class="price"><?= $coast ?></div>
        </div>
        <div class="right">
            <div class="top">
                <p><?= strip_tags(DisplayHelper::short($clinicDescription, 40)) ?></p>
            </div>
            <div class="bottom">
                <div class="doctor">
                    <?php if (isset($clinicTopSpecialistList[$clinic['User']['id']])) {
                        $topSpecialist = $clinicTopSpecialistList[$clinic['User']['id']];
                        ?>
                        <div class="img">
                            <a href="/specialist/profile/<?= $topSpecialist['id'] ?>/">
                                <img style="border-radius: 50%" src="<?= $this->Element("image",
                                    [
                                        "model" => "user",
                                        "id" => $topSpecialist['id'],
                                        "alias" => "avatar",
                                        "type" => "main",
                                        "onlyurl" => true,
                                    ]) ?>" alt="">
                            </a>
                        </div>
                        <div class="text">
                            <a href="/specialist/profile/<?= $topSpecialist['id'] ?>/">
                                <?= $topSpecialist['name'] ?>
                                <p>Лучший специалист</p>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="contacts">
                    <div class="address"><?= $clinic['User']['address'] ?></div>
                    <div class="phone"><?= $clinic['User']['phone'] ?></div>
                    <a href=""><?= $clinic['User']['name'] ?></a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>



