<?php if (isset($topSpecialistByService)) { ?>
    <div class="specialists">
        <h4>Больше всего ответов</h4>
        <?php foreach ($topSpecialistByService as $specialist) { ?>
            <div class="item">
                <a href="/specialist/profile/<?= $specialist['Specialist']['id'] ?>/" class="img">
                    <img src="<?= $this->Element("image", [
                        "id" => $specialist['Specialist']['id'], "model" => "user", "noimage" => true,
                        "alias" => "avatar", "type" => "mini",
                    ]) ?>" alt="Доктор <?= $specialist['Specialist']['name'] ?>" style="border-radius: 50%">
                </a>
                <div class="text">
                    <div>
                        <a href="/specialist/profile/<?= $specialist['Specialist']['id'] ?>/"
                           class="name"><?= $specialist['Specialist']['name'] ?></a>
                    </div>
                    <?php if (isset($specialist['Specialist']['Specialist']['Clinic'][0])) {
                        $clinic = isset($specialist['Specialist']['Specialist']['Clinic'][0]) ? $specialist['Specialist']['Specialist']['Clinic'][0] : null;
                        ?>
                        <a href="/clinic/profile/<?= $clinic['id'] ?>/" class="clinic"
                           style="line-height: 20px;"><?= $clinic['name']
                            ?></a>
                    <?php } else { ?>
                        <p><?= $specialist['Specialist']['profession'] ?></p>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
