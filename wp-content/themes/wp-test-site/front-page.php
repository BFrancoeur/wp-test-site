<?php
/**
 * The front page template
 *
 * Renders all homepage sections using Dovetail BEM structure.
 * {{variables}} from the parser output are replaced with WP template tags.
 *
 * @package WP_Test_Site
 */

get_header();
?>

<main id="main-content" class="site-main">

	<!-- ── Hero ──────────────────────────────────────────────────────────────── -->

	<?php
	$hero_image = has_post_thumbnail()
		? get_the_post_thumbnail_url( get_the_ID(), 'full' )
		: 'https://picsum.photos/1600/900?grayscale';
	?>

	<section class="section section--hero hero hero--dark">
		<img
			class="hero__bg-image"
			src="<?php echo esc_url( $hero_image ); ?>"
			alt="<?php the_title_attribute(); ?>"
		>
		<div class="hero__overlay"></div>
		<div class="hero__inner">
			<h1 class="hero__primary-cta">
				<?php the_title(); ?>
			</h1>
			<p class="hero__supporting-cta">
				<?php echo wp_kses_post( get_the_excerpt() ); ?>
			</p>
			<a href="#services" class="btn btn--large btn--white">
				<?php esc_html_e( 'See Our Services', 'wp-test-site' ); ?>
			</a>
		</div>
	</section>


	<!-- ── Services ─────────────────────────────────────────────────────────── -->
	<!-- TODO: replace hardcoded cards with a WP_Query on a 'service' post type -->

	<section id="services" class="section section--services services py-2xl">
		<div class="layout layout--cols-1 content-wrap">
			<div class="content-slot services__title" data-content="services-title">
				<h2><?php esc_html_e( 'What We Do', 'wp-test-site' ); ?></h2>
			</div>
			<div class="layout layout--cols-3 layout--wrap gap-md services__grid mt-lg">

				<?php
				$services = [
					[
						'icon'        => 'https://picsum.photos/64/64?random=1',
						'icon_alt'    => 'Service icon',
						'heading'     => 'Strategic Planning',
						'description' => 'We work with you to define clear goals and build a roadmap that turns ambition into measurable outcomes.',
						'cta_url'     => '#',
						'cta_label'   => 'Learn More',
					],
					[
						'icon'        => 'https://picsum.photos/64/64?random=2',
						'icon_alt'    => 'Service icon',
						'heading'     => 'Brand Identity',
						'description' => 'From logo to voice, we craft cohesive identities that resonate with your audience and stand out in the market.',
						'cta_url'     => '#',
						'cta_label'   => 'Learn More',
					],
					[
						'icon'        => 'https://picsum.photos/64/64?random=3',
						'icon_alt'    => 'Service icon',
						'heading'     => 'Digital Marketing',
						'description' => 'Data-driven campaigns across the right channels, built to grow your reach and convert the right customers.',
						'cta_url'     => '#',
						'cta_label'   => 'Learn More',
					],
					[
						'icon'        => 'https://picsum.photos/64/64?random=4',
						'icon_alt'    => 'Service icon',
						'heading'     => 'Web Development',
						'description' => 'Fast, accessible, and beautifully built websites that perform as well as they look — on every device.',
						'cta_url'     => '#',
						'cta_label'   => 'Learn More',
					],
					[
						'icon'        => 'https://picsum.photos/64/64?random=5',
						'icon_alt'    => 'Service icon',
						'heading'     => 'Content Strategy',
						'description' => 'We help you say the right things to the right people — with content that educates, engages, and converts.',
						'cta_url'     => '#',
						'cta_label'   => 'Learn More',
					],
					[
						'icon'        => 'https://picsum.photos/64/64?random=6',
						'icon_alt'    => 'Service icon',
						'heading'     => 'Analytics & Insights',
						'description' => 'Turn raw data into clear direction. We help you understand what\'s working and where your next opportunity lies.',
						'cta_url'     => '#',
						'cta_label'   => 'Learn More',
					],
				];

				foreach ( $services as $service ) : ?>
					<div class="service-card">
						<div class="service-card__icon">
							<img src="<?php echo esc_url( $service['icon'] ); ?>" alt="<?php echo esc_attr( $service['icon_alt'] ); ?>">
						</div>
						<div class="service-card__body">
							<h3 class="service-card__heading"><?php echo esc_html( $service['heading'] ); ?></h3>
							<p class="service-card__description"><?php echo esc_html( $service['description'] ); ?></p>
						</div>
						<div class="service-card__footer">
							<a href="<?php echo esc_url( $service['cta_url'] ); ?>" class="btn btn--medium btn--outline">
								<?php echo esc_html( $service['cta_label'] ); ?>
							</a>
						</div>
					</div>
				<?php endforeach; ?>

			</div><!-- .services__grid -->
		</div><!-- .content-wrap -->
	</section>


	<!-- ── About ─────────────────────────────────────────────────────────────── -->
	<!-- TODO: wire up with page content or ACF fields -->

	<section class="section section--about about py-2xl">
		<div class="content-wrap">
			<p class="text-muted text-center"><?php esc_html_e( '[About section — coming soon]', 'wp-test-site' ); ?></p>
		</div>
	</section>


	<!-- ── Who We Serve ──────────────────────────────────────────────────────── -->

	<section class="section section--who-we-serve who-we-serve py-2xl">
		<div class="content-wrap">
			<p class="text-muted text-center"><?php esc_html_e( '[Who We Serve — coming soon]', 'wp-test-site' ); ?></p>
		</div>
	</section>


	<!-- ── Why We Do It ──────────────────────────────────────────────────────── -->

	<section class="section section--why-we-do-it why-we-do-it py-2xl">
		<div class="content-wrap">
			<p class="text-muted text-center"><?php esc_html_e( '[Why We Do It — coming soon]', 'wp-test-site' ); ?></p>
		</div>
	</section>


	<!-- ── Social Proof ──────────────────────────────────────────────────────── -->

	<section class="section section--social-proof social-proof py-2xl">
		<div class="content-wrap">
			<p class="text-muted text-center"><?php esc_html_e( '[Social Proof — coming soon]', 'wp-test-site' ); ?></p>
		</div>
	</section>


	<!-- ── CTA ───────────────────────────────────────────────────────────────── -->

	<section class="section section--cta cta cta--dark py-2xl">
		<div class="content-wrap text-center">
			<h2 class="text-white"><?php esc_html_e( 'Ready to get started?', 'wp-test-site' ); ?></h2>
			<p class="text-white mt-md"><?php esc_html_e( 'Let\'s talk about what we can build together.', 'wp-test-site' ); ?></p>
			<a href="#" class="btn btn--large btn--white mt-xl"><?php esc_html_e( 'Get In Touch', 'wp-test-site' ); ?></a>
		</div>
	</section>

</main><!-- #main-content -->

<?php get_footer(); ?>
