<section class="clean--header component">
	<div class="container">
		<?php
			if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb('<p id="breadcrumbs">','</p>');
			}
		?>
		<h1><? the_sub_field('title'); ?></h1>	


	</div>
	
</section>