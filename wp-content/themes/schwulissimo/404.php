<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package schwulissimp
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<div class="page-content row">
				
                                     <div class="col-xs-12 col-md-9 col-md-push-3">
                                        <img src="<?php echo get_stylesheet_directory_uri()?>/img/404.jpg" alt="the 404 gays" width="1100" height="825" />
                                    </div>
                                    
                                    <div class="col-xs-12 col-md-3 col-md-pull-9">
                                        <div class="text-404">
                                        <h5>UPS..UNS findest du hier leider nicht</h5>
                                        <h5>Es wurde kein Inhalt an dieser Stelle hinterlegt</h5>
                                        <a href="<?php echo home_url() ?>">
"
                                        <h4 class="schwulissimo-red">
                                            <span class="glyphicon glyphicon-chevron-left"></span> 
                                            <span class="glyphicon glyphicon-chevron-left"></span> 
                                            
                                            Hier gehts zur&uuml;ck</h4>
                                        </a>
                                        </div>
                                    </div>
                                   

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
