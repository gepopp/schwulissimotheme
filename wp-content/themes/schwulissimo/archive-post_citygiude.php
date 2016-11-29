<?php
    /* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    get_header();
    
    $what = $_POST['cityguide-what'] != '' ? $_POST['cityguide-what'] : $_GET['what'] ;
    $where = $_POST['cityguide-where'] != '' ? $_POST['cityguide-where'] : $_GET['where'];
    $whatid = $_POST['cityguide-what-id'] != '' ? $_POST['cityguide-what-id'] : $_GET['whatid'];
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
<div class="row cityguide-searchbar">
    <form class="form-inline" action="<?php echo get_post_type_archive_link('post_citygiude')?>" method="post">
             <div class="col-sm-5">
             <div class="form-group" id="cityguide-where-container">
                 <label for="cityguide-where">Wo:</label>
                 <input type="text" class="form-control" id="cityguide-where" name="cityguide-where" placeholder="Postleitzahl oder Ort" value="<?php echo $where ?>" >
             </div>
             </div><div class="col-sm-5">
             <div class="form-group" id="cityguide-what-container">
                 <label for="cityguide-what">Was:</label>
                 <input type="text" class="form-control" id="cityguide-what" name="cityguide-what" placeholder="Ketegorie oder Stichwort" value="<?php echo $what ?>">
                 <input type="hidden" class="form-control" id="cityguide-what-id" name="cityguide-what-id" value="<?php echo $whatid ?>">
             </div>
              </div><div class="col-sm-2">
                  <input type="submit" class="btn btn-default" name="search-submit" class="form-control" value="suchen">
              </div>
    </form>
 </div>



 <div class="row">
     <div class="col-xs-12">
         <div id="cityguide-archive-map" style="width: 100%; margin-top: 20px;"></div>
     </div>
 </div>
<div class="row">
    <div class="col-sm-8 col-xs-12" id="cityguide-col">
    <?php 
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        if(isset($_POST['search-submit']) && $_POST['search-submit'] == 'suchen'){
            $paged = 1;
        }
        
        $args = array(
        'post_type' => 'post_citygiude',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        'paged' => $paged,
        );
        if(isset($where) && $where != ''){
            $args['meta_query'] = array(
                'relation' => 'AND',
                array(
                'key' => 'cityguide_adresse',
                'value' => $where,
                'compare' => 'LIKE'
               )
            );
        }
        if(isset($what) && $what != ''){
            
                if(strpos($_POST['cityguide-what'], 'Kategorie:') === false){
                   
                    $args['s'] = $what;
                }else{
                    $value = explode(': ', $what);
                    
                    $terms = get_terms('cityguide_category', array('name__like' => htmlspecialchars($value[1] )));
                   
                        if(is_array($terms)):
                            foreach($terms as $t){
                            $tid[] = $t->term_id;
                            }
                    $args['tax_query'] = array(
                                            'relation' => 'AND',
                                            array(
                                                'taxonomy' => 'cityguide_category',
                                                'field'    => 'term_id',
                                                'terms'    => $tid,
                                                'operator' => 'IN'
                                                ),
                                            );
                        endif;
                }
        }
        
        
    $query = new WP_Query($args);
    ?>
    <?php 
            if($query->have_posts()):
        while($query->have_posts()):?>
        <?php $query->the_post()?>
    <div class="col-xs-12 cityguides-container">
        <div class="col-sm-4 col-xs-4">
        <?php 
            $image = get_field('cityguide_logo');
                if(is_array($image)){
                        echo '<a href="' . get_the_permalink() . '"><img src="' . $image['sizes']['schwuliisimo-slider-small'] . '" width="' . $image['sizes']['schwuliisimo-slider-small-width'] . '" height="' . $image['sizes']['schwuliisimo-slider-small-height'] .'" /></a>';
                }else{
                    echo '<img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=Kein+Logo&w=201&h=101" />';
                }
            ?>
        </div>
        <div class="col-sm-4 col-xs-8">
            <h3><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
            <address>
                <?php 
                    $address = get_field('cityguide_adresse');
                        if(is_array($address)){
                            echo $address['address'];
                        }
                ?>
            </address>
        </div>
        <div class="col-sm-4 hidden-xs">
            <?php the_tags('<h6>Schlagw&ouml;rter:</h6>', ', ')?>
            <?php echo the_terms( get_the_ID(), 'cityguide_category', '<h6>Kategorien:</h6>', ', ' ); ?> 
        </div>
        <?php if(get_field('cityguide_status') == 3 ):?>
        <div class="premium-link"><a href="<?php the_permalink()?>">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a></div>
        <div class="premium-overlay">
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
        </div>
        <?php endif;?>
        
  
    </div>
    
    <?php endwhile; endif;?>
        
        <?php 
      
        //wp_pagenavi(array( 'query' => $query ));
        

       
          
        

          $big = 999999999; // need an unlikely integer

    echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $query->max_num_pages,
        'add_args' => array('where' => $where, 'what' => $what, 'whatid' => $whatid)
        ));
        ?>
    </div><!-- container guides -->
    <div class="col-sm-4 hidden-xs">
        <?php get_sidebar();?>
    </div>
</div><!-- row container guides -->


    
    
    
    
    <?php 
    get_footer();

