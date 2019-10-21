<?php if (isset($best_specialists)) { ?>
    <div class="specialists">
        <h4>Лучшие специалисты</h4>
        <? foreach ($best_specialists as $specialist) {
            ?>
            <div class="item">
                <a class="img" href="/specialist/profile/<?= $specialist['User']['id'] ?>/">
                    <img alt="" src="<?= $this->Element("image", [
                        "model" => "user",
                        "id" => $specialist['User']['id'],
                        "alias" => "avatar",
                        "type" => "mini",
                    ]) ?>" style="border-radius: 50px;"></a>
                <div class="text">
                    <div>
                        <a class="name" href="/specialist/profile/<?= $specialist['User']['id'] ?>/">
                            <?= $specialist['User']['name'] ?>
                        </a>
                    </div>
                    <?php if (isset($specialist['User']['Clinic'][0])) { ?>
                        <a class="clinic" href="/clinic/profile/<?= $specialist['User']['Clinic'][0]['id'] ?>/">
                            <?= $specialist['User']['Clinic'][0]['name'] ?>
                        </a>
                    <?php } else { ?>
                        <?= $specialist['User']['profession'] ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php }
