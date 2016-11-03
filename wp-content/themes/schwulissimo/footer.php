<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package schwulissimp
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
            <div class="container footer-container">
                
                <div class="row">
                    <div class="col-md-2 col-xs-4">
                        <div class="grey-spacer hidden-xs"></div>
                        <h5>Bereiche</h5>
                        <?php wp_nav_menu( array( 'theme_location' => 'footer-col-one' ) ); ?>
                    </div>
                    <div class="col-md-2 col-xs-4">
                         <h5>Rubriken</h5>
                        <?php wp_nav_menu( array( 'theme_location' => 'footer-col-two' ) ); ?>
                    </div>
                    <div class="col-md-2 col-xs-4">
                         <h5>Regionen</h5>
                        <?php wp_nav_menu( array( 'theme_location' => 'footer-col-three' ) ); ?>
                    </div>
                    <div class="col-md-2 col-xs-4">
                        <h5>Verlag</h5>
                        <?php wp_nav_menu( array( 'theme_location' => 'footer-col-four' ) ); ?>
                    </div>
                    <div class="col-md-2 col-xs-4">
                        <h5>Rechtliches</h5>
                        <?php wp_nav_menu( array( 'theme_location' => 'footer-col-five' ) ); ?>
                    </div>
                    <div class="col-md-2 col-xs-4">
                        <h5>folge uns</h5>
                        <?php wp_nav_menu( array( 'theme_location' => 'footer-col-six' ) ); ?></div>
                </div>
                
                
                
		<div class="site-info pull-right">
                    &copy; 2014 - <?php echo date('Y') ?> Fash Medien Verlag GmbH

		</div><!-- .site-info -->
                </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
