<?php
ob_clean();
?>

<div class="leave-feedback">
    <form class="inner" action="/reviews/add_review/" id="ReviewAddReviewForm" enctype="multipart/form-data"
          method="post" accept-charset="utf-8">
        <div class="top">
            <div class="navigation">
                <a href="">Главная</a>
                <span>Оставить отзыв</span>
            </div>
            <h1>Оставить отзыв</h1>
            <p>Если вам есть чем поделиться с другими пользователями портала, вы можете оставить отзыв,
                о проведенной услуге или процедуре. Мы опубликуем его, после предварительной модерации.</p>
        </div>
        <div class="leave-feedback-1">
            <div class="left">
                <input type="hidden" name="data[Review][service_id]" id="service_id" value="0">
                <input type="text" id="serviceNameField" placeholder="Какую услугу вам сделали?"
                       name="data[Review][service_name]"
                       required>

                <input type="hidden" name="data[Review][clinic_id]" id="clinic_id" value="">
                <input type="text" id="clinicNameField" placeholder="В какой клинике вам ее провели?"
                       name="data[Review][clinic_name]"
                       required>

                <input type="hidden" name="data[Review][region_id]" id="region_id" value="">
                <input type="text" id="regionNameField" placeholder="В каком городе была выполнена услуга?"
                       name="data[Review][region_name]"
                       required>

                <input type="hidden" name="data[Review][specialist_id]" id="specialist_id" value="">
                <input type="text" id="doctorNameField" placeholder="Как зовут врача, который провел услугу?"
                       name="data[Review][specialist_name]" required>

                <input type="number" placeholder="Сколько стоила услуга в рублях?" name="data[Review][coast]" required>

                <select class="styler white" required="required" name="data[Review][note_result]">
                    <option>Вы довольны результатом?</option>
                    <option value="0">Процедура еще не сделана</option>
                    <option value="1">Не рекомендую</option>
                    <option value="2">Сомневаюсь</option>
                    <option value="3">Рекомендую</option>
                </select>
            </div>
            <div class="right">
                <input type="text" placeholder="Заголовок отзыва" name="data[Review][subject]">
                <textarea placeholder="Ваш отзыв" rows="6" maxlength="15000"
                          name="data[Review][description]"></textarea>
                <input type="file" class="styler" data-browse="Выберите файл" data-placeholder="Добавить фотографии"
                       multiple="multiple" name="data[Photo][0][picture]">
            </div>
        </div>
        <div class="leave-feedback-2">
            <p>Оцените качество услуги?</p>
            <div class="stars stars-example-css">
                <select id="example-css" name="data[Review][note_specialist]" autocomplete="off" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
        </div>

        <input type="hidden" name="data[Review][service_title]" hidden>
        <input type="hidden" name="data[Review][comment_note]" hidden>


        <?php
        $errors = $this->Display->errors($this->validationErrors['Review']);
        if ($errors !== false) {
            echo "<h4 class=\"error\" style=\"color: red; position: relative; top: -40px; margin-bottom: 20px;\">$errors</h4>";
        }
        ?>
        <br>
        <div class="g-recaptcha" data-sitekey="secret_key"></div>
        <br>
        <div class="leave-feedback-3">
            <button type="submit" class="btn dark-blue">Оставить отзыв</button>
            <label>
                <input type="checkbox" class="styler" required>
                <p>Согласен с <a href="/privacy">политикой обработки данных</a></p>
            </label>
        </div>
    </form>
</div>

<script>
    $(function () {
        let lastDoctorName = null;
        let lastDoctorId = null;
        $('#doctorNameField').autocomplete(
            {
                hint: true,
                minLength: 0,
                openOnFocus: true,
                autoselectOnBlur: true,
                autoselect: true
            },
            [{
                source: function (searchString, response) {
                    $.ajax({
                        url: "/suggestion/specialist/",
                        data: {
                            search_string: searchString,
                        },
                        success: function (data) {
                            lines = $.map(data, function (item, index) {
                                return {
                                    value: item,
                                    id: index,
                                }
                            });
                            response(lines);
                        }
                    });
                }
            }]
        ).on('autocomplete:selected autocomplete:autocompleted', function (event, suggestion) {
            $('#specialist_id').val(suggestion.id);
            lastDoctorName = suggestion.value;
            lastDoctorId = suggestion.id;
        }).on('input', function () {
            let testingName = $('#doctorNameField').val();
            if (
                testingName !== '' &&
                lastDoctorName !== null &&
                lastDoctorName.includes(testingName) !== false
            ) {
                $('#specialist_id').val(lastDoctorId);
            } else {
                $('#specialist_id').val('');
            }
        });

        let lastClinicName = null;
        let lastClinicId = null;
        $('#clinicNameField').autocomplete(
            {
                hint: true,
                minLength: 0,
                openOnFocus: true,
                autoselectOnBlur: true,
                autoselect: true
            },
            [{
                source: function (searchString, response) {
                    $.ajax({
                        url: "/suggestion/clinic/",
                        data: {
                            search_string: searchString,
                        },
                        success: function (data) {
                            lines = $.map(data, function (item, index) {
                                return {
                                    value: item,
                                    id: index,
                                }
                            });
                            response(lines);
                        }
                    });
                }
            }]
        ).on('autocomplete:selected autocomplete:autocompleted', function (event, suggestion) {
            $('#clinic_id').val(suggestion.id);
            lastClinicName = suggestion.value;
            lastClinicId = suggestion.id;
        }).on('input', function () {
            let testingName = $('#clinicNameField').val();
            if (
                testingName !== '' &&
                lastClinicName !== null &&
                lastClinicName.includes(testingName) !== false
            ) {
                $('#clinic_id').val(lastClinicId);
            } else {
                $('#clinic_id').val('');
            }
        });

        let lastRegionName = null;
        let lastRegionId = null;
        $('#regionNameField').autocomplete(
            {
                hint: false,
                minLength: 0,
                openOnFocus: true,
                autoselectOnBlur: false,
                autoselect: false
            },
            [{
                source: function (searchString, response) {
                    $.ajax({
                        url: "/suggestion/region/",
                        data: {
                            search_string: searchString,
                        },
                        success: function (data) {
                            lines = $.map(data, function (item, index) {
                                return {
                                    value: item,
                                    id: index,
                                }
                            });
                            response(lines);
                        }
                    });
                }
            }]
        ).on('autocomplete:selected autocomplete:autocompleted', function (event, suggestion) {
            $('#region_id').val(suggestion.id);
            lastRegionName = suggestion.value;
            lastRegionId = suggestion.id;
        }).on('input', function () {
            let testingName = $('#regionNameField').val();
            if (
                testingName !== '' &&
                lastRegionName !== null &&
                lastRegionName.includes(testingName) !== false
            ) {
                $('#region_id').val(lastRegionId);
            } else {
                $('#region_id').val('');
            }
        });

        let lastServiceName = null;
        let lastServiceId = null;
        $('#serviceNameField').autocomplete(
            {
                hint: false,
                minLength: 0,
                openOnFocus: true,
                autoselectOnBlur: false,
                autoselect: false
            },
            [{
                source: function (searchString, response) {
                    $.ajax({
                        url: "/suggestion/service/",
                        data: {
                            search_string: searchString,
                        },
                        success: function (data) {
                            lines = $.map(data, function (item, index) {
                                return {
                                    value: item,
                                    id: index,
                                }
                            });
                            response(lines);
                        }
                    });
                }
            }]
        ).on('autocomplete:selected autocomplete:autocompleted', function (event, suggestion) {
            $('#service_id').val(suggestion.id);
            lastServiceName = suggestion.value;
            lastServiceId = suggestion.id;
        }).on('input', function () {
            let testingName = $('#serviceNameField').val();
            if (
                testingName !== '' &&
                lastServiceName !== null &&
                lastServiceName.includes(testingName) !== false
            ) {
                $('#service_id').val(lastServiceId);
            } else {
                $('#service_id').val(0);
            }
        });
    });
</script>

<style>
    input[type="number"]::placeholder {
        font-size: 1.07em;
        font-family: Circe;
        color: rgba(66, 65, 94, 0.5);
        -webkit-transition: 0.3s;
        -o-transition: 0.3s;
        transition: 0.3s;
    }

    .leave-feedback-1 input[type="number"] {
        outline: none;
        -webkit-transition: 0.3s;
        -o-transition: 0.3s;
        transition: 0.3s;
        font-size: 1.07em;
        border-radius: 2px;
        border: 1px solid #EAEEFE;
        padding: 18px 15px;
        color: rgba(66, 65, 94, 0.5);
        width: 100%;
        margin-bottom: 16px;
        font-family: Circe;
    }
</style>
