$(function() {	
	if ($('.tabslider').size() > 0) {
		$(".tab_wrap .tab_content").each(function(n) {
			$(this).attr("id", "item"+n);
		});
		
	/*	var pause = 2000,
		    durationPause = 100;
		$(".tab_wrap").carouFredSel({
			circular	: true,
			auto 		: true,
			direction   : "up",
			items       : 1,
			auto    : {
	        onAfter : function(oldItems, newItems) {
				var itemId = $(newItems).attr('id').substr(4);
				if ($.browser.mozilla){
				}
				else {
					var itemId = $(newItems).attr('id').substr(4);
				}
	            $('.tab_links a').eq(itemId).parent().addClass('act').siblings().removeClass('act');	
	        	}
	    	},
			scroll : {
			items : 1,
			fx : "none",
				duration : durationPause,
				pauseDuration : pause
		    }
		});
		$(".tab_wrap").trigger("linkAnchors", [".tab_links", "a"]);

		$('.tab_links a').click(function(){
		  $(this).parent().addClass('act').siblings().removeClass('act');
		  return false;
		});
		$('.tab_links a').hover(function(){
			$(".caroufredsel_wrapper").stop(true,true)
		})
		
		function get_option() {
	    var opt  = 'auto',
	        sub  = 'play' || "";
	    if (sub.length) {
	        opt += "."+sub;
	    }
	    return opt;
	} */
	}
	
	$('.tab_links li').click(function () {
       var num = Number($(this).index());
       $('.tab_content').css('display', 'none');
       $('#item'+num).css('display', 'block');
       $('.tab_links li').removeClass('act');
       $(this).addClass('act');
       return false;		
   });
});