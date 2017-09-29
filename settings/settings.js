console.log(abw_settings);
var hexToRgb = function (hex){
	var c;
	if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
		c= hex.substring(1).split('');
		if(c.length== 3){
			c= [c[0], c[0], c[1], c[1], c[2], c[2]];
		}
		c= '0x'+c.join('');
		return [(c>>16)&255, (c>>8)&255, c&255].join(',');
	}
	throw new Error('Bad Hex');
}
jQuery(document).ready(function(){
	var preview = `<div title="preview" id="preview-wrapper" class="body">
	<div id="preview" class="main-content" style="">
	<div id="overlay"></div>
	<div id="abw">Adblocker</div>
	</div>
	</div>`;

	var resetButtons = `<div id="button-container">
	<button id="reset_styles" class="reset_buttons">Reset Style</button>
	<button id="set_defaults" class="reset_buttons">Set Defaults</button>
	</div>`;

	jQuery('form').after(resetButtons).css({});

	jQuery(preview).appendTo('body.toplevel_page_adblocker-warning').css({
		position:'absolute',
		top: 300,
		right: 50,
		width: 250,
		height: 250,
		'box-shadow': '0px 0px 1px 0px',
		background: '#fff'
	});

	var abw = jQuery('#abw'),
	prv = jQuery('#preview'),
	overlay = jQuery('#overlay');

	var defaults = {
		margin_side: 20,
		margin_top : 0,
		overlay_background_color : '#ffffff',
		overlay_opacity : 0,
		overlay_box_shadow_side: 0,
		overlay_box_shadow_top: 40,
		overlay_box_shadow_blur: 60,
		overlay_box_shadow_spread : 0
	};
	
	var current = {	
		margin_side:jQuery('#abw_margin_side').val(),
		margin_top : jQuery('#abw_margin_top').val(),
		overlay_background_color 	: jQuery('#abw_overlay_background_color').val(),
		overlay_opacity : jQuery('#abw_overlay_opacity').val(),
		overlay_box_shadow_side:jQuery('#abw_overlay_box_shadow_side').val(),
		overlay_box_shadow_top: jQuery('#abw_overlay_box_shadow_top').val(),
		overlay_box_shadow_blur:jQuery('#abw_overlay_box_shadow_blur').val(),
		overlay_box_shadow_spread : jQuery('#abw_overlay_box_shadow_spread').val(),
	};

	jQuery('.reset_buttons').click(function(){
		switch (jQuery(this).attr('id')) {
			case 'reset_styles':
			reset_styles();
			break;
			case 'set_defaults':
			set_defaults();
			break;
		}
	});

	function set_defaults(){
		setStyle(defaults);
		set_inputs(defaults);
	}

	function set_inputs(obj){
		for(let o in obj){
			jQuery('#abw_'+o).val(obj[o]).trigger('input');
		}
	}

	function reset_styles(){
		setStyle(current);
		set_inputs(current);
	}

	function init(){		
		setStyle(abw_settings);		
	}

	jQuery('.style').on('input',function(){
		// var id = jQuery(this).attr('id');
		var el = {
			margin_side: jQuery('#abw_margin_side').val(),
			margin_top : jQuery('#abw_margin_top').val(),
			overlay_background_color : jQuery('#abw_overlay_background_color').val(),
			overlay_opacity : jQuery('#abw_overlay_opacity').val(),
			overlay_box_shadow_side: jQuery('#abw_overlay_box_shadow_side').val(),
			overlay_box_shadow_top: jQuery('#abw_overlay_box_shadow_top').val(),
			overlay_box_shadow_blur: jQuery('#abw_overlay_box_shadow_blur').val(),
			overlay_box_shadow_spread : jQuery('#abw_overlay_box_shadow_spread').val()
		};

		setStyle(el);		
	});

	var setStyle = function(style){
		abw.css({			
			boxShadow : style.overlay_box_shadow_side +'px '+style.overlay_box_shadow_top+'px '+style.overlay_box_shadow_blur+'px '+style.overlay_box_shadow_spread+'px',			
			width: prv.width() - style.margin_side - 21,
			margin: style.margin_top+'px 0px',
			marginLeft:+style.margin_side/2+'px',
		});

		overlay.css({
			backgroundColor: 'rgba('+hexToRgb(style.overlay_background_color)+','+style.overlay_opacity*5+')',
		});
	}

	init();
});