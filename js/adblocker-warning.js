//public variable
var __abw;
(function(){
	console.log('adblocker_warning.js loaded');
	var isEmpty = function($var) {
		var result;
		result = (Array.isArray($var)) ? ($var.length < 1 ? true : false)
		: ($var == 'undefined' || typeof $var == 'undefined'
			|| $var == null || $var == '') ? true : false;
		return result;
	}	

	function detectAdBlocker(){
		
		var args = arguments;
		var argumentsLength = arguments.length;
		var adBlockEnabled = false;
		var testAd = document.createElement('div');
		testAd.innerHTML = '&nbsp;';
		testAd.className = 'adsbox';
		document.body.appendChild(testAd);
		window.setTimeout(function() {
			if (typeof testAd == 'undefined') {
				adBlockEnabled = true;
			}
			if (testAd.offsetHeight === 0) {
				adBlockEnabled = true;
			}
			testAd.remove();			
			if (argumentsLength > 0) {
				if (!isEmpty(args[0]) && adBlockEnabled) {
					if (typeof args[0] == 'function') {
						args[0]();	
					}
					else{
						if(__dev){console.error('Passed parameter must be a function');}
						return;
					}					
				}
				if (!isEmpty(args[1])  && typeof args[1] == 'function' && !adBlockEnabled) {
					if (typeof args[1] == 'function') {
						args[1]();	
					}
					else{
						if(__dev){console.error('Passed parameter must be a function');}
						return;
					}
				}
			}else{
				if(__dev){console.debug('You have not defined any callback function');}
			}			
		}, 100);		
	}

	var getParams = function(){
		try{
			var temp = $.ajax(location.origin+'/wp-content/plugins/adblocker-warning/translation_array.php',{
				method: 'POST',
				async:false,
				data: {
					'func':'adblocker_warning'
				}
			}).done(res=>res);

			return JSON.parse(temp.responseText);
		}catch(e){
			console.log(e);
		}
	}

	if(isEmpty(YWRibG9ja2VyX3dhcm5pbmc)){
		console.warn('Adblocker Warning Page','=>','Variablen konnten nicht übergeben werden');
		YWRibG9ja2VyX3dhcm5pbmc = getParams();
	}

	//private variablen
	var adblocker_warning = YWRibG9ja2VyX3dhcm5pbmc; //eval(btoa('adblocker_warning').replace('=',''));
	var __pages = adblocker_warning.pages;
	var __dev = adblocker_warning.development == 1;
	var __activated = adblocker_warning.activated == 1;
	var __column = adblocker_warning.column;

	var __errorPages = {
		pageNotFound : '<h1>Page not Found</h1><a href="home">Zurück</>',
	}

	function adBlockerWarning($options){
		if(isEmpty($)){if(__dev){console.warn('jQuery is not defined');return false;}}
		var defaults = {
			pages : {
				home:'',
				default: '<h1>Bitte schalten Sie den Adblocker aus</h1>'
			},
			overlay:{
				number:10,
				margin: {
					side : 40,
					top:0
				},
				backgroundColor:'rgba(255,255,255,0)'
			},
			toOverlay: {
				top:'.td-header-menu-wrap-full',
				element:'.td-main-content-wrap .td-container',
			}
		},
		
		$settings = $.extend(true,defaults,$options);

		var reInitSettings = function(newSettings){
			$settings = $.extend(true,defaults,newSettings);
		}

		var resize = function(){
			$(window).scrollTop(0);
			var olT = $($settings.toOverlay.top).offset().top + $($settings.toOverlay.top).height(),
			olW =  !isEmpty($($settings.toOverlay.element).width())?$($settings.toOverlay.element).width()- $settings.overlay.margin.side:window.innerWidth - $settings.overlay.margin.side,
			olH = $($settings.toOverlay.element).height()-$settings.overlay.margin.top,
			wH = $(window).height();

			$('#adblocker-warning-box').css({
				'min-height': olH,
				'top':olT,
				'width':olW,
			});

			$('#pagable-content').css({
				'max-height': (wH-olT)
			});
		}

		var init = function(){
			if (!__activated) {if(__dev){console.warn('not activated');return;}	}
			var img = adblocker_warning.plugin_url;
			var olT = $($settings.toOverlay.top).offset().top + $($settings.toOverlay.top).height(),
			olW =  !isEmpty($($settings.toOverlay.element).width())?$($settings.toOverlay.element).width()-$settings.overlay.margin.side :window.innerWidth - $settings.overlay.margin.side,
			olH = $($settings.toOverlay.element).height()-$settings.overlay.margin.top,
			wH = $(window).height();
			var box = '';
			var adminbar = isEmpty($('#wpadminbar'))?0:$('#wpadminbar').height();
			console.log(adminbar);
			for(let i=0;i<$settings.overlay.number/2;i++){
				box += '<div style="position:fixed;top:'+adminbar+'px;left:0;width:100%;height:'+wH+'px;overflow:hidden;z-index:9999999;background-color:'+$settings.overlay.backgroundColor+'" class="abw"></div>';
			}
			box += '<div  id="adblocker-warning-wrapper" style="top:'+adminbar+'px;" class="blocker-boxes">';					
			box += '<div id="adblocker-warning-box" style="min-height:'+olH+'px;overflow:auto;top:'+olT+'px;width:'+olW+'px;">';
			box += '<div  id="close-abw" onclick="closeABW();"><i class="td-icon-close"></i></div>';
			box += '<div id="progress-wrapper" style="position: absolute;width: 100%;height:94%;left: 0;text-align: center;z-index: 999;padding:30px;pointer-events:none;">'
			box += '<div id="progress" style="display:none;">'
			box += '<img src="'+img+'/wp-admin/images/wpspin_light-2x.gif"></div></div>';
			box += '<div id="pagable-content" style="max-height:'+(wH-olT)+'px;overflow:auto;" id="home">';								
			box += '</div>';
			box += '</div>';
			box += '</div>';
			for(let i=0;i<$settings.overlay.number/2;i++){
				box += '<div style="pointer-events:none;position:fixed;top:0;left:0;width:100%;height:'+wH+'px;overflow:hidden;z-index:9999999;" class="abw"></div>';
			}

			if(!($('#adblocker-warning-wrapper').length)){
				$(box).appendTo('body');				
			}
			else{
				$('#adblocker-warning-wrapper,.abw').remove();
				$(box).appendTo('body');
			}

			$('body').addClass('blocked');
			setTimeout(function() {
				$('#adblocker-warning-wrapper').addClass('opened');
				$(window).scrollTop(0);
			}, 400);				
			changePage('home');
		}

		var changeHrefToOnClick = function(str){
			if(isEmpty(str)){
				if(__dev){console.warn('nothing to replace');}
				return false;
			}

			var re = new RegExp("<a([^>]* )href=\".*?:\/\/([^\"]*)\"", "g");
			var reR = new RegExp("<a([^>]* )href=\".*?([^\"]*)\"", "g");
			return str.replace(re,"<a$1 onclick=\"changePage('$2')\"").replace(reR,"<a$1 onclick=\"changePage('$2')\"");
		}

		var cHFHTTP = function(href){
			return href.replace(new RegExp(/.*?:\/\//,'g'),'');
		}

		var  debounce = function(func, wait, immediate) {
			var timeout;
			return function() {
				var context = this, args = arguments;
				var later = function() {
					timeout = null;
					if (!immediate) func.apply(context, args);
				};
				var callNow = immediate && !timeout;
				clearTimeout(timeout);
				timeout = setTimeout(later, wait);
				if (callNow) func.apply(context, args);
			};
		};

		this.closeABW = function(){
			var conf = confirm("Ist Adblocker aus?");
			if(conf){
				location.reload(true);
			}
			else{
				alert('Dieses Box kann nicht zugeschlossen werden ohne den Adblocker auszuschalten');
			}
		}

		this.changePage = function(page){
			$('#progress').show();
			if(isEmpty($settings.pages[page])){
				if(__dev){console.warn('Page does not exist');}
				$('#progress').hide();
				var pg = /http/.test(page)?page:'http://'+page;
				window.open(pg);
				return false;	
			}
			
			var dev = __dev?'/wordpress':'',
			status_,error_;
			$('#pagable-content').html(changeHrefToOnClick($settings.pages[page]));
			$('#progress').hide();								
		}
		if (__dev) {
			this.publicy = {
				getSettings : function(){
					return $settings;
				},

				cHFHTTP : function(href){
					return cHFHTTP(href);
				},
				changeHrefToOnClick: function(a){
					return changeHrefToOnClick(a);
				},

				resize : function(){
					resize();
				},

				reinit : function(column){
					if (column === __column) {
						init();
					}
					else{
						if(__dev){console.warn('Wrong password');}
					}
				},
				getPages : function(){
					return __pages;
				},
				isActive: function(){
					return __activated;
				},
				toggle:function(column){
					if (column === __column) {
						__activated = !__activated;
					}
					else{
						if(__dev){console.warn('Wrong password');}
					}
				}
			};
		}
		init();

		$(window).resize(debounce(function(){resize();},500));
		
		return this;	
	}
	(function($){
		$(document).ready(function() {		
			if (__activated) {
				detectAdBlocker(
					function(){
						__abw = adBlockerWarning({
							pages : __pages
						});
						$('body').addClass('blocked');										
						if (typeof ga != 'undefined') {
							try{
								ga('send', {hitType:'pageview',eventLabel:'adblocker'});
							}catch(e){
								if(__dev){console.warn('Error:',e);}
							}
						}
					},
					function(){
						if(__dev){console.log('Danke dass Sie keinen Adblocker verwenden');}
						$('body').removeClass('blocked');	
					});
			}		
		});

	})(jQuery)
})();
