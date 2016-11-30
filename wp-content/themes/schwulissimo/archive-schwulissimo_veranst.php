<?php  get_header(); ?>
 

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

        
    </div>
</div>
    
   
    
    
    
    
    <?php get_footer(); 

