<?php if (!empty($last_responses)) {
    ?>
    <div class="articles">
        <h4>
            <?= !empty($last_responses_title) ? $last_responses_title : 'Последние ответы' ?>
        </h4>
        <?php
        $alreadyAdded = [];
        foreach ($last_responses as $response) {
            if (in_array($response['Question']['id'], $alreadyAdded, true)) {
                continue;
            }
            $alreadyAdded[] = $response['Question']['id'];
            ?>
            <div>
                <a href="/forum/answer/<?= $response['Question']['id'] ?>"><?= $response['Question']['subject'] ?></a>
            </div>
        <?php } ?>
    </div>
<?php } ?>
