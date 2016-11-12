<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package schwulissimp
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header clearfix">
            <?php if ('post' === get_post_type() || 'schwulissimo_veranst' === get_post_type()) : ?>
                    <div class="entry-meta">
                        <?php schwulissimo_posted_on(); ?>
                    </div><!-- .entry-meta -->
                    <?php
                endif;
            ?>
            
                    
        <div class="entry-headline">
            <?php 
                 $introfield = get_field('field_5825a0bcc66b9'); //Introtext
                if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
                            
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
                ?>
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
        <div id="veranst-metaboxes">
            
            <?php schwulissimo_verastaltung_add_metaboxes() ?>
            
        </div>
	
</article><!-- #post-## -->
