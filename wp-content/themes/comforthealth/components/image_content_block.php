<section class="block-image image-<? the_sub_field('image_position'); ?> flexWrap">
	<div class="block-image__inner">
		<?

		// $image = get_sub_field('background_image'); print_r($image); 
		if ( get_sub_field('image_position') == 'left' ) :?>
			<div class="half-block with-image lazyload"  style="background-image:url('<? the_sub_field('background_image'); ?>');"></div>
			<div class="half-block with-content">
				<div>
					<?php
						the_sub_field('content');
					?>
					<? if (get_sub_field('link') ){ ?>
						<a href="<? the_sub_field('link'); ?>" class="btn outline">Read more</a>
					<?}?>
				</div>
				<i></i>
			</div>
		<?else:?>
			<div class="half-block with-content">
				<div>
					<?php the_sub_field('content'); ?>
					<?php $link = the_sub_field('link');?>
					<? if (get_sub_field('link') ){ ?>
						<a href="<? the_sub_field('link'); ?>" class="btn outline">Read more</a>
					<?}?>
				</div>
				<i></i>
			</div>
			<div class="half-block with-image lazyload"  style="background-image:url('<? the_sub_field('background_image'); ?>');"></div>
		<?endif;
		?>
	</div>
	
</section>
