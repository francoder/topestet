<?php
ob_clean();
?>


<div class="form">
    <div class="inner">
        <div class="navigation">
            <a href="/">Главная</a>
            <a href="/forum/">Форум</a>
            <span>Задать вопрос</span>
        </div>

        <?php
            if (isset($done) && $done) {?>
            <h1>Ваш вопрос успешно <?php if(isset($edit)):?>отредактирован<?php else:?>добавлен<?php endif;?>.
                Спасибо!
            </h1>
            <p>
                Ссылка на вопрос: <a href="<?=$url = "/forum/answer/$question_id/"?>">http://<?=$_SERVER['SERVER_NAME'].$url?></a>
            </p>
        <?php } else { ?>

            <h1>Задать вопрос специалисту</h1>
            <p>Если вы не нашли ответы на свои вопросы <a href="/forum/ ">в тематическом разделе,</a>
                то вы можете задать вопрос самостоятельно.</p>
            <form action="/forum/add/" id="QuestionAddForm" enctype="multipart/form-data" method="post"
                  accept-charset="utf-8">
                <div class="left">
                    <div class="selects">
                        <select name="data[Question][category_id]" id="categoryChanger" class="styler white"
                                data-placeholder="Тема вопроса"
                                required="required">
                            <?php foreach ($specializations as $specialization) {
                                if (isset($specializationId) === false) {
                                    $firstSpecializationId = $specialization['Specialization']['id'];
                                }
                                $specializationId = $specialization['Specialization']['id'];
                                ?>
                                <option value="<?= $specialization['Specialization']['id'] ?>">
                                    <?= $specialization['Specialization']['title'] ?>
                                </option>";
                                <?php
                            } ?>
                        </select>
                        <select name="data[Question][service_id]" class="styler white" data-placeholder="Вид процедуры"
                                required="required" id="serviceChanger">
                            <option></option>
                            <?php
                            foreach ($specializations as $specialization) {
                                $specializationId = $specialization['Specialization']['id'];
                                $servicePullLabel = $specialization['Specialization']['title'];
                                $servicePull = $services[$servicePullLabel];
                                if ($specializationId !== $firstSpecializationId) {
                                    continue;
                                }
                                foreach ($servicePull as $serviceId => $serviceName) { ?>
                                    <option value="<?= $serviceId ?>"><?= $serviceName ?></option>
                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                    <input type="text" name="data[Question][subject]" placeholder="Заголовок вопроса" required>
                </div>
                <div class="right">
                    <textarea placeholder="Описание вопроса" name="data[Question][content]" required></textarea>
                </div>

                <input name="data[Question][service_title]" value="" hidden>
                <div style="display: none">
                    <div id="photos">
                        <div id="photo_ex" class="photo_item">
                            <input type="file" name="data[Photo][0][picture]" id="Photo0Picture">
                            <input type="hidden" name="data[Photo][0][content]" value="---" id="Photo0Content">
                            <input type="hidden" name="data[Photo][0][alias]" value="question" id="Photo0Alias">
                            <a href="#" class="image_delete" style="display:none;">Удалить</a> <br>
                        </div>
                    </div>
                    <a href="#" class="add-photo">Добавить еще фото</a>
                </div>

                <div class="g-recaptcha" style="margin-bottom: 20px;"
                     data-sitekey="6LfxqhgUAAAAAOXXPrt4qQq8YkkfHU42nqn96riX"></div>
                <label>
                    <input type="checkbox" class="styler" required>
                    <span>Согласен с <a href="/privacy">политикой обработки данных</a></span>
                </label>
                <button class="btn dark-blue">Задать вопрос</button>
            </form>
        <?php } ?>
    </div>
</div>

<script>
    var specializations = {
        <?php foreach ($specializations as $specialization) {
            echo "
                '{$specialization['Specialization']['id']}' : {
                    'id' : {$specialization['Specialization']['id']},
                    'title' : '{$specialization['Specialization']['title']}',
                },
            ";
        } ?>
    };

    var serviceList = {
        <?php
            foreach ($specializations as $specialization) {
                $servicePull = $services[$specialization['Specialization']['title']];
                $servicePullList = '';
                foreach ($servicePull as $serviceId => $serviceName) {
                    $servicePullList .= "
                        '$serviceId' : {
                            'id' : $serviceId,
                            'title' : '$serviceName',
                        },
                    ";
                }
                echo "
                    '{$specialization['Specialization']['id']}' : {
                        $servicePullList
                    },
                ";
            }
        ?>
    };

    $("#serviceChanger").trigger('refresh');

    $('#categoryChanger').on('change', function () {
        let el = $("#serviceChanger");
        let optionList = '';
        $.each( serviceList[this.value], function( serviceId, service ) {
            optionList += '<option value="' + service.id + '">' + service.title + '</option>';
        });

        el.html(optionList).trigger('refresh');
    });
</script>
<script type="text/javascript">
	$('#QuestionAddForm').submit(function(){
		if (!grecaptcha.getResponse()){
			alert ('Докажите, что вы не робот!');
			return false;
		}
		return true;
	});
</script>
