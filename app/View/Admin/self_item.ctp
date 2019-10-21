<!-- Page Content -->
<div class="content">
    <!-- Bootstrap Design -->
    <div class="col-md-12 col-xs-12 col-lg-12">
        <h2 class="content-heading">
            <?= $page_title ?>
            <a class="float-right item_delete" href="/admin/self_item_del/<?= $model ?>//">
                <button type="button" class="btn btn-sm btn-secondary"
                        onclick=""
                        title="Удалить">
                    удалить запись <i class="fa fa-times"></i>
                </button>
            </a>
        </h2>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12 col-lg-12">
            <!-- Normal Form -->
            <div class="block">
                <div class="block-content">
                    <?= $this->Form->create($model, [
                        "url" => $this->here, "show_errors" => true,
                        "type" => (($image || array_search_sub(["type" => "file"], $schema)) ? "file" : ""),
                    ]); ?>
                    <?= $this->Form->hidden("id") ?>
                    <? if (isset($translate)) { ?>
                        <h3 style="text-align:center;">Основаная версия (<?= $languages[0] ?>)</h3>
                    <? } ?>
                    <div class="error"><?= $this->Display->errors($this->validationErrors) ?></div>

                    <? foreach ($schema as $id => $element) { ?>
                        <? if (isset($element['inform']) && $element['inform'] == false) continue; ?>
                        <?= $this->Admin->generate_line($model, $id, $element, $this); ?>
                    <? } ?>
                    <? if (isset($translate)) { ?>
                        <? unset($languages[0]); ?>
                        <? foreach ($languages as $lang) { ?>
                            <tr>
                                <td colspan="2" align="center">
                                    <h3 style="text-align:center;">Языковая версия для <?= $lang ?></h3>
                                </td>
                            </tr>
                            <? foreach ($translate as $field) { ?>
                                <?= $this->Admin->generate_line("Language.$lang", $field, $schema[$field], $this); ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>

                    <div class="form-group">
                        <button type="submit" class="btn btn-alt-primary">Сохранить</button>
                    </div>
                    <?= $this->Form->end(); ?>
                </div>
            </div>
            <!-- END Normal Form -->
        </div>
    </div>
    <!-- END Bootstrap Design -->
</div>
<!-- END Page Content -->
