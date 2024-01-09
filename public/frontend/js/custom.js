// JavaScript Document
	var WebsiteLaunchDate = new Date();
	monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	WebsiteLaunchDate.setMonth(WebsiteLaunchDate.getMonth() + 1);
	WebsiteLaunchDate =  WebsiteLaunchDate.getDate() + " " + monthNames[WebsiteLaunchDate.getMonth()] + " " + WebsiteLaunchDate.getFullYear();

function quick_search(){
	'use strict';
	/* Quik search in header on click function */
	var quikSearch = $("#quik-search-btn");
	var quikSearchRemove = $("#quik-search-remove");
	
	quikSearch.on('click',function() {
		$('.dez-quik-search').animate({'width': '100%' });
		$('.dez-quik-search').delay(500).css({'left': '0'  });
    });
    
	quikSearchRemove.on('click',function() {
        $('.dez-quik-search').animate({'width': '0%' ,  'right': '0'  });
		$('.dez-quik-search').css({'left': 'auto'  });
    });	
	/* Quik search in header on click function End*/
}

function magnific_popup()
{
	'use strict';	
	/* magnificPopup function */
    $('.mfp-gallery').magnificPopup({
		delegate: '.mfp-link',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
			}
		}
    });
	/* magnificPopup function end */
	
	/* magnificPopup for paly video function */		
	$('.video').magnificPopup({
		type: 'iframe',
		iframe: {
			markup: '<div class="mfp-iframe-scaler">'+
					 '<div class="mfp-close"></div>'+
					 '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
					 '<div class="mfp-title">Some caption</div>'+
			  		 '</div>'
		},
		callbacks: {
			markupParse: function(template, values, item) {
				values.title = item.el.attr('title');
			}
		}
	});
	/* magnificPopup for paly video function end*/
	
}

function scroll_top(){
	'use strict';
	var scrollTop = $("button.scroltop");
	/* page scroll top on click function */	
    scrollTop.on('click',function() {
		$("html, body").animate({
            scrollTop: 0
        }, 1000);
        return false;
    })

	$(window).on("scroll", function() {
		var scroll = $(window).scrollTop();
        if (scroll > 900) {
            $("button.scroltop").fadeIn(1000);
        } else {
            $("button.scroltop").fadeOut(1000);
        }
    });
	/* page scroll top on click function end*/
}

/* accordian open close icon change */	 	
function toggleChevron(e) {
	$(e.target)
		 .prev('.panel-heading')
		 .find("i.indicator")
		 .toggleClass('glyphicon-minus glyphicon-plus');
}

function accordian_icon()
{
	/* accodin open close icon change */	 	
	$('#accordion').on('hidden.bs.collapse', toggleChevron);
	$('#accordion').on('shown.bs.collapse', toggleChevron);
	/* accodin open close icon change end */
}
/* accodin open close icon change end*/	 	

/* Input Placeholder  */
function placeholderSupport()
{
	/* input placeholder for ie9 & ie8 & ie7 */
    $.support.placeholder = ('placeholder' in document.createElement('input'));
	/* input placeholder for ie9 & ie8 & ie7 end*/
	
	/*fix for IE7 and IE8  */
	if (!$.support.placeholder) {
		$("[placeholder]").focus(function () {
			if ($(this).val() == $(this).attr("placeholder")) $(this).val("");
		}).blur(function () {
			if ($(this).val() == "") $(this).val($(this).attr("placeholder"));
		}).blur();

		$("[placeholder]").parents("form").submit(function () {
			$(this).find('[placeholder]').each(function() {
				if ($(this).val() == $(this).attr("placeholder")) {
					 $(this).val("");
				}
			});
		});
	}
	/*fix for IE7 and IE8 end */
}
/* Input Placeholder End */
	 
/* equal height box */	 
function equalheight(container) {
	
	var currentTallest = 0, 
		currentRowStart = 0, 
		rowDivs = new Array(), 
		$el, topPosition = 0;
		
	$(container).each(function() {
		var $el = $(this);
		$($el).height('auto')
		topPostion = $el.position().top;

		if (currentRowStart != topPostion) {
			for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
				rowDivs[currentDiv].height(currentTallest);
			}
			rowDivs.length = 0; // empty the array
			currentRowStart = topPostion;
			currentTallest = $el.height();
			rowDivs.push($el);
		} else {
			rowDivs.push($el);
			currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
		}
		for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
			rowDivs[currentDiv].height(currentTallest);
		}
	});
}
/* equal height box */

/* footer fixed bottom function custom */	
function footerAlign() {
	'use strict';
	$('.site-footer').css('display', 'block');
	$('.site-footer').css('height', 'auto');
	var footerHeight = $('.site-footer').outerHeight();
	$('.footer-fixed > .page-wraper').css('padding-bottom', footerHeight);
	$('.site-footer').css('height', footerHeight);
}
/* footer fixed bottom function custom end */

/* Vertically center Bootstrap 3 modals so they aren't always stuck at the top function custom */
function reposition() {
	'use strict';
	var modal = $(this),
	dialog = modal.find('.modal-dialog');
	modal.css('display', 'block');
	
	/* Dividing by two centers the modal exactly, but dividing by three 
	 or four works better for larger screens.  */
	dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
}
/* Vertically center Bootstrap 3 modals so they aren't always stuck at the top function custom end*/


function file_input()
{
	'use strict';
	/* Input type file jQuery */	 	 
	$(document).on('change', '.btn-file :file', function() {
		var input = $(this);
		var	numFiles = input.get(0).files ? input.get(0).files.length : 1;
		var	label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	});
	
	$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
		input = $(this).parents('.input-group').find(':text');
		var log = numFiles > 10 ? numFiles + ' files selected' : label;
	
		if (input.length) {
			input.val(log);
		} else {
			if (log) alert(log);
		}
	});
	/* Input type file jQuery end*/
	
}

function header_fix()
{
	'use strict';
	/* Main navigation fixed on top  when scroll down function custom */		
	$(window).on('scroll', function () {
		var menu = $('.sticky-header');
		if ($(window).scrollTop() > menu.offset().top) {
			menu.addClass('is-fixed');
		} else {
			menu.removeClass('is-fixed');
		}
	});
	/* Main navigation fixed on top  when scroll down function custom end*/
	
}

function masonryBox()
{
	'use strict';
	/* masonry by  = bootstrap-select.min.js */ 
	var self = $("#masonry");
	self.imagesLoaded(function () {
		self.masonry({
			gutterWidth: 15,
			isAnimated: true,
			itemSelector: ".card-container"
		});
	});

	jQuery(".filters").on('click','li',function(e) {
		e.preventDefault();
		var filter = $(this).attr("data-filter");
		self.masonryFilter({
			filter: function () {
				if (!filter) return true;
				//return $(this).attr("data-filter") == filter;
				return $(this).hasClass(filter);
			}
		});
	});
	/* masonry by  = bootstrap-select.min.js end */
}

function setDivHeight()
{	
	'use strict';
	var allHeights = [];
	$('.dzseth div').each(function(e){
		allHeights.push($(this).height());
	})

	$('.dzseth div').each(function(e){
		var maxHeight = Math.max.apply(Math,allHeights);
		$(this).css('height',maxHeight);
	})
	
	allHeights = [];
	/* Removice */
	var screenWidth = $( window ).width();
	if(screenWidth < 991)
	{
		$('.dzseth div').each(function(e){
			$(this).css('height','');
		})
	}	
}	

/* For Home Page 8-9 */
function onePageLayout(){
	'use strict';
	// Add scrollspy to <body>
	$('body').scrollspy({target: ".navbar", offset: 50});   
	// Add smooth scrolling on all links inside the navbar
	$("#myNavbar a").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
	if (this.hash !== "") {
		// Prevent default anchor click behavior
		event.preventDefault();

		// Store hash
		var hash = this.hash;
		// Using jQuery's animate() method to add smooth page scroll
		// The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
		$('html, body').animate({
		scrollTop: $(hash).offset().top
		}, 800, function(){
		// Add hash (#) to URL when done scrolling (default click behavior)
		window.location.hash = hash;
		});
	}  // End if
  });
}

function openNav() {
	
	$('.openbtn').on('click',function(e){
		e.preventDefault();
		if($('#mySidenav').length > 0)
		{
			document.getElementById("mySidenav").style.left = "0";
		}

		if($('#mySidenav1').length > 0)
		{
			document.getElementById("mySidenav1").style.right = "0";
		}
		
	})
}

function closeNav() {
    
	$('.closebtn').on('click',function(e){
		e.preventDefault();
		if($('#mySidenav').length > 0)
		{
			document.getElementById("mySidenav").style.left = "-300px";
		}
		
		if($('#mySidenav1').length > 0)
		{
			document.getElementById("mySidenav1").style.right = "-820px";
		}
	})
}
/* For Home Page 8-9 */

/* counterUp one function by = counterup-min.js */
function counter(){
	
	if($(".counter").length)
	{
		$('.counter').counterUp({
			delay: 10,
			time: 3000
		});		
	}	

}

function setHeight() {
	var windowHeight = $(window).innerHeight();
	$('.content-admin-wraper , .aon-custo-map-iner , .full-screen-content').css('min-height', windowHeight);
};

/*** Add Switcher */
function addSwitcher()
{
	var dzSwitcher = '<div class=styleswitcher><div class=switcher-btn-bx><a class=switch-btn><span class="fa fa-gear fa-lg fa-spin"></span></a></div><div class=styleswitcher-inner><h6 class=switcher-title>Layout</h6><ul class=layout-view><li class="active wide-layout">Wide<li class=boxed>Boxed</ul><h6 class=switcher-title>Nav</h6><ul class=nav-view><li class="active nav-light">Light<li class=nav-dark>Dark</ul><h6 class=switcher-title>Header</h6><ul class=header-view><li class="active header-fixed">Fixed<li class=header-static>Static</ul><h6 class=switcher-title>Color Skin</h6><ul class=color-skins><li><a class="theme-skin skin-1"href="?theme=css/skin/skin-1"title="default Theme"></a><li><a class="theme-skin skin-2"href="?theme=css/skin/skin-2"title="pink Theme"></a><li><a class="theme-skin skin-3"href="?theme=css/skin/skin-3"title="sky Theme"></a><li><a class="theme-skin skin-4"href="?theme=css/skin/skin-4"title="green Theme"></a><li><a class="theme-skin skin-5"href="?theme=css/skin/skin-5"title="red Theme"></a><li><a class="theme-skin skin-6"href="?theme=css/skin/skin-6"title="orange Theme"></a><li><a class="theme-skin skin-7"href="?theme=css/skin/skin-7"title="purple Theme"></a><li><a class="theme-skin skin-8"href="?theme=css/skin/skin-8"title="blue Theme"></a></ul><h6 class=switcher-title>Background Image</h6><ul class=background-switcher><li><img alt=""rel=images/background/bg1.jpg src=images/switcher/switcher-bg/bg1.jpg><li><img alt=""rel=images/background/bg2.jpg src=images/switcher/switcher-bg/bg2.jpg><li><img alt=""rel=images/background/bg3.jpg src=images/switcher/switcher-bg/bg3.jpg><li><img alt=""rel=images/background/bg4.jpg src=images/switcher/switcher-bg/bg4.jpg></ul><h6 class=switcher-title>Background Pattern</h6><ul class=pattern-switcher><li><img alt=""rel=images/pattern/pt1.jpg src=images/switcher/switcher-patterns/bg1.jpg><li><img alt=""rel=images/pattern/pt2.jpg src=images/switcher/switcher-patterns/bg2.jpg><li><img alt=""rel=images/pattern/pt3.jpg src=images/switcher/switcher-patterns/bg3.jpg><li><img alt=""rel=images/pattern/pt4.jpg src=images/switcher/switcher-patterns/bg4.jpg><li><img alt=""rel=images/pattern/pt5.jpg src=images/switcher/switcher-patterns/bg5.jpg><li><img alt=""rel=images/pattern/pt6.jpg src=images/switcher/switcher-patterns/bg6.jpg><li><img alt=""rel=images/pattern/pt7.jpg src=images/switcher/switcher-patterns/bg7.jpg><li><img alt=""rel=images/pattern/pt8.jpg src=images/switcher/switcher-patterns/bg8.jpg><li><img alt=""rel=images/pattern/pt9.jpg src=images/switcher/switcher-patterns/bg9.jpg><li><img alt=""rel=images/pattern/pt10.jpg src=images/switcher/switcher-patterns/bg10.jpg><li><img alt=""rel=images/pattern/pt11.jpg src=images/switcher/switcher-patterns/bg11.jpg><li><img alt=""rel=images/pattern/pt12.jpg src=images/switcher/switcher-patterns/bg12.jpg></ul></div></div>';
	
	if($("#dzSwitcher").length == 0) {
		jQuery('body').append(dzSwitcher);
	}
}

/*################	End OF Function List ###################################*/
	
/* Document.ready Start */	

$(document).ready(function() {
    'use strict';
	
	var CurrentDate = new Date();
	CurrentDate.setMonth(CurrentDate.getMonth() + 1);
	alert(CurrentDate);
	//var websiteComingSoonDate = new Date() + ;
	closeNav();
	openNav();
	
	onePageLayout();
	
	setDivHeight();
	
	quick_search();
	
	magnific_popup();
	
	header_fix();

	scroll_top();
	
	accordian_icon();
	
	file_input();	
	
	footerAlign();

	placeholderSupport();
	
	addSwitcher();
	
	counter();
	
	setHeight();
	
	$('.tp-bgimg').after("<div class='overlay-row'></div>");
	
	/* Video responsive function */	
	$('iframe[src*="youtube.com"]').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
	$('iframe[src*="vimeo.com"]').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');	
	/* Video responsive function end*/  
	  
	/* gallery filter activation = jquery.mixitup.min.js */ 
	if ($('#image-gallery-mix').length) {
		$('.gallery-filter').find('li').each(function () {
			$(this).addClass('filter');
		});
		$('#image-gallery-mix').mixItUp();
	};
	if($('.gallery-filter.masonary').length){
		$('.gallery-filter.masonary').on('click','span', function(){
			var selector = $(this).parent().attr('data-filter');
			$('.gallery-filter.masonary span').parent().removeClass('active');
			$(this).parent().addClass('active');
			$('#image-gallery-isotope').isotope({ filter: selector });
			return false;
		});
	}
	/* gallery filter activation = jquery.mixitup.min.js */
	
	
	/* Reposition when a modal is shown */
	$('.modal').on('show.bs.modal', reposition);
	/* Reposition when the window is resized */
	$(window).on('resize', function() {
		$('.modal:visible').each(reposition);
	
		equalheight('.equal-wraper .equal-col');
		footerAlign();
	});
    /* Reposition when a modal is shown end*/
	
	
	/* Time Js */
	if($(".countdown").length)
	{
		
		$('.countdown').countdown({date: WebsiteLaunchDate+' 23:5'}, function() {
			$('.countdown').text('we are live');
		});
	}
	
	
});
/* Document.ready END */



/* Window Load START */
$(window).on('load', function () {
	'use strict'; 
	
	masonryBox();
	
	/* Bootstrap Select box function by  = bootstrap-select.min.js */ 
	$('select').selectpicker();
	/* Bootstrap Select box function by  = bootstrap-select.min.js end*/
	
	
	/* TouchSpin box function by  = jquery.bootstrap-touchspin.js */ 
	$("input[name='demo_vertical2']").TouchSpin({
      verticalbuttons: true,
      verticalupclass: 'glyphicon glyphicon-plus',
      verticaldownclass: 'glyphicon glyphicon-minus'
    });
	/* TouchSpin box function by  = jquery.bootstrap-touchspin.js end*/
	
	equalheight('.equal-wraper .equal-col');
	
	setTimeout(function(){
		$('#loading-area').remove();
	}, 0);
	
	if($(".content").length)
	{
		$(".content").mCustomScrollbar({
			setWidth:false,
			setHeight:false,
			axis:"y"
		});	
	}	
	
	
	
});
/*  Window Load END */

	