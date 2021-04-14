<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 */
 
// Votre code ici
get_header(); ?>
<div id="primary " class="content-area position-100">
		<main id="main" class="site-main" role="main">
    <!-- Si il y a des article alors affiche des articles -->
    <?php while(have_posts()) : the_post() ;?>  
    <!-- Contenue complet de la page  -->
    <?php the_post_thumbnail(); ?>
    <?php the_content(); ?>
    <!-- Extrain de la page  --> 
    <!-- <?php the_excerpt(); ?> -->
    <?php endwhile;?><!-- Une boucle while se fini toujour par un endwhile -->
	</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer(); ?>