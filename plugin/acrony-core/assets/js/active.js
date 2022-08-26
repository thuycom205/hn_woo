(function ($) {
    "use strict";
    $(document).on('ready', function () {        
        $(".post-photo-gallery").owlCarousel({
            'items': 1,
            'singleItem': true,
            'slideSpeed': 1000,
            'paginationSpeed': 1000,
            'rewindSpeed': 1000,
            'autoPlay': true,
            'navigation': true,
            'navigationText': ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
            'pagination': false,
            'responsive': true
        });
        $('.owl-controls .owl-buttons > div.owl-prev').html('<i class="fa fa-arrow-left"></i>');
        $('.owl-controls .owl-buttons > div.owl-next').html('<i class="fa fa-arrow-right"></i>');
        $('.gallery-item .gallery-icon a').attr('rel', 'prettyPhoto').addClass('kc-pretty-photo');
        
        
    });
    
    
    // JavaScript for label effects only
	$(window).load(function(){
		$(".contactform2 .input-box .form-input").val("");		
		$(".contactform2 .input-box .form-input").on('focus',function(){
            $(this).parents('.input-box').addClass("focus");
        });
		$(".contactform2 .input-box .form-input").on('focusout',function(){
            $(this).parents('.input-box').removeClass("focus");            
			if( $(this).val() == "" ){
				$(this).parents('.input-box').removeClass("has-content");
			}else{
				$(this).parents('.input-box').addClass("has-content");
			}
		});
	});

}(jQuery));