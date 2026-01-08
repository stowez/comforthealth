<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JP91E6ZN70">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-JP91E6ZN70');
</script>

<?php
 if( isset($_REQUEST['play']) ) {
	if($_COOKIE['played'] !== 1){
	setcookie("played", 1, time()+3600);
}
}
/**
 * The template for displaying the header
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
	<script src="https://use.fontawesome.com/3931bddda4.js"></script>
	<link rel="icon" type="image/png" href="<?bloginfo('template_url');?>/fav.png" />
	<?/*
*/?>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-7H7ZZKGHK9"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-7H7ZZKGHK9');
</script>


	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<nav class="navigation">
	<div class="container">
		<div class="flexWrap">
			<?if (is_front_page() || is_page('home')) :?>
				<span class="headerLogo"><a href="/" >
					Comfort Health - Clifton
				</a></span>
			<?else :?>
				<a href="/" class="headerLogo">
					Comfort Health - Clifton
				</a>
			<?endif;?>

			<a href="#menu" id="navicon">Menu <i class="fa fa-bars"></i></a>
			<? wp_nav_menu(array('menu' => '2')); ?>		 
		</div>
	</div>
</nav>


<div class="social-icons">
	<a href="https://www.facebook.com/ComfortHealthClifton/" target="_blank" class=""><i class="fa fa-facebook-official"></i></a>
	<a href="https://twitter.com/ComfortHealth_" target="_blank" class=""><i class="fa fa-twitter-square"></i></a>
	<a href="https://www.instagram.com/comfort_health/?hl=en" target="_blank" class=""><i class="fa fa-instagram"></i></a>
	<a href="https://www.youtube.com/channel/UCXKrfIHYRPO6dJiicl05J8Q" target="_blank"><i class="fa fa-youtube"></i></a>
</div>
