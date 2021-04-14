<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Magazine_Plus
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Aucun résultats', 'magazine-plus' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'êtes-vous prêts à publier votre première publication? <a href="%1$s">Commencez ici</a>.', 'magazine-plus' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Désolé, mais rien ne correspond à vos termes de recherche. Veuillez réessayer avec un autre mots-clés.', 'magazine-plus' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'Il semble que nous ne puissions pas trouver ce que vous cherchez. Peut-être que une de ces recherche peut vous aider.', 'magazine-plus' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
