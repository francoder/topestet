<?php
//Debugger::dump($specialist);
if (!empty($specialist)): ?>
    <?php //Debugger::dump($specialist['Clinic'][0]['name']) ?>
    <?php
    $clinicName = isset($specialist['Clinic'][0]) ? $specialist['Clinic'][0]['name'] : '';
    $clinicId = isset($specialist['Clinic'][0]) ? $specialist['Clinic'][0]['id'] : null;
    $clinicDescription = isset($specialist['Clinic'][0]) ? $specialist['Clinic'][0]['profession'] : '';
    $coast = '₽';

    if ($specialist['User']['coast_avg'] <= 30000) {
        $coast = '₽';
    } else if ($specialist['User']['coast_avg'] > 30000 && $specialist['User']['coast_avg'] <= 100000) {
        $coast = '₽₽';
    } else {
        $coast = '₽₽₽';
    }

    ?>
    <div class="item">
        <div class="left">
            <div class="top">
                <a href="/specialist/profile/<?= $specialist['User']['id'] ?>" class="img">
                    <img style="border-radius: 50%" src="<?= $this->Element("image",
                        [
                            "model" => "user",
                            "id" => $specialist['User']['id'],
                            "alias" => "avatar",
                            "type" => "main",
                            "onlyurl" => true,
                        ]) ?>" alt="">
                </a>
                <?php if ($specialist['User']['rate'] !== '0') { ?>
                    <div class="text">
                        <div class="up">
                            <a href="/specialist/profile/<?= $specialist['User']['id'] ?>"
                               style="color: #42415E; border-bottom: none">
                                <p><?= DisplayHelper::formatRating($specialist['User']['rate']) ?></p></a>
                            <a href="/specialist/profile/<?= $specialist['User']['id'] ?>">
                                <?= DisplayHelper::pluralReview($specialist['User']['review_count']) ?>
                            </a>
                        </div>
                        <div class="down">рейтинг</div>
                    </div>
                <?php } ?>
            </div>
            <a href="/specialist/profile/<?= $specialist['User']['id'] ?>">
                <div class="name"><?= $specialist['User']['name'] ?>
                </div>
                <div class="info">
                    <p><?= $specialist['User']['profession'] ?></p>
                </div>
                <div class="price"><?= $coast ?></div>
            </a>
        </div>
        <div class="right">
            <p>
                <a href="/specialist/profile/<?= $specialist['User']['id'] ?>">
                    <?= strip_tags(DisplayHelper::short($specialist['User']['description'], 20)) ?>
                </a>
            </p>
            <div class="bottom">
                <div class="clinic">
                    <?php if ($clinicId !== null) { ?>
                        <a href="/clinic/profile/<?= $clinicId ?>/">
                            <div class="name"><?= $clinicName ?></div>
                            <p><?= strip_tags(DisplayHelper::short($clinicDescription, 5)) ?></p>
                        </a>
                    <?php } ?>
                </div>
                <div class="contacts">
                    <div class="address"><?= $specialist['User']['address'] ?></div>
                    <div class="phone"><?= h($specialist['User']['phone']) ?></div>
                    <a href="http://<?= $specialist['User']['site'] ?>"><?= h($specialist['User']['site']) ?></a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>



