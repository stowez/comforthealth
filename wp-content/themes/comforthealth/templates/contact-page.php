<?php /* template name: Contact
*/

get_header();?>

<section class="clean--header component">
	<div class="container">
		<?php
			if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb('<p id="breadcrumbs">','</p>');
			}
		?>
		<h1><?the_title();?></h1>	


	</div>
	
</section>
<section class="contained-content cmpnt contact">
	<div class="container">
		<article class="mainContent fullwidth">
		<h2>Get in touch</h2>
			<? gravity_form(1, false, false, false, false, false); ?>
		</article>
	</div>
</section>
<section class="fullscreen-hero fullscreen-map">
	<div class="infoBox">
		<p><i class="fa fa-map-marker"></i><? the_field('address');?></p>
		<p><i class="fa fa-phone"></i><? the_field('telephone');?></p>
		<p><i class="fa fa-envelope"></i><? the_field('email');?></p>
		<p><i class="fa fa-road"></i><a href="https://www.google.com/maps/dir/Current+Location/<?= urlencode( get_field('address') ) ?>">Get Directions</a></p>
	</div>
	<? the_content();?>
</section>

<?get_footer();?>
