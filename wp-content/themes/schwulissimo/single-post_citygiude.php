<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package schwulissimp
 */

get_header(); ?>
<div class="row">
    <div class="col-xs-12">
        <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
            <?php
                if (function_exists('bcn_display')) {
                    bcn_display();
                }
            ?>
        </div><!-- breadcrumb div -->  
    </div><!-- 12 cols breadcrumb -->
</div><!-- row for breadcrumbs -->
<div class="row content-row">
    
	
		<?php
		while ( have_posts() ) : the_post();
                
                $gallery = get_field('field_58069b05d9441');
                
                    ?>
                <?php if(has_post_thumbnail()):?>
                <div class="col-xs-12">
                    <div class="eagle-gallery img500">
                        <div class="owl-carousel">
                            <?php 
                                $get_description = get_post(get_post_thumbnail_id())->post_excerpt;
                                if(get_the_title() == $get_description){
                                    $get_description = '';
                                }
                            ?>
                            <img src="<?php the_post_thumbnail_url('schwuliisimo-slider-large')?>" data-copy="<?php echo $get_description ?>" data-link="<?php echo get_the_permalink() ?>" data-medium-img="<?php the_post_thumbnail_url('full')?>" data-big-img="<?php the_post_thumbnail_url('full')?>" data-title="<?php echo get_the_title()?>" alt="">
                             <?php 
                           
                            foreach($gallery as $image_id):
                                
                                $get_description = $image_id['caption'];
                                if($image_id['title'] == $get_description){
                                    $get_description = '';
                                }
                            ?>
                            <img src="<?php echo $image_id['sizes']['schwuliisimo-slider-small']?>" 
                                 data-copy="<?php echo $get_description ?>" 
                                 data-link="#"
                                 data-title="<?php echo $image_id['title'] ?>" 
                                 alt="<?php echo $image_id['alt'] ?>"
                                 data-big-img="<?php echo $image_id['url']?>" 
                                 data-medium-img="<?php echo $image_id['sizes']['schwuliisimo-slider-large']?>" />
                            <?php endforeach;?>
                            


                        
  
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
                                itemsCustom: [[0, 1],[250, 2], [450, 3], [650, 5], [850, 5], [1050, 5], [1250, 3], [1450, 4]],
                                margin: 10
                            },
                        });
                    });
                    
                    </script>
                </div>
     <?php endif; ?>
                 <div class="col-md-8 col-xs-12">  
                    <?php 

                            
			get_template_part( 'template-parts/content-cityguide', get_post_format() );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
    
				comments_template();
                         
			endif;
		endwhile; // End of the loop.
		?>

	
</div><!-- main column -->      
 <div class="col-md-4 hidden-xs">
  <?php 
get_sidebar();
?>
</div><!-- sidebar -->
<footer class="entry-footer">
    <?php 
        schwulissimo_veranst_footer_additional(false);
        schwulissimo_entry_footer_additional(); ?>
	</footer><!-- .entry-footer -->
</div><!-- content row -->

<?php 
get_footer();
