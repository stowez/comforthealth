<?php 
/*
* Functions.php
* Lots of useful wordpress functionality to help with the theme
*/
// Hide horrendous admin bar
show_admin_bar( false ); 

// Register a Header menu
function register_my_menu() {
	register_nav_menu('navigation-menu',__( 'Navigation Menu' ));

	register_nav_menu('footer-menu',__( 'Footer Menu' ));
	register_nav_menu('footer-menu-2',__( 'Footer Menu 2' ));
	register_nav_menu('footer-menu-3',__( 'Footer Menu 3' ));
	register_nav_menu('footer-menu-4',__( 'Footer Menu 4' ));
}
add_action( 'init', 'register_my_menu' );

function comforthealth_setup(){
        add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'comforthealth_setup' );


/**
 * Load in our core stylesheet & our custom js
 */
function register_style_scripts() {
    // wp_enqueue_style( 'template', get_stylesheet_uri() );

	wp_enqueue_style( 'core',  get_template_directory_uri() . '/styles/core.css?v=5' );
	
	// PhotoSwipe Gallery
	wp_enqueue_style( 'photoswipe', 'https://cdn.jsdelivr.net/npm/photoswipe@5.4.4/dist/photoswipe.min.css' );
	wp_enqueue_style( 'photoswipe-dynamic-caption', 'https://unpkg.com/photoswipe-dynamic-caption-plugin@1.2.7/photoswipe-dynamic-caption-plugin.css' );
	
	wp_enqueue_script( 'photoswipe-init', get_template_directory_uri() . '/js/photoswipe-init.js', array(), '1.0', true );
	wp_add_inline_script( 'photoswipe-init', 'window.PhotoSwipeModule = {core: null, lightbox: null, caption: null};', 'before' );
	
	// Legacy Featherlight (kept for existing usage in hero banner)
	wp_enqueue_style( 'featherlight',  get_template_directory_uri() . '/js/featherlight.css' );
	
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array('jquery') );
}
add_action( 'wp_enqueue_scripts', 'register_style_scripts' );

// Function to add subscribe text to posts and pages
// Add Shortcode
function booking_shortcode() {
	
	return "<div id='my-cliniko-online-bookings'></div>
	<script type='text/javascript'>
(function(){
  var linker,
      iFrame = document.createElement('iframe'),
      divId = 'my-cliniko-online-bookings';
  iFrame.id = 'my-cliniko-online-bookings-iframe';
  iFrame.src = 'https://comfort-health.cliniko.com/bookings?embedded=true';
  iFrame.frameBorder = 0;
  iFrame.scrolling = 'auto';
  iFrame.width = '100%';
  iFrame.height = '1000';
  iFrame.style = 'pointer-events: auto;'
  function decorateiFrame(divId, url, opt_hash) {
    return function(tracker) {
      window.linker = window.linker || new window.gaplugins.Linker(tracker);
      iFrame.src = window.linker.decorate(url, opt_hash);
    };
  }
  // Dynamically add the iFrame to the page with proper linker parameters.
  ga(decorateiFrame(divId, iFrame.src));
  document.getElementById(divId).appendChild(iFrame);
  // Listen to the iFrame for resize events
  window.addEventListener('message', function handleIFrameMessage(e) {
  var clinikoBookings = document.getElementById('my-cliniko-online-bookings-iframe');
  if (typeof e.data !== 'string') return;
  if (e.data.search('cliniko-bookings-resize') > -1) {
    var height = Number(e.data.split(':')[1]);
    clinikoBookings.style.height = height + 50 + 'px';
  }
  e.data.search('cliniko-bookings-page') > -1 && clinikoBookings.scrollIntoView();
  });
})();

</script>";

}
add_shortcode( 'booking_form', 'booking_shortcode' );


// Enable thumbnails
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 250, 250, true );


remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' ); 


/**
 * Register our sidebars and widgetized areas.
 *
 */
function arphabet_widgets_init() {

	register_sidebar( array(
		'name'          => 'Footer',
		'id'            => 'footer_1',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'arphabet_widgets_init' );


function custom_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function custom_excerpt_more( $more ) {
return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );
