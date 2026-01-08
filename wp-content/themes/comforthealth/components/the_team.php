<section class="the-team">
	<div class="container">
	<div class="row justify-content-center">
	<?if( have_rows('team_members') ):
		while (have_rows('team_members')) : the_row();?>
			<? $image = get_sub_field('profile_picture') ?>
			<div class="col-4 team-member">
				<? if (get_sub_field('page_link')) :?>
					<a href="<?the_sub_field('page_link');?>" class="pageLink"></a>
				<?endif;?>
				<div class="profile-picture" style="background-image:url('<?= $image['url']; ?>')"></div>
				<div class="about-member">
					<h3><? the_sub_field('name')?></h3>
					<?if (get_sub_field('position')) :?>
						<span><? the_sub_field('position');?></span>
					<?endif;?>
					<?if (get_sub_field('profile')) :?>
						<? the_sub_field('profile')?>
					<?endif;?>
					<?if (get_sub_field('telephone')) :?>
						<a href="tel:<? the_sub_field('telephone')?>" class="tel"><i class="fa fa-phone"></i> <? the_sub_field('telephone')?></a>
					<?endif;?>
					<?if (get_sub_field('email')) :?>
						<a href="mailto:<? the_sub_field('email')?>" class="email"><i class="fa fa-envelope"></i> <? the_sub_field('email')?></a>
					<?endif;?>
				</div>
			</div>
		<?endwhile;?>
	<?endif;?>
	</div>
	</div>
</section>
