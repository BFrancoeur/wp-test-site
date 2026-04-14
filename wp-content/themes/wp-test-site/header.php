<?php
/**
 * The header for our theme
 *
 * Outputs the <head> section, opens <body>, and renders the site header.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Test_Site
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sr-only" href="#main-content"><?php esc_html_e( 'Skip to content', 'wp-test-site' ); ?></a>

<div id="page" class="site">

	<header id="masthead" class="site-header" role="banner">
		<div class="site-header__inner content-wrap">

			<!-- Branding -->
			<div class="site-header__branding">
				<?php if ( has_custom_logo() ) : ?>
					<div class="site-header__logo">
						<?php the_custom_logo(); ?>
					</div>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__site-name" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				<?php endif; ?>

				<?php
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-header__tagline"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
			</div><!-- .site-header__branding -->

			<!-- Primary Navigation -->
			<nav id="site-navigation" class="site-header__nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'wp-test-site' ); ?>">
				<button
					class="site-header__menu-toggle"
					aria-controls="primary-menu"
					aria-expanded="false"
					aria-label="<?php esc_attr_e( 'Toggle navigation', 'wp-test-site' ); ?>"
				>
					<span class="site-header__menu-toggle-bar"></span>
					<span class="site-header__menu-toggle-bar"></span>
					<span class="site-header__menu-toggle-bar"></span>
				</button>

				<?php
				wp_nav_menu( [
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'menu_class'     => 'site-header__menu',
					'fallback_cb'    => false,
				] );
				?>
			</nav><!-- .site-header__nav -->

		</div><!-- .site-header__inner -->
	</header><!-- #masthead -->
