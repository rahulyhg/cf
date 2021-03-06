<?php
if ( !is_user_logged_in() ) {
	if (new DateTime() < new DateTime("2016-07-27 14:00:00")) {
 		header('Location: '.get_site_url().'/presentacion/');
 	}
}
?>


<!DOCTYPE html><html>
<head>
  <meta charset='utf-8'>
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
  <title><? wp_title() ?></title>
  <link rel="stylesheet" href="<? bloginfo('stylesheet_url') ?>" media="screen" />
  <link rel="shortcut icon" href="http://ciudadfutura.com.ar/wp-content/themes/ciudadfutura/img/ciudad-futura-favicon.ico?384979801"/>

	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-2.2.0.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/d3.min.js"></script>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75871000-1', 'auto');
  ga('send', 'pageview');

</script>
  <!--[if lt IE 9]><script src="<?= get_template_directory_uri(); ?>/js/html5shiv.js"></script><![endif]-->
  <? wp_head() ?>

<body <?php body_class(); ?>>
	<div class="menu-wrap">
		<div class="menulink">
			<span class="glyphicon glyphicon-align-justify"></span>
		</div>
		<div class="container">
		<?php //wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_class' => 'menu-header' ) ); ?>
		<?php /* Primary navigation */
		wp_nav_menu( array(
		  'menu' => 'top_menu',
		  'depth' => 2,
		  'container' => false,
		  'menu_class' => 'nav nav-justified',
		  //Process nav menu using our custom nav walker
		  'walker' => new wp_bootstrap_navwalker())
		);
		?>
		</div>
	</div>
	<header>
	<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		
	</a>
	</header>
