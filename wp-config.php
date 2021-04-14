<?php

define( 'WP_CACHE', true ); // Added by WP Rocket


/**

 * La configuration de base de votre installation WordPress.

 *

 * Ce fichier est utilisé par le script de création de wp-config.php pendant

 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous

 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les

 * valeurs.

 *

 * Ce fichier contient les réglages de configuration suivants :

 *

 * Réglages MySQL

 * Préfixe de table

 * Clés secrètes

 * Langue utilisée

 * ABSPATH

 *

 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.

 *

 * @package WordPress

 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //

/** Nom de la base de données de WordPress. */

define( 'DB_NAME', "giep-intranet" );

/** Utilisateur de la base de données MySQL. */

define( 'DB_USER', "root" );

/** Mot de passe de la base de données MySQL. */

define( 'DB_PASSWORD', "58Lj9pqJNHAabK9O" );

/** Adresse de l’hébergement MySQL. */

define( 'DB_HOST', "localhost" );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */

define( 'DB_CHARSET', 'utf8mb4' );

/**

 * Type de collation de la base de données.

 * N’y touchez que si vous savez ce que vous faites.

 */

define( 'DB_COLLATE', '' );

/**#@+

 * Clés uniques d’authentification et salage.

 *

 * Remplacez les valeurs par défaut par des phrases uniques !

 * Vous pouvez générer des phrases aléatoires en utilisant

 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.

 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.

 * Cela forcera également tous les utilisateurs à se reconnecter.

 *

 * @since 2.6.0

 */

define( 'AUTH_KEY',         '_Z4/ (h&Ks=7L$X=}d$55>90acWYOLKSVT7-E*HXfqc [*CW,ZS:W$8Uy-Of0y4f' );

define( 'SECURE_AUTH_KEY',  '6P+m(-r!P]Fwt#us,mv06ggOb!WSe]]lNN+oM#qsC_8[;?YU-<u7G?cPLqP|x_1i' );

define( 'LOGGED_IN_KEY',    'gaEzpPauWC@^jc]vST={&.K3NaSBR$8X~6|QXV#~vb?R`n/QUc=I|;gORfJy 7Br' );

define( 'NONCE_KEY',        'Iddebw9??_7uNQUnL|aON*K#NlJY=p+K1-c~83|vY>&tpTo_thL.NoYt}8TY*4Q|' );

define( 'AUTH_SALT',        'GglFf%h]7F|Phzb/}7<o^<^>.yOS]|r4*n;t_W8cio^RgImgg] <9DOOleKMuC&B' );

define( 'SECURE_AUTH_SALT', 'WHl[Rxk8pV:-8k=qB{ +q,)MCDIbp7/AZ-AjliKQ?Z-[{zG_h6bKGPqnSOyq2u1#' );

define( 'LOGGED_IN_SALT',   's=d/<E+9J~bF1$*JK$s&A$LZu^#fOancA=5CpK=VAs|^Fj@+|m<b&P@CGyXWY`g7' );

define( 'NONCE_SALT',       '8qQ5nEt7nqH| ]W,HSF2BA<Jpq#-=DpKi%s rOgPYG.IQPei7>7e$mmI1}SoQ7<h' );

/**#@-*/

/**

 * Préfixe de base de données pour les tables de WordPress.

 *

 * Vous pouvez installer plusieurs WordPress sur une seule base de données

 * si vous leur donnez chacune un préfixe unique.

 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !

 */

$table_prefix = 'wp_giep_nc';

/**

 * Pour les développeurs : le mode déboguage de WordPress.

 *

 * En passant la valeur suivante à "true", vous activez l’affichage des

 * notifications d’erreurs pendant vos essais.

 * Il est fortement recommandé que les développeurs d’extensions et

 * de thèmes se servent de WP_DEBUG dans leur environnement de

 * développement.

 *

 * Pour plus d’information sur les autres constantes qui peuvent être utilisées

 * pour le déboguage, rendez-vous sur le Codex.

 *

 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/

 */

define('ALLOW_UNFILTERED_UPLOADS', true);

define( 'WP_MEMORY_LIMIT', '128M' );

define( 'WP_MAX_MEMORY_LIMIT', '256M' );


define( 'WP_DEBUG', false );

define( 'WP_POST_REVISIONS', 3 );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */

if ( ! defined( 'ABSPATH' ) )

  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */

require_once( ABSPATH . 'wp-settings.php' );