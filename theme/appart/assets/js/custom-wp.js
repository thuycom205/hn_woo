(function ($) {
    "use strict";

    var product_title = $('.product_content .pr_title');
    var price = $('.product_content .pr_price');
    $('.product_content').prepend(price).prepend(product_title);

    $('.menu-item-has-children').addClass('dropdown submenu nav-item');
    $('.menu-item-has-children a.main-menu-link').addClass('dropdown-toggle').attr('id', 'navbarDropdown').attr('data-toggle', 'dropdown').attr('role', 'button').attr('aria-haspopup', 'true').attr('aria-expanded', 'false');
    $('.b_features_content>p a').addClass('banner_btn btn-white');

})(jQuery);