<!-- Page Content -->
<div class="content">
    <!-- Bootstrap Design -->
    <h2 class="content-heading"><?= $page_title ?></h2>
    <div class="row">
        <div class="col-md-6">
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

                    <div class="form-group">
                        <label for="nf-name">Название</label>
                        <input type="text" class="form-control" id="nf-name" name="name"
                               placeholder="Google">
                    </div>
                    <div class="form-group">
                        <label for="nf-refer">Реферальная ссылка</label>
                        <input type="text" class="form-control" id="nf-refer" name="referral_link"
                               placeholder="google.com/?ref=1...">
                    </div>
                    <div class="form-group">
                        <label for="nf-course">Ссылка на курсы</label>
                        <input type="text" class="form-control" id="nf-course" name="course_link"
                               placeholder="google.com/course.xml...">
                    </div>
                    <div class="form-group">
                        <label for="nf-bl">Bl</label>
                        <input type="number" class="form-control" id="nf-bl" name="bl"
                               placeholder="13...">
                    </div>
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

<script>
    function formSubmit() {
        $.ajax({
            url: '{{  route('api-add - exchanger')  }}',
            data: $("#addExchangerForm").serialize(),
            dataType: 'json',
            method: 'POST',
            beforeSend: function () {
                Codebase.layout('header_loader_on')
            },
            complete: function () {
                Codebase.layout('header_loader_off');
            },
            error: function (response) {
                var errorMessage = response.responseJSON.error_message;
                if (errorMessage === 'Validation failure') {
                    errorMessage = 'Отправлены некорректные данные:'
                }
                var data = Object.values(response.responseJSON.data);
                console.log(data);
                swal(
                    'Ошибка',
                    errorMessage +
                    '<p><strong>' +
                    data.join('<br>') +
                    '</p></strong>',
                    'error'
                );
            },
            success: function (data) {
                swal({
                    title: 'Сохранено',
                    text: 'Обменник добавлен!',
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Перейти к списку',
                    html: false,
                }).then(function (result) {
                    if (result.value) {
                        window.location.href = "{{  route('admin-exchanger-list')  }}";
                    }
                });
            }
        });
    }
</script>


<table width="800" style="margin:0 auto;">
    <tr>
        <td colspan="2">
        </td>
    </tr>
    <? foreach ($schema as $id => $element): ?>
        <? if (isset($element['inform']) && $element['inform'] == false) continue; ?>
        <?= $this->Admin->generate_line($model, $id, $element, $this); ?>
    <? endforeach; ?>
    <? /*
			<tr>
				<td nowrap>Дата</td>
				<td width="100%"><?=$this->Form->text("date", array("value" => (isset($this->data['News']['date']) && !empty($this->data['News']['date']))?$this->data['News']['date']:date("Y-m-d")))?></td>
			</tr>
			<tr>
				<td nowrap>Заголовок (рус)</td>
				<td width="100%"><?=$this->Form->text("title_rus", array("class" => "field"))?></td>
			</tr>
			<tr>
				<td nowrap>Заголовок (англ)</td>
				<td width="100%"><?=$this->Form->text("title_eng", array("class" => "field"))?></td>
			</tr>
			<tr>
				<td colspan="2">
					Текст (рус):<br>
					<?=$this->Form->textarea("text_rus", array("style" => "width:100%;height:150px;", "class" => "field"));?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					Текст (англ):<br>
					<?=$this->Form->textarea("text_eng", array("style" => "width:100%;height:150px;", "class" => "field"));?>
				</td>
			</tr>*/ ?>
    <? if (isset($translate)): ?>
        <? unset($languages[0]); ?>
        <? foreach ($languages as $lang): ?>
            <tr>
                <td colspan="2" align="center">
                    <h3 style="text-align:center;">Языковая версия для <?= $lang ?></h3>
                </td>
            </tr>
            <? foreach ($translate as $field): ?>
                <?= $this->Admin->generate_line("Language.$lang", $field, $schema[$field], $this); ?>
            <? endforeach; ?>
        <? endforeach; ?>
    <? endif; ?>
    <tr>
        <td width="100%" colspan="2" align="center">
            <a href="/admin/self_item_del/User/46179/?redirect=<?= urlencode('/admin/self_list/User/') ?>">Удалить
                запись</a>
        </td>
    </tr>
</table>
<? ?>
