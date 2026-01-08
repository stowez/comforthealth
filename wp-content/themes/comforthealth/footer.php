<?/*<div class="footerSocial mainFooter">
	<div class="container">
		<div class="row with-gutter">
			<div class="col col-4">
				<?php dynamic_sidebar( 'footer_1' ); ?>
			</div>
			<div class="col col-4">
				<h4>From Twitter</h4>
				<a class="twitter-timeline" data-width="100%" data-height="350" data-dnt="true" href="https://twitter.com/ComfortHealth_">Tweets by ComfortHealth_</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
			</div>
			<div class="col col-4">
				<h4>From Instagram</h4>
				<?= do_shortcode('[instagram-feed]');?>	
			</div>
		</div>
	</div>
</div>
*/?>
<?/*<div class="row with-gutter newsletter">
	<div class="container">
		<div class="col-12 col">
			<div class="row">
				<p>For the latest special offers and news about Comfort Health enter your email below.</p>
				<? gravity_form(2, false, false, false, false, false, 10); ?>
			</div>
		</div>	
	</div>
</div>
*/?>
<div class="footerNav">
	<div class="container">
		<div class="row">
			<div class="col col-3">
				<h4>Comforthealth</h4>
				<? wp_nav_menu(array('menu' => 'footer-menu')); ?>		 
			</div>
			<div class="col col-3">
				<h4>Physiotherapy Services</h4>
				<? wp_nav_menu(array('menu' => 'footer-menu-2')); ?>		 
			</div>
			<div class="col col-3">
				<h4>Other Services</h4>
				<? wp_nav_menu(array('menu' => 'footer-menu-3')); ?>		 
			</div>
			<div class="col col-3">
				<h4>More</h4>
				<? wp_nav_menu(array('menu' => 'footer-menu-4')); ?>		 
			</div>
		</div>
	</div>
</div>
<footer class="sitefooter">
	<div class="container content content--center">
		<p>Comfort Health All Rights Reserved </p>
	</div>
</footer>
<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>

<? wp_footer();?>
<? if(is_page('video-call-physiotherapy')):?>
<script>
gform.addFilter( 'gform_datepicker_options_pre_init', function( optionsObj, formId, fieldId ) {
    if ( formId == 4 && fieldId == 11) {
        optionsObj.firstDay = 1;
        optionsObj.beforeShowDay = jQuery.datepicker.noWeekends;
    }
    return optionsObj;
});
</script>
<? endif; ?>
<script src="<? bloginfo('template_url');?>/js/featherlight.js" type="text/javascript" charset="utf-8"></script>
</body>
