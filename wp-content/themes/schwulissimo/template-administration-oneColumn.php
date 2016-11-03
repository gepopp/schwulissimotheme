<?php
 
    /*
     * Template Name: Administration One Column
     */
    
    acf_form_head();
    get_header('administration');
    
    if(have_posts()):while (have_posts()): the_post();
    
    ?>
    
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
           <?php the_content(); ?>
        </div>
    </div>
</div>
<script>
(function($) {
        
        $(document).ready(function(){
            
            $('.acf-field-5806a38b70ecd .acf-input').append( $('#postdivrich') );
            
        });
        
    })(jQuery);    
    </script>
    <style type="text/css">
        .acf-field #wp-content-editor-tools {
            background: transparent;
            padding-top: 0;
        }
    </style>
    <?php 
    
    endwhile;endif;
    
    get_footer();