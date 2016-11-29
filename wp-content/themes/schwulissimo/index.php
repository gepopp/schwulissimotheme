<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package schwulissimp
 */

get_header(); ?>

	

                 
<div class="row">
    <div class="col-md-12">
		<?php
                    
                    $args = array(
                        'post_type' => array('post' ),
                        'posts_per_page' => 20,
                        'orderby' => 'rand',
                       //'post__in' => array(235706)
                    );
                        $query_gallery = new WP_Query($args);
                    ?>
                    <div class="eagle-gallery img500">
                        <div class="owl-carousel">
                            <?php if($query_gallery->have_posts()):?>
                            <?php while($query_gallery->have_posts()):?>
                            <?php $query_gallery->the_post()?>
                            <?php if(has_post_thumbnail()):  
                                $get_description = get_post(get_post_thumbnail_id())->post_excerpt;
                                if(get_the_title() == $get_description){
                                    $get_description = '';
                                }
                            ?>
                            <img src="<?php the_post_thumbnail_url('schwuliisimo-slider-large')?>" data-copy="<?php echo $get_description ?>" data-link="<?php echo get_the_permalink() ?>" data-medium-img="<?php the_post_thumbnail_url('full')?>" data-big-img="<?php the_post_thumbnail_url('full')?>" data-title="<?php echo get_the_title()?>" alt="">
                             <?php endif;?>
                            <?php endwhile;?>
                            <?php endif;?>
                        </div>
                    </div>
                    <script>
                    jQuery(document).ready(function($){
                        $(".eagle-gallery").eagleGallery({
                            miniSliderArrowPos: 'inside',
                            miniSliderArrowStyle: 2,
                            changeMediumSpeed: 600,
                            changeMediumStyle: false,
                            autoPlayMediumImg: true,
                            miniSlider: {
                                navigation: true,
                                pagination: false,
                                navigationText: false,
                                rewindNav: false	,
                                theme: 'mini-slider',
                                responsiveBaseWidth: '.eagle-gallery',
                                itemsCustom: [[0, 1],[250, 2], [450, 3], [650, 6], [850, 4], [1050, 4], [1250, 4], [1450, 4]],
                                margin: 10
                            },
                        });
                    });
                    </script>
                 </div>
                </div>   
                    
                <?php schwulissimo_get_cityguide_needles() ?>
       
                <div id="primary" class="content-area row">
		<main id="main" class="site-main col-md-9" role="main">
         
                    
                <?php 
                   
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
                <sidebar class="col-md-3 hidden-xs">
                    <?php get_sidebar(); ?>
                </sidebar>
	</div><!-- #primary -->

<?php
get_footer();
