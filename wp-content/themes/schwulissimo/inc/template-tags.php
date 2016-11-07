<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package schwulissimp
 */

if ( ! function_exists( 'schwulissimo_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function schwulissimo_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'schwulissimo' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'schwulissimo' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
        
        $shareline = '
                      <a class="social-share" href="https://www.facebook.com/sharer/sharer.php?u=' .  get_the_permalink() . '">facebook share</a>
                      <a class="social-share" href="https://plus.google.com/share?url=' .  get_the_permalink() . '">g+ share</a>
                      <a class="social-share" href="https://www.twitter.com/home?status=' .  get_the_permalink() . '">g+ share</a>
                      <a class="social-share" href="mailto:?subject=Gefunden auf ' . home_url() . '&body=' . get_the_permalink() .'">email share</a>';
        if(wp_is_mobile()){
                $shareline .= '<a class="social-share" href="whatsapp://send?text=' . get_the_permalink() . '"> whatsapp </a>';
        }

	echo '<span class="posted-on">' . $posted_on . '</span><span class="shareline pull-right"> ' . $shareline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'schwulissimo_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function schwulissimo_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'schwulissimo' ) );
		if ( $categories_list && schwulissimo_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'schwulissimo' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'schwulissimo' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'schwulissimo' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'schwulissimo' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'schwulissimo' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function schwulissimo_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'schwulissimo_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'schwulissimo_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so schwulissimo_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so schwulissimo_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in schwulissimo_categorized_blog.
 */
function schwulissimo_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'schwulissimo_categories' );
}
add_action( 'edit_category', 'schwulissimo_category_transient_flusher' );
add_action( 'save_post',     'schwulissimo_category_transient_flusher' );

function schwulissimo_entry_footer_additional(){
    ?>
    <h3 style="display:table"><span style="display:table-cell; white-space: nowrap;"><div class="grey-spacer"></div><div style="display:inline;">WEITERE THEMEN</div></span>
    <span  style="display: table-cell; width: 100%; position: relative;"><div style="position:absolute;width: 100%; height: 100%; margin-left: 20px;" class="grey-bottom-line"></div></span></h3>
    <?php 
        
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 4,
            'post__not_in' => array(get_the_ID()),
            'orderby' => 'rand'
            
        );
        
       
            $query = new WP_Query($args);
            if($query->have_posts()):
            echo '<div class="row">';
                while($query->have_posts()):
                $query->the_post();
            ?>
            <div class="col-md-6 col-xs-12 post-preview">
                
                <?php if (has_post_thumbnail()) {?>
                 <a href="<?php echo get_the_permalink()?>"><?php the_post_thumbnail('schwuliisimo-detail-cols', array('class' => 'pull-left')) ?></a>   
                <?php }else{?>
                 <a href="<?php echo get_the_permalink()?>"><img src="<?php echo get_stylesheet_directory_uri() . '/img/default-207x153.jpg'?>" alt="schwulissimo default image" width="207" height="153" class="img-responsive pull-left" /></a>
                         <?php }?>

               
                <div class="content-short">
                <p class="term"><?php echo   the_terms(get_the_ID(), 'category')?></p>
                <p class="h5"><a href="<?php echo get_the_permalink()?>"><?php the_title()?></a></p>
                <span class="content-short"><?php the_excerpt() ?></span>
                </div>
              
            
            </div>
            <?php 
                endwhile;
                echo '</div>';
            endif;
}
function schwulissimo_contiue_reading_link($excerpt){
            
            
            $excerpt = '<a href="' . get_the_permalink() . '" class="more-link"> mehr...</a>';
            return $excerpt; 
    
}
add_filter('excerpt_more', 'schwulissimo_contiue_reading_link');