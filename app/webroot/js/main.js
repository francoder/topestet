$(document).ready(function(){
	//разварачиваем habtm
	$('.show_habtm').click(function(){
		$(this).parent().find('.habtm_values').slideDown();
		$(this).hide();
		$(this).parent().find('.hide_habtm').show();
		return false;
	});
	
	$('.hide_habtm').click(function(){
		$(this).parent().slideUp(function(){
			$(this).parent().parent().find('.show_habtm').show();
		});
		$(this).hide();
		
		return false;
	});
	
	$(".item_delete").click(function(){
		return confirm('Вы действительно хотите удалить?');
	});
	
	$("#check_all").change(function(){
		if ($("#check_all").attr("checked") == true){
			$("table.list tbody input[type=checkbox]").attr("checked", "true");
		} else {
			$("table.list tbody input[type=checkbox]").attr("checked", "");
		}
	});
	
	$("table.list tbody input[type=checkbox]").click(function(){
		$("#check_all").attr("checked", "");
	});
	
	if ($("form:first input[type=text]:first").val() == ""){
		$("form:first input[type=text]:first").focus();
	}
	
	//$("#wysiwyg").wysiwyg();
	//$(".wysiwyg").wysiwyg();
	
	
	$("#set_point_auto").click(function	(){
		return find_adress();
	});
	
	$("form").submit(function(){
		//$("form input").attr("disabled", 0);
	});
	
	//сохранить и продолжить
	$("#save_continue").click(function(){
		$("#save_continue_field").val(1);
		return true;
	});
	
	$("div.img_preview > img").click(function(){
		copyToClipboard($(this).parent().find("input[type=text]").val());
	});
	
	$("div.img_preview input[type=text]").click(function(){
		$(this).focus().select();
		copyToClipboard($(this).val());
	});
	
	//переключение редактора
	$(".editor_switcher a").click(function(){
		$(this).addClass("selected");
		if ($(this).hasClass("plain")){
			$(this).parent().find("a.editor").removeClass("selected");
			//$(".wysiwyg").wysiwyg("destroy");
			$(this).parent().parent().find("textarea.wysiwyg").wysiwyg("destroy");
		} else {
			$(this).parent().find("a.plain").removeClass("selected");
			$(this).parent().parent().find("textarea.wysiwyg").wysiwyg();
		}
		//$(this).parent().parent().find("div.wysiwyg").toggle();
		//$(this).parent().parent().find("textarea.wysiwyg").toggle();
		return false;
	});
	
	$('.wysiwyg').redactor({minHeight: 400, imageUpload: '/image_upload.php', autoresize: false, linkAnchor: true });	
});

