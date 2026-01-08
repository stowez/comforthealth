// A $( document ).ready() block.
$( document ).ready(function() {
	didScroll = false;

	$(window).scroll(function() {
		didScroll = true;
	});

	setInterval(function() {
		if ( didScroll ) {
			didScroll = false;
			if ( $(window).scrollTop() != 0 ) {
				$('.navigation').addClass('scrolled');
			} else {
				$('.navigation').removeClass('scrolled');
			}
		}
	}, 250);

	if ( $(window).scrollTop() != 0 ) {
		didScroll = true;
		$('.navigation').addClass('scrolled');
	}


	if ($('section').first().hasClass('clean--header') ) {
		$('section').first().css('margin-top', '55px');
		$('.navigation').addClass('noscroll')
	}

	if ( $('body').hasClass('blog') || $('body').hasClass('single-post') ) {
		$('.navigation').addClass('noscroll')
	}


	 $('.masonry').matchHeight();

	 $('#navicon').on('click', function(e) {
			console.log('here');
	 	e.preventDefault();
	 	$('#menu-main').toggleClass('open');
	 	$(this).toggleClass('open');
	 })

	 $('li.menu-item-object-custom.menu-item-has-children > a').on('click', function(e) {
	 	if($(window).innerWidth() < 800) {
	 		e.preventDefault();
				 		$(this).parent('li').toggleClass('active');
 		}
	 });

	 $('#scrollNext').on('click', function(e) {
	 	e.preventDefault();
	 	var next = $(this).parent().next();
	 	$('html, body').animate({scrollTop: $(next).offset().top}, 500);
	 	// console.log($);
	 });
});

