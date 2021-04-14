<?php
/*
Template Name: Pleine largeur Fabrice
*/
 
// Votre code ici
get_header(); ?>
<main>
    <!-- Si il y a des article alors affiche des articles -->
    <?php while(have_posts()) : the_post() ;?>  
    <!-- Contenue complet de la page  -->
    <?php the_post_thumbnail(); ?>
    <?php the_content(); ?>
    <!-- Extrain de la page  --> 
    <!-- <?php the_excerpt(); ?> -->
    <?php endwhile;?><!-- Une boucle while se fini toujour par un endwhile -->
</main>
<?php get_footer(); ?>
