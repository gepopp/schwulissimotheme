<?php
  function schwulissimo_category_archive_slider(){
        
      global $cat;
        
        ob_start();
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 5,
            'post_status' => 'publish',
            'cat' => $cat
        );
            $query = new WP_Query($args);
        ?>
                  

            
                    <div class="eagle-gallery img500" style="margin-top: 20px">
                        <div class="owl-carousel">
                            <?php if($query->have_posts()): while ($query->have_posts()): $query->the_post(); ?>
                            
                          <img src="<?php the_post_thumbnail_url('schwuliisimo-slider-small')?>"
                               data-type="category-archive"
                               data-link="<?php echo get_the_permalink() ?>" 
                               data-medium-img="<?php the_post_thumbnail_url('schwuliisimo-slider-large')?>" 
                               data-big-img="<?php the_post_thumbnail_url('full')?>" 
                               data-title="<?php echo get_the_title()?>" alt="">  
                            <?php endwhile;endif;?>
                        </div>
                    </div>
            <?php wp_reset_postdata()?>

            <script>
                    
                    jQuery(document).ready(function($){
                        $(".eagle-gallery").eagleGallery({
                            miniSliderArrowPos: 'inside',
                            miniSliderArrowStyle: 2,
                            changeMediumSpeed: 600,
                            changeMediumStyle: false,
                            autoPlayMediumImg: true,
                            miniSlider: {
                                navigation: true,
                                pagination: false,
                                navigationText: false,
                                rewindNav: false	,
                                theme: 'mini-slider',
                                responsiveBaseWidth: '.eagle-gallery',
                                itemsCustom: [[0, 1],[250, 2], [450, 3], [650, 5], [850, 5], [1050, 5], [1250, 3], [1450, 4]],
                                margin: 10
                            },
                        });
                    });
                    
                    </script>
       
    <?php
        echo ob_get_clean();
        
        
    }