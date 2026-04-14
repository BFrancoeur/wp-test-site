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

	<section class="section section--about about py-2xl">
		<div class="content-wrap">
			<div class="about__inner">
				<h2 class="about__heading"><?php esc_html_e( 'Who We Are', 'wp-test-site' ); ?></h2>
				<p class="about__body">
					<?php esc_html_e( 'We are a team of strategists, creatives, and builders who believe great work starts with a clear understanding of who you\'re trying to reach — and why it matters. For over a decade, we\'ve partnered with businesses of all sizes, from ambitious startups to established enterprises, helping them clarify their vision, sharpen their message, and build the digital presence they deserve. We don\'t believe in one-size-fits-all solutions. Every engagement begins with listening: to your goals, your challenges, and the people you serve. What we bring is a rare combination of strategic thinking and hands-on execution — a team that sees the big picture and does the work to bring it to life. We\'re proud of the relationships we\'ve built along the way, and we\'d love to add yours to the list.', 'wp-test-site' ); ?>
				</p>
			</div>
		</div>
	</section>


	<!-- ── Who We Serve ──────────────────────────────────────────────────────── -->

	<section class="section section--who-we-serve who-we-serve">
		<div class="layout layout--cols-2">
				<div class="two-col-section__text">
					<h2 class="two-col-section__heading"><?php esc_html_e( 'Who We Serve', 'wp-test-site' ); ?></h2>
					<p class="two-col-section__body">
						<?php esc_html_e( 'We work with organizations that are ready to grow — businesses that know where they want to go but need the right partner to help them get there. Whether you\'re a startup building your brand from scratch, a mid-sized company ready to level up your marketing, or an established business navigating a digital transformation, we\'ve been there before. Our clients come from a wide range of industries, but they share one thing in common: a commitment to doing things right. We bring the same commitment to every engagement, no matter the size of the project or the stage of the business.', 'wp-test-site' ); ?>
					</p>
				</div>
				<div class="two-col-section__image">
					<img
						src="https://picsum.photos/600/480?random=10"
						alt="<?php esc_attr_e( 'Who we serve', 'wp-test-site' ); ?>"
					>
				</div>
		</div>
	</section>


	<!-- ── Why We Do It ──────────────────────────────────────────────────────── -->

	<section class="section section--why-we-do-it why-we-do-it">
		<div class="layout layout--cols-2">
				<div class="two-col-section__image">
					<img
						src="https://picsum.photos/600/480?random=20"
						alt="<?php esc_attr_e( 'Why we do it', 'wp-test-site' ); ?>"
					>
				</div>
				<div class="two-col-section__text">
					<h2 class="two-col-section__heading"><?php esc_html_e( 'Why We Do It', 'wp-test-site' ); ?></h2>
					<p class="two-col-section__body">
						<?php esc_html_e( 'We got into this work because we believed business could be done differently — with more honesty, more care, and more of a long-term view. Too many organizations are sold quick fixes that don\'t hold up. We\'re here to build things that last. Every strategy we develop, every brand we shape, and every campaign we launch is grounded in a genuine desire to see our clients succeed. Not just in the short term, but in ways that compound over time. That\'s what gets us out of bed in the morning. That\'s why we do it.', 'wp-test-site' ); ?>
					</p>
				</div>
		</div>
	</section>


	<!-- ── Social Proof ──────────────────────────────────────────────────────── -->

	<section class="section section--social-proof social-proof py-section">
		<div class="content-wrap">
			<div class="layout layout--cols-4 gap-md">

				<?php
				$testimonials = [
					[
						'body' => 'Working with this team completely changed how we think about our brand. They listened before they spoke, and what they delivered was exactly what we needed — clear, confident, and built to last.',
						'name' => 'Sarah M., Founder &amp; CEO',
					],
					[
						'body' => 'We\'d worked with other agencies before, but none of them got us the way this team did. The strategy they built has driven real, measurable results. I can\'t recommend them highly enough.',
						'name' => 'James T., VP of Marketing',
					],
					[
						'body' => 'From the first conversation to the final handoff, the process was smooth, transparent, and genuinely collaborative. They made a complex project feel manageable. We\'ll absolutely be back.',
						'name' => 'Priya K., Director of Growth',
					],
					[
						'body' => 'Our website traffic has doubled and our conversion rate is up 40% since we launched the new site. The team delivered beyond what we expected, on time and on budget.',
						'name' => 'David R., Co-Founder',
					],
				];
				?>

				<?php foreach ( $testimonials as $testimonial ) : ?>
					<div class="testimonial">
						<blockquote class="testimonial__body">
							<?php echo esc_html( $testimonial['body'] ); ?>
						</blockquote>
						<p class="testimonial__name"><?php echo wp_kses_post( $testimonial['name'] ); ?></p>
					</div>
				<?php endforeach; ?>

			</div>
		</div>
	</section>


	<!-- ── CTA ───────────────────────────────────────────────────────────────── -->

	<section class="section section--cta cta cta--green py-section">
		<div class="content-wrap text-center">
			<h2 class="text-white"><?php esc_html_e( 'Ready to get started?', 'wp-test-site' ); ?></h2>
			<p class="text-white mt-md"><?php esc_html_e( 'Let\'s talk about what we can build together.', 'wp-test-site' ); ?></p>
			<a href="#" class="btn btn--large btn--white mt-xl"><?php esc_html_e( 'Get In Touch', 'wp-test-site' ); ?></a>
		</div>
	</section>

</main><!-- #main-content -->

<?php get_footer(); ?>
