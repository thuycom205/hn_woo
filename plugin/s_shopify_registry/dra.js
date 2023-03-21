jQuery(document).on('submit', 'form.AjaxForm').submit(function () {
    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        dataType: 'json',
        data: $(this).serialize(),
        success: function (data) {
            alert('Submitted');
        },
        error: function (xhr, err) {
            alert('Error');
        }
    });

    function initCss(e) {
window.AllFetchURL = 'https://app.thexseed.com';
        var t = document.createElement("link");
        t.setAttribute("rel", "stylesheet"), t.setAttribute("type", "text/css"),
            t.onload = e, t.setAttribute("href", window.AllFetchURL + "/s_shopify_registry/static/src/bootstrap-polaris.min.css"), document.head.appendChild(t)
    }    function initCss2(e) {
window.AllFetchURL = 'https://app.thexseed.com';
        var t = document.createElement("link");
        t.setAttribute("rel", "stylesheet"), t.setAttribute("type", "text/css"),
            t.onload = e, t.setAttribute("href", window.AllFetchURL + "/s_shopify_registry/static/src/o_backend.css"), document.head.appendChild(t)
    }

initCss();
    initCss2();


    (function($) {
    $.extend($.fn, {
        makeCssInline: function() {
            this.each(function(idx, el) {
                var style = el.style;
                var properties = [];
                for(var property in style) {
                    if($(this).css(property)) {
                        properties.push(property + ':' + $(this).css(property));
                    }
                }
                this.style.cssText = properties.join(';');
                $(this).children().makeCssInline();
            });
        }
    });
}(jQuery));

    $('.Polaris-Heading').makeCssInline();
    $('.Polaris-Layout__AnnotationDescription').makeCssInline();

    $('.o_filter_menu').makeCssInline();
    $('.o_dropdown_toggler_btn').makeCssInline();
    $('.o_dropdown_title').makeCssInline();
    $('i').makeCssInline();


    	var registry_setting = $('a[data-menu-xmlid= "x"]');

			if (registry_setting.length > 0) {
			  registry_setting.click(function(e) {
				e.preventDefault();
			    alert('test');
			});
			}
