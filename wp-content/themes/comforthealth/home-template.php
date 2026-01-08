<?php
/*
* template name: Home
*/
get_header();

while ( have_posts() ) : the_post();
the_title();
	// check if the flexible content field has rows of data
	if( have_rows('flexible_block') ):

		// loop through the rows of data
		while ( have_rows('flexible_block') ) : the_row();

			// check current row layout
			$layout = get_row_layout();
			$path = get_template_directory() . "/components/" . $layout . ".php";

			// If the page compoenent exists
			if (file_exists($path)) {
				get_template_part('components/'.$layout);
			}

		endwhile;
	endif;
endwhile;
?>

<?
get_footer();
?>