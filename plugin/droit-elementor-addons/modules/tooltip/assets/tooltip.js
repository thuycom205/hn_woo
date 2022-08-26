; (function ($) {
	'use strict';
    var $window = $(window);
    $window.on('elementor/frontend/init', function () {
        var dlTooltipOptions = [];
        var dlToolTip = elementorModules.frontend.handlers.Base.extend({
            onInit: function () {
				elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
				if (this.$element.hasClass('dl-free-tooltip-enable')) {
					this.$element.append("<span class='dl-free-tooltip-content'></span>");
					this.init();
				}
			},

            getReadySettings: function () {
				var settings = {
					trigger: this.getElementSettings('dl_free_tooltip_trigger'),
					content: this.getElementSettings('dl-free-tooltip-content'),
					animation: this.getElementSettings('dl_free_tooltip_animation'),
					duration: this.getElementSettings('dl_free_tooltip_duration') || 500,
					showArrow: this.getElementSettings('dl_free_tooltip_arrow') || false,
					position: this.getElementSettings('dl_free_tooltip_position'),
				};

				return $.extend({}, settings);
			},

            init: function () {
                var $scope = this.$element;

                if (this.$element.hasClass("dl-free-tooltip-enable")) {
                    
                    dlTooltipOptions = this.getReadySettings();

                    var content = $scope.find('.dl-free-tooltip-content');
                    content.html($.parseHTML(dlTooltipOptions.content));
                    content.css('animation-duration', dlTooltipOptions.duration + 'ms');
                    content.addClass(dlTooltipOptions.animation);

                    if (!dlTooltipOptions.showArrow) {
						content.addClass('no-arrow');
					}

                    if (dlTooltipOptions.trigger == 'click') {
						this.$element.on('click', function () {
							if (content.hasClass('show')) {
								content.removeClass('show');
							} else {
								content.addClass('show');
							}
						});
					}
                    else if (dlTooltipOptions.trigger == 'hover') {
						this.$element.on('mouseenter', function () {
							content.addClass('show');
						});
						this.$element.on('mouseleave', function () {
							content.removeClass('show');
						});
					}
                }
            }
        });

        elementorFrontend.hooks.addAction(
			'frontend/element_ready/widget', 
			function ($scope) {
				elementorFrontend.elementsHandler.addHandler(dlToolTip, {
					$element: $scope,
				});
			}
		);

    });

}(jQuery));