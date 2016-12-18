<?php 
 get_header(); 
 $where = $_POST['partypics-where'] != '' ? $_POST['partypics-where'] : $_GET['where'];
 $what = $_POST['partypics-what'] != '' ? $_POST['partypics-what'] : $_GET['what'];
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
            <?php schwulissimo_partypics_archive_slider() ?>
    </div>
</div><!-- end slider -->
    <?php schwulissimo_partypics_archive_searchbar($where, $what); ?>
<!-- start two column layout -->
<div class="row">
    <div class="col-sm-8">
        <!-- loop -->
        <?php 
            
            $paged = ( get_query_var('paged') ) ? absint(get_query_var('paged')) : 1;
            if (isset($_POST['search-submit']) && $_POST['search-submit'] == 'suchen') {
                $paged = 1;
            }
            
            $args = array(
                'post_type'         => 'post_partypics',
                'posts_per_page'    => 5,
                'paged'             => $paged
                
            );
            
                $terms = array((int) $where);
                
                if(!empty($where) && $where != 'a'){
                    $args['tax_query'] = array(
                        'relation' => 'AND',
                        array(
                        'taxonomy' => 'post_region',
			'field'    => 'term_id',
			'terms'    =>  $terms,
                        'operator' => 'IN',    
                        )
                    );
                }
                    if(!empty($what)){
                        $args['s'] = $what;
                    }
                $query = new WP_Query($args);
            
                if($query->have_posts()):
                    while ($query->have_posts()):
                    $query->the_post();
                
                        schwulissimo_partypics_archive_metabox();
                
                
                    endwhile;
                endif;
            
            ?>
            <div class="col-xs-12 partipics-pagination">
                <?php
                    $big = 999999999; // need an unlikely integer

                    echo paginate_links(array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '?paged=%#%',
                        'current' => max(1, get_query_var('paged')),
                        'total' => $query->max_num_pages,
                        'add_args' => array('where' => $where, 'what' => $what, 'whatid' => $whatid)
                    ));
                ?>
            </div>
    </div>
    <div class="col-sm-4 hidden-xs">
        
      <?php   get_sidebar(); ?>
        
    </div>
</div>
<!-- end two column layout -->



<?php get_footer()?>

 