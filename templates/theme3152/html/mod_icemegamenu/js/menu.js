/*
 * ScrollToFixed
 * https://github.com/bigspotteddog/ScrollToFixed
 * 
 * Copyright (c) 2011 Joseph Cava-Lynch
 * MIT license
 */
;(function(e){e.isScrollToFixed=function(t){return!!e(t).data("ScrollToFixed")};e.ScrollToFixed=function(t,n){function m(){s.trigger("preUnfixed.ScrollToFixed");x();s.trigger("unfixed.ScrollToFixed");h=-1;f=s.offset().top;l=s.offset().left;if(r.options.offsets){l+=s.offset().left-s.position().left}if(c==-1){c=l}o=s.css("position");i=true;if(r.options.bottom!=-1){s.trigger("preFixed.ScrollToFixed");E();s.trigger("fixed.ScrollToFixed")}}function g(){var e=r.options.limit;if(!e)return 0;if(typeof e==="function"){return e.apply(s)}return e}function y(){return o==="fixed"}function b(){return o==="absolute"}function w(){return!(y()||b())}function E(){if(!y()){p.css({display:s.css("display"),width:(s.outerWidth(true)*100/s.parent().width()).toFixed(2)-.04+"%",height:s.outerHeight(true),"float":s.css("float")});cssOptions={position:"fixed",top:r.options.bottom==-1?N():"",bottom:r.options.bottom==-1?"":r.options.bottom,"margin-left":"0px"};if(!r.options.dontSetWidth){cssOptions["width"]=s.width()}s.css(cssOptions);s.addClass(r.options.baseClassName);if(r.options.className){s.addClass(r.options.className)}o="fixed"}}function S(){var e=g();var t=l;if(r.options.removeOffsets){t="";e=e-f}cssOptions={position:"absolute",top:e,left:t,"margin-left":"0px",bottom:""};if(!r.options.dontSetWidth){cssOptions["width"]=s.width()}s.css(cssOptions);o="absolute"}function x(){if(!w()){h=-1;p.css("display","none");s.css({width:"",position:u,left:"",top:a,"margin-left":""});s.removeClass("scroll-to-fixed-fixed");if(r.options.className){s.removeClass(r.options.className)}o=null}}function T(e){if(e!=h){s.css("left",l-e);h=e}}function N(){var e=r.options.marginTop;if(!e)return 0;if(typeof e==="function"){return e.apply(s)}return e}function C(){if(!e.isScrollToFixed(s))return;var t=i;if(!i){m()}var n=e(window).scrollLeft();var o=e(window).scrollTop();var a=g();if(r.options.minWidth&&e(window).width()<r.options.minWidth){if(!w()||!t){L();s.trigger("preUnfixed.ScrollToFixed");x();s.trigger("unfixed.ScrollToFixed")}}else if(r.options.maxWidth&&e(window).width()>r.options.maxWidth){if(!w()||!t){L();s.trigger("preUnfixed.ScrollToFixed");x();s.trigger("unfixed.ScrollToFixed")}}else if(r.options.bottom==-1){if(a>0&&o>=a-N()){if(!b()||!t){L();s.trigger("preAbsolute.ScrollToFixed");S();s.trigger("unfixed.ScrollToFixed")}}else if(o>=f-N()){if(!y()||!t){L();s.trigger("preFixed.ScrollToFixed");E();h=-1;s.trigger("fixed.ScrollToFixed")}T(n)}else{if(!w()||!t){L();s.trigger("preUnfixed.ScrollToFixed");x();s.trigger("unfixed.ScrollToFixed")}}}else{if(a>0){if(o+e(window).height()-s.outerHeight(true)>=a-(N()||-k())){if(y()){L();s.trigger("preUnfixed.ScrollToFixed");if(u==="absolute"){S()}else{x()}s.trigger("unfixed.ScrollToFixed")}}else{if(!y()){L();s.trigger("preFixed.ScrollToFixed");E()}T(n);s.trigger("fixed.ScrollToFixed")}}else{T(n)}}}function k(){if(!r.options.bottom)return 0;return r.options.bottom}function L(){var e=s.css("position");if(e=="absolute"){s.trigger("postAbsolute.ScrollToFixed")}else if(e=="fixed"){s.trigger("postFixed.ScrollToFixed")}else{s.trigger("postUnfixed.ScrollToFixed")}}var r=this;r.$el=e(t);r.el=t;r.$el.data("ScrollToFixed",r);var i=false;var s=r.$el;var o;var u;var a;var f=0;var l=0;var c=-1;var h=-1;var p=null;var d;var v;var A=function(e){if(s.is(":visible")){i=false;C()}};var O=function(e){C()};var M=function(){var e=document.body;if(document.createElement&&e&&e.appendChild&&e.removeChild){var t=document.createElement("div");if(!t.getBoundingClientRect)return null;t.innerHTML="x";t.style.cssText="position:fixed;top:100px;";e.appendChild(t);var n=e.style.height,r=e.scrollTop;e.style.height="3000px";e.scrollTop=500;var i=t.getBoundingClientRect().top;e.style.height=n;var s=i===100;e.removeChild(t);e.scrollTop=r;return s}return null};var _=function(e){e=e||window.event;if(e.preventDefault){e.preventDefault()}e.returnValue=false};r.init=function(){r.options=e.extend({},e.ScrollToFixed.defaultOptions,n);r.$el.css("z-index",r.options.zIndex);p=e("<div />");o=s.css("position");u=s.css("position");a=s.css("top");if(w())r.$el.after(p);e(window).bind("resize.ScrollToFixed",A);e(window).bind("scroll.ScrollToFixed",O);if(r.options.preFixed){s.bind("preFixed.ScrollToFixed",r.options.preFixed)}if(r.options.postFixed){s.bind("postFixed.ScrollToFixed",r.options.postFixed)}if(r.options.preUnfixed){s.bind("preUnfixed.ScrollToFixed",r.options.preUnfixed)}if(r.options.postUnfixed){s.bind("postUnfixed.ScrollToFixed",r.options.postUnfixed)}if(r.options.preAbsolute){s.bind("preAbsolute.ScrollToFixed",r.options.preAbsolute)}if(r.options.postAbsolute){s.bind("postAbsolute.ScrollToFixed",r.options.postAbsolute)}if(r.options.fixed){s.bind("fixed.ScrollToFixed",r.options.fixed)}if(r.options.unfixed){s.bind("unfixed.ScrollToFixed",r.options.unfixed)}if(r.options.spacerClass){p.addClass(r.options.spacerClass)}s.bind("resize.ScrollToFixed",function(){p.height(s.height())});s.bind("scroll.ScrollToFixed",function(){s.trigger("preUnfixed.ScrollToFixed");x();s.trigger("unfixed.ScrollToFixed");C()});s.bind("detach.ScrollToFixed",function(t){_(t);s.trigger("preUnfixed.ScrollToFixed");x();s.trigger("unfixed.ScrollToFixed");e(window).unbind("resize.ScrollToFixed",A);e(window).unbind("scroll.ScrollToFixed",O);s.unbind(".ScrollToFixed");p.remove();r.$el.removeData("ScrollToFixed")});A()};r.init()};e.ScrollToFixed.defaultOptions={marginTop:0,limit:0,bottom:-1,zIndex:1e3,baseClassName:"scroll-to-fixed-fixed"};e.fn.scrollToFixed=function(t){return this.each(function(){new e.ScrollToFixed(this,t)})}})(jQuery)

jQuery(function($){
		var $scrollEl = ($.browser.mozilla || $.browser.msie) ? $('html') : $('body');
		if(screen.width>767){
			$(window).load(function(){
				$('#icemegamenu').closest('.row-container').parent().scrollToFixed({minWidth: 768});
			})
		}
		///////////////////
		$('.icemegamenu li>a.iceMenuTitle').hover(function(){
			$(this).addClass('hover');
		},
		function(){
			$(this).removeClass('hover');
		});
		var $hide_block = false;
		$('.icemega_modulewrap input[type]').focus(function(){
			$hide_block = true;
		})
		$('.icemega_modulewrap input[type]').blur(function(){
			$hide_block = false;
		})
		if($('body').hasClass('desktop_mode') || ($('body').hasClass('mobile') && screen.width>767)){
			$('.icemegamenu li').not('.parent').find('>a.iceMenuTitle[href^="#"]').click(function(){
				var a=$(this);
				animate_body(a);
			})
			$('.icemegamenu li.parent>a.iceMenuTitle[href^="#"]').click(function(){
				var a=$(this);
				if(a.closest("li").hasClass("hover")){
					hide_submenu(a);
					animate_body(a);
				}
				else{
					$('.icemegamenu li.parent[class^="iceMenuLiLevel"]').not(a.closest("li").parents("li")).not(a.closest("li")).removeClass("hover");
					a.closest("li").addClass("hover").attr("data-hover","true");
					a.closest("li").find(">ul.icesubMenu").addClass("visible");
					return false
				}
			})
			$('.icemegamenu li.parent>a').not('[href]').click(function(){
				var a=$(this);
				if(a.closest("li").hasClass("hover")){
					if(!a.attr('href')){
						a.removeClass('hover');
						a.closest("li").attr('data-hover','false');
						hide_submenu(a, 0);
					}
				}
				else{
					$('.icemegamenu li.parent[class^="iceMenuLiLevel"]').not(a.closest("li").parents("li")).not(a.closest("li")).removeClass("hover");
					a.closest("li").addClass("hover").attr("data-hover","true");
					a.closest("li").find(">ul.icesubMenu").addClass("visible");
					return false;
				}
			})
			$('.icemegamenu li[class^="iceMenuLiLevel"]').not('.parent').find('>a.iceMenuTitle[href]').not('[href^="#"]').click(function(){
				var a=$(this);
				if(window.location.href.split("#")[0]==a.attr('href')) {
					animate_body(a);
					return false;
				}
			})
			$('.icemegamenu li.parent[class^="iceMenuLiLevel"]').find('>a.iceMenuTitle[href]').not('[href^="#"]').click(function(){
				var a=$(this);
				if(a.closest("li").hasClass("hover")){
					if(window.location.href.split("#")[0]==a.attr('href')){
						hide_submenu(a);
						animate_body(a);
						return false;
					}
				}
				else{
					$('.icemegamenu li.parent[class^="iceMenuLiLevel"]').not(a.closest("li").parents("li")).not(a.closest("li")).removeClass("hover");
					a.closest("li").addClass("hover").attr("data-hover","true");
					a.closest("li").find(">ul.icesubMenu").addClass("visible");
					return false;
				}
			})
			$('body').click(function(){
				$('.icemegamenu li.parent').each(function(){
					$(this).attr('data-hover','false');
					a = $(this).find('>a');
					hide_submenu(a, 0);
				})
			})
		}
		else{
			$('.icemegamenu li.parent[class^="iceMenuLiLevel"]').hover(function(){
				$('#icemegamenu li.parent[class^="iceMenuLiLevel"]').not($(this).parents('li')).not($(this)).removeClass('hover');
				$(this).addClass('hover').attr('data-hover','true');
				$(this).find('>ul.icesubMenu').addClass('visible');
			},
			function(){
				$(this).attr('data-hover','false');
				a = $(this).find('>a');
				hide_submenu(a);
			})
			$('.icemegamenu li.iceMenuLiLevel_1>a.iceMenuTitle[href^="#"]').click(function(){
				var a=$(this);
				animate_body(a);
			})
			$('.icemegamenu li[class^="iceMenuLiLevel"]>a.iceMenuTitle[href]').click(function(){
				var a=$(this);
				if(window.location.href.split("#")[0]==a.attr('href')) {
					animate_body(a);
					return false;
				}
				
			})
		}
		function hide_submenu(a, delay){
   			delay = typeof delay !== 'undefined' ? delay : 800;
			a.delay(delay).queue(function(b){
				if(a.closest("li").attr("data-hover")=="false" && $hide_block != true){
					a.closest("li").removeClass("hover").delay(250).queue(function(c){
						if(a.closest("li").attr("data-hover")=="false"){
							a.closest("li").find(">ul.icesubMenu").removeClass("visible")
						}
						c()
					})
				}
				b()
			});
		}
		function animate_body(a){
			if(window.location.href.split("#")[0]!=a.attr('href')){
				if($('a[name="'+a.attr("href").substring(1)+'"]').length){
					click_scroll=true;
					$('.icemegamenu li[class^="iceMenuLiLevel"]').removeClass("hover").find(">a.iceMenuTitle").removeClass("icemega_active").removeClass('hover');
					a.addClass("icemega_active");
					if(history.pushState){
						history.pushState(null,null,a.attr("href"))
					}
					$scrollEl.animate({
						scrollTop: $('a[name="'+a.attr("href").substring(1)+'"]').offset().top-$(".scroll-to-fixed-fixed").outerHeight()
					},400,function(){
						$(this).delay(200).queue(function(b){
							click_scroll=false;
							$(this).delay(1200).queue(function(c){
								if(typeof $.fn.lazy=="function"){
									$("img.lazy").lazy({
										bind:"event",effect:"fadeIn",effectTime:500
									})
								}
								c()
							});
							b()
						})
					})
				}
			}
			if(window.location.href.split("#")[0]==a.attr('href')){
				click_scroll=true;
				$('.icemegamenu li[class^="iceMenuLiLevel"]').removeClass("hover").find(">a.iceMenuTitle").removeClass("icemega_active").removeClass('hover');
				a.addClass("icemega_active");
				if(history.pushState){
					history.pushState(null,null,'#')
				}
				$scrollEl.animate({
					scrollTop: 0
				},400,function(){
					$(this).delay(200).queue(function(b){
						click_scroll=false;
						$(this).delay(1200).queue(function(c){
							if(typeof $.fn.lazy=="function"){
								$("img.lazy").lazy({
									bind:"event",effect:"fadeIn",effectTime:500
								})
							}
							c()
						});
						b()
					})
				})
			}
			return false;
		}
		function change_menu_item(){
			if(!click_scroll){
				var a=$(window).scrollTop(),
				d="";
				y = $(document).height();
				if(!init_hash||init_hash==""){
					for(var b=0,c=idArray.length;b<c;b++){
						if($('a[name="'+idArray[b].substring(1)+'"]').length){
							if(a+($(window).height()-$(".scroll-to-fixed-fixed").outerHeight())/2>=$('a[name="'+idArray[b].substring(1)+'"]').offset().top && y>a+($(window).height()-$(".scroll-to-fixed-fixed").outerHeight())/2-$('a[name="'+idArray[b].substring(1)+'"]').offset().top){
								d=idArray[b];
								y=a+($(window).height()-$(".scroll-to-fixed-fixed").outerHeight())/2-$('a[name="'+idArray[b].substring(1)+'"]').offset().top
							}
						}
					}
					lastScrollTop=a;
					if(window.location.hash!=d&&d!=""){
						if(history.pushState){
							history.pushState(null,null,d)
						}
						$('.icemegamenu li[class^="iceMenuLiLevel"]').removeClass("hover").find(">a.iceMenuTitle").removeClass("icemega_active").removeClass('hover');
						$("a.iceMenuTitle[href="+d+"]").addClass("icemega_active")
					}
					if(a == 0){
						if(history.pushState && window.location.hash){
							history.pushState(null,null,'#')
						}
						$('.icemegamenu li[class^="iceMenuLiLevel"]').removeClass("hover").find(">a.iceMenuTitle").removeClass("icemega_active").removeClass('hover');
						if(window.location.hash){
							$("a.iceMenuTitle[href=\""+window.location.href+"\"]").addClass("icemega_active")
						}
						else{
							$("a.iceMenuTitle[href=\""+window.location.href.split('#')[0]+"\"]").addClass("icemega_active")
						}
					}
				}
				else{
					if($("a.iceMenuTitle[href="+init_hash+"]").length){
						$('.icemegamenu li[class^="iceMenuLiLevel"]').removeClass("hover").find(">a.iceMenuTitle").removeClass("icemega_active").removeClass('hover');
						$("a.iceMenuTitle[href="+init_hash+"]").addClass("icemega_active");
					}
					if($('a[name="'+init_hash.substring(1)+'"]').length){
						click_scroll=true;
						$scrollEl.delay(100).queue(function(z){
							$scrollEl.animate({
								scrollTop: $('a[name="'+init_hash.substring(1)+'"]').offset().top-$(".scroll-to-fixed-fixed").outerHeight()
							},400,function(){
								$(this).delay(200).queue(function(e){
									click_scroll=false;
									init_hash=false;
									$(this).delay(1200).queue(function(f){
										if(typeof $.fn.lazy=="function"){
											$(".lazy_container img").lazy({
												bind:"event",effect:"fadeIn",effectTime:500
											})
										}
										f()
									});
									e()
								})
							})
							z()
						})
					}
				}
				return false
			}
		}
		if($('.icemegamenu li[class^="iceMenuLiLevel"]>a.iceMenuTitle[href^="#"]').length && $('.icemegamenu li[class^="iceMenuLiLevel"]>a.iceMenuTitle[href^="#"]').attr('href')!='#'){
			$(window).scroll($.throttle(500,function(){change_menu_item()}));
			$(window).load(function(){
				change_menu_item();
				if($(this).scrollTop()>24){
					$("body:first").addClass("scrolled")
				}
				else{
					$("body:first").removeClass("scrolled")
				}
			});
			var idArray=[],
			click_scroll=false,
			init_hash=window.location.hash,
			lastScrollTop=0;
			$('.icemegamenu li[class^="iceMenuLiLevel"]>a.iceMenuTitle[href^="#"]').each(function(a){
				idArray[a]=$(this).attr("href");
			});
		}
	});