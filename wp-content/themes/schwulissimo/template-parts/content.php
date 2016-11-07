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
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php schwulissimo_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->
     
        <div id="author-meta-box">
            <?php
                    $author = new BP_Core_User( get_the_author_meta('ID') );
            ?>
            <p class="beside-image">EIN<?php echo $author->avatar; ?></p><p class="beside-image">ARTIKEL VON</p>
            <a href="<?php echo $author->user_url ?>" class="author-profile-link" ><?php echo $author->profile_data['Name']['field_data']?></a>
            <div class="author-additional-info">
                <a class="author-socials" href="<?php echo $author->profile_data['Facebook']['field_data'] ?>">Facebook</a>
                <a class="author-socials" href="<?php echo $author->profile_data['Twitter']['field_data'] ?>">Facebook</a>
                <a class="author-socials" href="<?php echo $author->profile_data['google plus']['field_data'] ?>">Facebook</a>
                <a class="author-socials" href="mailto:<?php echo $author->email ?>">Mail</a>
            </div>
        </div>
        
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

	
</article><!-- #post-## -->
