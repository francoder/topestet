auth = false;
$(document).ready(function(){
	$(".sortable").tableSort(1);
	
	no_clear = false;
	$("#specialist_list").autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "/service/list_specialist/",
					dataType: "json",
					data: {
						search: request.term,
						service_id: $("#ReviewServiceId").val()
					},
					success: function(data) {
						lines = new Array();
						j = 0;
						for (i in data){
							lines[j] = new Array();
							lines[j]["value"] = data[i];
							lines[j]["id"] = i;
							j++;
						}
						response(lines);
					}
				});
			},
			minLength: 1,
			select: function(event, ui) {
				$("#specialist_id").val(ui.item.id);
				no_clear = true;
			},
			message: false
	});
	
	$("#clinic_list").autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "/service/list_specialist/2",
					dataType: "json",
					data: {
						search: request.term,
						service_id: $("#ReviewServiceId").val()
					},
					success: function(data) {
						lines = new Array();
						j = 0;
						for (i in data){
							lines[j] = new Array();
							lines[j]["value"] = data[i];
							lines[j]["id"] = i;
							j++;
						}
						response(lines);
					}
				});
			},
			minLength: 1,
			select: function(event, ui) {
				$("#clinic_id").val(ui.item.id);
				no_clear = true;
			}
	});
	
	$("#specialist_list").change(function(){
		if (!no_clear){
			$("#specialist_id").val('');
		}
		no_clear = false;
	});
	
	//устаовка оценки звездочкой
	notes = new Array();
	notes[1] = "Очень плохо";
	notes[2] = "Плохо";
	notes[3] = "Нормально";
	notes[4] = "Хорошо";
	notes[5] = "Отлично";
	
	$('.note').each(function(){
		i = 0;
		$(this).find(".star").each(function(){
			$(this).attr("id", "star_" + (i + 1));
			i++;
		});
	});
	set_stars_note();
		
	$(".note .star").mouseover(function(){
		$(this).parent().find(".star").removeClass("active");
		id = /\d+/;
		id = id.exec($(this).attr("id")) * 1;
		for(i = 1; i < id + 1; i ++){
			$(this).parent().find("#star_" + i).addClass("active");
		}
		$(this).parent().parent().find(".note_comment").text(notes[id]);
	});
	
	$(".note .star").click(function(){
		id = /\d+/;
		id = id.exec($(this).attr("id")) * 1;
		$(this).parent().parent().find(".note_specialist").val(id);
		set_stars_note();
	});
	
	$(".note").mouseout(function(){
		set_stars_note();
	});
	
	//отправляем оценку за услугу специалиста
	$('.ser_spec_note .star').click(function(){
		id = /\d+/;
		note = id.exec($(this).attr("id")) * 1;
		ser_spec_id = id.exec($(this).parents('.ser_spec').attr('id')) * 1;
		$.ajax({
			url: '/specialist/service_note/',
			data: {
				note: note,
				id: ser_spec_id
			},
			type: 'post',
			dataType: 'json',
			success: function (response){
				$(r = '#ser_spec_' + response['ser_spec_id'] + ' .res_rate').text(response['rate']);
				$('#ser_spec_' + response['ser_spec_id'] + ' .res_cnt').text(response['cnt']);
			}
		});
		return false;
	});
	
	//ответ на комментарии
	$(".comment_response").click(function(){
		n = $(this).parent().parent().find("a.nick");
		user_name = $(n).text();
		comment_id = $(n).attr("id");
		exp = /\d+/
		comment_id = exp.exec(comment_id);
		$("#comment_parent_id").val(comment_id);
		$("#comment_to span").text(user_name);
		$("#comment_to").show();
		t = ($("div.add-comment").offset().top);
		$('body,html').animate({scrollTop: t + "px"});
		return false;
	});
	
	$("#comment_clear").click(function(){
		$("#comment_to").hide();
		$("#comment_parent_id").val('');
		return false;
	});
	
	//редактирование комментариев
	$("div.comment .edit").click(function(){
		$(this).parent().find(".comment_edit").show();
		return false;
	});
	
	$("div.comment .hide").click(function(){
		$(this).parent().hide();
		return false;
	});
	
	//добавления дополнительный полей к форме с картинками
	$(".list_photo .add-photo").click(function(){
		ex = $("#photo_ex").html();
		current_id = /\[(\d+)\]/
		current_id = current_id.exec(ex);
		current_id = current_id[1];
		id_replace = "\\[" + current_id + "\\]";
		
		number = $("#photos .photo_item").size();
		replace = "[" + (number) + "]";
		ex = ex.replace(new RegExp(id_replace,'g'),replace);
		ph_id = 'ph_' + Math.round(Math.random() * 100);
		template = '<div class="photo_item photo_additional" id="' + ph_id + '">' + ex + '</div>';
				
		$("#photos").append(template);
		$("#" + ph_id + " input[type=image]").val('');
		$("#" + ph_id + " input.photo_id").remove();
		$("#" + ph_id + " textarea").val('');
		$("#" + ph_id + " > img").remove();
		$("#photos .photo_additional .image_delete").show();
		$("#photos .image_delete").click(function(){
			$(this).parent().remove();
			return false;
		});
		return false;
	});
	
	//применение фильтров к фотографиям
	$("form.photo_filters input[type=checkbox]").click(function(){
		$(this).parents("form:first").submit();
	});
	
	//предзагрузка иконки
	im = new Image();
	im.src = "/img/th_gre.png";
	
	im1 = new Image();
	im1.src = "/img/th_red.png";
	
	$("a.vote_pos img").mouseover(function(){
		$(this).attr("src", "/img/th_gre.png")
	});
	
	$("a.vote_pos img").mouseout(function(){
		$(this).attr("src", "/img/th_up_gre.png")
	});
	
	$("a.vote_neg img").mouseover(function(){
		$(this).attr("src", "/img/th_red.png")
	});
	
	$("a.vote_neg img").mouseout(function(){
		$(this).attr("src", "/img/th_down_gre.png")
	});
	
	//всплывающая подсказка
	hide = true;
	$(".for_hint").mouseover(function(pos){
		set_hint_pos(pos, this);
		hide = false;
	});
	
	$(".for_hint").mouseout(function(){
		hide = true;
		setTimeout("hide_hint()", 200);
	});
	
	$(".for_hint img").mouseover(function(){
		hide = false;
	});
	
	$(".for_hint img").mouseout(function(){
		hide = true;
	});
	
	$(".hint").mouseover(function(){
		hide = false;
	});
	
	$(".hint").mouseout(function(){
		hide = true;
		setTimeout("hide_hint()", 200);
	});
	
	//если услуги нет в списке
	show_additional_field();
	$(".service_list").change(function(){
		show_additional_field();
	});
	
	$(".service_list").keyup(function(){
		show_additional_field();
	});
	
	//показать список регионов
	$("#regions_title").click(function(){
		if ($("#regions").css("display") == "none"){
			$("#regions").slideDown();
			$("#regions_title").css("background", "url(/img/minus_icon.png) no-repeat");
		} else {
			$("#regions").slideUp();
			$("#regions_title").css("background", "url(/img/plus_icon.png) no-repeat");
		}
	});
	//показать список Специализация
	$("#spec_hide").click(function(){
		if ($("#specialize").css("display") == "none"){
			$("#specialize").slideDown();
			$("#spec_hide").css("background", "url(/img/minus_icon.png) no-repeat");
		} else {
			$("#specialize").slideUp();
			$("#spec_hide").css("background", "url(/img/plus_icon.png) no-repeat");
		}
	});
	//показать список Услуги
	$("#service_hide").click(function(){
		if ($("#servicebox").css("display") == "none"){
			$("#servicebox").slideDown();
			$("#service_hide").css("background", "url(/img/minus_icon.png) no-repeat");
		} else {
			$("#servicebox").slideUp();
			$("#service_hide").css("background", "url(/img/plus_icon.png) no-repeat");
		}
	});
	//переход на страницу услуг в городе
	$("#specialist_region").change(function(){
		if ($(this).val() != ""){
			url = "/catalog/" + specialist_type + "region/" + $(this).val() + "/" + $("#specialization").val() + "/";
			if (typeof($("#service").val()) != "undefined"){
				url = url + $("#service").val();
			}
			document.location = url;
		}
	});
	
	//голосование за элементы
	//фото до и после, ответы
	$(".rate a").click(function(){

        if ('revvv' === $(this).attr('class')) return true;

		new_id = "vote_" + Math.round(Math.random(1,1000) * 1000);
		$(this).parent().attr("id", new_id);
		url = $(this).attr("href") + "?id=" + new_id;
		$.ajax({
			url: url,
			dataType: "json",
			success: function(data) {
				if (data['id']){
					cnt = data['count'];
					if (cnt > 0) cnt = "+" + cnt;
					$("#" + data['id'] + " span").text(cnt);
					$("#" + data['id'] + " a").css({cursor: "default"});
					$("#" + data['id'] + " a").unbind('click').click(function(){return false});
					$("#" + data['id'] + " a img").unbind('mouseover').unbind('mouseout');
					if (data['note'] == 1) {
						$("#" + data['id'] + " a.vote_pos img").attr("src", "/img/th_gre_2.png");
					} else {
						$("#" + data['id'] + " a.vote_neg img").attr("src", "/img/th_red_2.png");
					}
					alert_message('Ваш голос учтен!');
				}
			},
			error: function(qXHR, textStatus, errorThrown) {
				if (errorThrown == "Forbidden"){
					document.location = "/user/login/";
				} else {
					alert("Неизвестная ошибка, повторите позже")
				}
			}
		});
		return false;
	});

	//говорим спасибо
	$(".thanks a").click(function(){
		url = $(this).attr("href");
		$.ajax({
			url: $(this).attr("href"),
			success: function(response){
				$(this).parents(".thanks").hide();
				alert_message('Ваш голос засчитан!');
			},
			error: function(response, r2, r3){
				if (r3 == 'Forbidden'){
					document.location = '/user/login/?redirect=' + url;
				}
			}
		});
		
		return false;
	});
	
	//кликаем по пункту в списке сообщений
	$(".message_link").click(function(){
		document.location = $(this).find("a").attr("href");
		return false;
	});
	
	//слайдер-листалка на главной
	count_tabs = $(".tab_links li a").size();
	current_tab = 0;
	auto_slide = true;
	if ($(".tab_links").size()){
		$(".tab_links li a").click(function(){
			auto_slide = false;
			id = 0;
			i = 0;
			t = this;
			$(".tab_links li a").each(function(){
				if (this == t){
					id = i;
				}
				i++;
			});
			show_tab(id);
			return false;
		});
	}
	
	window.setTimeout('show_next_tab()', 4000);
	
	//указываем одно или два фото в раздел до и после
	photospec_select();
	
	$(".photospec_select input").change(function(){
		photospec_select();
	});
	
	//подгрузка отзывов
	$('.show_next_page a').click(function(){
		type = $(this).parent().parent().attr('data-type');
		t = $(this).parent().parent();
		//alert(type);
		if (current_page[type] < pages_count[type]){
			$.ajax({
				url: $(this).attr('href'),
				success: function (response){
					$(t).parent().find('.next_page_container').append(response);
					current_page[type]++;
					if (current_page[type] == pages_count[type]){
						$(t).remove();
					} else {
						$(t).find('a').attr('href', $(t).find('a').attr('href').replace('page:' + current_page[type], 'page:' + (current_page[type] + 1)));
					}
					
				}
			});
		}
		return false;
	});
});

function photospec_select(){
	$(".photospec_select input[type=radio]").each(function(){
		if ($(this).prop("checked")){
			val = $(this).val();
		}
	});
	if (typeof(val) != "undefined"){
		if (val == 1){
			$(".photo_one").show();
			$(".photo_two").hide();
		} else {
			$(".photo_one").hide();
			$(".photo_two").show();
		}
	}
}

function show_next_tab(){
	if (auto_slide){
		next_tab = current_tab + 1;
		if ((next_tab + 1) > count_tabs){
			next_tab = 0;
		}
		show_tab(next_tab);
		window.setTimeout('show_next_tab()', 4000);
	}
}

function show_tab(id){
	i = 0;
	$(".tab_links li").removeClass("act");
	$(".tab_links li a").each(function(){
		if (i == id){
			$(this).parent().addClass("act");
		}
		i++;
	});
	current_tab = id;
	$(".tab_wrap > div").hide();
	$(".tab_wrap #item" + id).show();
}

function alert_message(mes){
	$("#alert span").text(mes);
	$("#alert").css("left", ($("body").width() - $("#alert").width())/2 + "px");
	$("#alert").slideDown(function(){
		setTimeout('$("#alert").slideUp();', 5000);
	})
}

function show_additional_field(){
	if ($(".service_list").val() == 0) {
		$(".additional_field").show();
	} else {
		$(".additional_field").hide();
	}
}

function hide_hint(){
	if (hide){
		$('.hint').hide();
	}
}

function set_hint_pos(pos, t){
	if ($(".hint").css("display") == "none"){
		$(".hint").show().css({
			top: pos.pageY + 5 + "px",
			left:  pos.pageX + 5 + "px"
		});
	}
}

function set_stars_note(t){
	$('.note').each(function(){
		$(this).find('.star').removeClass("active");
		$(this).parent().find('.note_comment').text('');
		if ($("#note_specialist").val() != ""){
			i = 0;
			note = $(this).parent().find(".note_specialist").val();
			$(this).find(".star").each(function(){
				if ((i + 1) <= note){
					$(this).addClass("active");
				}
				i++;
			});
			$(this).parent().find(".note_comment").text(notes[note]);
		}
	});
	
}