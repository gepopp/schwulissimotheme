<?php get_header(); ?>

<?php 
    $searchterm     = isset($_POST['veranst-what']) ? $_POST['veranst-what'] : $_GET['what'];
    $region         = isset($_POST['veranst-where']) ? $_POST['veranst-where'] : $_GET['where'];
    $when           = isset($_POST['veranst-when']) ? $_POST['veranst-when'] : $_GET['when'];
    ?>

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
<div class="row">
    <div class="col-md-12">
        <?php schwulissimo_veranst_archive_slider() ?>
        <?php schwulissimo_versnt_archive_searchbar($searchterm, $region, $when) ?>
    </div>
    

    <?php 
        
        if($when != ''){
            $dates = preg_split("/ - /", $when);
            $start = date('Ymd', strtotime($dates[0]));
            $end = date('Ymd', strtotime($dates[1]));
            $date = array((int)$start, (int)$end);
            $compare = 'BETWEEN';
        }
        
        $paged = ( get_query_var('paged') ) ? absint(get_query_var('paged')) : 1;
            if (isset($_POST['search-submit']) && $_POST['search-submit'] == 'suchen') {
                $paged = 1;
            }
        
        $args = array(
            'post_type'     =>  'schwulissimo_veranst',
            'post_status'   =>  'publish',
            'posts_per_page' => 10,
            'paged' => $paged,
            'meta_query'    =>  array(
                    'relation' =>   'AND',
                    array(
                        'key' => 'schwulissimo_veranst_ort_und_termin_%_termine_%_datum', 
                        'value' => $date, 
                        'compare' => $compare
                    ),
                )
            );
                if(isset($searchterm) && $searchterm != ''){
                    $args['s'] = $searchterm;
                }
                if(isset($region) && $region != 'all'){
                    $args['tax_query'] = array(
                        'relation' => 'AND',
                        array(
                        'taxonomy' => 'post_region',
			'field'    => 'term_id',
			'terms'    => (int)$region,
                        )
                    );
                }
            $query = new WP_Query($args);
        ?>
    <div class="col-sm-8">
        <?php if($query->have_posts()): while($query->have_posts()): ?>
                <?php 
                    $query->the_post();
                    $data = schwulissimo_veranst_get_date_id($when);
                ?>
                <div class="row">
                    <div class="col-xs-12 post-preview veranst-preview">
                        <div style="background-color: #373737">
                            <div class="col-sm-6" style="padding:0;">
                                <?php if (has_post_thumbnail()) { ?>
                                    <a href="<?php echo get_the_permalink() ?>"><?php the_post_thumbnail('schwuliisimo-ticket-small', array('class' => 'pull-left', 'style' => 'padding:0;')) ?></a>   
                                <?php } else { ?>
                                    <a href="<?php echo get_the_permalink() ?>"><img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=kein_Bild&w=315&h=195" alt="schwulissimo default image" width="207" height="153" class="img-responsive pull-left" /></a>
                                <?php } ?>
                                <div class="veranst-archive-headline-title" style=""><h5><?php echo get_the_term_list(get_the_ID(), 'veranstaltung_category', $before, ', ', $after) ?></h5></div>
                                <div class="veranst-archive-headline-date" style="position:absolute;"><?php echo $data['date'] ?></div> 
                            </div><!-- image and overlay -->

                            <div class="col-sm-6 veranst-archive-infobox">
                                <ul class="list-unstyled" style="margin: 0;">
                                    <li><a href="<?php the_permalink() ?>"><h3 style="color:white; padding-top: 15px;"><?php echo get_the_title() ?></h3></a></li>
                                    <li>
                                        <span class="glyphicon glyphicon-map-marker"></span>
                                        <?php
                                                                                      
                                        if (!$data['id']) {
                                            echo get_field('field_5825ca617c42e');
                                            echo ' ';
                                            echo get_field('field_5825d5393de3b');
                                        } else {
                                            echo '<a href="' . get_the_permalink($data['id']) . '">' . get_the_title($data['id']) . '</a>';
                                        }
                                        ?>
                                    </li>
                                            <?php
                                            if ($data['date']) {
                                                
                                              
                                                    echo '<li><span class="glyphicon glyphicon-calendar"></span> ' . $data['date'] . '</li>';
                                                    echo '<li><span class="glyphicon glyphicon-time"></span> ' . $data['time'] . '</li>';
                                                
                                            } else {
                                                $datetime = get_field('field_58108892ea5c7');
                                                $datearr = explode(' ', $datetime);
                                                if (is_array($datearr)) {
                                                    echo '<li><span class="glyphicon glyphicon-calendar"></span> ' . $datearr[0] . '</li>';
                                                    echo '<li><span class="glyphicon glyphicon-time"></span> ' . $datearr[1] . '</li>';
                                                }
                                            }
                                            ?>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div>        
                    </div>
                </div><!-- outer -->
            <?php endwhile; endif;?>

        <?php
            global $wp_query;

            $big = 999999999; // need an unlikely integer

            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $query->max_num_pages,
                'add_args' => array('s' => $searchterm, 'what' => $what, 'when' => $when)
            ));
        ?>
    </div><!-- main content col  8 -->
    <div class="col-sm-4 hidden-xs">
        <?php get_sidebar() ?>
    </div>
</div><!-- main content row -->

<?php get_footer();

    