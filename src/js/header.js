export default function () {
	jQuery(document).ready(function($){
		var mainHeader = $('header .nav'),
			headerHeight = mainHeader.height();

		//set scrolling variables
		var scrolling = false,
			previousTop = 0,
			currentTop = 0,
			scrollDelta = 10,
			scrollOffset = 150;

		mainHeader.on('click', '.nav-trigger', function(event){
			// open primary navigation on mobile
			event.preventDefault();
			mainHeader.toggleClass('nav-open');
		});

		$(window).on('scroll', function(){
			if( !scrolling ) {
				scrolling = true;
				(!window.requestAnimationFrame)
					? setTimeout(autoHideHeader, 250)
					: requestAnimationFrame(autoHideHeader);
			}
		});

		$(window).on('resize', function(){
			headerHeight = mainHeader.height();
		});

		function autoHideHeader() {
			var currentTop = $(window).scrollTop();

			checkSimpleNavigation(currentTop);

		   	previousTop = currentTop;
			scrolling = false;
		}

		function checkSimpleNavigation(currentTop) {
			//there's no secondary nav or secondary nav is below primary nav
		    if (previousTop - currentTop > scrollDelta) {
		    	//if scrolling up...
		    	mainHeader.removeClass('hide');
		    } else if( currentTop - previousTop > scrollDelta && currentTop > scrollOffset) {
		    	//if scrolling down...
		    	mainHeader.addClass('hide');
		    }
		}

	    var scrolling = false;
	    $(window).on('scroll', function(){
	    	if( !scrolling ) {
	    		scrolling = true;
	    		(!window.requestAnimationFrame)
	    			? setTimeout(autoHideHeader, 250)
	    			: requestAnimationFrame(autoHideHeader);
	    	}
	    });

		$('header .nav-item > a').click(function(e) {
			if($(this).parent('.nav-item').find('aside.menu').hasClass('is-visible')) {
				e.preventDefault();
				$(this).find('aside.menu').removeClass('is-visible');
				$(this).parents('.nav-center').find('aside.menu').removeClass('is-visible');
			} else if ($(this).parent('.nav-item').find('aside.menu').length) {
				e.preventDefault();
				$(this).parents('.nav-center').find('aside.menu').removeClass('is-visible');
				$(this).parent('.nav-item').find('aside.menu').addClass('is-visible');
			}
		});
	});
}
