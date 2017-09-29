console.log(abw_settings);
jQuery(document).ready(function(){
	var preview = `<div title="preview" id="preview-wrapper">
						<div id="preview" style="">
							<div class="overlay"></div>
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
});