//<![CDATA[
// loads after all dom elements have been loaded
jQuery( window ).load( function( $ )
{
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$.sp_theme_on_load = {
		init: function() 
		{
			//isotope layout for blog
			var container = jQuery(".article-wrap");
			container.isotope({
			  //options
			  itemSelector : '.isotope',
			  layoutMode : 'masonry',
			});
		
			//isotope layout for portfolio
			var portFolioContainer = jQuery("#portfolio-container");
			portFolioContainer.isotope({
			  //options
			  itemSelector : '.portfolio-item',
			  layoutMode : 'fitRows',
			});
			
			jQuery("ul.portfolio-sort li a").click(function() {
				var tag = jQuery(this).attr("data-filter");
				// remove the active class
				jQuery("ul.portfolio-sort li a").removeClass();
				jQuery(this).addClass('active');
				portFolioContainer.isotope({ filter: tag });
				return false;
			});
		} // close init
	}; // close namespace
	$.sp_theme_on_load.init();
});

jQuery( document ).ready( function( $ )
{ 
	$.sp_theme_on_ready = {
		init: function()
		{
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // hover intent plugin
			  jQuery.fn.hoverIntent = function(f,g) {
				  // default configuration options
				  var cfg = {
					  sensitivity: 7,
					  interval: 100,
					  timeout: 0
				  };
				  // override configuration options with user supplied object
				  cfg = jQuery.extend(cfg, g ? { over: f, out: g } : f );
		  
				  // instantiate variables
				  // cX, cY = current X and Y position of mouse, updated by mousemove event
				  // pX, pY = previous X and Y position of mouse, set by mouseover and polling interval
				  var cX, cY, pX, pY;
		  
				  // A private function for getting mouse position
				  var track = function(ev) {
					  cX = ev.pageX;
					  cY = ev.pageY;
				  };
		  
				  // A private function for comparing current and previous mouse position
				  var compare = function(ev,ob) {
					  ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
					  // compare mouse positions to see if they've crossed the threshold
					  if ( ( Math.abs(pX-cX) + Math.abs(pY-cY) ) < cfg.sensitivity ) {
						  jQuery(ob).unbind("mousemove",track);
						  // set hoverIntent state to true (so mouseOut can be called)
						  ob.hoverIntent_s = 1;
						  return cfg.over.apply(ob,[ev]);
					  } else {
						  // set previous coordinates for next time
						  pX = cX; pY = cY;
						  // use self-calling timeout, guarantees intervals are spaced out properly (avoids JavaScript timer bugs)
						  ob.hoverIntent_t = setTimeout( function(){compare(ev, ob);} , cfg.interval );
					  }
				  };
		  
				  // A private function for delaying the mouseOut function
				  var delay = function(ev,ob) {
					  ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
					  ob.hoverIntent_s = 0;
					  return cfg.out.apply(ob,[ev]);
				  };
		  
				  // A private function for handling mouse 'hovering'
				  var handleHover = function(e) {
					  // copy objects to be passed into t (required for event object to be passed in IE)
					  var ev = jQuery.extend({},e);
					  var ob = this;
		  
					  // cancel hoverIntent timer if it exists
					  if (ob.hoverIntent_t) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); }
		  
					  // if e.type == "mouseenter"
					  if (e.type == "mouseenter") {
						  // set "previous" X and Y position based on initial entry point
						  pX = ev.pageX; pY = ev.pageY;
						  // update "current" X and Y position based on mousemove
						  jQuery(ob).bind("mousemove",track);
						  // start polling interval (self-calling timeout) to compare mouse coordinates over time
						  if (ob.hoverIntent_s != 1) { ob.hoverIntent_t = setTimeout( function(){compare(ev,ob);} , cfg.interval );}
		  
					  // else e.type == "mouseleave"
					  } else {
						  // unbind expensive mousemove event
						  jQuery(ob).unbind("mousemove",track);
						  // if hoverIntent state is true, then call the mouseOut function after the specified delay
						  if (ob.hoverIntent_s == 1) { ob.hoverIntent_t = setTimeout( function(){delay(ev,ob);} , cfg.timeout );}
					  }
				  };
		  
				  // bind the function to the two event listeners
				  return this.bind('mouseenter',handleHover).bind('mouseleave',handleHover);
			  };
		  
			/*== homepage slider ==*/
			var sliderInterval = parseInt(jQuery(".homepage_slider_interval").val()),
				sliderFX = jQuery(".homepage_slider_effects").val(),
				sliderTransitionSpeed = parseInt(jQuery(".homepage_slider_transition").val(),10),
				sliderEasing = jQuery(".homepage_slider_easing").val(),
				sliderPauseOnHover = jQuery(".homepage_slider_pause").val(),
				sliderDirection = jQuery(".homepage_slider_direction").val(),
				sliderTouchSwipe = jQuery(".homepage_slider_touchswipe").val(),
				slideMenuWidth = 0;

			if (sliderInterval === "" || sliderInterval === 0) {
				sliderInterval = false;	
			} else {
				sliderInterval = sliderInterval * 1000;	
			} 	
			
			jQuery("#home-slider").carouFredSel({
				items: {
					visible: 1,
					filter: '.slide',
					height: "auto",
					width: "100%"						
				},
				responsive: false,
				circular: true,
				infinite: true,
				direction: sliderDirection,
				align: "center",
				scroll: {
					items: 1,
					pauseOnHover: sliderPauseOnHover,
					easing: sliderEasing,
					duration: sliderTransitionSpeed,
					fx: sliderFX,
					swipe: sliderTouchSwipe
				},
				auto: {
					play: sliderInterval,
					timeoutDuration: sliderInterval	
				},
				next: {
					button: '#banner-wrapper span.nav-right-arrow'	
				},
				prev: {
					button: '#banner-wrapper span.nav-left-arrow'
				}				
			});
					  
			  // slide on click
			  jQuery(".product-slide").click(function(e) {
				  e.preventDefault();
				  var slide = parseInt(jQuery(this).children('a').attr('data-rel'));
				  jQuery("#home-slider").trigger('slideTo', slide);
				  jQuery(".product-slide").removeClass('activeSlide');
				  jQuery(this).addClass('activeSlide');
			  });  
			  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // homepage carousel
			  var changeEvery = parseInt(jQuery(".homepage_carousel_interval").val()),
			  		carouselItems = parseInt(jQuery(".homepage_carousel_scroll_items").val()),
			  		carouselSpeed = parseInt(jQuery(".homepage_carousel_speed").val()),
			  		carouselVisible = parseInt(jQuery(".homepage_carousel_visible").val()),
			  		carouselEasing = jQuery(".homepage_carousel_easing").val(),
			  		carouselCircular = jQuery(".homepage_carousel_circular").val(),
			  		carouselReverse = jQuery(".homepage_carousel_reverse").val(),
			  		carouselEffects = jQuery(".homepage_carousel_effects").val(),
			  		carouselPauseOnHover = jQuery(".homepage_carousel_pauseonhover").val(),
			  		carouselInfinite = jQuery(".homepage_carousel_infinite").val(),
			  		carouselTouchWipe = jQuery(".homepage_carousel_touchswipe").val(),
			  		carouselAutoScrollDirection = jQuery(".homepage_carousel_autoscrolldirection").val(),
			  		prevButton = "#carousel-wrapper .carousel-arrow-left",
			  		nextButton = "#carousel-wrapper .carousel-arrow-right";

			  if (carouselItems === "") { carouselItems = 1; }
			  if (carouselReverse === "true") { 
				  var temp = nextButton; 
				  nextButton = prevButton;
				  prevButton = temp;	
			  }
			  if (changeEvery === "" || changeEvery === 0) {
				  changeEvery = null;	
				  var autoplay = false;
			  } else {
				  changeEvery = changeEvery * 1000;	
			  } 
			  if (carouselSpeed === '' || carouselSpeed === null) { carouselSpeed = 1000; }
			  if (carouselEasing === '' || carouselEasing === '0') { carouselEasing = null; }
			  if (carouselVisible !== 0 && carouselVisible !== '' && carouselVisible !== null) {
				  jQuery("#carousel-wrapper #carousel ul").carouFredSel({
					  items: {
						   visible: carouselVisible,
						   minimum: 2				 
					  },
					  circular: carouselCircular,
					  infinite: carouselInfinite,
					  responsive: false,
					  direction: carouselAutoScrollDirection,
					  align: 'center',
					  width: '100%',
					  height: '100%',
					  scroll: {
						  items: carouselItems,
						  easing: carouselEasing,
						  duration: carouselSpeed,
						  pauseOnHover: carouselPauseOnHover,
						  fx: carouselEffects,
						  swipe: carouselTouchWipe
					  },
					  auto: {
						  play: autoplay,
						  timeoutDuration: changeEvery	
					  },
					  next: {
						  button: nextButton	
					  },
					  prev: {
						  button: prevButton
					  },
					  onCreate: function() {
						  jQuery("#carousel").css("visibility","visible");	
					  }
				  });
			  }
		  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // run functions when screensize is resized
			  // save original menu objects before resize
			  // check if mobile ready is enabled
			  if ( sp_custom.mobile_ready ) {
				  var mainMenu = jQuery("nav.main-nav").html();
				  var footerMenu = jQuery("nav.footer-nav").html();
				  // set variable to check if quickview should be disabled if screen size is too small
				  var quickview = jQuery("#quickview_enable");
				  function startMobile() {
					  if (jQuery(window).width() < 960) {

						  // change visible items on carousel depending on screen width
						  jQuery("#carousel-wrapper #carousel ul, .footer_slider ul").trigger("configuration", ["direction", function( value ) {
							  jQuery(this).trigger("configuration", ["items.visible", (value - 1)]);
						  }]);
						  
						  // disable quickview
						  quickview.val("false");
						  if (!jQuery("select.mobile-dropdown").length) {
								  // switch to dropdown menu on small screens
								  // top menu
								  jQuery('<select class="mobile-dropdown"/>').appendTo("nav.main-nav");
								  
								  // Create default option "Go to..."
								  jQuery("<option />", {
									 "selected": "selected",
									 "value"   : "",
									 "text"    : sp_custom.mobile_go_to_text
								  }).appendTo("nav.main-nav select");
								  
								  // Populate dropdown with menu items
								  var indentString = '&nbsp;&nbsp;&nbsp;';
								  jQuery("nav.main-nav a").each(function() {
									 var el = jQuery(this);
									 if (el.attr("href") != '#' && el.attr("href") != '') {
										 jQuery("<option />", {
											 "value"   : el.attr("href"),
											 "text"    : el.text().replace('/','')
										 }).appendTo("nav.main-nav select");					 
									  }
								  });
								  jQuery("nav.main-nav ul").remove();
								  
								  // category menu
								  jQuery('<select class="mobile-dropdown"/>').appendTo("nav.footer-nav");
								  
								  // Create default option "Go to..."
								  jQuery("<option />", {
									 "selected": "selected",
									 "value"   : "",
									 "text"    : sp_custom.mobile_go_to_text
								  }).appendTo("nav.footer-nav select");
								  
								  // Populate dropdown with menu items
								  jQuery("nav.footer-nav a").each(function() {
									   var el = jQuery(this);
										   if (el.attr("href") != '#' && el.attr("href") != '') {
										   jQuery("<option />", {
											   "value"   : el.attr("href"),
											   "text"    : el.text().replace('/','')
										   }).appendTo("nav.footer-nav select");
									   }
								  });
								  jQuery("nav.footer-nav ul").remove();
								  jQuery("#home-slider .textblock").hide();
						  }
						  // hide the textblock on the homepage slider 
						  jQuery("#home-slider .textblock").hide();
					  } else if (document.documentElement.clientWidth > 960 && jQuery("select.mobile-dropdown").length) {
						  // put the original menu back as they were
						  jQuery("nav.main-nav").html(mainMenu);
						  jQuery("nav.footer-nav").html(footerMenu);	
						  // put back the textblock on the homepage slider
						  jQuery("#home-slider .textblock").show();
						  
						  // enable quickview
						  quickview.val("true");						  
					  }
					  jQuery("#home-slider").trigger('updateSizes');
				  }
				  // runs when browser window is resized
				  jQuery(window).resize(function() { startMobile(); });
				  // runs onces when page loads
				  startMobile();
			  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				  // change pages with dropdown when in menu mobile mode
				  jQuery("nav.main-nav select.mobile-dropdown").live('change', function() {
					  window.location = jQuery(this).find("option:selected").val();
				  });
				  jQuery("nav.footer-nav select.mobile-dropdown").live('change', function() {
					  window.location = jQuery(this).find("option:selected").val();
				  });
			  }
			  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // menu effects
			  this.navLi = jQuery('nav ul li').children('ul').css("display","block").hide().end();
			  function menuOpen() {
				  jQuery(this).find('> ul').fadeIn(300);
			  }
			  
			  function menuClose() {
				  jQuery(this).find('> ul').fadeOut(200);	
			  }
			  var config = {
			   over: menuOpen,     
			   timeout: 100, // number = milliseconds delay before onMouseOut    
			   interval: 0,
			   out: menuClose   	
			   }
			  
			  this.navLi.hoverIntent(config);
			  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // cart menu effect
			  function cartOpen() {
				  jQuery("#cartContents").fadeIn(300);
				  jQuery("span.arrow",this).stop(true,true).animate({top: "80%"},300);
			  }
			  function cartClose() {
				  jQuery("#cartContents").fadeOut(200);
				  jQuery("span.arrow",this).stop(true,true).animate({top: "50%"},500);
			  }
			  var config = {
			   over: cartOpen,     
			   timeout: 100, // number = milliseconds delay before onMouseOut    
			   interval: 0,
			   out: cartClose   	
			   }
			  
			  jQuery("div#cart").hoverIntent(config);
		  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // footer carousel
			  var changeEvery = parseInt(jQuery(".footer_carousel_interval").val());
			  var carouselItems = parseInt(jQuery(".footer_carousel_scroll_items").val());
			  var carouselSpeed = parseInt(jQuery(".footer_carousel_speed").val());
			  var carouselVisible = parseInt(jQuery(".footer_carousel_visible").val());
			  var carouselEasing = jQuery(".footer_carousel_easing").val();
			  var carouselCircular = jQuery(".footer_carousel_circular").val();
			  var carouselReverse = jQuery(".footer_carousel_reverse").val();
			  var carouselEffects = jQuery(".footer_carousel_effects").val();
			  var carouselPauseOnHover = jQuery(".footer_carousel_pauseonhover").val();
			  var carouselInfinite = jQuery(".footer_carousel_infinite").val();
			  var carouselTouchWipe = jQuery(".footer_carousel_touchswipe").val();
			  var carouselAutoScrollDirection = jQuery(".footer_carousel_autoscrolldirection").val();
			  var prevButton = ".footer_featured .carousel-arrow-right";
			  var nextButton = ".footer_featured .carousel-arrow-left";
			  if (carouselItems === "") { carouselItems = 1; }
			  if (carouselReverse === "true") { 
				  var temp = nextButton; 
				  nextButton = prevButton;
				  prevButton = temp;	
			  }
			  if (changeEvery === "" || changeEvery === 0) {
				  changeEvery = null;	
				  var autoplay = false;
			  } else {
				  changeEvery = changeEvery * 1000;	
			  } 
			  if (carouselSpeed === '' || carouselSpeed === null) { carouselSpeed = 1000; }
			  if (carouselEasing === '' || carouselEasing === '0') { carouselEasing = null; }
			  if (carouselVisible !== 0 && carouselVisible !== '' && carouselVisible !== null) {
				  jQuery(".footer_slider ul").carouFredSel({
					  items: {
						   visible: carouselVisible,
						   minimum: 2,
						   filter: ".footer_slider ul li"			 
					  },
					  circular: carouselCircular,
					  infinite: carouselInfinite,
					  responsive: false,
					  direction: carouselAutoScrollDirection,
					  align: 'center',
					  width: '100%',
					  height: '100%',
					  scroll: {
						  items: carouselItems,
						  easing: carouselEasing,
						  duration: carouselSpeed,
						  pauseOnHover: carouselPauseOnHover,
						  fx: carouselEffects,
						  swipe: carouselTouchWipe
					  },
					  auto: {
						  play: autoplay,
						  timeoutDuration: changeEvery	
					  },
					  next: {
						  button: nextButton	
					  },
					  prev: {
						  button: prevButton
					  },
					  onCreate: function() {
						  jQuery(".footer_slider").css("visibility","visible");	
					  }
				  });
			  }
			  		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // footer latest testimonials rotate
			  jQuery("#testimonials p").hide().eq(0).show();
			  // A self executing named function that loops through the posts:
			  if (jQuery(".footer_rotator_delay").val() != "") {
				  
				  
				  (function showNextTestimonial(){
					  var changeEvery = jQuery(".footer_rotator_delay").val();
					  if (changeEvery == '0') {
						  // do nothing
					  } else {
						  // Wait for 3 seconds and hide the current visible post
						  jQuery('#testimonials p:visible').delay(changeEvery*1000).fadeOut('slow',function(){
							  // Move it to the back:
							  jQuery(this).appendTo('#testimonials');
				  
							  // Show the next post
							  jQuery('#testimonials p:first').fadeIn('slow',function(){
				  
								  // Call the function again:
								  showNextTestimonial();
							  });
						  });
					  }
				  })();
			  }
			  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // input on focus/blur search
				  jQuery(".searchform input[name=s]").focus(function() {
					  var default_value = this.value;			
					  if(this.value === default_value) {
						  this.value = '';
					  }
					  //jQuery(this).removeClass('blur');
					  jQuery(this).css("color","#fff").css("font-style","normal");
				  });
				  jQuery(".searchform input[name=s]").blur(function() {
						  
					  var id = jQuery(this).attr('id');
					  if (id == 'author') {
						  var default_value = 'Name';
					  } else if (id == 'email') {
						  var default_value = 'Email';
					  } else if (id == 'url') {
						  var default_value = 'Url';
					  } else {
						  var default_value = "Search";	
					  }
					  if(this.value === '') {
						  this.value = default_value;
						  //jQuery(this).addClass('blur');
						  jQuery(this).css("color","#f5f5f5").css("font-style","italic");
					  }
					  
				  });
		  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // input on focus/blur comments
				  jQuery("#commentform input[type=text]").focus(function() {
					  var default_value = this.value;			
					  if(this.value === default_value) {
						  this.value = '';
					  }
					  //jQuery(this).removeClass('blur');
					  jQuery(this).css("color","#333").css("font-style","normal");
				  });
				  jQuery("#commentform input[type=text]").blur(function() {
						  
					  var id = jQuery(this).attr('id');
					  if (id == 'author') {
						  var default_value = 'Name';
					  } else if (id == 'email') {
						  var default_value = 'Email';
					  } else if (id == 'url') {
						  var default_value = 'Url';
					  } else {
						  var default_value = "Search";	
					  }
					  if(this.value === '') {
						  this.value = default_value;
						  //jQuery(this).addClass('blur');
						  jQuery(this).css("color","#999").css("font-style","italic");
					  }
					  
				  });
		  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// pretty Photo v3.0
			var socialtools = jQuery("#lightbox_social").val();
			var lightbox_show_overlay_gallery = jQuery("#lightbox_show_overlay_gallery").val();
			var lightbox_title = jQuery("#lightbox_title").val();
			
			if (socialtools === 'true') {
				socialtools = '<div class="pp_social"><div class="twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div><div class="facebook"><iframe src="http://www.facebook.com/plugins/like.php?locale=en_US&href='+location.href+'&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:23px;" allowTransparency="true"></iframe></div></div>';	
			} else {
				socialtools = false;	
			}
			var lightbox_theme = jQuery("#lightbox_theme").val();
			if (lightbox_theme === '') {
				lightbox_theme = 'facebook';
			}
			var lightbox_slideshow = jQuery("#lightbox_slideshow").val();
			if (lightbox_slideshow === '') {
				lightbox_slideshow = false;	
			} else {
				lightbox_slideshow = 5000;	
			}

			if ( lightbox_show_overlay_gallery === '' ) {
				lightbox_show_overlay_gallery = false;
			}
						
			jQuery(".preview_link").prettyPhoto({deeplinking: false, animationSpeed:'slow',theme:lightbox_theme,overlay_gallery:lightbox_show_overlay_gallery,show_title:lightbox_title,slideshow:lightbox_slideshow, autoplay_slideshow: false, social_tools: socialtools, callback: function() {jQuery(".product_item").css("z-index","10000"); }, oncreate: function(thisImage) {										 
			    	var selected_image_src = thisImage.find('img').attr('src');
			    	var reg = /src=(.+)(?=&h)/;
			    	var results = reg.exec(selected_image_src);						
					
					if (!results) {
						var selected_image_src = thisImage.find('img').attr('src');
				    	var results = selected_image_src;							
					}
				    	
				    // removes first index from array that was clicked on
				    var parts = pp_images.splice(0, 1);
				    var pp_titles_org = pp_titles;
				    var pp_descriptions_org = pp_descriptions;

				    pp_titles.splice(0, 1);
				    pp_descriptions.splice(0, 1);
				    if (jQuery.inArray(results[1], pp_images) > -1) {
				    	set_position = jQuery.inArray(results[1], pp_images);
					} else { // after variation swap
						// restore the original set of images
						pp_images.splice(0, 0, parts[0]);
						set_position = jQuery.inArray(thisImage.attr('href'), pp_images);
						//pp_titles = pp_titles_org;
						//pp_descriptions = pp_descriptions_org;
					}	
				}  
			});
			jQuery(".preview_link").click(function() { jQuery(".product_item").css("z-index","9500"); });
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // pretty Photo v3.0 for shortcodes
			  var socialtools = jQuery(".sc_lightbox_show_social").val();
			  if (socialtools === 'true') {
				  socialtools = '<div class="pp_social"><div class="twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div><div class="facebook"><iframe src="http://www.facebook.com/plugins/like.php?locale=en_US&href='+location.href+'&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:23px;" allowTransparency="true"></iframe></div></div>';	
			  } else {
				  socialtools = false;	
			  }
			  var lightbox_theme = jQuery(".sc_lightbox_theme").val();
			  if (lightbox_theme === '') {
				  lightbox_theme = 'pp_default';
			  }
			  var lightbox_slideshow = jQuery(".sc_lightbox_slideshow").val();
			  if (lightbox_slideshow === 'false') {
				  lightbox_slideshow = false;	
			  } else {
				  lightbox_slideshow = 5000;	
			  }
		  
			  jQuery(".lightbox-wrap").prettyPhoto({animationSpeed:'slow',theme:lightbox_theme,slideshow:lightbox_slideshow, autoplay_slideshow: false, social_tools: socialtools });

			  
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// plugin to center element vertically
				jQuery.fn.center = function (absolute) {
					return this.each(function () {
						var t = jQuery(this);
				
						t.css({
							position:	absolute ? 'absolute' : 'fixed', 
							left:		'50%', 
							top:		'50%'
						}).css({
							marginLeft:	'-' + (t.outerWidth() / 2) + 'px', 
							marginTop:	'-' + (t.outerHeight() / 2) + 'px'
						});
				
						if (absolute) {
							t.css({
								marginTop:	parseInt(t.css('marginTop'), 10) + jQuery(window).scrollTop(), 
								marginLeft:	parseInt(t.css('marginLeft'), 10) + jQuery(window).scrollLeft()
							});
						}
					});
				};				
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // fadeout hover effects
			  jQuery(".cat-wrap, .wpsc-latest-product, .widget_wpsc_categorisation .wpsc_category_image_link, .portfolio-item, .portfolio-single .image-wrap, .wpcart_gallery .preview_link, .imagecol .preview_link, .product-slide .products").hover(function() {
				  jQuery(this).find("img:first").stop(true, true).fadeTo('fast',0.6);
				  },function () {
				  jQuery(this).find("img:first").stop(true, true).fadeTo('slow',1);
		  
			  });
		  		  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		  /*!
		  * jQuery Cookie Plugin
		  * https://github.com/carhartl/jquery-cookie
		  *
		  * Copyright 2011, Klaus Hartl
		  * Dual licensed under the MIT or GPL Version 2 licenses.
		  * http://www.opensource.org/licenses/mit-license.php
		  * http://www.opensource.org/licenses/GPL-2.0
		  */
		  (function($) {
			  $.cookie = function(key, value, options) {
		  
				  // key and at least value given, set cookie...
				  if (arguments.length > 1 && (!/Object/.test(Object.prototype.toString.call(value)) || value === null || value === undefined)) {
					  options = $.extend({}, options);
		  
					  if (value === null || value === undefined) {
						  options.expires = -1;
					  }
		  
					  if (typeof options.expires === 'number') {
						  var days = options.expires, t = options.expires = new Date();
						  t.setDate(t.getDate() + days);
					  }
		  
					  value = String(value);
		  
					  return (document.cookie = [
						  encodeURIComponent(key), '=', options.raw ? value : encodeURIComponent(value),
						  options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
						  options.path ? '; path=' + options.path : '',
						  options.domain ? '; domain=' + options.domain : '',
						  options.secure ? '; secure' : ''
					  ].join(''));
				  }
		  
				  // key and possibly options given, get cookie...
				  options = value || {};
				  var decode = options.raw ? function(s) { return s; } : decodeURIComponent;
		  
				  var pairs = document.cookie.split('; ');
				  for (var i = 0, pair; pair = pairs[i] && pairs[i].split('='); i++) {
					  if (decode(pair[0]) === key) return decode(pair[1] || ''); // IE saves cookies with empty string as "c; ", e.g. without "=" as opposed to EOMB, thus pair[1] may be undefined
				  }
				  return null;
			  };
		  })(jQuery);
		  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		  // add wordpress comment reply script
		  addComment={moveForm:function(d,f,i,c){var m=this,a,h=m.I(d),b=m.I(i),l=m.I("cancel-comment-reply-link"),j=m.I("comment_parent"),k=m.I("comment_post_ID");if(!h||!b||!l||!j){return}m.respondId=i;c=c||false;if(!m.I("wp-temp-form-div")){a=document.createElement("div");a.id="wp-temp-form-div";a.style.display="none";b.parentNode.insertBefore(a,b)}h.parentNode.insertBefore(b,h.nextSibling);if(k&&c){k.value=c}j.value=f;l.style.display="";l.onclick=function(){var n=addComment,e=n.I("wp-temp-form-div"),o=n.I(n.respondId);if(!e||!o){return}n.I("comment_parent").value="0";e.parentNode.insertBefore(o,e);e.parentNode.removeChild(e);this.style.display="none";this.onclick=null;return false};try{m.I("comment").focus()}catch(g){}return false},I:function(a){return document.getElementById(a)}};
		  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // easing plugin
		  
		  jQuery.easing['jswing'] = jQuery.easing['swing'];
		  
		  jQuery.extend( jQuery.easing,
		  {
			  def: 'easeOutQuad',
			  swing: function (x, t, b, c, d) {
				  //alert(jQuery.easing.default);
				  return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
			  },
			  easeInQuad: function (x, t, b, c, d) {
				  return c*(t/=d)*t + b;
			  },
			  easeOutQuad: function (x, t, b, c, d) {
				  return -c *(t/=d)*(t-2) + b;
			  },
			  easeInOutQuad: function (x, t, b, c, d) {
				  if ((t/=d/2) < 1) return c/2*t*t + b;
				  return -c/2 * ((--t)*(t-2) - 1) + b;
			  },
			  easeInCubic: function (x, t, b, c, d) {
				  return c*(t/=d)*t*t + b;
			  },
			  easeOutCubic: function (x, t, b, c, d) {
				  return c*((t=t/d-1)*t*t + 1) + b;
			  },
			  easeInOutCubic: function (x, t, b, c, d) {
				  if ((t/=d/2) < 1) return c/2*t*t*t + b;
				  return c/2*((t-=2)*t*t + 2) + b;
			  },
			  easeInQuart: function (x, t, b, c, d) {
				  return c*(t/=d)*t*t*t + b;
			  },
			  easeOutQuart: function (x, t, b, c, d) {
				  return -c * ((t=t/d-1)*t*t*t - 1) + b;
			  },
			  easeInOutQuart: function (x, t, b, c, d) {
				  if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
				  return -c/2 * ((t-=2)*t*t*t - 2) + b;
			  },
			  easeInQuint: function (x, t, b, c, d) {
				  return c*(t/=d)*t*t*t*t + b;
			  },
			  easeOutQuint: function (x, t, b, c, d) {
				  return c*((t=t/d-1)*t*t*t*t + 1) + b;
			  },
			  easeInOutQuint: function (x, t, b, c, d) {
				  if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
				  return c/2*((t-=2)*t*t*t*t + 2) + b;
			  },
			  easeInSine: function (x, t, b, c, d) {
				  return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
			  },
			  easeOutSine: function (x, t, b, c, d) {
				  return c * Math.sin(t/d * (Math.PI/2)) + b;
			  },
			  easeInOutSine: function (x, t, b, c, d) {
				  return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
			  },
			  easeInExpo: function (x, t, b, c, d) {
				  return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
			  },
			  easeOutExpo: function (x, t, b, c, d) {
				  return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
			  },
			  easeInOutExpo: function (x, t, b, c, d) {
				  if (t==0) return b;
				  if (t==d) return b+c;
				  if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
				  return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
			  },
			  easeInCirc: function (x, t, b, c, d) {
				  return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
			  },
			  easeOutCirc: function (x, t, b, c, d) {
				  return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
			  },
			  easeInOutCirc: function (x, t, b, c, d) {
				  if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
				  return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
			  },
			  easeInElastic: function (x, t, b, c, d) {
				  var s=1.70158;var p=0;var a=c;
				  if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
				  if (a < Math.abs(c)) { a=c; var s=p/4; }
				  else var s = p/(2*Math.PI) * Math.asin (c/a);
				  return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
			  },
			  easeOutElastic: function (x, t, b, c, d) {
				  var s=1.70158;var p=0;var a=c;
				  if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
				  if (a < Math.abs(c)) { a=c; var s=p/4; }
				  else var s = p/(2*Math.PI) * Math.asin (c/a);
				  return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
			  },
			  easeInOutElastic: function (x, t, b, c, d) {
				  var s=1.70158;var p=0;var a=c;
				  if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
				  if (a < Math.abs(c)) { a=c; var s=p/4; }
				  else var s = p/(2*Math.PI) * Math.asin (c/a);
				  if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
				  return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
			  },
			  easeInBack: function (x, t, b, c, d, s) {
				  if (s == undefined) s = 1.70158;
				  return c*(t/=d)*t*((s+1)*t - s) + b;
			  },
			  easeOutBack: function (x, t, b, c, d, s) {
				  if (s == undefined) s = 1.70158;
				  return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
			  },
			  easeInOutBack: function (x, t, b, c, d, s) {
				  if (s == undefined) s = 1.70158; 
				  if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
				  return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
			  },
			  easeInBounce: function (x, t, b, c, d) {
				  return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
			  },
			  easeOutBounce: function (x, t, b, c, d) {
				  if ((t/=d) < (1/2.75)) {
					  return c*(7.5625*t*t) + b;
				  } else if (t < (2/2.75)) {
					  return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
				  } else if (t < (2.5/2.75)) {
					  return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
				  } else {
					  return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
				  }
			  },
			  easeInOutBounce: function (x, t, b, c, d) {
				  if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
				  return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
			  }
		  });

			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				/*
				
				Uniform v1.7.5
				Copyright © 2009 Josh Pyles / Pixelmatrix Design LLC
				http://pixelmatrixdesign.com
				
				Requires jQuery 1.4 or newer
				
				Much thanks to Thomas Reynolds and Buck Wilson for their help and advice on this
				
				Disabling text selection is made possible by Mathias Bynens <http://mathiasbynens.be/>
				and his noSelect plugin. <http://github.com/mathiasbynens/noSelect-jQuery-Plugin>
				
				Also, thanks to David Kaneda and Eugene Bond for their contributions to the plugin
				
				License:
				MIT License - http://www.opensource.org/licenses/mit-license.php
				
				Enjoy!
				
				*/
				
				  $.uniform = {
					options: {
					  selectClass:   'selector',
					  radioClass: 'radio',
					  checkboxClass: 'checker',
					  fileClass: 'uploader',
					  filenameClass: 'filename',
					  fileBtnClass: 'action',
					  fileDefaultText: 'No file selected',
					  fileBtnText: 'Choose File',
					  checkedClass: 'checked',
					  focusClass: 'focus',
					  disabledClass: 'disabled',
					  buttonClass: 'button',
					  activeClass: 'active',
					  hoverClass: 'hover',
					  useID: true,
					  idPrefix: 'uniform',
					  resetSelector: false,
					  autoHide: true
					},
					elements: []
				  };
				
				  if($.browser.msie && $.browser.version < 7){
					$.support.selectOpacity = false;
				  }else{
					$.support.selectOpacity = true;
				  }
				
				  $.fn.uniform = function(options) {
				
					options = $.extend($.uniform.options, options);
				
					var el = this;
					//code for specifying a reset button
					if(options.resetSelector != false){
					  $(options.resetSelector).mouseup(function(){
						function resetThis(){
						  $.uniform.update(el);
						}
						setTimeout(resetThis, 10);
					  });
					}
					
					function doInput(elem){
					  $el = $(elem);
					  $el.addClass($el.attr("type"));
					  storeElement(elem);
					}
					
					function doTextarea(elem){
					  $(elem).addClass("uniform");
					  storeElement(elem);
					}
					
					function doButton(elem){
					  var $el = $(elem);
					  
					  var divTag = $("<div>"),
						  spanTag = $("<span>");
					  
					  divTag.addClass(options.buttonClass);
					  
					  if(options.useID && $el.attr("id") != "") divTag.attr("id", options.idPrefix+"-"+$el.attr("id"));
					  
					  var btnText;
					  
					  if($el.is("a") || $el.is("button")){
						btnText = $el.text();
					  }else if($el.is(":submit") || $el.is(":reset") || $el.is("input[type=button]")){
						btnText = $el.attr("value");
					  }
					  
					  btnText = btnText == "" ? $el.is(":reset") ? "Reset" : "Submit" : btnText;
					  
					  spanTag.html(btnText);
					  
					  $el.css("opacity", 0);
					  $el.wrap(divTag);
					  $el.wrap(spanTag);
					  
					  //redefine variables
					  divTag = $el.closest("div");
					  spanTag = $el.closest("span");
					  
					  if($el.is(":disabled")) divTag.addClass(options.disabledClass);
					  
					  divTag.bind({
						"mouseenter.uniform": function(){
						  divTag.addClass(options.hoverClass);
						},
						"mouseleave.uniform": function(){
						  divTag.removeClass(options.hoverClass);
						  divTag.removeClass(options.activeClass);
						},
						"mousedown.uniform touchbegin.uniform": function(){
						  divTag.addClass(options.activeClass);
						},
						"mouseup.uniform touchend.uniform": function(){
						  divTag.removeClass(options.activeClass);
						},
						"click.uniform touchend.uniform": function(e){
						  if($(e.target).is("span") || $(e.target).is("div")){    
							if(elem[0].dispatchEvent){
							  var ev = document.createEvent('MouseEvents');
							  ev.initEvent( 'click', true, true );
							  elem[0].dispatchEvent(ev);
							}else{
							  elem[0].click();
							}
						  }
						}
					  });
					  
					  elem.bind({
						"focus.uniform": function(){
						  divTag.addClass(options.focusClass);
						},
						"blur.uniform": function(){
						  divTag.removeClass(options.focusClass);
						}
					  });
					  
					  $.uniform.noSelect(divTag);
					  storeElement(elem);
					  
					}
				
					function doSelect(elem){
					  var $el = $(elem);
					  
					  var divTag = $('<div />'),
						  spanTag = $('<span />');
					  
					  if(!$el.css("display") == "none" && options.autoHide){
						divTag.hide();
					  }
				
					  divTag.addClass(options.selectClass);
				
					  if(options.useID && elem.attr("id") != ""){
						divTag.attr("id", options.idPrefix+"-"+elem.attr("id"));
					  }
					  
					  var selected = elem.find(":selected:first");
					  if(selected.length == 0){
						selected = elem.find("option:first");
					  }
					  spanTag.html(selected.html());
					  
					  elem.css('opacity', 0);
					  elem.wrap(divTag);
					  elem.before(spanTag);
				
					  //redefine variables
					  divTag = elem.parent("div");
					  spanTag = elem.siblings("span");
				
					  elem.bind({
						"change.uniform": function() {
						  spanTag.text(elem.find(":selected").html());
						  divTag.removeClass(options.activeClass);
						},
						"focus.uniform": function() {
						  divTag.addClass(options.focusClass);
						},
						"blur.uniform": function() {
						  divTag.removeClass(options.focusClass);
						  divTag.removeClass(options.activeClass);
						},
						"mousedown.uniform touchbegin.uniform": function() {
						  divTag.addClass(options.activeClass);
						},
						"mouseup.uniform touchend.uniform": function() {
						  divTag.removeClass(options.activeClass);
						},
						"click.uniform touchend.uniform": function(){
						  divTag.removeClass(options.activeClass);
						},
						"mouseenter.uniform": function() {
						  divTag.addClass(options.hoverClass);
						},
						"mouseleave.uniform": function() {
						  divTag.removeClass(options.hoverClass);
						  divTag.removeClass(options.activeClass);
						},
						"keyup.uniform": function(){
						  spanTag.text(elem.find(":selected").html());
						}
					  });
					  
					  //handle disabled state
					  if($(elem).attr("disabled")){
						//box is checked by default, check our box
						divTag.addClass(options.disabledClass);
					  }
					  $.uniform.noSelect(spanTag);
					  
					  storeElement(elem);
				
					}
				
					function doCheckbox(elem){
					  var $el = $(elem);
					  
					  var divTag = $('<div />'),
						  spanTag = $('<span />');
					  
					  if(!$el.css("display") == "none" && options.autoHide){
						divTag.hide();
					  }
					  
					  divTag.addClass(options.checkboxClass);
				
					  //assign the id of the element
					  if(options.useID && elem.attr("id") != ""){
						divTag.attr("id", options.idPrefix+"-"+elem.attr("id"));
					  }
				
					  //wrap with the proper elements
					  $(elem).wrap(divTag);
					  $(elem).wrap(spanTag);
				
					  //redefine variables
					  spanTag = elem.parent();
					  divTag = spanTag.parent();
				
					  //hide normal input and add focus classes
					  $(elem)
					  .css("opacity", 0)
					  .bind({
						"focus.uniform": function(){
						  divTag.addClass(options.focusClass);
						},
						"blur.uniform": function(){
						  divTag.removeClass(options.focusClass);
						},
						"click.uniform touchend.uniform": function(){
						  if(!$(elem).attr("checked")){
							//box was just unchecked, uncheck span
							spanTag.removeClass(options.checkedClass);
						  }else{
							//box was just checked, check span.
							spanTag.addClass(options.checkedClass);
						  }
						},
						"mousedown.uniform touchbegin.uniform": function() {
						  divTag.addClass(options.activeClass);
						},
						"mouseup.uniform touchend.uniform": function() {
						  divTag.removeClass(options.activeClass);
						},
						"mouseenter.uniform": function() {
						  divTag.addClass(options.hoverClass);
						},
						"mouseleave.uniform": function() {
						  divTag.removeClass(options.hoverClass);
						  divTag.removeClass(options.activeClass);
						}
					  });
					  
					  //handle defaults
					  if($(elem).attr("checked")){
						//box is checked by default, check our box
						spanTag.addClass(options.checkedClass);
					  }
				
					  //handle disabled state
					  if($(elem).attr("disabled")){
						//box is checked by default, check our box
						divTag.addClass(options.disabledClass);
					  }
				
					  storeElement(elem);
					}
				
					function doRadio(elem){
					  var $el = $(elem);
					  
					  var divTag = $('<div />'),
						  spanTag = $('<span />');
						  
					  if(!$el.css("display") == "none" && options.autoHide){
						divTag.hide();
					  }
				
					  divTag.addClass(options.radioClass);
				
					  if(options.useID && elem.attr("id") != ""){
						divTag.attr("id", options.idPrefix+"-"+elem.attr("id"));
					  }
				
					  //wrap with the proper elements
					  $(elem).wrap(divTag);
					  $(elem).wrap(spanTag);
				
					  //redefine variables
					  spanTag = elem.parent();
					  divTag = spanTag.parent();
				
					  //hide normal input and add focus classes
					  $(elem)
					  .css("opacity", 0)
					  .bind({
						"focus.uniform": function(){
						  divTag.addClass(options.focusClass);
						},
						"blur.uniform": function(){
						  divTag.removeClass(options.focusClass);
						},
						"click.uniform touchend.uniform": function(){
						  if(!$(elem).attr("checked")){
							//box was just unchecked, uncheck span
							spanTag.removeClass(options.checkedClass);
						  }else{
							//box was just checked, check span
							var classes = options.radioClass.split(" ")[0];
							$("." + classes + " span." + options.checkedClass + ":has([name='" + $(elem).attr('name') + "'])").removeClass(options.checkedClass);
							spanTag.addClass(options.checkedClass);
						  }
						},
						"mousedown.uniform touchend.uniform": function() {
						  if(!$(elem).is(":disabled")){
							divTag.addClass(options.activeClass);
						  }
						},
						"mouseup.uniform touchbegin.uniform": function() {
						  divTag.removeClass(options.activeClass);
						},
						"mouseenter.uniform touchend.uniform": function() {
						  divTag.addClass(options.hoverClass);
						},
						"mouseleave.uniform": function() {
						  divTag.removeClass(options.hoverClass);
						  divTag.removeClass(options.activeClass);
						}
					  });
				
					  //handle defaults
					  if($(elem).attr("checked")){
						//box is checked by default, check span
						spanTag.addClass(options.checkedClass);
					  }
					  //handle disabled state
					  if($(elem).attr("disabled")){
						//box is checked by default, check our box
						divTag.addClass(options.disabledClass);
					  }
				
					  storeElement(elem);
				
					}
				
					function doFile(elem){
					  //sanitize input
					  var $el = $(elem);
				
					  var divTag = $('<div />'),
						  filenameTag = $('<span>'+options.fileDefaultText+'</span>'),
						  btnTag = $('<span>'+options.fileBtnText+'</span>');
					  
					  if(!$el.css("display") == "none" && options.autoHide){
						divTag.hide();
					  }
				
					  divTag.addClass(options.fileClass);
					  filenameTag.addClass(options.filenameClass);
					  btnTag.addClass(options.fileBtnClass);
				
					  if(options.useID && $el.attr("id") != ""){
						divTag.attr("id", options.idPrefix+"-"+$el.attr("id"));
					  }
				
					  //wrap with the proper elements
					  $el.wrap(divTag);
					  $el.after(btnTag);
					  $el.after(filenameTag);
				
					  //redefine variables
					  divTag = $el.closest("div");
					  filenameTag = $el.siblings("."+options.filenameClass);
					  btnTag = $el.siblings("."+options.fileBtnClass);
				
					  //set the size
					  if(!$el.attr("size")){
						var divWidth = divTag.width();
						//$el.css("width", divWidth);
						$el.attr("size", divWidth/10);
					  }
				
					  //actions
					  var setFilename = function()
					  {
				
						var filename = $el.val();
						if (filename === '')
						{
						  filename = options.fileDefaultText;
						}
						else
						{
						  filename = filename.split(/[\/\\]+/);
						  filename = filename[(filename.length-1)];
						}
						filenameTag.text(filename);
					  };
				
					  // Account for input saved across refreshes
					  setFilename();
				
					  $el
					  .css("opacity", 0)
					  .bind({
						"focus.uniform": function(){
						  divTag.addClass(options.focusClass);
						},
						"blur.uniform": function(){
						  divTag.removeClass(options.focusClass);
						},
						"mousedown.uniform": function() {
						  if(!$(elem).is(":disabled")){
							divTag.addClass(options.activeClass);
						  }
						},
						"mouseup.uniform": function() {
						  divTag.removeClass(options.activeClass);
						},
						"mouseenter.uniform": function() {
						  divTag.addClass(options.hoverClass);
						},
						"mouseleave.uniform": function() {
						  divTag.removeClass(options.hoverClass);
						  divTag.removeClass(options.activeClass);
						}
					  });
				
					  // IE7 doesn't fire onChange until blur or second fire.
					  if ($.browser.msie){
						// IE considers browser chrome blocking I/O, so it
						// suspends tiemouts until after the file has been selected.
						$el.bind('click.uniform.ie7', function() {
						  setTimeout(setFilename, 0);
						});
					  }else{
						// All other browsers behave properly
						$el.bind('change.uniform', setFilename);
					  }
				
					  //handle defaults
					  if($el.attr("disabled")){
						//box is checked by default, check our box
						divTag.addClass(options.disabledClass);
					  }
					  
					  $.uniform.noSelect(filenameTag);
					  $.uniform.noSelect(btnTag);
					  
					  storeElement(elem);
				
					}
					
					$.uniform.restore = function(elem){
					  if(elem == undefined){
						elem = $($.uniform.elements);
					  }
					  
					  $(elem).each(function(){
						if($(this).is(":checkbox")){
						  //unwrap from span and div
						  $(this).unwrap().unwrap();
						}else if($(this).is("select")){
						  //remove sibling span
						  $(this).siblings("span").remove();
						  //unwrap parent div
						  $(this).unwrap();
						}else if($(this).is(":radio")){
						  //unwrap from span and div
						  $(this).unwrap().unwrap();
						}else if($(this).is(":file")){
						  //remove sibling spans
						  $(this).siblings("span").remove();
						  //unwrap parent div
						  $(this).unwrap();
						}else if($(this).is("button, :submit, :reset, a, input[type='button']")){
						  //unwrap from span and div
						  $(this).unwrap().unwrap();
						}
						
						//unbind events
						$(this).unbind(".uniform");
						
						//reset inline style
						$(this).css("opacity", "1");
						
						//remove item from list of uniformed elements
						var index = $.inArray($(elem), $.uniform.elements);
						$.uniform.elements.splice(index, 1);
					  });
					};
				
					function storeElement(elem){
					  //store this element in our global array
					  elem = $(elem).get();
					  if(elem.length > 1){
						$.each(elem, function(i, val){
						  $.uniform.elements.push(val);
						});
					  }else{
						$.uniform.elements.push(elem);
					  }
					}
					
					//noSelect v1.0
					$.uniform.noSelect = function(elem) {
					  function f() {
					   return false;
					  };
					  $(elem).each(function() {
					   this.onselectstart = this.ondragstart = f; // Webkit & IE
					   $(this)
						.mousedown(f) // Webkit & Opera
						.css({ MozUserSelect: 'none' }); // Firefox
					  });
					 };
				
					$.uniform.update = function(elem){
					  if(elem == undefined){
						elem = $($.uniform.elements);
					  }
					  //sanitize input
					  elem = $(elem);
				
					  elem.each(function(){
						//do to each item in the selector
						//function to reset all classes
						var $e = $(this);
				
						if($e.is("select")){
						  //element is a select
						  var spanTag = $e.siblings("span");
						  var divTag = $e.parent("div");
				
						  divTag.removeClass(options.hoverClass+" "+options.focusClass+" "+options.activeClass);
				
						  //reset current selected text
						  spanTag.html($e.find(":selected").html());
				
						  if($e.is(":disabled")){
							divTag.addClass(options.disabledClass);
						  }else{
							divTag.removeClass(options.disabledClass);
						  }
				
						}else if($e.is(":checkbox")){
						  //element is a checkbox
						  var spanTag = $e.closest("span");
						  var divTag = $e.closest("div");
				
						  divTag.removeClass(options.hoverClass+" "+options.focusClass+" "+options.activeClass);
						  spanTag.removeClass(options.checkedClass);
				
						  if($e.is(":checked")){
							spanTag.addClass(options.checkedClass);
						  }
						  if($e.is(":disabled")){
							divTag.addClass(options.disabledClass);
						  }else{
							divTag.removeClass(options.disabledClass);
						  }
				
						}else if($e.is(":radio")){
						  //element is a radio
						  var spanTag = $e.closest("span");
						  var divTag = $e.closest("div");
				
						  divTag.removeClass(options.hoverClass+" "+options.focusClass+" "+options.activeClass);
						  spanTag.removeClass(options.checkedClass);
				
						  if($e.is(":checked")){
							spanTag.addClass(options.checkedClass);
						  }
				
						  if($e.is(":disabled")){
							divTag.addClass(options.disabledClass);
						  }else{
							divTag.removeClass(options.disabledClass);
						  }
						}else if($e.is(":file")){
						  var divTag = $e.parent("div");
						  var filenameTag = $e.siblings(options.filenameClass);
						  btnTag = $e.siblings(options.fileBtnClass);
				
						  divTag.removeClass(options.hoverClass+" "+options.focusClass+" "+options.activeClass);
				
						  filenameTag.text($e.val());
				
						  if($e.is(":disabled")){
							divTag.addClass(options.disabledClass);
						  }else{
							divTag.removeClass(options.disabledClass);
						  }
						}else if($e.is(":submit") || $e.is(":reset") || $e.is("button") || $e.is("a") || elem.is("input[type=button]")){
						  var divTag = $e.closest("div");
						  divTag.removeClass(options.hoverClass+" "+options.focusClass+" "+options.activeClass);
						  
						  if($e.is(":disabled")){
							divTag.addClass(options.disabledClass);
						  }else{
							divTag.removeClass(options.disabledClass);
						  }
						  
						}
						
					  });
					};
				
					return this.each(function() {
					  if($.support.selectOpacity){
						var elem = $(this);
				
						if(elem.is("select")){
						  //element is a select
						  if(elem.attr("multiple") != true){
							//element is not a multi-select
							if(elem.attr("size") == undefined || elem.attr("size") <= 1){
							  doSelect(elem);
							}
						  }
						}else if(elem.is(":checkbox")){
						  //element is a checkbox
						  doCheckbox(elem);
						}else if(elem.is(":radio")){
						  //element is a radio
						  doRadio(elem);
						}else if(elem.is(":file")){
						  //element is a file upload
						  doFile(elem);
						}else if(elem.is(":text, :password, input[type='email']")){
						  doInput(elem);
						}else if(elem.is("textarea")){
						  doTextarea(elem);
						}else if(elem.is("a") || elem.is(":submit") || elem.is(":reset") || elem.is("button") || elem.is("input[type=button]")){
						  doButton(elem);
						}
						  
					  }
					});
				  };
				  
				  //$(".variations_form .variations select, .woocommerce_ordering select.orderby, .widget-container select, .shipping-calculator-form select").uniform();		
				  $("select:not(#rating, .checkout select, .mobile-dropdown)").uniform();		

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		  /*global jQuery */
		  /*!
		  * FitVids 1.0
		  *
		  * Copyright 2011, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
		  * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
		  * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
		  *
		  * Date: Thu Sept 01 18:00:00 2011 -0500
		  */
		  		  
		  $.fn.fitVids = function( options ) {
			var settings = {
			  customSelector: null
			}
		
			var div = document.createElement('div'),
				ref = document.getElementsByTagName('base')[0] || document.getElementsByTagName('script')[0];
		
			div.className = 'fit-vids-style';
			div.innerHTML = '&shy;<style>         \
			  .fluid-width-video-wrapper {        \
				 width: 100%;                     \
				 position: relative;              \
				 padding: 0;                      \
			  }                                   \
												  \
			  .fluid-width-video-wrapper iframe,  \
			  .fluid-width-video-wrapper object,  \
			  .fluid-width-video-wrapper embed {  \
				 position: absolute;              \
				 top: 0;                          \
				 left: 0;                         \
				 width: 100%;                     \
				 height: 100%;                    \
			  }                                   \
			</style>';
		
			ref.parentNode.insertBefore(div,ref);
		
			if ( options ) {
			  $.extend( settings, options );
			}
		
			return this.each(function(){
			  var selectors = [
				"iframe[src*='player.vimeo.com']",
				"iframe[src*='www.youtube.com']",
				"iframe[src*='www.kickstarter.com']",
				"object",
				"embed"
			  ];
		
			  if (settings.customSelector) {
				selectors.push(settings.customSelector);
			  }
		
			  var $allVideos = $(this).find(selectors.join(','));
		
			  $allVideos.each(function(){
				var $this = $(this);
				if (this.tagName.toLowerCase() == 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
				var height = ( this.tagName.toLowerCase() == 'object' || $this.attr('height') ) ? $this.attr('height') : $this.height(),
					width = $this.attr('width') ? $this.attr('width') : $this.width(),
					aspectRatio = height / width;
				if(!$this.attr('id')){
				  var videoID = 'fitvid' + Math.floor(Math.random()*999999);
				  $this.attr('id', videoID);
				}
				$this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
				$this.removeAttr('height').removeAttr('width');
			  });
			});
		  }	
		  jQuery('.video').fitVids();				  

			  // WPEC 
			  if ( sp_custom.wpec_active === '1' )
			  {	
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// image swap
				jQuery('.sp-attachment-thumbnails').click(function(){
					var loading = jQuery(this).parents('.imagecol:first').find('img.load');
					loading.show();
					var productImage = jQuery(this).parents('.imagecol:first').find('.product_image');
					var timString = jQuery(this).parent().attr('data-src');
					var title = jQuery(this).parent().attr('title');
					var height = /[&?]h=(\d+)/.exec( timString );
					var width = /[&?]w=(\d+)/.exec( timString );
					// checks to make sure sizes are not null
					height = (height == null) ? 347 : height[1];
					width = (width == null) ? 347 : width[1];
					
					productImage.attr( 'src', timString ).attr( 'height', height ).attr( 'width', width ).attr('alt', title);
					productImage.parent('a:first').attr('href', jQuery(this).parent().attr('href')).attr('title', title);
					loading.hide();
					return false;
				});
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// gold cart ordering/sorting function
						jQuery('#wpsc-main-search select').live('change', function(){
							var t = jQuery(this), qs;
							if (t.val() !== '') {
								location.search = jQuery.query.SET(t.attr('name'), t.val());
							}
						});
					
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// sp wpec product category accordion
					jQuery(".sp-cat-accordion").show().accordion({
						collapsible: true,
						active: false,
						autoHeight: false,
						header: 'a.header'	
					});
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// sp wpec product price range slider
					var price_max = jQuery(".sp-wpec-price-range-slider-widget #price-max").val();
					var price_min = jQuery(".sp-wpec-price-range-slider-widget #price-min").val();
					var selected_min = jQuery(".sp-wpec-price-range-slider-widget #selected-min").val();
					var selected_max = jQuery(".sp-wpec-price-range-slider-widget #selected-max").val();
					var currsymbol = jQuery(".sp-wpec-price-range-slider-widget #currsymbol").val();
					var shop_link = jQuery( ".sp-wpec-price-range-slider-widget a.price-filter" );
					if ( shop_link.length )
						var shop_link_href = shop_link.attr('href').replace( 'all', '' );
					
					jQuery( ".sp-wpec-price-range-slider-widget #slider-range" ).slider({
						range: true,
						min: price_min,
						max: price_max,
						values: [ selected_min, selected_max ],
						slide: function( event, ui ) {
							jQuery( ".sp-wpec-price-range-slider-widget #price" ).val( currsymbol + ui.values[ 0 ] + " - " + currsymbol + ui.values[ 1 ] );
							
							shop_link.attr('href', shop_link_href + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
						}
					});
					jQuery( ".sp-wpec-price-range-slider-widget #price" ).val( currsymbol + $( ".sp-wpec-price-range-slider-widget #slider-range" ).slider( "values", 0 ) + " - " + currsymbol + $( ".sp-wpec-price-range-slider-widget #slider-range" ).slider( "values", 1 ) );			
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// check to see if quickview is enabled
					if (jQuery("input.quickview_enabled").val() === "true") {
						// gridview image hover show quick view
						jQuery(".product_grid_item .item_image").hover(function() {
							if (jQuery("#quickview_enable").val() == "true") {
								jQuery(".quickview-button",this).stop(true, true).fadeIn(300);
								
							}
							jQuery(".more-button",this).stop(true, true).animate({bottom: '0'},300);
						},function() {
							if (jQuery("#quickview_enable").val() == "true") {
								jQuery(".quickview-button",this).stop(true, true).fadeOut(300);	
								
							}
							jQuery(".more-button",this).stop(true, true).animate({bottom: '-20px'},300);
						});
					
						// quickview container
							jQuery(".product_grid_item .quickview-button").click(function() {
								var $product_id = jQuery(this).parents(".product_grid_item").find("input.hidden-id").val();
								var $product_content = jQuery(".product_item.product_view_"+$product_id).fadeIn(300).center().css("position","fixed");
								jQuery('body').append("<div class='quickview_popup'></div>");
								if (navigator.appName === "Microsoft Internet Explorer") {
									jQuery(".quickview_popup").hide().show();
									jQuery('body').append($product_content);
									
								} else { 
									jQuery(".quickview_popup").hide().fadeIn(300,function() { jQuery('body').append($product_content); });
								}
								return false;
							});
							
							jQuery(".quickview_popup").live('click',function() {
								jQuery(this).fadeOut(200, function() { jQuery(".product_item:visible").hide(); jQuery(this).remove(); });	
							});
							
							jQuery(".product_item .close").live('click',function() {
								jQuery(".quickview_popup").fadeOut(200, function() { jQuery(".product_item:visible").hide(); jQuery(this).remove(); });	
								return false;
							});
				
					} else {
						jQuery(".product_grid_item .item_image").hover(function() {
							jQuery(".more-button",this).stop(true, true).animate({bottom: '0'},300);
						},function() {
							jQuery(".more-button",this).stop(true, true).animate({bottom: '-20px'},300);
						});
						
					}
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// default view more details hover	
						jQuery(".default_product_display .item_image, .wpsc_also_bought .also_bought_item_image").hover(function() {
							jQuery(".more-button",this).stop(true, true).animate({bottom: '0'},300);
						},function() {
							jQuery(".more-button",this).stop(true, true).animate({bottom: '-20px'},300);
						});
			  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				  // terms and conditions
				  jQuery(".terms_lightbox").live('click', function(e) {
					  e.preventDefault();
					  var term_content = jQuery("#term-content").html();	
					  var term_container = '<div class="term-container">'+term_content+'</div>';
					  var overlay = '<div class="term-overlay"></div>';		
					  jQuery(overlay).appendTo('body').fadeIn(300,function() {
						  jQuery(term_container).appendTo('body').center().fadeIn(800);
					  });
				  });
				  if (jQuery(".term-overlay:visible")) {
					  jQuery("body").click(function() {
						  jQuery(".term-container").remove();
						  jQuery(".term-overlay").remove();
					  });
				  }

		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // header cart update
			  function update_count() {
					  var $spdata = {
						  action: "sp_add_to_cart",
						  ajaxCustomNonce : sp_custom.ajaxCustomNonce
					  };
					jQuery.post(sp_custom.ajaxurl, $spdata, function(response) {
						//alert("inside ajax");
						var response = jQuery.parseJSON(response);
						jQuery("#header-cart em.count span.number").html(response.count);
						jQuery("#header-cart em.total span.price").html(response.total);
					});
				  return false;
				  
			  }
			  
				// Submit the product form using AJAX
				jQuery( 'form.product_form_ajax, .wpsc-add-to-cart-button-form' ).on( 'submit', function() {
					var product = jQuery(".wpsc_buy_button",this);
					// we cannot submit a file through AJAX, so this needs to return true to submit the form normally if a file formfield is present
					file_upload_elements = jQuery.makeArray( jQuery( 'input[type="file"]', jQuery( this ) ) );
					if(file_upload_elements.length > 0) {
						return true;
					} else {
						form_values = jQuery(this).serialize() + '&action=' + jQuery( 'input[name="wpsc_ajax_action"]' ).val();

						// Sometimes jQuery returns an object instead of null, using length tells us how many elements are in the object, which is more reliable than comparing the object to null
						if( jQuery( '#fancy_notification' ).length === 0 ) {
							jQuery( 'div.wpsc_loading_animation', this ).css( 'visibility', 'visible' );
						}

						var success = function( response ) {
							if ( response.fancy_notification ) {
								//if ( jQuery( '#fancy_notification_content' ) ) {
									jQuery( '#fancy_notification_content' ).html( response.fancy_notification );
								//}
							}							
							update_count();
							jQuery('div.shopping-cart-wrapper').html( response.widget_output );
							jQuery('div.wpsc_loading_animation').css('visibility', 'hidden');

							jQuery( '.cart_message' ).delay( 3000 ).slideUp( 500 );

							//Until we get to an acceptable level of education on the new custom event - this is probably necessary for plugins.
							if ( response.wpsc_alternate_cart_html ) {
								eval( response.wpsc_alternate_cart_html );
							}

							jQuery( document ).trigger( { type : 'wpsc_fancy_notification', response : response } );
							if ( jQuery( '#fancy_notification' ).length === 0 ) {
								jQuery('#loading_animation').css("display", 'none');
								jQuery(product).parents(".wpsc_buy_button_container .input-button-buy").children(".alert.addtocart").fadeIn(300,function() { jQuery(this).delay(3000).fadeOut(300); });
							}	

							//update header cart when empty cart is clicked
							jQuery("form.wpsc_empty_the_cart a.emptycart_ajax").click( function() {
								jQuery("form.wpsc_empty_the_cart img.empty-cart-loading").show();
								parent_form = jQuery(this).parents("form.wpsc_empty_the_cart");
								form_values = jQuery(parent_form).serialize() + '&action=' + jQuery( 'input[name="wpsc_ajax_action"]', parent_form ).val();
								jQuery.post( wpsc_ajax.ajaxurl, form_values, function(response) {
									jQuery('div.shopping-cart-wrapper').html( response.widget_output );
									jQuery("#header-cart em.count span.number").html("0");
									jQuery("#header-cart em.total span.price .pricedisplay").html("0");
								}, 'json');
								
								return false;

							});											
						};

						jQuery.post( wpsc_ajax.ajaxurl, form_values, success, 'json' );

						sp_wpsc_fancy_notification(this);
						return false;
					}
				});			

				// submit the fancy notifications forms.
				function sp_wpsc_fancy_notification(parent_form){
					if(typeof(WPSC_SHOW_FANCY_NOTIFICATION) == 'undefined'){
						WPSC_SHOW_FANCY_NOTIFICATION = true;
					}
					if((WPSC_SHOW_FANCY_NOTIFICATION == true) && (jQuery('#fancy_notification').length !== 0) && (jQuery("input.quickview_enabled").val() != "true")){ 
						form_button_id = jQuery(parent_form).attr('id') + "_submit_button";
						var element = jQuery('#fancy_notification').css("display", 'block').center().css("position","fixed");
						jQuery('body').append("<div class='popup'></div>");
						if (navigator.appName === "Microsoft Internet Explorer") {
							jQuery(".popup").hide().show();
						} else { 
							jQuery(".popup").hide().fadeIn(300);
						}
						jQuery('body').append(element);
						jQuery('#fancy_notification_content').css("display", 'block');
					}
				}
				// binds the continue shopping button and hides the overlay
				jQuery(".continue_shopping").live('click',function() {
					jQuery(".popup").fadeOut(200, function() { jQuery(this).remove(); });
					//jQuery('#fancy_notification').remove();
				});
						
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//update header cart when empty cart is clicked
				jQuery("form.wpsc_empty_the_cart").on('click', 'a.emptycart_ajax', function() {
					jQuery("form.wpsc_empty_the_cart img.empty-cart-loading").show();
					parent_form = jQuery(this).parents("form.wpsc_empty_the_cart");
					form_values = jQuery(parent_form).serialize() + '&action=' + jQuery( 'input[name="wpsc_ajax_action"]', parent_form ).val();
					jQuery.post( wpsc_ajax.ajaxurl, form_values, function(response) {
						jQuery('div.shopping-cart-wrapper').html( response.widget_output );
						jQuery("#header-cart em.count span.number").html("0");
						jQuery("#header-cart em.total span.price .pricedisplay").html("0");
					}, 'json');
					
					return false;

				});
			  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// variation image swap function
				function sp_variation_image_swap(product_id, var_ids) {
					var $image_element = jQuery("a[data-id="+product_id+"]").find("img.product_image");
					var $timthumb_options = $image_element.attr('src');
					$timthumb_options = $timthumb_options.match('&.*');
					
					var $data = {
					action: "sp_variation_image_swap",
					product_id: product_id,
					var_ids: var_ids,
					ajaxCustomNonce : sp_custom.ajaxCustomNonce
					};
					jQuery.post(sp_custom.ajaxurl, $data, function(response) {
						response = jQuery.parseJSON(response);
						jQuery('img.loading-'+product_id).hide();
						if (response) { 
							$image_element.parent('.preview_link').attr('href',response.image_src);
							$image_element.fadeTo('fast',0, function() {
								var newImage = $('<img src="' + sp_custom.framework_url+'timthumb/timthumb.php?src='+response.image_src+$timthumb_options + '">'); // used to preload the new swapped image to prevent stutter
								$( newImage ).load( function()
								{ 
									$image_element.attr("src", sp_custom.framework_url+'timthumb/timthumb.php?src='+response.image_src+$timthumb_options).fadeTo('fast',1).attr("alt", response.image_alt).parent('.preview_link').attr('title', response.image_alt);
									
							    });
							});
						} else {
							$image_element.fadeTo('fast',1);	
						}
					}); 
				}
			  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // update price when variation changes
			  jQuery(".wpsc_select_variation_ajax").live('change', function() {
				  jQuery('option[value="0"]', this).attr('disabled', 'disabled');
				  var parent_form = jQuery(this).parents("form.product_form_ajax");
				  if ( parent_form.length == 0 )
					  return;		
		  
				  var product_id = jQuery(this).parents('form.product_form_ajax').children('input[name="product_id"]').val();
				  if (jQuery("input#variation_image_swap").val() === "true") {
					  var allSelected;
					  var var_ids = new Array();
					  var i = 0; //counter
		  
					  // loops through all selections and check if all has been selected to proceed (also captures all variation ids)
					  jQuery(parent_form).find("select.wpsc_select_variation_ajax").each(function() {
						  if (jQuery("option:selected",this).val() == 0) {
							  allSelected = false;
							  return false;
						  } else {
							  var_ids[i] = jQuery("option:selected",this).val();
							  allSelected = true;
							  i++;	
						  }
					  });
		  
					  // if all selections have been made continue
					  if (allSelected) {
						  jQuery('img.loading-'+product_id).show();
						  jQuery('img#product_image_'+product_id).fadeTo('fast',0.5);
						  sp_variation_image_swap(product_id, var_ids); // runs the function to perform the variation image swap
					  }
				  }
				  form_values =jQuery("input[name='product_id'], .wpsc_select_variation_ajax",parent_form).serialize( );
				  jQuery.post( sp_custom.site_url+'?update_product_price=true', form_values, function(response) {
					  var stock_display = jQuery('div.stock_display_' + product_id),
						  price_field = jQuery('input.product_price_' + product_id),
						  price_span = jQuery('.product_price_' + product_id + '.pricedisplay, .product_price_' + product_id + ' .currentprice'),
						  donation_price = jQuery('input.donation_price_' + product_id),
						  old_price = jQuery('.old_product_price_' + product_id),
						  save = jQuery('.yousave_' + product_id),
						  buynow = jQuery('.BB_BuyButtonForm' + product_id);
					  if ( response.variation_found ) {
						  if ( response.stock_available ) {
							  stock_display.removeClass('out_of_stock').addClass('in_stock');
						  } else {
							  stock_display.addClass('out_of_stock').removeClass('in_stock');
						  }
					  }
					  
					  stock_display.html(response.variation_msg);
					  
					  if ( response.price !== undefined ) {
						  if (price_field.length && price_field.attr('type') == 'text') {
							  price_field.val(response.numeric_price);
						  } else {
							  price_span.html(response.price);
							  old_price.html(response.old_price);
							  save.html(response.you_save);
						  }
						  donation_price.val(response.numeric_price);
					  }
				  }, 'json');
			  });
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
				// resets the width of the credit card expiry input fields			

				jQuery(".wpsc_checkout_table.table-2").find("input[name='expiry[month]']").css("width", "20px");
				jQuery(".wpsc_checkout_table.table-2").find("input[name='expiry[year]']").css("width", "20px");		
				
				// below is needed to hide/show different gateways - from WPEC legacy user.js file
				jQuery("div.custom_gateway table").each(
					function() {
						if(jQuery(this).css('display') == 'none') {
							jQuery('input', this).attr( 'disabled', true);
						}
					}
					);
				
				function selectCustomGateway() {
					var parent_div = jQuery(this).parents("div.custom_gateway");
		
					jQuery('table input',parent_div).attr( 'disabled', false);
					jQuery('table',parent_div).show();
					jQuery("div.custom_gateway table").not(jQuery('table',parent_div)).hide();
					jQuery("div.custom_gateway table input").not(jQuery('table input',parent_div)).attr( 'disabled', true);
				}
				
				jQuery("input.custom_gateway").change(
					function() {
						if(jQuery(this).is(':checked') == true) {
							selectCustomGateway.call(this);
						}
					}
					);
					
				selectCustomGateway.call(jQuery('input.custom_gateway:checked'));
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// check if variation is selected, if not bounce box
					jQuery('.productcol, .textcol').each(function(){
					jQuery('.wpsc_buy_button', this).click(function(){
						var addtocart = true;
						jQuery(this).parents('form:first').find('select.wpsc_select_variation_ajax').parent(".selector").each(function(){
							if(jQuery(this).find('select.wpsc_select_variation_ajax').val() <= 0){
								//$div = jQuery(this).parent(".selector");
								jQuery(this).css('position','relative');
								jQuery(this).stop(true, true).animate({'left': '-=5px'}, 50, function(){
									jQuery(this).stop(true, true).animate({'left': '+=10px'}, 100, function(){
										jQuery(this).stop(true, true).animate({'left': '-=10px'}, 100, function(){
											jQuery(this).stop(true, true).animate({'left': '+=10px'}, 100, function(){
												jQuery(this).stop(true, true).animate({'left': '-=5px'}, 50, function() {
													jQuery(this).parents(".productcol").find(".alert.error").fadeIn(300,function() { jQuery(this).delay(4000).fadeOut(300); });
												});
											});
										});
									});
								});
								addtocart = false;
							}
						});
						
						if ( addtocart ) {
							return true;
						} else {
							return false;
						}
					});
				});	
		  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// jQuery Star rating system by http://www.fyneworks.com/jquery/star-rating/ 
				// Version 3.1.4
				// IE6 Background Image Fix
				if ($.browser.msie) try { document.execCommand("BackgroundImageCache", false, true)} catch(e) { };
				// Thanks to http://www.visualjquery.com/rating/rating_redux.html
				
				// plugin initialization
				$.fn.rating = function(options){
					if(this.length==0) return this; // quick fail
					
					// Handle API methods
					if(typeof arguments[0]=='string'){
						// Perform API methods on individual elements
						if(this.length>1){
							var args = arguments;
							return this.each(function(){
								$.fn.rating.apply($(this), args);
				});
						};
						// Invoke API method handler
						$.fn.rating[arguments[0]].apply(this, $.makeArray(arguments).slice(1) || []);
						// Quick exit...
						return this;
					};
					
					// Initialize options for this call
					var options = $.extend(
						{}/* new object */,
						$.fn.rating.options/* default options */,
						options || {} /* just-in-time options */
					);
					
					// Allow multiple controls with the same name by making each call unique
					$.fn.rating.calls++;
					
					// loop through each matched element
					this
					 .not('.star-rating-applied')
						.addClass('star-rating-applied')
					.each(function(){
						
						// Load control parameters / find context / etc
						var control, input = $(this);
						var eid = (this.name || 'unnamed-rating').replace(/\[|\]/g, '_').replace(/^\_+|\_+$/g,'');
						var context = $(this.form || document.body);
						
						// FIX: http://code.google.com/p/jquery-star-rating-plugin/issues/detail?id=23
						var raters = context.data('rating');
						if(!raters || raters.call!=$.fn.rating.calls) raters = { count:0, call:$.fn.rating.calls };
						var rater = raters[eid];
						
						// if rater is available, verify that the control still exists
						if(rater) control = rater.data('rating');
						
						if(rater && control)//{// save a byte!
							// add star to control if rater is available and the same control still exists
							control.count++;
							
						//}// save a byte!
						else{
							// create new control if first star or control element was removed/replaced
							
							// Initialize options for this rater
							control = $.extend(
								{}/* new object */,
								options || {} /* current call options */,
								($.metadata? input.metadata(): ($.meta?input.data():null)) || {}, /* metadata options */
								{ count:0, stars: [], inputs: [] }
							);
							
							// increment number of rating controls
							control.serial = raters.count++;
							
							// create rating element
							rater = $('<span class="star-rating-control"/>');
							input.before(rater);
							
							// Mark element for initialization (once all stars are ready)
							rater.addClass('rating-to-be-drawn');
							
							// Accept readOnly setting from 'disabled' property
							if(input.attr('disabled') || input.hasClass('disabled')) control.readOnly = true;
							
							// Accept required setting from class property (class='required')
							if(input.hasClass('required')) control.required = true;
							
							// Create 'cancel' button
							rater.append(
								control.cancel = $('<div class="rating-cancel"><a title="' + control.cancel + '">' + control.cancelValue + '</a></div>')
								.mouseover(function(){
									$(this).rating('drain');
									$(this).addClass('star-rating-hover');
									//$(this).rating('focus');
								})
								.mouseout(function(){
									$(this).rating('draw');
									$(this).removeClass('star-rating-hover');
									//$(this).rating('blur');
								})
								.click(function(){
								 $(this).rating('select');
								})
								.data('rating', control)
							);
							
						}; // first element of group
						
						// insert rating star
						var star = $('<div class="wpec-star-rating rater-'+ control.serial +'"><a title="' + (this.title || this.value) + '">' + this.value + '</a></div>');
						rater.append(star);
						
						// inherit attributes from input element
						if(this.id) star.attr('id', this.id);
						if(this.className) star.addClass(this.className);
						
						// Half-stars?
						if(control.half) control.split = 2;
						
						// Prepare division control
						if(typeof control.split=='number' && control.split>0){
							var stw = ($.fn.width ? star.width() : 0) || control.starWidth;
							var spi = (control.count % control.split), spw = Math.floor(stw/control.split);
							star
							// restrict star's width and hide overflow (already in CSS)
							.width(spw)
							// move the star left by using a negative margin
							// this is work-around to IE's stupid box model (position:relative doesn't work)
							.find('a').css({ 'margin-left':'-'+ (spi*spw) +'px' })
						};
						
						// readOnly?
						if(control.readOnly)//{ //save a byte!
							// Mark star as readOnly so user can customize display
							star.addClass('star-rating-readonly');
						//}  //save a byte!
						else//{ //save a byte!
						 // Enable hover css effects
							star.addClass('star-rating-live')
							 // Attach mouse events
								.mouseover(function(){
									$(this).rating('fill');
									$(this).rating('focus');
								})
								.mouseout(function(){
									$(this).rating('draw');
									$(this).rating('blur');
								})
								.click(function(){
									$(this).rating('select');
								})
							;
						//}; //save a byte!
						
						// set current selection
						if(this.checked)	control.current = star;
						
						// set current select for links
						if(this.nodeName=="A"){
				if($(this).hasClass('selected'))
				 control.current = star;
			   };
						
						// hide input element
						input.hide();
						
						// backward compatibility, form element to plugin
						input.change(function(){
				$(this).rating('select');
			   });
						
						// attach reference to star to input element and vice-versa
						star.data('rating.input', input.data('rating.star', star));
						
						// store control information in form (or body when form not available)
						control.stars[control.stars.length] = star[0];
						control.inputs[control.inputs.length] = input[0];
						control.rater = raters[eid] = rater;
						control.context = context;
						
						input.data('rating', control);
						rater.data('rating', control);
						star.data('rating', control);
						context.data('rating', raters);
			  }); // each element
					
					// Initialize ratings (first draw)
					$('.rating-to-be-drawn').rating('draw').removeClass('rating-to-be-drawn');
					
					return this; // don't break the chain...
				};
				
				/*--------------------------------------------------------*/
				
				/*
					### Core functionality and API ###
				*/
				$.extend($.fn.rating, {
					// Used to append a unique serial number to internal control ID
					// each time the plugin is invoked so same name controls can co-exist
					calls: 0,
					
					focus: function(){
						var control = this.data('rating'); if(!control) return this;
						if(!control.focus) return this; // quick fail if not required
						// find data for event
						var input = $(this).data('rating.input') || $( this.tagName=='INPUT' ? this : null );
			   // focus handler, as requested by focusdigital.co.uk
						if(control.focus) control.focus.apply(input[0], [input.val(), $('a', input.data('rating.star'))[0]]);
					}, // $.fn.rating.focus
					
					blur: function(){
						var control = this.data('rating'); if(!control) return this;
						if(!control.blur) return this; // quick fail if not required
						// find data for event
						var input = $(this).data('rating.input') || $( this.tagName=='INPUT' ? this : null );
			   // blur handler, as requested by focusdigital.co.uk
						if(control.blur) control.blur.apply(input[0], [input.val(), $('a', input.data('rating.star'))[0]]);
					}, // $.fn.rating.blur
					
					fill: function(){ // fill to the current mouse position.
						var control = this.data('rating'); if(!control) return this;
						// do not execute when control is in read-only mode
						if(control.readOnly) return;
						// Reset all stars and highlight them up to this element
						this.rating('drain');
						this.prevAll().andSelf().filter('.rater-'+ control.serial).addClass('star-rating-hover');
					},// $.fn.rating.fill
					
					drain: function() { // drain all the stars.
						var control = this.data('rating'); if(!control) return this;
						// do not execute when control is in read-only mode
						if(control.readOnly) return;
						// Reset all stars
						control.rater.children().filter('.rater-'+ control.serial).removeClass('star-rating-on').removeClass('star-rating-hover');
					},// $.fn.rating.drain
					
					draw: function(){ // set value and stars to reflect current selection
						var control = this.data('rating'); if(!control) return this;
						// Clear all stars
						this.rating('drain');
						// Set control value
						if(control.current){
							control.current.data('rating.input').attr('checked','checked');
							control.current.prevAll().andSelf().filter('.rater-'+ control.serial).addClass('star-rating-on');
						}
						else
						 $(control.inputs).removeAttr('checked');
						// Show/hide 'cancel' button
						control.cancel[control.readOnly || control.required?'hide':'show']();
						// Add/remove read-only classes to remove hand pointer
						this.siblings()[control.readOnly?'addClass':'removeClass']('star-rating-readonly');
					},// $.fn.rating.draw
					
					
					
					
					
					select: function(value,wantCallBack){ // select a value
								
								// ***** MODIFICATION *****
								// Thanks to faivre.thomas - http://code.google.com/p/jquery-star-rating-plugin/issues/detail?id=27
								//
								// ***** LIST OF MODIFICATION *****
								// ***** added Parameter wantCallBack : false if you don't want a callback. true or undefined if you want postback to be performed at the end of this method'
								// ***** recursive calls to this method were like : ... .rating('select') it's now like .rating('select',undefined,wantCallBack); (parameters are set.)
								// ***** line which is calling callback
								// ***** /LIST OF MODIFICATION *****
						
						var control = this.data('rating'); if(!control) return this;
						// do not execute when control is in read-only mode
						if(control.readOnly) return;
						// clear selection
						control.current = null;
						// programmatically (based on user input)
						if(typeof value!='undefined'){
						 // select by index (0 based)
							if(typeof value=='number')
						 return $(control.stars[value]).rating('select',undefined,wantCallBack);
							// select by literal value (must be passed as a string
							if(typeof value=='string')
								//return
								$.each(control.stars, function(){
									if($(this).data('rating.input').val()==value) $(this).rating('select',undefined,wantCallBack);
								});
						}
						else
							control.current = this[0].tagName=='INPUT' ?
							 this.data('rating.star') :
								(this.is('.rater-'+ control.serial) ? this : null);
			
						// Update rating control state
						this.data('rating', control);
						// Update display
						this.rating('draw');
						// find data for event
						var input = $( control.current ? control.current.data('rating.input') : null );
						// click callback, as requested here: http://plugins.jquery.com/node/1655
								
								// **** MODIFICATION *****
								// Thanks to faivre.thomas - http://code.google.com/p/jquery-star-rating-plugin/issues/detail?id=27
								//
								//old line doing the callback :
								//if(control.callback) control.callback.apply(input[0], [input.val(), $('a', control.current)[0]]);// callback event
								//
								//new line doing the callback (if i want :)

								if((wantCallBack ||wantCallBack == undefined) && control.callback) control.callback.apply(input[0], [input.val(), $('a', control.current)[0]]);// callback event
								//to ensure retro-compatibility, wantCallBack must be considered as true by default
								// **** /MODIFICATION *****
								
			  },// $.fn.rating.select
					
					
					
					
					
					readOnly: function(toggle, disable){ // make the control read-only (still submits value)
						var control = this.data('rating'); if(!control) return this;
						// setread-only status
						control.readOnly = toggle || toggle==undefined ? true : false;
						// enable/disable control value submission
						if(disable) $(control.inputs).attr("disabled", "disabled");
						else     			$(control.inputs).removeAttr("disabled");
						// Update rating control state
						this.data('rating', control);
						// Update display
						this.rating('draw');
					},// $.fn.rating.readOnly
					
					disable: function(){ // make read-only and never submit value
						this.rating('readOnly', true, true);
					},// $.fn.rating.disable
					
					enable: function(){ // make read/write and submit value
						this.rating('readOnly', false, false);
					}// $.fn.rating.select
					
			 });
				
				/*--------------------------------------------------------*/
				
				/*
					### Default Settings ###
					eg.: You can override default control like this:
					$.fn.rating.options.cancel = 'Clear';
				*/
				$.fn.rating.options = { //$.extend($.fn.rating, { options: {
						cancel: 'Cancel Rating',   // advisory title for the 'cancel' link
						cancelValue: '',           // value to submit when user click the 'cancel' link
						split: 0,                  // split the star into how many parts?
						
						// Width of star image in case the plugin can't work it out. This can happen if
						// the jQuery.dimensions plugin is not available OR the image is hidden at installation
						starWidth: 16//,
						
						//NB.: These don't need to be pre-defined (can be undefined/null) so let's save some code!
						//half:     false,         // just a shortcut to control.split = 2
						//required: false,         // disables the 'cancel' button so user can only select one of the specified values
						//readOnly: false,         // disable rating plugin interaction/ values cannot be changed
						//focus:    function(){},  // executed when stars are focused
						//blur:     function(){},  // executed when stars are focused
						//callback: function(){},  // executed when a star is clicked
			 }; //} });
				jQuery(function(){
				 jQuery('input[type=radio].star').rating({
					callback: function(){
						var $rate = jQuery(this).parents(".product_rating").find(".star-rating-on").length;
						var $id = jQuery(this).parents(".product_rating").children("input[name='id']").val();
						//alert($id);
						var $data = {
						action: "sp_product_rate",
						id: $id,
						rate: $rate,
						ajaxCustomNonce : sp_custom.ajaxCustomNonce
						};
						jQuery.post(sp_custom.ajaxurl, $data, function(response) {
							//alert("inside ajax");
							//alert(response);
							jQuery(".product_rating."+$id).html(response);
							jQuery(".product_rating p.message").delay(2000).fadeOut(2000);
							//jQuery('input[type=radio].star').rating();
							
						}); 
					} 
				});
				});
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // checkout progress slider
			  jQuery(".slide1 a.step2").click(function(e){
	     	  	  e.preventDefault();
				  jQuery(".slide1").fadeOut('600',function() {
					  jQuery(".slide2").fadeIn('300', function() {
							jQuery("#status-bg .info").addClass("active");	
					  });
				  });
						  
			  });
		  
			  jQuery(".slide2 a.step1").click(function(e){
			  	  e.preventDefault();
				  jQuery(".slide2").fadeOut('600',function() {
					  jQuery(".slide1").fadeIn('300', function() {
						  jQuery("#status-bg .info").removeClass("active");	
					  });
					  
				  });
						  
			  });
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // back to the top scroll effect
			  jQuery('.btt a').click(function(){
				  jQuery('html, body').animate({scrollTop:0}, 'slow');
				  return false;
			  });
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // search box fade in effect
			  jQuery("#searchBox .search-button").toggle(function() {
				  jQuery("#searchBox .search").fadeIn('fast').animate({ width: '140px'},100);
			  }, function() {
				  jQuery("#searchBox .search").animate({ width: '0'},100).fadeOut('fast');
			  });
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // jump scroll effect
			  jQuery('a.jump').click(function(){
				  var button = jQuery(this).attr('title');
				  var section = jQuery("#"+button).offset().top;
				  jQuery('html, body').animate({scrollTop:section}, 'slow');
				  return false;
			  });
		  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // wp ajax login
			  jQuery("#ajax_loginform").live('submit',function() {
					  var $log = jQuery("#ajax_loginform #log").val();
					  var $pwd = jQuery("#ajax_loginform #pwd").val();
					  var $rememberme = jQuery("#ajax_loginform #rememberme").val();
					  var $spdata = {
						  action: "sp_ajax_login",
						  log_name: $log,
						  pwd: $pwd,
						  rememberme: $rememberme,
						  ajaxCustomNonce : sp_custom.ajaxCustomNonce
					  };
					  jQuery("#ajax_loginform .wpsc_loading_animation").css("visibility","visible");
					jQuery.post(sp_custom.ajaxurl, $spdata, function(response) {
					  jQuery("#ajax_loginform .wpsc_loading_animation").css("visibility", "hidden");
						if (response.match(/login=1/)) {
						  window.location = response;
						} else {
						  jQuery("#ajax_loginform .response:visible").fadeOut(200,function() {
							  jQuery("#ajax_loginform .response").html(response).fadeIn(300);
						  });
					  
						}
					});
					
				  return false;
				  
			  });
		  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // wp ajax lost password
			  jQuery("#ajax_loginform p.response a").live('click',function() {
				  jQuery("#login_form:visible").fadeOut(200,function() {
					  jQuery("#forgot").fadeIn(300);
				  });
				  return false;
			  });
			  
			  jQuery("#ajax_lostpasswordform").live('submit',function() {
					  var $user_login = jQuery("#ajax_lostpasswordform #user_login").val();
					  var $spdata = {
						  action: "sp_ajax_lostpasswordform",
						  user_login: $user_login,
						  ajaxCustomNonce : sp_custom.ajaxCustomNonce
					  };
					  jQuery("#ajax_lostpasswordform .wpsc_loading_animation").css("visibility","visible");
					jQuery.post(sp_custom.ajaxurl, $spdata, function(response) {
					  jQuery("#ajax_lostpasswordform .wpsc_loading_animation").css("visibility", "hidden");
						  if (!response.match(/user/i)) {
							  jQuery.post(response,{user_login:$user_login});
							  jQuery("#ajax_lostpasswordform .response:visible").fadeOut(200,function() {
								  jQuery("#ajax_lostpasswordform #user_login").val('');
								  jQuery("#ajax_lostpasswordform .response").html("Reset e-mail sent!").fadeIn(300);
							  });
						  } else {
						  jQuery("#ajax_lostpasswordform .response:visible").fadeOut(200,function() {
							  jQuery("#ajax_lostpasswordform .response").html(response).fadeIn(300);
						  });
						  }
					  });
					
				  return false;
				  
			  });
		  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  // wp ajax logout
			  jQuery(".account_logout").live('click',function() {
				  jQuery(".header-logout-loading").css("display","block");
				  var $spdata = {
					  action: "sp_ajax_logout",
					  ajaxCustomNonce : sp_custom.ajaxCustomNonce
				  };
				  jQuery.post(sp_custom.ajaxurl, $spdata, function(response) {
					  window.location = response;
				  });
				  return false;
			  });
			  
		  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			  //full version and license can be found here: http://plugins.jquery.com/files/jquery.inlineFieldLabel.js.txt
			  (function($){$.fn.inlineFieldLabel=function(options){var opts=$.extend({},$.fn.inlineFieldLabel.defaults,options);this.each(function(){$this=$(this);var o=$.metadata?$.extend({},opts,$this.metadata({type:opts.metadataType,name:opts.metadataName})):opts;innerFunction($this,o.label);});return this;};$.fn.inlineFieldLabel.defaults={label:'some placeholder',metadataType:'class',metadataName:'metadata'};function innerFunction(jqElement,fieldLabel){var textInput=null;var clonedTextInput=null;var strBefore="";var strAfter="";var counter=0;textInput=jqElement;if(textInput.attr('type')=='password'){clonedTextInput=textInput.clone();strBefore=clonedTextInput.append(textInput.clone()).html();strAfter=strBefore.replace('type="password"','type="text"');;strAfter.replace('type="password"','type="text"');textInput.after(strAfter);clonedTextInput=textInput.next();clonedTextInput.addClass("intra-field-label").val(fieldLabel);textInput.hide();}else{textInput.addClass("intra-field-label").val(fieldLabel);}
			  if(clonedTextInput!=null){clonedTextInput.focus(function(){textInput.show();textInput.trigger('focus');clonedTextInput.hide();});}
			  textInput.focus(function()
			  {if(this.value==fieldLabel)
			  {textInput.removeClass("intra-field-label").val("");};});textInput.blur(function()
			  {if(this.value=="")
			  {if(clonedTextInput!=null){textInput.hide();clonedTextInput.show();}
			  else{textInput.addClass("intra-field-label").val(fieldLabel);}};});textInput.parents('form:first').find('input[type="submit"]').click(function(){if(clonedTextInput!=null){textInput.show();clonedTextInput.remove();}
			  if(textInput.val()==fieldLabel)
			  {textInput.removeClass("intra-field-label").val("");};});}})(jQuery);

			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// goto external link 
				jQuery(".external-purchase").click(function() {
					var extLink = jQuery(this).attr('data-external-link');
					var linkTarget = jQuery(this).attr('data-link-target');
					
					if (linkTarget == '') {
						linkTarget = '_self';
					}
					
					window.open(extLink, linkTarget);
					
					return false;
					
				});
				// single detail page tabs
				var tabsCollapsed = jQuery("#tabs_start_collapsed").val();
				var tabsSelected = 0;
				if ( tabsCollapsed === "true" ) {
					tabsCollapsed = true;	
					tabsSelected = -1;
				} else {
					tabsCollapsed = false;	
				}
				jQuery(".wpec-tabs").tabs({ collapsible: tabsCollapsed, selected: tabsSelected });
			 } // end WPEC check	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//WOOCOMMERCE
			if ( sp_custom.woo_active === '1' )
			{
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// on add to cart, show loader
				jQuery(".single_add_to_cart_button").live('click',function() {
					jQuery(this).parents(".woo_buy_button_container").find(".loading_animation").css("visibility", "visible");
				});
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// check to see if quickview is enabled
				if (jQuery("input.quickview_enabled").val() === "true") {
					// gridview image hover show quick view
					jQuery(".product_grid_item .item_image").hover(function() {
						if (jQuery("#quickview_enable").val() == "true") {
							jQuery(".quickview-button",this).stop(true, true).fadeIn(300);
							
						}
						jQuery(".more-button",this).stop(true, true).animate({bottom: '0'},300);
					},function() {
						if (jQuery("#quickview_enable").val() == "true") {
							jQuery(".quickview-button",this).stop(true, true).fadeOut(300);	
							
						}
						jQuery(".more-button",this).stop(true, true).animate({bottom: '-20px'},300);
					});
					// quickview container
						jQuery(".product_grid_item .quickview-button").click(function() {
							var $product_id = jQuery(this).parents(".product_grid_item").find("input.hidden-id").val();
							/*
							// below code is necessary as a workaround to enable variation image swap due to limitation of WOO not having variable scope
							var divObj = jQuery("div.images");
							divObj.each(function() {
								jQuery(this).removeClass("images");
							});
							jQuery(".product_view_" + $product_id).find("div.imagecol").addClass("images");
							 
							var variationObj = jQuery(".product_view_" + $product_id).find("div.single_variation_wrap");
							
							var resetObj = jQuery("a.reset_variations_hook");
							resetObj.each(function() {
								jQuery(this).removeClass("reset_variations");
							});
							var wrapObj = jQuery(".single_variation_wrap_hook");
							wrapObj.each(function() {
								jQuery(this).removeClass("single_variation_wrap");
							});
							var variationObj = jQuery(".single_variation_hook");
							variationObj.each(function() {
								jQuery(this).removeClass("single_variation");
							});
							var buttonObj = jQuery(".variations_button_hook");
							buttonObj.each(function() {
								jQuery(this).removeClass("variations_button");
							});
							var varObj = jQuery(".variations_hook");
							varObj.each(function() {
								jQuery(this).removeClass("variations");
							});
							
							var curForm = jQuery("form[data-id="+$product_id+"]");
							curForm.find("a.reset_variations_hook").addClass("reset_variations");
							curForm.find(".single_variation_wrap_hook").addClass("single_variation_wrap");
							curForm.find(".single_variation_hook").addClass("single_variation");
							curForm.find(".variations_button_hook").addClass("variations_button");
							curForm.find(".variations_hook").addClass("variations");
							// end horrible workaround for woocommerce because they didn't add SCOPE!!!!
							*/
							var $product_content = jQuery(".product_item.product_view_"+$product_id).fadeIn(300).center().css("position","fixed");
							jQuery('body').append("<div class='quickview_popup'></div>");
							if (navigator.appName === "Microsoft Internet Explorer") {
								jQuery(".quickview_popup").hide().show();
								jQuery('body').append($product_content);
								
							} else { 
								jQuery(".quickview_popup").hide().fadeIn(300,function() { jQuery('body').append($product_content); });
							}
							return false;
						});
						
						jQuery(".quickview_popup").live('click',function() {
							jQuery(this).fadeOut(200, function() { jQuery(".product_item:visible").hide(); jQuery(this).remove(); });	
						});
						
						jQuery(".product_item .close").live('click',function() {
							jQuery(".quickview_popup").fadeOut(200, function() { jQuery(".product_item:visible").hide(); jQuery(this).remove(); });	
							return false;
						});
			
				} else {
					jQuery(".product_grid_item .item_image").hover(function() {
						jQuery(".more-button",this).stop(true, true).animate({bottom: '0'},300);
					},function() {
						jQuery(".more-button",this).stop(true, true).animate({bottom: '-20px'},300);
					});
					
				}
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// default view more details hover	
				jQuery(".default_product_display .item_image, .wpsc_also_bought .also_bought_item_image").hover(function() {
					jQuery(".more-button",this).stop(true, true).animate({bottom: '0'},300);
				},function() {
					jQuery(".more-button",this).stop(true, true).animate({bottom: '-20px'},300);
				});
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// image hover
				jQuery(".single_product_display .item_image, article.list .image-wrap, .portfolio-item, .portfolio-single .image-wrap, .related-hover").hover(function() {
					jQuery("img",this).stop(true, true).fadeTo('2000',0.6);
					jQuery("span.hover-icon",this).stop(true, true).fadeIn('slow');
				}, function() {
					jQuery("img",this).stop(true, true).fadeTo('2000',1);
					jQuery("span.hover-icon",this).stop(true, true).fadeOut('slow');	
				});
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// product gallery image swap
				jQuery('.sp-attachment-thumbnails').click(function(){
					var loading = jQuery(this).parents('.imagecol:first').find('img.load');
					loading.show();
					var productImage = jQuery(this).parents('.imagecol:first').find('.product_image');
					var timString = jQuery(this).parent().attr('data-src');
					var title = jQuery(this).parent().attr('title');
					var height = /[&?]h=(\d+)/.exec( timString );
					var width = /[&?]w=(\d+)/.exec( timString );
					// checks to make sure sizes are not null
					height = (height == null) ? 347 : height[1];
					width = (width == null) ? 347 : width[1];
					
					productImage.attr( 'src', timString ).attr( 'height', height ).attr( 'width', width ).attr('alt', title);
					productImage.parent('a:first').attr('href', jQuery(this).parent().attr('href')).attr('title', title);
					loading.hide();
					return false;
				});
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// show review form when button is clicked
				jQuery(".show_review_form").click(function(e) {
					e.preventDefault();
					jQuery("#review_form_wrapper:hidden").slideDown('fast');
				});

			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// widget image hover
				jQuery(".widget-container ul.product_list_widget li img, .categories ul.cat li img").hover(function() {
					jQuery(this).stop(true,true).animate({opacity: '0.6'},600);
				}, function() {
					jQuery(this).stop(true,true).animate({opacity: '1'},400);
				});				
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			} // close woo check

			  	  
		} // close init
	}; // close namespace
	$.sp_theme_on_ready.init();
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// end jquery on ready
});
//]]>