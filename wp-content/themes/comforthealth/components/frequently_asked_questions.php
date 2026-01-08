<section class="faqs component">
	<div class="container">
		<?if( have_rows('frequently_asked_question') ):
			while (have_rows('frequently_asked_question')) : the_row();?>
			<div class="question">
				<p><?the_sub_field('question');?></p>
				<p class="answer"><?the_sub_field('answer');?></p>
			</div>
			<?endwhile;?>
		<?endif;?>
		
	</div>
	
</section>