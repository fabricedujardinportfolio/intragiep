<?php
/**
 *Template Name: Template sidebar Fabrice
 */

get_header(); ?>

<?php if ( true === apply_filters( 'magazine_plus_filter_home_page_content', true ) ) : ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php if ( is_front_page() ) : ?>
					<?php
					echo '<div id="sidebar-front-page-widget-area" class="widget-area">';
					if ( is_active_sidebar( 'sidebar-front-page-widget-area' ) ) {
						dynamic_sidebar( 'sidebar-front-page-widget-area' );
					}
					else {
						do_action( 'magazine_plus_action_default_front_page_widget_area' );
					}
					echo '</div><!-- #sidebar-front-page-widget-area -->';
					?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'page' ); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
						endif;
					?>
				<?php endif; ?>


			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
	/**
	 * Hook - magazine_plus_action_sidebar.
	 *
	 * @hooked: magazine_plus_add_sidebar - 10
	 */
	do_action( 'magazine_plus_action_sidebar' );
?>

<?php endif; // End if show home content. ?>

<?php get_footer(); ?>
