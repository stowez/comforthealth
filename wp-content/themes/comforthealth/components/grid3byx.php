<section class="component grid-3by parallax" style="background-image:url('<? the_sub_field('background_image') ?>')">
	<div class="container">

		<?if( have_rows('grid_items') ):
			while (have_rows('grid_items')) : the_row();?>
			<div class="col-4 left col-padding">
				<div class="gridItem">
					<img src="<?the_sub_field('grid_icon'); ?>"/>
					<h3><?the_sub_field('grid_title'); ?></h3>
					<?the_sub_field('grid_text'); ?>
					<p class="subtitle"><?the_sub_field('grid_subtitle'); ?></p>
				</div>
			</div>
				
			<?endwhile;
		endif;?>
	</div>
	
</section>