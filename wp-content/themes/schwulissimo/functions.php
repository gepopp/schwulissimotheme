<?php
/**
 * schwulissimp functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package schwulissimp
 */

if ( ! function_exists( 'schwulissimo_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function schwulissimo_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on schwulissimp, use a find and replace
	 * to change 'schwulissimo' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'schwulissimo', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'schwulissimo' ),
		'administration' => esc_html__( 'Primary Administration', 'schwulissimo' ),
                
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'schwulissimo_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'schwulissimo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function schwulissimo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'schwulissimo_content_width', 640 );
}
add_action( 'after_setup_theme', 'schwulissimo_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function schwulissimo_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'schwulissimo' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'schwulissimo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'schwulissimo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function schwulissimo_scripts() {
    
        wp_enqueue_style( 'oswald-font', 'https://fonts.googleapis.com/css?family=Oswald' );
	wp_enqueue_style( 'schwulissimo-style', get_stylesheet_uri() );
        wp_enqueue_style( 'slider-css', get_stylesheet_directory_uri() . '/css/eagle.gallery.css' );
	
	wp_enqueue_script( 'schwulissimo-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	
        wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCJQi7ySNFDknUkgC0yBD1DVIkbBoi3dBg', array() );
       
        wp_enqueue_script( 'gallery-js', get_stylesheet_directory_uri() . '/js/dev/eagle.gallery.js', array('jquery') );
        
        
        wp_register_script( 'schwulissimo-main', get_template_directory_uri() . '/js/main.min.js', array('jquery', 'google-maps', 'jquery-ui-autocomplete'), '20151215', true );
        wp_register_script( 'schwulissimo-cityguide-single', get_template_directory_uri() . '/js/dev/cityguide-single.js', array('schwulissimo-main'), '20151215', true );   
        wp_register_script( 'schwulissimo-cityguide-archive', get_template_directory_uri() . '/js/dev/cityguide-archive.js', array('schwulissimo-main'), '20151215', true );   
        
        
        wp_localize_script('schwulissimo-main', 'post_info', array('ID' => get_the_ID(), 
            'markerIcon' => get_stylesheet_directory_uri().'/img/schwulissimo_map_icon.png',
            'markerIconSmall' => get_stylesheet_directory_uri().'/img/schwulissimo_map_icon_small.png',
            'needles' => schwulissimo_get_cityguide_needles(),
            'spinner' => get_stylesheet_directory_uri().'/img/dashinfinity.gif',
            'fastajax' => get_stylesheet_directory_uri() . '/inc/ajax-spped.php'
            ));
        wp_enqueue_script('schwulissimo-main');
        
       
        
        if(is_singular('post_citygiude')){
            wp_enqueue_script('schwulissimo-cityguide-single'); 
        }
        
        if(is_post_type_archive('post_citygiude')){
            wp_localize_script('schwulissimo-cityguide-archive', 'cityguide_addresses', array('unique' => get_cityguide_addr(), 'cats' => get_cityguide_terms()));
            wp_enqueue_script('schwulissimo-cityguide-archive'); 
        }
        
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'schwulissimo_scripts' );

/*
 * require administration section scripts
 */
add_action( 'init', 'schwulissimo_require_scripts');
function schwulissimo_require_scripts() {

        $files = glob(get_template_directory() . '/administration-shortcodes/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                require_once $file; // delete file
        }
} 
/**
 * Implement the Ajax functions
 */
require get_template_directory() . '/inc/ajax.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-tags-veranst.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * Load option Pages
 */
require get_template_directory() . '/inc/optionPages.php';
/**
 * Load Importer
 */
require get_template_directory() . '/inc/importer.php';
/**
 * Load helpers
 */
require get_template_directory() . '/inc/helper-functions.php';
/**
 * Load ct
 */
require get_template_directory() . '/inc/custom-taxonomy.php';
/**
 * Load cpt 
 */
require get_template_directory() . '/inc/cpt-veranstaltung.php';
require get_template_directory() . '/inc/cpt-cityguide.php';
require get_template_directory() . '/inc/cpt-partypics.php';

add_filter('get_search_form', function($html){
    
$form = 
<<<EOT
    <form role="search" method="get" class="search-form" action="http://www.sewemo.eu/schwulissimo/">
				<label>
					<span class="screen-reader-text">Suche nach:</span>
					<input type="search" class="search-field" placeholder="" value="" name="s">
				</label>
				<button type="submit"  class="search-submit" value=""><span class="glyphicon glyphicon-search"></span></button>
			</form>
EOT;
return $form;
    
});

//add_action('add_over_header', function(){   echo '<div class="container">';   echo '<img src="http://placehold.it/1140x300">';  echo '</div>'; });
//add_action('add_under_header', function(){  echo '<img src="http://placehold.it/1140x300">'; });



add_action( 'init', function() {
  register_nav_menus(
    array(
      'footer-col-one' => __( 'Footer Column One' ),
      'footer-col-two' => __( 'Footer Column Two' ),
      'footer-col-three' => __( 'Footer Column Three' ),
      'footer-col-four' => __( 'Footer Column Four' ),
      'footer-col-five' => __( 'Footer Column Five' ),
      'footer-col-six' => __( 'Footer Column Six' ),
    )
  );
} );

/**
 * setup theme specific image sizes
 */
add_action( 'after_setup_theme', function(){ 

    add_image_size( 'schwuliisimo-slider-large', 1005, 500, array('center', 'center') );
    add_image_size( 'schwuliisimo-slider-small', 201, 101, array('center', 'center') );
    add_image_size( 'schwuliisimo-story-index', 642, 600, array('center', 'center') );
    add_image_size( 'schwuliisimo-detail-medium', 615, 570, array('center', 'center') );
    add_image_size( 'schwuliisimo-detail-small', 226, 130, array('center', 'center') );
    add_image_size( 'schwuliisimo-detail-cols', 207, 170, array('center', 'center') );
    add_image_size( 'schwuliisimo-subpage-small', 488, 570, array('center', 'center') );
    add_image_size( 'schwuliisimo-ticket-small', 315, 195, array('center', 'center') );
    
});
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


add_filter('excerpt_more', function($excerpt){
            
            
            $excerpt = '<a href="' . get_the_permalink() . '" class="more-link"> mehr...</a>';
            return $excerpt; 
    
});
add_filter('posts_where', function ( $where ) {
	
	$where = str_replace("meta_key = 'schwulissimo_veranst_ort_und_termin_%", "meta_key LIKE 'schwulissimo_veranst_ort_und_termin_%", $where);

	return $where;
});
function get_cityguide_addr(){
        
        $sql  = 'SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key = "cityguide_adresse"';
        global $wpdb;
        $res = $wpdb->get_results($sql);

        if(is_array($res)):
        foreach($res as $r){
              $arr =  maybe_unserialize($r->meta_value);
              if(is_array($arr) && array_key_exists('address', $arr)){
              $arr1 = explode(',', $arr['address']);
              $where[] = trim($arr1[1]);
              }
        }
        endif;
        return json_encode(array_values(array_unique($where)));
}
function get_cityguide_terms(){
    
        $terms = get_terms( 'cityguide_category', array('hide_empty' => true ));
           if(is_array($terms)){
               foreach($terms as $t){
                        $what[] = array('label' => 'Kategorie: ' . htmlspecialchars_decode($t->name), 'value' => 'term_'.$t->term_id);
               }
           }
           return json_encode($what);
}
function schwulissimo_add_custom_types( $query ) {
  if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
    $query->set( 'post_type', array(
     'post', 'post_citygiude', 'schwulissimo_veranst'
		));
	  return $query;
	}
}
add_filter( 'pre_get_posts', 'schwulissimo_add_custom_types' );

 

function my_acf_google_map_api( $api ){
	
	$api['key'] = 'AIzaSyCJQi7ySNFDknUkgC0yBD1DVIkbBoi3dBg';
	
	return $api;
	
}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');


