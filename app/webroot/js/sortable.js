jQuery.fn.tableSort = function(options){
	var sorted_type = false;
	var sorted_column = false;
	var table = this;
	
	$(this).find("thead th span").click(function(){
		line = this;
		//определяем ячейку по которой кликнули
		column_to_sort = false;
		j = 1;
		$(table).find("thead th span").each(function(){
			if (this == line) {
				column_to_sort = j;
			}
			j++;
		});
		return do_sort(column_to_sort);
	});
	
	function do_sort(column_to_sort){
		column_content = new Array();
		content_sorted = new Array();
		numbers_sorted = new Array();
		table_lines = new Array();
		
		if (sorted_column == column_to_sort && sorted_type == 1){
			sorted_type = -1;
		} else {
			sorted_type = 1;
		}
		$(table).find("thead th").removeClass("headerSortUp");
		$(table).find("thead th").removeClass("headerSortDown");
		
		//сбор данных для сортировки
		i = 0;
		$(table).find("tbody tr").each(function(){
			value = ($(this).find("td:nth-child(" + column_to_sort + ")").attr("data-value"));
			if (!value){
				value = $(this).find("td:nth-child(" + column_to_sort + ")").text();
			}
			if (value == value * 1){
				value = value * 1;
			}
			column_content[i] = value;
			numbers_sorted[i] = i;
			table_lines[i] = "<tr>" + $(this).html() + "</tr>";
			i++;
		});
		
		//пошла сортировка
		content_sorted = column_content;
		for (i = 0; i < content_sorted.length + 1; i++){
			etalon = content_sorted[i];
			etalon_number = i;
			for (j = i + 1; j < content_sorted.length + 1; j++){
				if ((sorted_type == 1 && content_sorted[j] < content_sorted[i]) || (sorted_type == -1 && content_sorted[j] > content_sorted[i])){
					chair = content_sorted[i];
					content_sorted[i] = content_sorted[j];
					content_sorted[j] = chair;
					
					chair = numbers_sorted[i];
					numbers_sorted[i] = numbers_sorted[j];
					numbers_sorted[j] = chair;
				}
			}
		}
		
		//применяем сортировку
		sorted_column = column_to_sort;
		$(table).find("tbody tr").remove();
		for (i = 0; i < numbers_sorted.length + 1; i++){
			$(table).find("tbody").append(table_lines[numbers_sorted[i]]);
		}
		if (sorted_type == 1){
			$(table).find("thead th:nth-child(" + column_to_sort + ")").addClass("headerSortUp");
		} else {
			$(table).find("thead th:nth-child(" + column_to_sort + ")").addClass("headerSortDown");
		}
	}
}