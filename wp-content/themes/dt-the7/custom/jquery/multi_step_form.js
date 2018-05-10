jQuery(document).ready(function($){
var count=0; // to count blank fields


/*---------------------------------------------------------*/

	
	$(".xdsoft_time").click(function(){           //Function runs on NEXT button click 
	$(this).parent().next().fadeIn('slow');
	$(this).parent().css({'display':'none'});
//Adding class active to show steps forward;
	$('.active').next().addClass('active');
	});
	
	$(".pre_btn").click(function(){            //Function runs on PREVIOUS button click 
	$(this).parent().prev().fadeIn('slow');
	$(this).parent().css({'display':'none'});
//Removing class active to show steps backward;
	$('.active:last').removeClass('active');
	});
});
