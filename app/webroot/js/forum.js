$(function() {
    $('.f_response_edit').on('click', function(event){
        var fedit_form_id = 'fedit_form_' + $(this).parent().attr('id').split('_')[1];

        $('#' + fedit_form_id).show();

        return false;
    });

    $('.f_response_del').on('click', function(event){
        if (confirm("Вы действительно хотите удалить ответ?")) {
            var url = $(this).attr('href');

            var fedit_id = $(this).parent().attr('id');

            var fanswer_id = 'fanswer_' + fedit_id.split('_')[1];

            $.post(url, {}, function(data){
                if (data.error && data.error === true) {
                    alert(data.error_message);
                } else {
                    $('#' + fanswer_id).empty().hide();
                    $('#' + fedit_id).empty().append('Ответ удалён');
                }
            }, "json");
        }
        return false;
    });

    $('.fedit_form').on('submit', function(){
        
        var id = $(this).parent().attr('id').split('_')[1];

        var url = '/forum/response_edit/' + id + '/';

        var edit_text = $('#edit_text_' + id).val();

        $.post(url, {id: id, edit_text: edit_text}, function(data){
            if (data.error && data.error === true) {
                alert(data.error_message);
            } else {
                $('#response_' + id).empty().append(data.response);
                $('#edit_text_' + id).val(data.response);
                $('#fedit_form_' + id).hide();
            }
        }, "json");

        return false;
    });

    $('.f_qcomment_del').on('click', function(event){
        if (confirm("Вы действительно хотите удалить комментарий?")) {
            var url = $(this).attr('href');

            var cedit_id = $(this).parent().attr('id');

            var qcomment_id = 'qcomment_' + cedit_id.split('_')[1];

            $.post(url, {}, function(data){
                if (data.error && data.error === true) {
                    alert(data.error_message);
                } else {
                    $('#' + qcomment_id).empty().hide();
                    $('#' + cedit_id).empty().append('Ответ удалён');
                }
            }, "json");
        }
        return false;
    });


    $('.f_qcomment_edit').on('click', function(event){
        var cedit_form_id = 'cedit_form_' + $(this).parent().attr('id').split('_')[1];

        $('#' + cedit_form_id).show();

        return false;
    });

    $('.cedit_form').on('submit', function(){
        
        var id = $(this).parent().attr('id').split('_')[1];

        var url = '/forum/qcomment_edit/' + id + '/';

        var edit_text = $('#cedit_text_' + id).val();

        $.post(url, {id: id, edit_text: edit_text}, function(data){
            if (data.error && data.error === true) {
                alert(data.error_message);
            } else {
                $('#comment_text_' + id).empty().append('<p>' + data.response + '</p>');
                $('#cedit_text_' + id).val(data.response);
                $('#cedit_form_' + id).hide();
            }
        }, "json");

        return false;
    });
});