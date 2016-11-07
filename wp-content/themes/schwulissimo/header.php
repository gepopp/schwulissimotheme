<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package schwulissimp
 */
require_once get_stylesheet_directory() . '/wp_bootstrap_navwalker.php';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<meta property="og:image" content="http://www.coachesneedsocial.com/wp-content/uploads/2014/12/BannerWCircleImages-1.jpg" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="page" class="site">
        <?php do_action('add_over_header'); ?>

        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'schwulissimo'); ?></a>
        <header id="masthead" class="site-header" role="banner">
            <div class="container container-header">
                <div class="site-branding">
                    <div class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/logo.png" width="400" height="50" alt="Schwulissimo Logo Schriftzug" />
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/slogan.png" width="93" height="50" alt="Schwulissimo Logo Schriftzug" class="hidden-xs"  id="slogan"/>
                        </a>
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div id="site-search" class="pull-right hidden-xs">
                            <?php get_search_form() ?>
                        </div>
                    </div>
                </div><!-- .site-branding -->
                <nav class="navbar navbar-default" role="navigation">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">

                        </div>
                        <a class="navbar-brand brand-hide" href="<?php echo home_url(); ?>">
                            <div class="grey-spacer"></div>
                        </a>
                        <?php
                            wp_nav_menu(array(
                                'menu' => 'primary',
                                'theme_location' => 'primary',
                                'depth' => 2,
                                'container' => 'div',
                                'container_class' => 'collapse navbar-collapse',
                                'container_id' => 'bs-example-navbar-collapse-1',
                                'menu_class' => 'nav navbar-nav',
                                'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                                'walker' => new wp_bootstrap_navwalker())
                            );
                        ?>
                        <script>
                            jQuery(document).ready(function($){
                            
                            /*
                                $('#bs-example-navbar-collapse-1, #bs-example-navbar-collapse-2').append('<ul class="nav navbar-nav navbar-right">' +
                                '<li class="dropdown">' +
                                '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span style="color: #e73c30;"><span class="glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp; Region:</span> W&auml;hle deine Region <span class="caret"></span></a>' +
                                  '<ul class="dropdown-menu">' +
                                        '<li><a href="#">Action</a></li>' +
                                        '<li><a href="#">Another action</a></li>' +
                                        '<li><a href="#">Something else here</a></li>' +
                                        '<li role="separator" class="divider"></li>' +
                                        '<li><a href="#">Separated link</a></li>' +
                                        '</ul><li></ul>');
*/
                                if ($(window).scrollTop() > 100) {
                                    $('.hidden-nav').show();
                                    $('.hidden-nav').css('background', 'white');
                                    $('.hidden-nav').css('border-bottom', '1px solid black');
                                }

                                $(window).scroll(function () {

                                    var top = $(this).scrollTop();
                                    console.log(top);
                                    if (top > 100) {
                                        $('.hidden-nav').fadeIn();
                                        $('.hidden-nav').css('background', 'white');
                                        $('.hidden-nav').css('border-bottom', '1px solid black');

                                    } else {
                                        $('.hidden-nav').hide();
                                    }


                                });



                            });
                        </script>

                        <nav class="navbar navbar-default navbar-fixed-top hidden-nav" style="display:none;" role="navigation">
                            <div class="container">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a class="navbar-brand" href="<?php echo home_url(); ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/img/logo.png" width="200" height="24" alt="Schwulissimo Logo Schriftzug" style="display: inline-block;" />
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/img/slogan.png" width="48" height="24" alt="Schwulissimo Logo Schriftzug" id="hidden-slogan" style="display: inline-block;" />
                                    </a>
                                </div>

                                <?php
                                    wp_nav_menu(array(
                                        'menu' => 'primary',
                                        'theme_location' => 'primary',
                                        'depth' => 2,
                                        'container' => 'div',
                                        'container_class' => 'collapse navbar-collapse',
                                        'container_id' => 'bs-example-navbar-collapse-2',
                                        'menu_class' => 'nav navbar-nav',
                                        'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                                        'walker' => new wp_bootstrap_navwalker())
                                    );
                                ?>
                            </div>
                        </nav>
                    </div> 
                    <?php do_action('add_under_header')?>
</header><!-- #masthead -->
        <div id="content" class="site-content container">
