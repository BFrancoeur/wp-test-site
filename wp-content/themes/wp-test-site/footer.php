<?php
/**
 * The template for displaying the footer
 *
 * Contains the site footer, closes #page, and calls wp_footer().
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Test_Site
 */
?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-footer__inner content-wrap">

			<!-- Top row: branding + footer nav -->
			<div class="site-footer__top">

				<div class="site-footer__branding">
					<?php if ( has_custom_logo() ) : ?>
						<div class="site-footer__logo">
							<?php the_custom_logo(); ?>
						</div>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__site-name" rel="home">
							<?php bloginfo( 'name' ); ?>
						</a>
					<?php endif; ?>

					<?php
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-footer__tagline"><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>
				</div><!-- .site-footer__branding -->

				<?php if ( has_nav_menu( 'menu-2' ) ) : ?>
					<nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'Footer Navigation', 'wp-test-site' ); ?>">
						<?php
						wp_nav_menu( [
							'theme_location' => 'menu-2',
							'menu_id'        => 'footer-menu',
							'container'      => false,
							'menu_class'     => 'site-footer__menu',
							'fallback_cb'    => false,
							'depth'          => 1,
						] );
						?>
					</nav><!-- .site-footer__nav -->
				<?php endif; ?>

			</div><!-- .site-footer__top -->

			<!-- Bottom row: copyright + credits -->
			<div class="site-footer__bottom">
				<p class="site-footer__copyright">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php bloginfo( 'name' ); ?>
					</a>.
					<?php esc_html_e( 'All rights reserved.', 'wp-test-site' ); ?>
				</p>

				<p class="site-footer__credits">
					<?php
					printf(
						/* translators: %s: WordPress link */
						esc_html__( 'Powered by %s', 'wp-test-site' ),
						'<a href="https://wordpress.org" rel="nofollow">WordPress</a>'
					);
					?>
				</p>
			</div><!-- .site-footer__bottom -->

		</div><!-- .site-footer__inner -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
