<?php
/**
 * Theme functions related to structure.
 *
 * This file contains structural hook functions.
 *
 * @package Magazine_Plus
 */

if ( ! function_exists( 'magazine_plus_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since 1.0.0
	 */
	function magazine_plus_doctype() {
		?><!DOCTYPE html> <html <?php language_attributes(); ?>>
		<link rel="prefetch" href="http://192.168.40.60/intragiep/">
		<?php
	}
endif;

add_action( 'magazine_plus_action_doctype', 'magazine_plus_doctype', 10 );

if ( ! function_exists( 'magazine_plus_head' ) ) :
	/**
	 * Header Codes.
	 *
	 * @since 1.0.0
	 */
	function magazine_plus_head() {
		?>
	    <meta charset="<?php bloginfo( 'charset' ); ?>">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="profile" href="http://gmpg.org/xfn/11">
	    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<!-- Accueil -->		
		<link rel="prefetch" href="http://intranet_dev/">
		<link rel="prefetch" href="http://intranet_dev/amicale-du-giep-nc/">
		<link rel="prefetch" href="http://intranet_dev/amicale-du-giep-nc/documents-de-lamical-du-giep/">
		<link rel="prefetch" href="http://intranet_dev/annuaire-interne/">
		<link rel="prefetch" href="http://intranet_dev/les-services-support/">
		<!-- EVENEMENTS  -->
		<link rel="prefetch" href="http://intranet_dev/events/amicale-events/">
		<link rel="prefetch" href="http://intranet_dev/events/service-coordination-et-peri-formation-bourail-events/">
		<link rel="prefetch" href="http://intranet_dev/events/service-communication-documentation-events/">
		<link rel="prefetch" href="http://intranet_dev/events/service-finances-ressources-humaines/">
		<link rel="prefetch" href="http://intranet_dev/events/service-moyens-generaux/">
		<link rel="prefetch" href="http://intranet_dev/events/direction-events/">
		<link rel="prefetch" href="http://intranet_dev/events/spot-events/">
		<link rel="prefetch" href="http://intranet_dev/events/hotellerie-restauration-events/">
		<link rel="prefetch" href="http://intranet_dev/events/metiers-de-la-mer-events/">
		<link rel="prefetch" href="http://intranet_dev/events/industrie-events-test/">
		<link rel="prefetch" href="http://intranet_dev/events/transport-logistique-events-test/">
		<link rel="prefetch" href="http://intranet_dev/events/maintenance-auto-events/">
		<link rel="prefetch" href="http://intranet_dev/events/test-events-informations/">
		<!-- News -->
		<link rel="prefetch" href="http://intranet_dev/archive/">
		<link rel="prefetch" href="http://intranet_dev/category/">
		<link rel="prefetch" href="http://intranet_dev/category/giep/">
		<link rel="prefetch" href="http://intranet_dev/activites-du-site/">
		<link rel="prefetch" href="http://intranet_dev/nouvelle-arrivant/">
		<!-- Documents -->
		<link rel="prefetch" href="http://intranet_dev/download/">
		<!-- Pôle -->
		<link rel="prefetch" href="http://intranet_dev/les-poles/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/information-orientation/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/maintenance-automobile-engins/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/transport-logistique/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/industrie/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/metiers-de-la-mer/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/hotellerie-restauration/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/spot/">
		<link rel="prefetch" href="http://intranet_dev/les-services-support/service-finances-ressources-humaines/livret-daccueil/">		
		<!-- Pôle DOCUMENT -->
		<link rel="prefetch" href="http://intranet_dev/les-poles/spot/documents-du-pole-spot/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/hotellerie-restauration/documents-du-pole-hotellerie-restauration/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/metiers-de-la-mer/documents-du-pole-metiers-de-la-mer/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/industrie/documents-du-pole-industrie/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/transport-logistique/documents-du-pole-transport-logistique/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/maintenance-automobile-engins/document-du-pole-maintenance-automobile-engins/">
		<link rel="prefetch" href="http://intranet_dev/les-poles/information-orientation/document-du-pole-information-orientation/">
		<!-- Service -->
		<link rel="prefetch" href="http://intranet_dev/les-services-support/direction/">
		<link rel="prefetch" href="http://intranet_dev/les-services-support/service-moyens-generaux/">
		<link rel="prefetch" href="http://intranet_dev/les-services-support/service-finances-ressources-humaines/">
		<link rel="prefetch" href="http://intranet_dev/les-services-support/service-communication-documentation/">
		<link rel="prefetch" href="http://intranet_dev/les-services-support/service-coordination-et-peri-formation-bourail/">
		<!-- Service DOCUMENT -->
		<link rel="prefetch" href="http://intranet_dev/les-services-support/direction/document-du-service-de-direction/">
		<link rel="prefetch" href="http://intranet_dev/les-services-support/service-moyens-generaux/document-des-service-des-moyens-generaux/">
		<link rel="prefetch" href="http://intranet_dev/les-services-support/service-finances-ressources-humaines/documents-des-service-finances-ressources-humaines/">
		<link rel="prefetch" href="http://intranet_dev/les-services-support/service-finances-ressources-humaines/livret-daccueil/">
		<link rel="prefetch" href="http://intranet_dev/les-services-support/service-communication-documentation/documents-des-service-communication-documentation/">
		<link rel="prefetch" href="http://intranet_dev/les-services-support/service-coordination-et-peri-formation-bourail/documents-du-service-coordination-et-peri-formation-bourail/">
		<!-- Annuaire -->
		<link rel="prefetch" href="http://intranet_dev/annuaire-interne/direction-annuaire/">
		<link rel="prefetch" href="http://intranet_dev/annuaire-interne/annuaire-des-services-coordination-et-peri-formation-bourail/">
		<link rel="prefetch" href="http://intranet_dev/annuaire-interne/pole-industrie-annuaire/">
		<link rel="prefetch" href="http://intranet_dev/annuaire-interne/annuaire-du-service-des-moyens-generaux/">
		<link rel="prefetch" href="http://intranet_dev/annuaire-interne/annuaire-des-service-communication-documentation/">
		<link rel="prefetch" href="http://intranet_dev/annuaire-interne/annuaire-des-services-finance-ressource/">
		<link rel="prefetch" href="http://intranet_dev/annuaire-interne/maintenance-annuaire/">
		<link rel="prefetch" href="http://intranet_dev/annuaire-interne/information-orientation-annuaire/">
		<link rel="prefetch" href="http://intranet_dev/annuaire-interne/pole-preparatoire/">
		<link rel="prefetch" href="http://intranet_dev/annuaire-interne/pole-tourisme-hotellerie-restauration/">
		<link rel="prefetch" href="http://intranet_dev/annuaire-interne/logistique-annuaire/">
		<!-- LES DOCUMENTS LE PLUS VISITER -->
		<link rel="prefetch" href="http://intranet_dev/download/livret-daccueil/">
		<!-- ADMIN -->
		<link rel="prefetch" href="http://intranet_dev/wp-admin/">
		<link rel="prefetch" href="http://intranet_dev/wp-admin/profile.php">
		<link rel="prefetch" href="http://intranet_dev/wp-admin/upload.php">
		<link rel="prefetch" href="http://intranet_dev/wp-admin/admin.php?page=tablepress">
		<link rel="prefetch" href="http://intranet_dev/wp-admin/edit.php?post_type=ifso_triggers">
	    <?php
	}
endif;
add_action( 'magazine_plus_action_head', 'magazine_plus_head', 10 );

if ( ! function_exists( 'magazine_plus_page_start' ) ) :
	/**
	 * Page Start.
	 *
	 * @since 1.0.0
	 */
	function magazine_plus_page_start() {
		?><div id="page" class="hfeed site"><?php
	}
endif;
add_action( 'magazine_plus_action_before', 'magazine_plus_page_start' );

if ( ! function_exists( 'magazine_plus_page_end' ) ) :
	/**
	 * Page End.
	 *
	 * @since 1.0.0
	 */
	function magazine_plus_page_end() {
		?></div><!-- #page --><?php
	}
endif;

add_action( 'magazine_plus_action_after', 'magazine_plus_page_end' );

if ( ! function_exists( 'magazine_plus_content_start' ) ) :
	/**
	 * Content Start.
	 *
	 * @since 1.0.0
	 */
	function magazine_plus_content_start() {
		?><div id="content" class="site-content"><div class="container"><div class="inner-wrapper"><?php
	}
endif;
add_action( 'magazine_plus_action_before_content', 'magazine_plus_content_start' );


if ( ! function_exists( 'magazine_plus_content_end' ) ) :
	/**
	 * Content End.
	 *
	 * @since 1.0.0
	 */
	function magazine_plus_content_end() {
		?></div><!-- .inner-wrapper --></div><!-- .container --></div><!-- #content --><?php
	}
endif;
add_action( 'magazine_plus_action_after_content', 'magazine_plus_content_end' );


if ( ! function_exists( 'magazine_plus_header_start' ) ) :
	/**
	 * Header Start.
	 *
	 * @since 1.0.0
	 */
	function magazine_plus_header_start() {
		$extra_class = '';
		?><header id="masthead" class="site-header" role="banner"><div class="container"><div class="inner-wrapper"><?php
	}
endif;
add_action( 'magazine_plus_action_before_header', 'magazine_plus_header_start' );

if ( ! function_exists( 'magazine_plus_header_end' ) ) :
	/**
	 * Header End.
	 *
	 * @since 1.0.0
	 */
	function magazine_plus_header_end() {
		?></div> <!-- .inner-wrapper --></div><!-- .container --></header><!-- #masthead --><?php
	}
endif;
add_action( 'magazine_plus_action_after_header', 'magazine_plus_header_end' );



if ( ! function_exists( 'magazine_plus_footer_start' ) ) :
	/**
	 * Footer Start.
	 *
	 * @since 1.0.0
	 */
	function magazine_plus_footer_start() {
		$footer_status = apply_filters( 'magazine_plus_filter_footer_status', true );
		if ( true !== $footer_status ) {
			return;
		}
		?><footer id="colophon" class="site-footer" role="contentinfo"><div class="container"><?php
	}
endif;
add_action( 'magazine_plus_action_before_footer', 'magazine_plus_footer_start' );


if ( ! function_exists( 'magazine_plus_footer_end' ) ) :
	/**
	 * Footer End.
	 *
	 * @since 1.0.0
	 */
	function magazine_plus_footer_end() {
		$footer_status = apply_filters( 'magazine_plus_filter_footer_status', true );
		if ( true !== $footer_status ) {
			return;
		}
		?></div><!-- .container --></footer><!-- #colophon --><?php
	}
endif;
add_action( 'magazine_plus_action_after_footer', 'magazine_plus_footer_end' );
