(function ($) {
    "use strict";

    if($(window).width() > 1920) {
        $('#hero_shape2_4k').show();
        $('#hero_shape2_normal').remove();
    }
    else if($(window).width() < 1920) {
        $('#hero_shape2_4k').remove();
        $('#hero_shape2_normal').show();
    }

})(jQuery);