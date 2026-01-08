<?
	if (get_sub_field('background_image_or_colour') != 'colour'  ) {
		$style = "background-image: url('".get_sub_field('background_image')."')";
	} else {
		$style = "background-color: ".get_sub_field('background_colour');
	}
	?>

<style> 
.video-background {
  background: transparent;
  position: fixed;
  top: 0; right: 0; bottom: 0; left: 0;
  /* z-index: -99; */
}
.video-foreground,
.video-background video {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}
@media (min-aspect-ratio: 16/9) {
  .video-foreground { height: 300%; top: -100%; }
}
@media (max-aspect-ratio: 16/9) {
  .video-foreground { width: 300%; left: -100%; }
}
@media all and (max-width: 600px) {
.vid-info { width: 50%; padding: .5rem; }
.vid-info h1 { margin-bottom: .2rem; }
}
@media all and (max-width: 500px) {
.vid-info .acronym { display: none; }
}

.video-content {
	position: absolute;
    top: 50%;
    background: #1e1e1e57;
    z-index: 51;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 1rem;
	opacity: 0;
	transition: all 1s ease;
}

.video-content p {
	color: #fff;
}

.fullscreen-hero h1 {
	line-height: 4rem;
}

@media (max-width: 700px) {
		.video-content {
			opacity: 100;
			width: 100%;
			height: 100vh;
    		padding-top: 8rem;
			top: 0;
			transform: none;
			left: 0;
		}

		.home .fullscreen-hero {
			background-image: url('https://www.comforthealth.co.uk/wp-content/uploads/2019/08/42836120742_fb175cb0d8_k.jpg') !important;
		}

		.video-foreground {
			display: none;
		}

		.video-content.bottom {
			padding-top: 0;
		}
}
.bottom {
	top: 85%;
	background : none;
	transform: translateX(-50%);
	min-width: 100%;
}
</style>

<section class="fullscreen-hero fullscreen-hero--center <?if (is_front_page()) :?> front-page <?endif;?> <?= (get_sub_field('background_image_or_colour') == 'image' ? 'darkOverlay' : 'lightCmpt') ?> <?= (get_sub_field('half_height') ? 'half--hero' : '')?>" style="<?= $style ?>">
	<? if(get_sub_field('background_image_or_colour') == 'video') {?>
		<div class="video-content">
				<? the_sub_field('content_block'); ?>
				<h2><a href="/booking/" class="book-now-button">Book Now</a></h2>
			</div>
		</div>
		<div class="video-background">
			<div class="video-foreground">
			<video controls autoplay plays-inline muted loop>
					<source src="<?= bloginfo('stylesheet_directory'); ?>/home-video-720p.webm" type="video/webm" >
					<source src="<?= bloginfo('stylesheet_directory'); ?>/home-video-720p.mov" type="video/mov" >
					<source src="<?= bloginfo('stylesheet_directory'); ?>/home-video-720p.mp4" type="video/mp4" >
				</video>
			</div>
		</div>



		<? /* OLD Video
			$video = get_sub_field('background_video');
			$link =preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","$1",$video);
		

		<div class="video-background">
			<div class="video-foreground">
			<iframe src="//www.youtube.com/embed/<?=$link?>?controls=0&showinfo=0&rel=0&autoplay=1&loop=1&mute=1&playlist=<?=$link?>" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="video-content">
					<? the_sub_field('content_block'); ?>
				</div>
				<div class="video-content bottom">
					<h2><a href="/booking/" class="book-now-button">Book Now</a></h2>
				</div>
		</div>
		*/
		?>
	<?} else {?>
		
		<div class="container">
			<?php
				if ( function_exists('yoast_breadcrumb') && get_sub_field('half_height') && !get_sub_field('hide_breadcrumbs')) {
					yoast_breadcrumb('<p id="breadcrumbs">','</p>');
				}
			?>
			<? if(get_sub_field('logo_icon')):?>
				<figure style="width: 400px; height:145px; margin: 0 auto;"> 
					<img src="<? the_sub_field('logo_icon'); ?>" class="" width="400" height="145">

				</figure>
			<?endif;?>
			<article class="content content--center">

				<? the_sub_field('content_block'); ?>
				<?if (get_sub_field('include_video_button')) :?>
					<a class="btn outline video" href="https://www.youtube.com/embed/t25gS8Mjlak?rel=0&amp;controls=0&amp;showinfo=0&autoplay=1" data-featherlight="iframe" data-featherlight-iframe-frameborder="0" data-featherlight-iframe-allow="autoplay; encrypted-media" data-featherlight-iframe-allowfullscreen="true" data-featherlight-iframe-style="display:block;border:none;height:80vh;width:80vw;"><? the_sub_field('play_button_text'); ?></a>
				<?endif;?>
			</article>
			<?if (is_front_page()) :?>
				<h2><a href="/booking/" class="book-now-button">Book Now</a></h2>
			<?endif;?>
		
		</div>
	<?}?>
	<a href="#" id="scrollNext"><i class="fa fa-angle-double-right"></i></a>
	
</section>
<? if( isset($_REQUEST['play'])  && !isset($_COOKIE['played']) && $_COOKIE['played'] !== 1 ) {?>
<div class="featherlight featherlight-iframe mimic" style="display: block; background:rgba(0,0,0,0.8)"><div class="featherlight-content"><button class="featherlight-close-icon featherlight-close" aria-label="Close">✕</button><iframe src="https://www.youtube.com/embed/RbV9RcT0xOQ?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1" frameborder="0" allow="autoplay; encrypted-media" autplay allowfullscreen="true" style="display:block;border:none;height:80vh;width:80vw;" class="featherlight-inner"></iframe></div></div>
	<script>
		$( document ).ready(function() {


			$('.mimic .featherlight-close').on('click', function() {
				$('.mimic').remove();
			});

			window.addEventListener("keydown", function(event) {
				if(event.which == 27) {
					$('.mimic').remove();
				}
			});
		});
	</script>
<?}?>

<script>
		$( document ).ready(function() {
			console.log($('.video-content').length );
			if($('.video-content').length > 0) {
			
				setTimeout(() => {
					$('.video-content').css('opacity', 100);
				}, 1000);
			}
		});
</script>