<?php get_header(); ?>
    <?php 
        global $cat; 
            $name  = single_cat_title('', false);
            $cat = get_cat_ID($name);
            
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
<?php schwulissimo_category_archive_slider()?>

<?php
    
     $args = array(
            'post_type' => 'post',
            'posts_per_page' => 1,
            'post_status' => 'publish',
            'offset' => 5,
            'cat' => $cat
        );
            $query = new WP_Query($args);
                    if($query->have_posts()): while ($query->have_posts()): $query->the_post();
        ?>
<div class="row" style="margin-top:30px;">
    <div class="col-sm-6">
        <div  class="preview-image-large-holder">
            <a href="<?php the_permalink()?>">
                <?php the_post_thumbnail('schwuliisimo-subpage-small')?>
                <div class="caption"><?php the_title()?></div>
            </a>
        </div>
    </div>
    <div class="col-sm-6">
        <ul class="list-unstyled">
    <?php 
      endwhile; endif;
      wp_reset_postdata();
     $args = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'post_status' => 'publish',
            'offset' => 6,
            'cat' => $cat
        );
            $query = new WP_Query($args);
                    if($query->have_posts()): while ($query->have_posts()): $query->the_post();
        ?>
            <li>
                <a href="<?php the_permalink()?>"><?php the_post_thumbnail('schwuliisimo-detail-cols', array( 'style' => 'float:left; padding: 0 15px 30px 0'))?></a>
                <h5 class="category-archive-sider"><a href="<?php the_permalink()?>"><?php the_title()?></a></h5><p style="font-size: .75em;"><?php echo get_the_excerpt()?></p>
                <div class="clearfix"></div>
            </li>
            <?php endwhile;endif;?>
        </ul>
    </div>
</div>
    
<?php do_action('add_category_one')?>


<div class="row" style="margin-top:30px;">
<div class="col-sm-6">
        <ul class="list-unstyled">
    <?php 
     
     $args = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'post_status' => 'publish',
            'offset' => 10,
            'cat' => $cat
        );
            $query = new WP_Query($args);
                    if($query->have_posts()): while ($query->have_posts()): $query->the_post();
        ?>
            <li>
                <a href="<?php the_permalink()?>"><?php the_post_thumbnail('schwuliisimo-detail-cols', array( 'style' => 'float:left; padding: 0 15px 30px 0'))?></a>
                <h5 class="category-archive-sider"><a href="<?php the_permalink()?>"><?php the_title()?></a></h5><p style="font-size: .75em;"><?php echo get_the_excerpt()?></p>
                <div class="clearfix"></div>
            </li>
            <?php endwhile;endif;?>
        </ul>
    </div>
    <?php
    
     $args = array(
            'post_type' => 'post',
            'posts_per_page' => 1,
            'post_status' => 'publish',
            'offset' => 9,
            'cat' => $cat
        );
            $query = new WP_Query($args);
                    
        ?>

    <div class="col-sm-6">
        <?php if($query->have_posts()): while ($query->have_posts()): $query->the_post(); ?>
        <div  class="preview-image-large-holder">
            <a href="<?php the_permalink()?>">
                <?php the_post_thumbnail('schwuliisimo-subpage-small')?>
                <div class="caption"><?php the_title()?></div>
            </a>
        </div>
        <?php  endwhile; endif;  wp_reset_postdata(); ?>
    </div>
 </div>  
   
<?php do_action('add_category_one')?>

<?php schwulissimo_section_headline('&auml;ltere beitr&auml;ge')?>

    <?php 
        
        $paged = ( get_query_var('paged') ) ? absint(get_query_var('paged')) : 1;
           
        
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 20,
            'post_status' => 'publish',
            'offset' => 9 + 20 * ($paged -1),
            'cat' => $cat,
            'paged' => $paged,
        );
            $query = new WP_Query($args);
                if($query->have_posts()):
        ?>
<div class="row">
   
    <div class="col-sm-6">
        
        <ul class="list-unstyled">
        <?php $runner=1; while($query->have_posts()): $query->the_post();?>
            <li><h5 class="category-archive-list"><?php the_time('d.m.Y')?> <span class="red"><?php the_title() ?></span></h5></li>
            <?php if($runner == 10):?>
        </ul></div>
    <ul class="list-unstyled">
            <div class="col-sm-6">
                <?php endif;?>

            <?php $runner++;?>
        <?php endwhile;?>
        </ul>     
    </div>
         <div class="col-xs-12">
        <?php wp_pagenavi()?>
    </div>
</div>

<?php 
    endif;
    get_footer();
