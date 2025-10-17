<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
	<nav class="site-nav">
		<div class="nav-inner">
			<div class="site-logo">
				<?php
				if ( function_exists('the_custom_logo') && has_custom_logo() ) {
					the_custom_logo();
				}
				?>
			</div>

            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
	            <span class="burger-lines"></span>
            </button>

			<?php
			wp_nav_menu([
				'theme_location' => 'primary',
				'container'      => false,    
				'menu_class'     => 'menu',
                'menu_id'        => 'primary-menu',   
				'fallback_cb'    => false,    
			]);
			?>
		</div>
	</nav>
</header>

<main id="site-content">