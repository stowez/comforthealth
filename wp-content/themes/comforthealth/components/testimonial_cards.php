<section class="testimonial-cards component">
	<div class="container content">
		<?if( have_rows('cards') ):
			while (have_rows('cards')) : the_row();?>
			<div class="col col-4 col-top col-padding">
				<div class="card">
					<?if (get_sub_field('card_image') ) {
						$image = get_sub_field('card_image');?>
						<figure><img src="<?= $image['sizes']['thumbnail'];?>" alt="<?= $image['alt'];?>"></figure>
					<?}?>
					<? the_sub_field('card_text')?>
					<p class="testimonial-author"><? the_sub_field('card_author'); ?></p>
				</div>
			</div>
			<?endwhile;
		endif;?>
	</div>
	
</section>
