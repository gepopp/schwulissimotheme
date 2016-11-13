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
                    ?>
                <div class="col-xs-12" id="post-image-holder">
                    <?php if(has_post_thumbnail()):?>
                        <?php the_post_thumbnail('schwuliisimo-slider-large')?>
                    <?php else: ?>
                    <img src="<?php echo get_stylesheet_directory_uri() . '/img/default.jpg'?>" alt="schwulissimo gays default image" width="1004" height="482" class="img-responsive" />
                    <?php endif;?>


                </div>
                <div class="col-xs-12" id="post-image-caption">
                    <span class="pull-right"><?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?></span>
                    <span class="pull-left"><?php echo get_field('field_58108608ea5bc')  //subtitle ?></span>
                </div>
                 <div class="col-md-8 col-xs-12">  
                    <?php 

                            
			get_template_part( 'template-parts/content', get_post_format() );

			//the_post_navigation();

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
		<?php schwulissimo_entry_footer_additional(); ?>
	</footer><!-- .entry-footer -->
</div><!-- content row -->

<?php 
get_footer();
