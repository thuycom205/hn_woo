'use strict';
jQuery(document).ready(function () {
	jQuery('#post').bind('submit', function (e) {

		// jQuery('.wlb-product').each(function () {
		// 	var i_val = jQuery(this).val();
		// 	if (!i_val) {
		// 		jQuery(this).focus();
		// 		jQuery('.wlb-error').html('Please select product');
		// 		var id = jQuery(this).closest('.wlb-data').attr('data-id');
		// 		if (id) {
		// 			jQuery('.wlb-node').removeClass('wlb-active');
		// 			jQuery('.wlb-data').removeClass('wlb-active');
		// 			jQuery('.wlb-node-' + id).addClass('wlb-active');
		// 			jQuery('.wlb-item-' + id).addClass('wlb-active');
		// 		}
		// 		e.preventDefault();
		// 	}
		// })
	});
	jQuery('.wlb-add-new').bind('click', function () {
		/*Add field*/
		var u_id = Date.now();
		var data = '<div class="wlb-data wlb-item-' + u_id + '" data-id="' + u_id + '">'
			+ '<div class="wlb-field">'
			+ '<input style="display: none" class="wlb-productx wlb-product-search" name="wlb_params[product_info][]" data-placeholder="Search your product"> </input>'
			+ '</div> <select class="wlb-product s_product_id" name="wlb_params[product_id][]"></select>'
			+ '<div class="wlb-field">'
			+ 'X <input class="wlb-x" type="number" name="wlb_params[x][]" value="0" min="0" max="100" step="0.01" />'
			+ 'Y <input class="wlb-y" type="number" name="wlb_params[y][]" value="0" min="0" max="100" step="0.01" />'
			+ '</div>'
			+ '<span class="wlb-remove">x</span>'
			+ '</div>';
		jQuery('.wlb-table').append(data);
		/*Add node*/
		var node_data = '<span class="wlb-node wlb-node-' + u_id + '" data-id="' + u_id + '">+</span>';
		jQuery('.wlb-image-container').append(node_data);
		jQuery('.s_product_id').selectize({
			maxItems: null,
			valueField: 'id',
			labelField: 'title',
			searchField: 'title',
			create: false,
			render: {
				option: function (item, escape) {
					var actors = [];
					for (var i = 0, n = item.length; i < n; i++) {
						actors.push('<span>' + escape(item[i].title) + '</span>');
					}

					return '<div>' +

						'<span class="title">' +
						'<span class="name">' + escape(item.title) + '</span>' +
						'</span>' +
						'</div>';
				},
				'item': function (data, escape) {
					return '<div class="item" ' + 'data-img="' + data.title + '"' + ' >' + escape(data.title) + '</div>';
				}
			},
			load: function (query, callback) {
				var data = {
					param: {
						q: query
					}
				}
				if (!query.length) return callback();
				jQuery.ajax({
					url: 'http://localhost:8069/pso/search_productx',
					type: 'POST',
					beforeSend: function (xhr) {
						xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
					},
					data: JSON.stringify(data),

					contentType: "application/json",
					error: function () {
						callback();
					},
					success: function (res) {
						console.log(res);
						callback(res.result);
					}
				});
			},
			onChange: function(value) {
				var self = this;

				var k = self.getValue();
				var si = self.$input;

				var inputDiv = si.next().find('.selectize-input');

				var productsArr = [];

				var inputC = inputDiv.find('.item');
				var productName = '';
				inputC.each(function (index) {
					var title = jQuery(this).attr('data-img');
					var value = jQuery(this).attr('data-value');
					productsArr.push({'title': title, 'id': value});
					productName = title;
				});
				var x = JSON.stringify(productsArr);
				var wpfield = self.$input.prev();
				var sel= wpfield.find('input');
				sel.val(productName);
				// core.bus.trigger('shopify_collection_changed', x);
			}
		});

		drag();

	});
	jQuery(".wlb-shortcode input").click(function () {
		jQuery(this).select();
	});

	function drag() {
		/*Select2 search product*/
		jQuery('.wlb-table .wlb-product-searchx').select2({
			placeholder       : "Please fill in your product title",
			ajax              : {
				url           : "admin-ajax.php?action=wlb_search_product",
				dataType      : 'json',
				type          : "GET",
				quietMillis   : 50,
				delay         : 250,
				data          : function (params) {
					return {
						keyword: params.term
					};
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache         : true
			},
			escapeMarkup      : function (markup) {
				return markup;
			}, // let our custom formatter work
			minimumInputLength: 1
		});
		/*Init drag node*/
		jQuery('.wlb-node').draggable({
			containment: '.wlb-image-container',
			cursor     : "crosshair",
			drag       : function (event, ui) {
				var image = jQuery(this).closest('.wlb-image-container');
				var width = image.width();
				var height = image.height();

				var xPos = (ui.position.left / width) * 100;
				var yPos = (ui.position.top / height) * 100;

				var id = jQuery(this).attr('data-id');
				if (id) {
					jQuery('.wlb-node').removeClass('wlb-active');
					jQuery('.wlb-data').removeClass('wlb-active');
					jQuery('.wlb-node-' + id).addClass('wlb-active');
					jQuery('.wlb-item-' + id).addClass('wlb-active');
					var item = jQuery('.wlb-item-' + id);
					item.find('.wlb-x').val(xPos.toFixed(2));
					item.find('.wlb-y').val(yPos.toFixed(2));
				}
			}
		});
		jQuery('.wlb-remove').unbind('click');
		jQuery('.wlb-remove').bind('click', function () {
			if (confirm("Would you want to remove this node?")) {
				var id = jQuery(this).closest('.wlb-data').attr('data-id');
				jQuery(this).closest('.wlb-data').remove();
				jQuery('.wlb-node-' + id).remove();
			}
		});
		jQuery('.wlb-node,.wlb-data').unbind('click');
		jQuery('.wlb-node,.wlb-data').bind('click', function () {
			var id = jQuery(this).attr('data-id');
			jQuery('.wlb-node').removeClass('wlb-active');
			jQuery('.wlb-data').removeClass('wlb-active');
			jQuery('.wlb-node-' + id).addClass('wlb-active');
			jQuery('.wlb-item-' + id).addClass('wlb-active');
		})
		jQuery('.wlb-x,.wlb-y').unbind('change');
		jQuery('.wlb-x,.wlb-y').bind('change', function () {
			var pos_x = jQuery(this).closest('.wlb-data').find('.wlb-x').val();
			var pos_y = jQuery(this).closest('.wlb-data').find('.wlb-y').val();

			jQuery('.wlb-node.wlb-active').css({
				'left': pos_x + '%',
				'top' : pos_y + '%'
			})
		});
	}

	/*Init node*/
	function init() {
		drag();
		// Set all variables to be used in scope
		var frame,
			metaBox = jQuery('#woocommerce-lookbook.postbox'), // Your meta box id here
			addImgLink = metaBox.find('.wlb-upload-img'),
			delImgLink = metaBox.find('.wlb-delete-img'),
			imgContainer = metaBox.find('.wlb-image-container'),
			imgIdInput = metaBox.find('.wlb-image-data');

		// ADD IMAGE LINK
		addImgLink.on('click', function (event) {

			event.preventDefault();

			// If the media frame already exists, reopen it.
			if (frame) {
				frame.open();
				return;
			}

			// Create a new media frame
			frame = wp.media({
				title   : 'Select or Upload Media',
				button  : {
					text: 'Use image'
				},
				multiple: false  // Set to true to allow multiple files to be selected
			});


			// When an image is selected in the media frame...
			frame.on('select', function () {

				// Get media attachment details from the frame state
				var attachment = frame.state().get('selection').first().toJSON();

				// Send the attachment URL to our custom image input field.
				imgContainer.append('<img class="wlb-image" src="' + attachment.url + '" alt="" style="max-width:100%;"/>');

				// Send the attachment id to our hidden input
				imgIdInput.val(attachment.id);

				// Hide the add image link
				addImgLink.addClass('hidden');

				// Unhide the remove image link
				delImgLink.removeClass('hidden');
			});

			// Finally, open the modal on click
			frame.open();
		});


		// DELETE IMAGE LINK
		delImgLink.on('click', function (event) {

			event.preventDefault();

			// Clear out the preview image
			imgContainer.html('');

			// Un-hide the add image link
			addImgLink.removeClass('hidden');

			// Hide the delete image link
			delImgLink.addClass('hidden');

			// Delete the image id from the hidden input
			imgIdInput.val('');
			jQuery('.wlb-table').html('');

		});

	}

	init();
	jQuery('.s_product_id_updated').each(function (index,element) {
		var initvalue =[];
		var initval=[];
		var obj = {};
		try {
			var productid = jQuery(this).attr('data-productid');
			var productname = jQuery(this).attr('data-productname');
			obj.title = productname;
			obj.id = productid;
			initvalue.push(obj);
			initval.push(productid);
		} catch (e) {

		}

		jQuery(this).selectize({
			maxItems: null,
			valueField: 'id',
			labelField: 'title',
			searchField: 'title',
			items: initval,
			options:initvalue,

			create: false,
			render: {
				option: function (item, escape) {
					var actors = [];
					for (var i = 0, n = item.length; i < n; i++) {
						actors.push('<span>' + escape(item[i].title) + '</span>');
					}

					return '<div>' +

						'<span class="title">' +
						'<span class="name">' + escape(item.title) + '</span>' +
						'</span>' +
						'</div>';
				},
				'item': function (data, escape) {
					return '<div class="item" ' + 'data-img="' + data.title + '"' + ' >' + escape(data.title) + '</div>';
				}
			},
			load: function (query, callback) {
				var data = {
					param: {
						q: query
					}
				}
				if (!query.length) return callback();
				jQuery.ajax({
					url: 'http://localhost:8069/pso/search_productx',
					type: 'POST',
					beforeSend: function (xhr) {
						xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
					},
					data: JSON.stringify(data),

					contentType: "application/json",
					error: function () {
						callback();
					},
					success: function (res) {
						console.log(res);
						callback(res.result);
					}
				});
			},
			onChange: function(value) {
				var self = this;

				var k = self.getValue();
				var si = self.$input;

				var inputDiv = si.next().find('.selectize-input');

				var productsArr = [];

				var inputC = inputDiv.find('.item');
				var productName = '';
				inputC.each(function (index) {
					var title = jQuery(this).attr('data-img');
					var value = jQuery(this).attr('data-value');
					productsArr.push({'title': title, 'id': value});
					productName = title;
				});
				var x = JSON.stringify(productsArr);
				var wpfield = self.$input.prev();
				var sel= wpfield.find('input');
				sel.val(productName);
				// core.bus.trigger('shopify_collection_changed', x);
			}
		});

	})
});