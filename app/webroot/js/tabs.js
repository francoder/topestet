$.fn.tabs = function() {
	var selector = this;
	
	this.each(function() {
		var obj = $(this); 
		
		$(obj.attr('href')).hide();
		
		$(obj).click(function() {
			$(selector).removeClass('selected');
			
			$(selector).each(function(i, element) {
				$($(element).attr('href')).hide().removeClass('tab-active');
			});
			
			$(this).addClass('selected');
			
			$($(this).attr('href')).fadeIn().addClass('tab-active');
			
			return false;
		});
	});

	$(this).show();
	
	$(this).first().click();
	if(location.hash!='' && $('a[href="' + location.hash + '"]').length)
		$('a[href="' + location.hash + '"]').click();	
};