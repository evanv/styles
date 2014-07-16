<?php
/**
 * Custom amendments for the theme.
 *
 * @category    Obloquy
 * @subpackage  Genesis
 * @copyright   Website by KarmaKazi Creative
 * @license     GPL-2.0+
 * @link        http://www.karmakazicreative.com
 * @since       1.0.0
 *
 */

add_action( 'genesis_setup', 'obloquy_theme_setup', 15 );
/**
 * Theme Setup
 *
 * This setup function attaches all of the site-wide functions
 * to the correct hooks and filters. All the functions themselves
 * are defined below this setup function.
 *
 * @since 1.0.1
 */
function obloquy_theme_setup() {

	//* Child theme (do not remove)
	define( 'CHILD_THEME_NAME', __( 'obloquy Theme', 'obloquy' ) );
	define( 'CHILD_THEME_VERSION', '1.0.9' );
	define( 'CHILD_THEME_URL', 'http://karmakazicreative.com/' );
	define( 'CHILD_THEME_DEVELOPER', __( 'KarmaKazi Creative', 'obloquy' ) );
	
//* Add viewport meta tag for mobile browsers.
	add_theme_support( 'genesis-responsive-viewport' );
	
//* Add HTML5 markup structure.
	add_theme_support( 'html5' );

	//*	Set content width.
	$content_width = apply_filters( 'content_width', 610, 610, 980 );

	//* Add new featured image sizes.
	add_image_size( 'horizontal-thumbnail', 680, 453, TRUE );
	add_image_size( 'square-thumbnail', 450, 450, TRUE );
        add_image_size( 'vertical-thumbnail', 480, 600, FALSE );
        add_image_size( 'featured-category', 600, 800, FALSE );
        add_image_size( 'rogue', 280, 240, array( 'center', 'top' ) );

	//* Add support for custom background.
	add_theme_support( 'custom-background' );

	//* Unregister header right sidebar.
	unregister_sidebar( 'header-right' );

	//* Create color style options.
	add_theme_support( 'genesis-style-selector', array(
			'theme-citrus'	=> __( 'Citrus', 'obloquy' ),
			'theme-earthy'	=> __( 'Earthy', 'obloquy' ),
		)
	);
	
	//* Add support for custom header.
	add_theme_support( 'genesis-custom-header', array(
			'width'  => 600,
			'height' => 210
		)
	);

        //*Reposition the secondary menu.
        remove_action( 'genesis_after_header', 'genesis_do_subnav' );
        add_action( 'genesis_before_footer', 'genesis_do_subnav' );

	//* Add support for 3-column footer widgets.
	add_theme_support( 'genesis-footer-widgets', 3 );

	//* Enqueue child theme styles.
	add_action( 'wp_enqueue_scripts', 'obloquy_enqueue_syles' );

	//* Enqueue child theme JavaScript.
	add_action( 'wp_enqueue_scripts', 'obloquy_enqueue_js' );

	//* Add child theme body class.
	add_filter( 'body_class', 'obloquy_add_body_class' );

	//* Add post navigation.
	add_action( 'genesis_after_entry_content', 'genesis_prev_next_post_nav', 5 );

	//* Modify the WordPress read more link.
	add_filter( 'the_content_more_link', 'obloquy_read_more_link' );

	//* Add excerpt read more link.
	add_filter( 'excerpt_more', 'get_read_more_link' );
	add_filter( 'the_content_more_link', 'get_read_more_link' );

	//* Modify the speak your mind text.
	add_filter( 'genesis_comment_form_args', 'obloquy_comment_form_args' );

	//* Customize the credits.
	add_filter( 'genesis_footer_creds_text', 'obloquy_footer_creds_text' );

	//* Load an ad section before .site-inner.
	add_action( 'genesis_after_header', 'obloquy_top_ad' );

	//*	Load theme sidebars.
	obloquy_register_sidebars();

}

/**
 * Load Genesis
 *
 * This is technically not needed.
 * However, to make functions.php snippets work, it is necessary.
 */
require_once( get_template_directory() . '/lib/init.php' );

/**
 * Load all additional stylesheets for the obloquy theme.
 *
 */
function obloquy_enqueue_syles() {
	wp_enqueue_style( 'obloquy-google-fonts', '//fonts.googleapis.com/css?family=Gentium+Book+Basic:700|Sorts+Mill+Goudy|EB+Garamond', array(), CHILD_THEME_VERSION );
}

/**
 * Load all required JavaScript for the obloquy theme.
 *
 * @since 1.0.1
 */
function obloquy_enqueue_js() {
	$js_uri = get_stylesheet_directory_uri() . '/lib/js/';
	// Add general purpose scripts.
	wp_enqueue_script( 'obloquy-general', $js_uri . 'general.js', array( 'jquery' ), '1.0.0', true );
}

/**
 * Add the theme name class to the body element.
 *
 * @param  string $classes
 * @return string Modified body classes.
 *
 */
function obloquy_add_body_class( $classes ) {
		$classes[] = 'obloquy';
		return $classes;
}

/**
 * Modify the Genesis read more link.
 *
 * @param  string $more
 * @return string Modified read more text.
 *
 */
function obloquy_read_more_link() {
	return '<p></p><a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'obloquy' ) . ' &raquo;</a>';
}

/**
 * Add excerpt read more link.
 *
 * @param  string $more
 * @return string Modified read more text.
 *
 */
function get_read_more_link() {
   return '...&nbsp;<p></p><a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'obloquy' ) . ' &raquo;</a>';
}

/**
 * Modify the speak your mind text.
 *
 */
function obloquy_comment_form_args( $args ) {
	$args['title_reply'] = __( 'Comments', 'obloquy' );
	return $args;
}

/**
 * Customize the footer text
 *
 * @param  string $creds Default credits.
 * @return string Modified Shay Bocks credits.
 *
 */
function obloquy_footer_creds_text( $creds ) {
	return sprintf(
		'[footer_copyright before="%s "] &middot; [footer_childtheme_link before=""] %s <a href="http://www.shaybocks.com/">%s</a> &middot; %s [footer_genesis_link url="http://www.studiopress.com/" before=""] &middot; [footer_wordpress_link before=" %s"]',
		__( 'Copyright', 'obloquy' ),
		__( 'by', 'obloquy' ),
		CHILD_THEME_DEVELOPER,
		__( 'Built on the ', 'obloquy' ),
		__( 'Powered by ', 'obloquy' )
	);
}

/**
 * Load an ad section before .site-inner.
 *
 */
add_action( 'genesis_after_header', 'obloquy_top_ad' );
function obloquy_top_ad() {
	//* Return early if we have no ad.
	if ( ! is_active_sidebar( 'top-ad' ) ) {
		return;
	}

	echo '<div class="top-ad">';
		dynamic_sidebar( 'top-ad' );
	echo '</div>';
}

/**
 * Register sidebars for Obloquy theme.
 *
 */
function obloquy_register_sidebars() {
	genesis_register_sidebar( array(
		'id'			=> 'top-ad',
		'name'			=> __( 'Top Ad', 'obloquy' ),
		'description'	=> __( 'This is the top ad section.', 'obloquy' ),
	) );
	genesis_register_sidebar( array(
		'id'			=> 'home-top',
		'name'			=> __( 'Home Top', 'obloquy' ),
		'description'	=> __( 'This is the home top section.', 'obloquy' ),
	) );
	genesis_register_sidebar( array(
		'id'			=> 'home-middle',
		'name'			=> __( 'Home Middle', 'obloquy' ),
		'description'	=> __( 'This is the home middle section.', 'obloquy' ),
	) );
	genesis_register_sidebar( array(
		'id'			=> 'home-bottom',
		'name'			=> __( 'Home Bottom', 'obloquy' ),
		'description'	=> __( 'This is the home bottom section.', 'obloquy' ),
	) );
}

	
 /**
 * Post Authors Post Link Shortcode
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/wordpress-post-multiple-authors/
 * 
 * @param array $atts
 * @return string $authors
 */
function be_post_authors_post_link_shortcode( $atts ) {

	$atts = shortcode_atts( array( 
		'between'      => null,
		'between_last' => null,
		'before'       => null,
		'after'        => null
	), $atts );

	$authors = function_exists( 'coauthors_posts_links' ) ? coauthors_posts_links( $atts['between'], $atts['between_last'], $atts['before'], $atts['after'], false ) : $atts['before'] . get_author_posts_url() . $atts['after'];
	return $authors;
}
add_shortcode( 'post_authors_post_link', 'be_post_authors_post_link_shortcode' , 11);



/**Add the obloquy audio content */
add_action( 'genesis_entry_header', 'kkc_custom_field_before_content', 12 );

function kkc_custom_field_before_content() {
     if( is_page() || is_single()  ) {
          echo do_shortcode(genesis_get_custom_field('obl_audio'));
     }
}


add_action( 'genesis_entry_footer', 'kkc_after_post_upload' );
function kkc_after_post_upload() {
     $kkc_audio = genesis_get_custom_field('obl_audio');
     if( is_single() && empty( $kkc_audio )  && !has_post_format( 'video' ) ) {
          echo do_shortcode('[gravityform id="5" name="Audio Submit" title="true" description="true"]');
     }
}


add_action( 'genesis_entry_header', 'kkc_submit_audio' , 13 );
function kkc_submit_audio() {
     $kkc_audio = genesis_get_custom_field('obl_audio');
     if( empty( $kkc_audio ) && !is_archive() && !is_page()  && !has_post_format( 'video' ) ) {
          echo "<div class='yourvoice'>This Obloquy needs your help! Click <a href='http://dev.obloquy.com'>here</a> to add your voice!</div>";
     }
}




/** Set default content width */
if ( ! isset( $content_width ) ) $content_width = 680;



/**
 * Custom Body Classes
 * @link http://www.billerickson.net/wordpress-class-body-tag/
 * @author Bill Erickson
 *
 * @param array $classes existing body classes
 * @return array modified body classes
 */
function my_body_classes( $classes ) {
	if ( is_author() || is_category() || is_archive() ) {
		$classes[] = "archive"; 
    }
	return $classes;
}
add_filter( 'body_class', 'my_body_classes' );


//* Add featured image to post */
add_action( 'genesis_entry_header', 'single_post_featured_image', 15 );

function single_post_featured_image() {
	
	if ( ! is_singular( 'post' ) )
		return;
	
	$img = genesis_get_image( array( 'format' => 'html', 'size' => 'vertical-thumbnail', 'attr' => array( 'class' => 'post-image' ) ) );
	printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
	
}


//* Add custom body class to the head
add_filter( 'body_class', 'sp_body_class' );
function sp_body_class( $classes ) {
	if ( is_category( '1' ))
		$classes[] = 'custom-class';
		return $classes;
}



//* Remove the author box on single posts XHTML Themes
remove_action( 'genesis_after_post', 'genesis_do_author_box_single' );

//* Remove the author box on single posts HTML5 Themes
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

add_theme_support( 'post-formats', array( 'video' ) );