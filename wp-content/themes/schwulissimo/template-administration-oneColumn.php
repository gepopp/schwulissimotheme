<?php
 
    /*
     * Template Name: Administration One Column
     */
    
    
    get_header('administration');
    
    if(have_posts()):while (have_posts()): the_post();
    
    ?>
    
<div class="container">
    <div class="row">
        <div class="col-xs-12">
           <?php the_content(); ?>
        </div>
    </div>
</div>

    <?php 
    
    endwhile;endif;
    
    get_footer();