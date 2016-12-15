<?php get_header() ?>

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
    <?php schwulissimo_partypics_archive_searchbar(); ?>
<!-- start two column layout -->
<div class="row">
    <div class="col-sm-8">
        <!-- loop -->
        <?php 
                if(have_posts()):
                    while (have_posts()):
                    the_post();
                
                        schwulissimo_partypics_archive_metabox();
                
                
                    endwhile;
                endif;
            
            ?>

    </div>
    <div class="col-sm-4 hidden-xs"></div>
</div>
<!-- end two column layout -->



<?php get_footer()?>

 