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
	<header class="entry-header">
            <h5><?php 
                                    $type = get_post_type();
                                    if($type == 'post'){
                                        echo 'NEWS';
                                    }elseif($type == 'post_citygiude'){
                                        echo 'cityguide';
                                    }elseif($type == 'schwulissimo_veranst'){
                                        echo 'veranstaltung';
                                    }
                                
                                ?></h5>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php schwulissimo_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php schwulissimo_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
