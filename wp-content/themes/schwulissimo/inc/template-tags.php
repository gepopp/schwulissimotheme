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
        
        //#Bei Veranstaltungen das Post Datum durch den Ort der Ver. ersetzen
            if(get_post_type() == 'schwulissimo_veranst'){
                    
                   
                        $veranst_meta =  get_schwulissimo_veranst_meta_short(get_the_ID());
                 
                         if(is_array($veranst_meta) && !empty($veranst_meta)){
                             
                             if(count($veranst_meta) == 1){
                               $cityguideID = $veranst_meta[0]['veranstaltungsort'][0];
                             
                                $time_string = '<a href="' . get_the_permalink($cityguideID) . '">' . get_the_title($cityguideID) . ', ' . get_field('field_5817061b588df', $cityguideID) . '</a>';
                             
                                
                             }else{
                                
                                 $time_string = "Mehrere Veranstaltungsorte";
                             
                             }
                         }else{
                             
                            $sep ='';
                            $ort_alt = get_field('field_5825ca617c42e');
                            $veranstalter_alt = get_field('field_5825d5393de3b');
                
                            if($ort_alt != '' && $veranstalter_alt != ''){
                                    $sep = ', ';
                                    $time_string = $ort_alt . $sep . $veranstalter_alt;
                             }  
                         }
            }

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



/**
 * echo the additional event boxes
 * 
 * @todo mb display promoted events as payed
 */
function schwulissimo_veranst_footer_additional(){
    
    // add the headline
    schwulissimo_section_headline('MEHR EVENTS');
        
        $date = date('Ymd');
        $args = array(
            'post_type' => 'schwulissimo_veranst',
            'post_status' => 'publish',
            'posts_per_page' => 2,
            //'post__not_in' => array(get_the_ID()),
            'post__in' => array('164404', '165962'),
            'orderby' => 'rand',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'relation' => 'OR',
                array(
			'key'	 	=> 'schwulissimo_veranst_ort_und_termin_%_termine_%_datum',
			'value'	  	=> $date,
			'compare' 	=> '>=',
		),
                array(
			'key'	 	=> 'event_date',
			'value'	  	=> $date,
			'compare' 	=> '>',
		),
              )
            )
        );


        $query = new WP_Query($args);
       
        if ($query->have_posts()):
            echo '<div class="row">';
            while ($query->have_posts()):
                $query->the_post();
                ?>
                <div class="col-md-6 col-xs-12 post-preview veranst-preview">
                    <div class="veranst-preview-headline-date">
                    <?php 
                        $termine = false;
                        $veranst = get_schwulissimo_veranst_meta_short(get_the_ID());
                        if(is_array($veranst) && !empty($veranst)){
                            foreach($veranst as  $v){
                                foreach($v['termine'] as $t){
                                        $termine[] = strtotime($t['datum']);
                                }
                            }
                        }
                        if(is_array($termine) && !empty($termine)){
                        natsort($termine);
                        foreach($termine as  $t){
                                if($t >=  time()){
                                    echo date('d.m.', $t);
                                    break;
                                }
                        }
                    }elseif(get_field('event_date') != ''){
                        echo date('d.m.', strtotime(get_field('event_date')));
                    }else{
                        echo 'k.A.';
                    }
                    ?>

                    </div>
                    <div class="veranst-preview-headline-title"><a href="<?php echo get_the_permalink() ?>" style="color:white;"><?php the_title() ?></a></div>
                                
                <?php if (has_post_thumbnail()) { ?>
                                     <a href="<?php echo get_the_permalink() ?>"><?php the_post_thumbnail('schwuliisimo-ticket-small', array('class' => 'pull-left')) ?></a>   
                <?php } else { ?>
                                     <a href="<?php echo get_the_permalink() ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/img/default-207x153.jpg' ?>" alt="schwulissimo default image" width="207" height="153" class="img-responsive pull-left" /></a>
                <?php } ?>
                <div class="veranst-preview-content-short">
                    <ul class="list-unstyled">
                        <li><span class="glyphicon glyphicon-map-marker hidden-xs"></span>
                        <?php if(!is_array($veranst)){
                            echo get_field('field_5825ca617c42e');
                            echo ' ';
                            echo get_field('field_5825d5393de3b');
                        }else{
                          $vID =  $veranst[0]['veranstaltungsort'][0];
                         // $addr = get_field('field_581702c7588d1', $vID);
                          //echo $addr['address'];
                        echo '<a href="' . get_the_permalink($vID) . '">' . get_the_title($vID) . '</a>';
                          
                         
                        }?>
                            
                        </li>
                        
                        <li>
                            <ul class="list-unstyled">
                        <?php 
                        if(is_array($veranst)){
                            $runner = 1;
                            foreach($veranst[0]['termine'] as $t){
                                
                                    if(strtotime($t['datum']) < time() ) continue;
                                
                                echo '<li><span class="glyphicon glyphicon-calendar hidden-xs"></span> ' . $t['datum'] . '</li>';
                                echo '<li><span class="glyphicon glyphicon-time hidden-xs"></span> ' . $t['stunde'] . ':' . $t['minute'] . '</li>';
                                $runner++;
                                if($runner > 1) break;
                            }
                            if(count($veranst[0]['termine'])>1){
                                    echo '<li> <a class="more-appointment hidden-xs" href="' . get_the_permalink($vID) . '">weitere Termine anzeigen' . '</a>';
                                    echo '<li><a class="more-appointment visible-xs" href="' . get_the_permalink($vID) . '">mehr...</a></li>';
                            }
                        }else{
                            $datetime = get_field('field_58108892ea5c7');
                                $datearr = explode(' ', $datetime);
                                    if(is_array($datearr)){
                                        echo '<li><span class="glyphicon glyphicon-calendar hidden-xs"></span> ' . $datearr[0] . '</li>';
                                        echo '<li><span class="glyphicon glyphicon-time hidden-xs"></span> ' . $datearr[1] . '</li>';
                                    }
                        }
                            
                            ?>
                            </ul>
                        </li>
                    </ul>
                </div>
                </div><!-- outer -->
                <?php
            endwhile;
            echo '</div>';
        endif;
    }




/**
 * get the location and dates repeater
 * @param type $id
 * @return array repeater field
 */
function get_schwulissimo_veranst_meta_short($id){
    
        return get_field('field_5819ccf689193', $id);
   
}





/**
 * add the detail info box after descritption
 */
function schwulissimo_verastaltung_add_metaboxes(){
    
        $veranstaltungsorte = get_schwulissimo_veranst_meta_short(get_the_ID());
        if(is_array($veranstaltungsorte)):
        foreach($veranstaltungsorte as $ort){
            ?>
        <div class="veranst-metabox clearfix">
            <div class="col-sm-4 hidden-xs">
                
                <?php 
                    $veranstalter = $ort['veranstaltungsort'][0];
                    $link = get_the_permalink($veranstalter);
                        echo '<a href="' . $link . '">';
                    if(has_post_thumbnail($veranstalter)){
                echo get_the_post_thumbnail($veranstalter, 'thumbnail');
                    }else{
                $lat = get_field('field_581702c7588d1', $veranstalter)['lat'];
                $lng = get_field('field_581702c7588d1', $veranstalter)['lng'];
                 ?>
            <img  src="http://maps.google.com/maps/api/staticmap?center=<?php echo $lat . ',' . $lng ?>&amp;zoom=16&amp;size=150x150&amp;&key=AIzaSyCJQi7ySNFDknUkgC0yBD1DVIkbBoi3dBg&markers=size:mid%7Ccolor:red%7Clabel:S%7C<?php echo $lat . ',' . $lng ?>">
                    <?php } ?>
            </a>
            </div>
             <div class="col-xs-6 col-sm-4">
                 
                <h4>Veranstalter</h4>
                <p><a href="<?php echo $link ?>" class="cityguide-link"><?php echo get_the_title($veranstalter); ?></a><br>
                    <a class="more-link" href="<?php echo get_the_title($veranstalter); ?>">mehr...</a>
                </p>
                    <p><?php echo get_field('field_581702c7588d1', $veranstalter)['address'] ?></p>
                
            </div> 
            <div class="col-xs-6 col-sm-4">
                <h4>Termine</h4>
                <ul class="list-unstyled">
                    <?php 
                    foreach($ort['termine'] as $termin){
                            if(strtotime($termin['datum']) >= time()){
                                echo '<li>' . $termin['datum'] . ' um: ' . $termin['stunde'] . ':' . $termin['minute'] . '</li>';
                            }
                    }    
                    ?>
                    </ul>
                </div>
            <div class="col-xs-12">
                <?php 
                $affi = $ort['schwulissimo_veranst_affiliate_link'];
                if( $affi != ''):?>

                <div class="spacer"></div>
                <a class="btn-primary" href="<?php echo $affi ?>">Jetzt Tickets kaufen</a>
                
                <?php endif;?>
                </div>
            
        </div>
            <?php 
        }
        endif;//is_array
    
}
function schwulissimo_buy_tips_teaser(){
    
    schwulissimo_section_headline('MEHR UNTERHALTUNG');
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'orderby' => 'rand',
        'meta_query' => array(array('key' => '_thumbnail_id')),
        'tax_query' => array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => array( 'buecher', 'dvdblue-ray', 'erotik', 'kino', 'konzerte', 'musik' ),
		),
            )
    );
        $query = new WP_Query($args);
            if($query->have_posts()):
                echo '<div class="row">';
                while ($query->have_posts()):
                $query->the_post();
                if(!has_post_thumbnail()) continue;
                ?>
                <div class="col-xs-4 teaser-thumnail">
                    <a href="<?php echo get_the_permalink()?>"><?php the_post_thumbnail('large')?></a>   
                </div>
                <?php 
                endwhile;
                echo '</div>';
            endif;
    
}

/**
 * output the section headline with spacer
 * 
 * @param string $text  the headline text
 */
function schwulissimo_section_headline($text){
    ?>
<h3 style="display:table; overflow:hidden;"><span style="display:table-cell; white-space: nowrap;"><div class="grey-spacer"></div><div style="display:inline;"><?php echo $text ?></div></span>
    <span  style="display: table-cell; width: 100%; position: relative;"><div style="position:absolute;width: 100%; height: 100%; margin-left: 20px;" class="grey-bottom-line"></div></span></h3>
    <?php    
}