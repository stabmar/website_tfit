jQuery(document).ready(function($) {
 
	Color.prototype.toString = function(remove_alpha) {
		if (remove_alpha == 'no-alpha') {
			return this.toCSS('rgba', '1').replace(/\s+/g, '');
		}
		if (this._alpha < 1) {
			return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
		}
		var hex = parseInt(this._color, 10).toString(16);
		if (this.error) return '';
		if (hex.length < 6) {
			for (var i = 6 - hex.length - 1; i >= 0; i--) {
				hex = '0' + hex;
			}
		}
		return '#' + hex;
	};
	 
	  $('.pluto-color-control').each(function() {
		var $control = $(this),
			value = $control.val().replace(/\s+/g, '');
		// Manage Palettes
		var palette_input = $control.attr('data-palette');
		if (palette_input == 'false' || palette_input == false) {
			var palette = false;
		} else if (palette_input == 'true' || palette_input == true) {
			var palette = true;
		} else {
			var palette = $control.attr('data-palette').split(",");
		}
		$control.wpColorPicker({ // change some things with the color picker
			 clear: function(event, ui) {
			// TODO reset Alpha Slider to 100
			 },
			change: function(event, ui) {
				// send ajax request to wp.customizer to enable Save & Publish button
				if( typeof ui.color != 'undefined' ) {
					var _new_value = ui.color.toString();
				} else {
					var _new_value = $control.val();
				}
				var key = $control.attr('data-customize-setting-link');
				wp.customize(key, function(obj) {
					obj.set(_new_value);
				});
				// change the background color of our transparency container whenever a color is updated
				var $transparency = $control.parents('.wp-picker-container:first').find('.transparency');
				// we only want to show the color at 100% alpha
				$transparency.css('backgroundColor', ui.color.toString('no-alpha'));
			},
			palettes: palette // remove the color palettes
		});
		$('<div class="pluto-alpha-container"><div class="slider-alpha"></div><div class="transparency"></div></div>').appendTo($control.parents('.wp-picker-container'));
		var $alpha_slider = $control.parents('.wp-picker-container:first').find('.slider-alpha');
		// if in format RGBA - grab A channel value
		if (value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)) {
			var alpha_val = parseFloat(value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)[1]) * 100;
			var alpha_val = parseInt(alpha_val);
		} else {
			var alpha_val = 100;
		}
		$alpha_slider.slider({
			slide: function(event, ui) {
				$(this).find('.ui-slider-handle').text(ui.value); // show value on slider handle
				// send ajax request to wp.customizer to enable Save & Publish button
				var _new_value = $control.val();
				var key = $control.attr('data-customize-setting-link');
				wp.customize(key, function(obj) {
					obj.set(_new_value);
				});
			},
			create: function(event, ui) {
				var v = $(this).slider('value');
				$(this).find('.ui-slider-handle').text(v);
			},
			value: alpha_val,
			range: "max",
			step: 1,
			min: 1,
			max: 100
		}); // slider
		$alpha_slider.slider().on('slidechange', function(event, ui) {
			var new_alpha_val = parseFloat(ui.value),
				iris = $control.data('a8cIris'),
				color_picker = $control.data('wpWpColorPicker');
			iris._color._alpha = new_alpha_val / 100.0;
			$control.val(iris._color.toString());
			color_picker.toggler.css({
				backgroundColor: $control.val()
			});
			// fix relationship between alpha slider and the 'side slider not updating.
			var get_val = $control.val();
			$($control).wpColorPicker('color', get_val);
		});
	});
	
	/* Move our focus widgets in the our focus panel */
	wp.customize.section( 'sidebar-widgets-sidebar-ourfocus' ).panel( 'panel_4' );
	wp.customize.section( 'sidebar-widgets-sidebar-ourfocus' ).priority( '4' );
	
	/* Move our team widgets in the our team panel */
	wp.customize.section( 'sidebar-widgets-sidebar-ourteam' ).panel( 'panel_7' );
	wp.customize.section( 'sidebar-widgets-sidebar-ourteam' ).priority( '4' );
	
	/* Move testimonial widgets in the testimonials panel */
	wp.customize.section( 'sidebar-widgets-sidebar-testimonials' ).panel( 'panel_8' );
	wp.customize.section( 'sidebar-widgets-sidebar-testimonials' ).priority( '5' );
	
	/* Move about us widgets in the about us panel */
	wp.customize.section( 'sidebar-widgets-sidebar-aboutus' ).panel( 'panel_6' );
	wp.customize.section( 'sidebar-widgets-sidebar-aboutus' ).priority( '8' );
	
	/* Move packages widgets in the packages panel */
	wp.customize.section( 'sidebar-widgets-sidebar-packages' ).panel( 'panel_11' );
	wp.customize.section( 'sidebar-widgets-sidebar-packages' ).priority( '5' );
	
	/* Move Subscribe widgets in the subscribe panel */
	wp.customize.section( 'sidebar-widgets-sidebar-subscribe' ).panel( 'panel_13' );
	wp.customize.section( 'sidebar-widgets-sidebar-subscribe' ).priority( '4' );
	
	/* Move Footer widgets in the footer panel */
	wp.customize.section( 'sidebar-widgets-zerif-sidebar-footer' ).panel( 'panel_2' );
	wp.customize.section( 'sidebar-widgets-zerif-sidebar-footer' ).priority( '100' );
	
	wp.customize.section( 'sidebar-widgets-zerif-sidebar-footer-2' ).panel( 'panel_2' );
	wp.customize.section( 'sidebar-widgets-zerif-sidebar-footer-2' ).priority( '101' );
	
	wp.customize.section( 'sidebar-widgets-zerif-sidebar-footer-3' ).panel( 'panel_2' );
	wp.customize.section( 'sidebar-widgets-zerif-sidebar-footer-3' ).priority( '102' );
	
	/* Tooltips for General Options */
	jQuery('#customize-control-zerif_use_safe_font label').append('<span class="dashicons dashicons-info zerif-moreinfo-icon"></span><div class="zerif-moreinfo-content">Zerif PRO main font is Montserrat, which only supports the Latin script. <br><br> If you are using other scripts like Cyrillic or Greek , you need to check this box to enable the safe fonts for better compatibility.</div>');
	
	jQuery('#customize-control-zerif_disable_smooth_scroll label').append('<span class="dashicons dashicons-info zerif-moreinfo-icon"></span><div class="zerif-moreinfo-content">Smooth scrolling can be very useful if you read a lot of long pages. Normally, when you press Page Down, the view jumps directly down one page. <br><br>With smooth scrolling, it slides down smoothly, so you can see how much it scrolls. This makes it easier to resume reading from where you were before.<br><br>By checking this box, the smooth scroll will be disabled.</div>');
	
	jQuery('#customize-control-zerif_disable_preloader label').append('<span class="dashicons dashicons-info zerif-moreinfo-icon"></span><div class="zerif-moreinfo-content">The preloader is the circular progress element that first appears on the site. When the loader finishes its progress animation, the whole page elements are revealed. <br><br>The preloader is used as a creative way to make waiting a bit less boring for the visitor.<br><br>By checking this box, the preloader will be disabled.</div>');
	
	jQuery('#customize-control-zerif_accessibility label').append('<div class="dashicons dashicons-info zerif-moreinfo-icon"></div><div class="zerif-moreinfo-content">Web accessibility means that people with disabilities can use the Web. More specifically, Web accessibility means that people with disabilities can perceive, understand, navigate, and interact with the Web, and that they can contribute to the Web. <br><br>Web accessibility also benefits others, including older people with changing abilities due to aging.<br><br>By checking this box, you will enable this option on the site.</div>');

	jQuery('.zerif-moreinfo-icon').hover(function() {
		jQuery(this).next('.zerif-moreinfo-content').show();
	},function(){
		jQuery(this).next('.zerif-moreinfo-content').hide();
	});


	/*JS for shortcode section*/


	/********************************************
	 *** Generate uniq id ***
	 *********************************************/
	function zerif_uniqid(prefix, more_entropy) {

		if (typeof prefix === 'undefined') {
			prefix = '';
		}

		var retId;
		var formatSeed = function(seed, reqWidth) {
			seed = parseInt(seed, 10)
				.toString(16); // to hex str
			if (reqWidth < seed.length) { // so long we split
				return seed.slice(seed.length - reqWidth);
			}
			if (reqWidth > seed.length) { // so short we pad
				return Array(1 + (reqWidth - seed.length))
						.join('0') + seed;
			}
			return seed;
		};

		// BEGIN REDUNDANT
		if (!this.php_js) {
			this.php_js = {};
		}
		// END REDUNDANT
		if (!this.php_js.uniqidSeed) { // init seed with big random int
			this.php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
		}
		this.php_js.uniqidSeed++;

		retId = prefix; // start with prefix, add current milliseconds hex string
		retId += formatSeed(parseInt(new Date()
				.getTime() / 1000, 10), 8);
		retId += formatSeed(this.php_js.uniqidSeed, 5); // add seed hex string
		if (more_entropy) {
			// for more entropy we add a float lower to 10
			retId += (Math.random() * 10)
				.toFixed(8)
				.toString();
		}

		return retId;
	}


	/********************************************
	 *** General Repeater ***
	 *********************************************/

	var entityMap = {
		"&": "&amp;",
		"<": "&lt;",
		">": "&gt;",
		'"': '&quot;',
		"'": '&#39;',
		"/": '&#x2F;',
	};

	function escapeHtml(string) {
		string = String(string).replace(new RegExp('\r?\n','g'), '<br />');
		string = String(string).replace(/\\/g,'&#92;');
		return String(string).replace(/[&<>"'\/]/g, function (s) {
			return entityMap[s];
		});

	}

	function zerif_refresh_general_control_values(){
		jQuery(".zerif_general_control_repeater").each(function(){
			var values = [];
			var th = jQuery(this);
			th.find(".zerif_general_control_repeater_container").each(function(){

				var title = jQuery(this).find(".zerif_title_control").val();
				var subtitle = jQuery(this).find(".zerif_subtitle_control").val();
				var id = jQuery(this).find(".zerif_box_id").val();
				var color = jQuery(this).find(".zerif_color_control").val();
				var opacity = jQuery(this).find(".zerif_opacity_control").val();
				var text_color = jQuery(this).find(".zerif_text_color_control").val();
				if( !id ){
					id = 'zerif_' + zerif_uniqid();
					jQuery(this).find(".zerif_box_id").val(id);
				}
				var shortcode = jQuery(this).find(".zerif_shortcode_control").val();

				if( title!='' || subtitle!='' || shortcode!='' ){
					values.push({
						"title" : escapeHtml(title),
						"subtitle" : escapeHtml(subtitle),
						"color" : color,
						"id" : id,
						"shortcode" : escapeHtml(shortcode),
						"opacity" : opacity,
						"text_color" : text_color 
					});
				}

			});
			th.find('.zerif_repeater_colector').val(JSON.stringify(values));
			th.find('.zerif_repeater_colector').trigger('change');
		});
	}




		jQuery('#customize-theme-controls').on('click','.zerif-customize-control-title',function(){
			jQuery(this).next().slideToggle('medium', function() {
				if (jQuery(this).is(':visible'))
					jQuery(this).css('display','block');
			});
		});




		/**
		 * This adds a new box to repeater
		 *
		 */
		jQuery("#customize-theme-controls").on("click", ".zerif_general_control_new_field",function(){
			var th = jQuery(this).parent();
			var id = 'zerif_' + zerif_uniqid();
			if( typeof th != 'undefined' ) {
				/* Clone the first box*/
				var field = th.find(".zerif_general_control_repeater_container:first").clone();

				if( typeof field != 'undefined' ){

					/*Show delete box button because it's not the first box*/
					field.find(".zerif_general_control_remove_field").show();

					/*Set box id*/
					field.find(".zerif_box_id").val(id);

					/* Remove value from text color field */
					field.find(".zerif_text_color_control").val('#000000');

					/* Remove value from color field */
					field.find(".zerif_color_control").val('#ffffff');

					/* Remove value from opacity field */
					field.find(".zerif_opacity_control").val('');

					/*Remove value from title field*/
					field.find(".zerif_title_control").val('');

					/*Remove value from subtitle field*/
					field.find(".zerif_subtitle_control").val('');

					/*Remove value from shortcode field*/
					field.find(".zerif_shortcode_control").val('');

					/*Append new box*/
					th.find(".zerif_general_control_repeater_container:first").parent().append(field);

					/*Refresh values*/
					zerif_refresh_general_control_values();
				}

			}
			return false;
		});



		jQuery("#customize-theme-controls").on("click", ".zerif_general_control_remove_field",function(){
			if( typeof	jQuery(this).parent() != 'undefined'){
				jQuery(this).parent().parent().remove();
				zerif_refresh_general_control_values();
			}
			return false;
		});


		jQuery("#customize-theme-controls").on('keyup', '.zerif_title_control',function(){
			zerif_refresh_general_control_values();
		});

		jQuery("#customize-theme-controls").on('keyup', '.zerif_subtitle_control',function(){
			zerif_refresh_general_control_values();
		});

		jQuery("#customize-theme-controls").on('keyup', '.zerif_shortcode_control',function(){
			zerif_refresh_general_control_values();
		});

		jQuery("#customize-theme-controls").on('change', '.zerif_text_color_control',function(){
			zerif_refresh_general_control_values();
		});
	
		jQuery("#customize-theme-controls").on('change', '.zerif_color_control',function(){
			zerif_refresh_general_control_values();
		});

		jQuery("#customize-theme-controls").on('change', '.zerif_opacity_control',function(){
			zerif_refresh_general_control_values();
		});


		/*Drag and drop to change icons order*/

		jQuery(".zerif_general_control_droppable").sortable({
			update: function( event, ui ) {
				zerif_refresh_general_control_values();
			}
		});


});
