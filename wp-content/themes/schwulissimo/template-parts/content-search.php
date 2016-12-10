<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package schwulissimp
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <div class="col-sm-4">
            
            <?php the_post_thumbnail('schwuliisimo-detail-cols', array('class' => 'img-responsive'))?>

            
        </div>
    <div class="col-sm-8">
	<header class="entry-header">
            <h5><?php 
                                    $type = get_post_type();
                                    if($type == 'post'){
                                                echo '<a href="' . get_post_type_archive_link($type) . '">NEWS</a>';
                                    }elseif($type == 'post_citygiude'){
                                        echo '<a href="' . get_post_type_archive_link($type) . '">cityguide</a>';
                                    }elseif($type == 'schwulissimo_veranst'){
                                        echo '<a href="' . get_post_type_archive_link($type) . '">veranstaltung</a>';
                                    }
                                
                                ?></h5>
           
            <?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php schwulissimo_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
            
            
           	<?php the_title( sprintf( '<h6 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' ); ?>

		
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php schwulissimo_entry_footer(); ?>
	</footer><!-- .entry-footer -->
        </div>
    </div>
</article><!-- #post-## -->
