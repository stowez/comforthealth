<? /*
* Template name: Blog
*/

 get_header(); ?>

<?php if ( have_posts() ) : ?>
	<section class="blog-page">
	<?php
		$count = 0;
		// Start the loop.
		while ( have_posts() ) : the_post();?>

			<? if($count == 0): ?>

				<article class="single-blog banner <?= ( $count == 0 ? 'featured' : '') ?>" style="background-image:url('<? the_post_thumbnail_url('full'); ?>');">
					<div class="container">
						<header >
							<h1 class="banner__title"><a href="<? the_permalink(); ?>"><? the_title(); ?></a></h1>
							<footer class="banner__author">
								<? $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( get_the_author_meta('email') ) ) ) . "?s=50"?>
								<span class="avatar"><img src="<?= $grav_url; ?>"> By <?=get_the_author_meta('display_name');?> on <?= the_time('jS F Y')?></span>
								<div>
									<a href="<? the_permalink();?> " class="btn outline">Read more</a>
								</div>
							</footer>
						</header>
					</div>
				</article>
			<? else: ?>

				<? if( $count == 1) : echo '<section class="all-posts"><div class="container blog__flex"><div class="blog__posts">'; endif; ?>
				<article class="single-blog masonry">
					<figure class="blog__figure">
						<? the_post_thumbnail('large'); ?>
						
					</figure>
					<header class="blog__header">
						<div class="blog__header__meta">
							<span class="blog__author blog__author__timestamp">
								<?= the_time('jS F Y')?>
							</span>

							<?/*<div class="blog__figure__tags">
								<?$cats = get_the_category();?>
								<?$catCount = 0;?>
								<? foreach ($cats as $cat):?>
									<?if($catCount > 5):
										break;
									endif;?>
									<? /* <a href="#" class="cat-tags"><?= $cat->name; ?></a>?>
									<?$catCount++;?>
								<?endforeach;?>
							</div>*/ ?>
						</div>
						<h2 class="blog__title"><a href="<? the_permalink(); ?>"><? the_title(); ?></a></h2>	
					</header>
					
					<div class="blog__content">
						<? the_excerpt(); ?>

						<a href="<? the_permalink();?> " class="read-more">Read more</a>
						<footer class="blog__footer-post">
								<? $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( get_the_author_meta('email') ) ) ) . "?s=50" ?>
								<span class="avatar"><img src="<?= $grav_url; ?>"></span>
								<p>
									<?= get_the_author_meta('display_name'); ?>
								</p>

								
						</footer>
					</div>
				</article>
			<? endif; ?>
			
		<?
		$count++;
		// End the loop.
		endwhile;?>
		</div>
		</div></section>
	</section>
		<div class="navigation-pagination">
		<?// Previous/next page navigation.
		the_posts_pagination( array(
			'prev_text'          => __( 'Previous page', 'twentysixteen' ),
			'next_text'          => __( 'Next page', 'twentysixteen' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
		) );?>
		</div>
<?
endif;

get_footer();
		?>
