<div class="container pt-10 col-md-10">
    <h3>
        <span class="glyphicon glyphicon-cog"></span>
        Настройка системы
    </h3>
    <? if (isset($done) && $done): ?>
        <?= $this->element("message", ["ok" => true, "message" => "Настройки сохранены"]); ?>
    <? endif; ?>
    <div class="well">
        <?= $this->Form->create("Configs", ["url" => $this->here, 'class' => 'form-horizontal']); ?>
        <? foreach ($configs as $i => $config): ?>
            <div class="form-group">
                <label class="control-label col-sm-4 "><?= $config['Config']['description'] ?></label>
                <div class="col-sm-8">
                    <? $v = (isset($this->data['Configs']["config_{$config['Config']['name']}"])) ? $this->data['Configs']["config_{$config['Config']['name']}"] : $config['Config']['value']; ?>
                    <?= $this->Form->{$config['Config']['type']}("{$config['Config']['name']}",
                        [
                            "class" => "form-control",
                            "value" => $v,
                            "checked" => $v,
                        ]); ?>
                </div>
            </div>
        <? endforeach; ?>
        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-4">
                <?= $this->Form->submit('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</div>
