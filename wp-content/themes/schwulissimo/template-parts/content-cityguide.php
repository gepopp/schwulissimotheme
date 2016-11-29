<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package schwulissimp
 */
global $cityguide_status;
$cityguide_status = get_field('field_58319bac65faa');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header clearfix">
        <div id="author-meta-box" class=" col-sm-3" style="border:none;padding-top: 0;">
           <?php $cityguide_logo = get_field('field_583199e7aaf58');
                 $cityguide_logo_url = $cityguide_logo['sizes']['thumbnail'];
            ?>
                <img src="<?php echo $cityguide_logo_url != '' ? $cityguide_logo_url : 'https://placeholdit.imgix.net/~text?txtsize=33&txt=Kein Logo&w=200&h=200' ?>" />

        </div>
                    
        <div class="entry-headline col-xs-12 col-sm-9">
             <?php if ('post' === get_post_type() || 'schwulissimo_veranst' === get_post_type() || 'post_citygiude' == get_post_type()) : ?>
                    <div class="entry-meta">
                        <?php schwulissimo_posted_on(); ?>
                    </div><!-- .entry-meta -->
                    <?php
                endif;
            ?>
        </div>  
        <div class="entry-headline col-xs-12 col-sm-9 entry-title-holder">
        <?php	the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
        </div>
        
	</header><!-- .entry-header -->
    
    
	
     
       
        
	<div class="entry-content">
		<?php
                   
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'schwulissimo' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'schwulissimo' ),
				'after'  => '</div>',
			) );
                   
		?>
	</div><!-- .entry-content -->
         <?php 
                
                    
            ?>
        <div id="cityguide-metaboxes">
            
            <?php schwulissimo_cityguide_single_meta_box() ?>
            
        </div>
	
</article><!-- #post-## -->
