( function($){
    var DLAnimatedGradientBG = function( el, ) {
        if ( ! el.hasClass('dl-animated-gradient-bg-yes') ) {
            return;
        }

        var color = el.data('gradient-colors'),
            angle = el.data('gradient-angle'),
            gradientColor = 'linear-gradient(' + angle + ', ' + color + ')';
        
        el.css( 'background-image', gradientColor );
    };

    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/global', DLAnimatedGradientBG );
    } );
}( jQuery ) );