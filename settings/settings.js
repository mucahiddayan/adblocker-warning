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

	function init(){		
		overlay.css({
			backgroundColor : 'rgba('+hexToRgb(abw_settings.overlay_background_color)+','+abw_settings.overlay_opacity*5+')',			
		});

		abw.css({
			boxShadow : abw_settings.overlay_box_shadow_side +'px '+abw_settings.overlay_box_shadow_top+'px '+abw_settings.overlay_box_shadow_blur+'px '+abw_settings.overlay_box_shadow_spread+'px',			
			width: prv.width()-abw_settings.margin_side -21,
			margin: abw_settings.margin_top+'px 0px',
			marginLeft:+abw_settings.margin_side/2+'px',
		});
	}

	jQuery('.style').on('input',function(){
		// var id = jQuery(this).attr('id');
		var abw_margin_side = jQuery('#abw_margin_side').val(),
			abw_margin_top = jQuery('#abw_margin_top').val(),
			abw_overlay_background_color = jQuery('#abw_overlay_background_color').val(),
			abw_overlay_opacity = jQuery('#abw_overlay_opacity').val(),
			abw_overlay_box_shadow_side = jQuery('#abw_overlay_box_shadow_side').val(),
			abw_overlay_box_shadow_side = jQuery('#abw_overlay_box_shadow_side').val(),
			abw_overlay_box_shadow_top = jQuery('#abw_overlay_box_shadow_top').val(),
			abw_overlay_box_shadow_blur = jQuery('#abw_overlay_box_shadow_blur').val(),
			abw_overlay_box_shadow_spread = jQuery('#abw_overlay_box_shadow_spread').val();

		
		abw.css({			
			boxShadow : abw_overlay_box_shadow_side +'px '+abw_overlay_box_shadow_top+'px '+abw_overlay_box_shadow_blur+'px '+abw_overlay_box_shadow_spread+'px',			
			width: prv.width() - abw_margin_side - 21,
			margin: abw_margin_top+'px 0px',
			marginLeft:+abw_margin_side/2+'px',
		});

		overlay.css({
			backgroundColor: 'rgba('+hexToRgb(abw_overlay_background_color)+','+abw_overlay_opacity*5+')',
		});
	});

	init();
});