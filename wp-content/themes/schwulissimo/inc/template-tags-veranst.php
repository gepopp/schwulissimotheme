<?php
 
    function schwulissimo_veranst_archive_slider(){
        
        
        ob_start();
        $date = date('Ymd');
        $args = array(
            'post_type' => 'schwulissimo_veranst',
            'post_status' => 'publish',
            'meta_query'  => array(
                'relation' => 'AND',
                array(
                    'key' => 'schwulissimo_veranst_promoted',
                    'value' => 1,
                    'operator' => '='
                ),
                array(
                    'key' => 'schwulissimo_veranst_ort_und_termin_%_termine_%_datum',
                    'value' => $date,
                    'compare' => '>=',
                ),
            )
        );
            $query = new WP_Query($args);
            
            ?>
            

            
                    <div class="eagle-gallery img500" style="margin-top: 20px">
                        <div class="owl-carousel">
                            <?php if($query->have_posts()): while ($query->have_posts()): $query->the_post(); 
                            $dates_location = get_field('schwulissimo_veranst_ort_und_termin');
                            foreach($dates_location as $dl){
                               $dle = $dl;
                                foreach($dl['termine'] as $t){
                                        $time = strtotime($t['datum'] . ' ' . $t['stunde'] . ':' . $t['minute']);
                                    if( $time >= time() ){
                                        $data['date'] = date('d.m.', $time);
                                        $data['address'] = get_field('cityguide_adresse', $dl['veranstaltungsort'][0])['address'];
                                        $data['time'] = $t['stunde'] . ':' . $t['minute'];
                                        $data['location'] = get_the_title($dl['veranstaltungsort'][0]);
                                        break;
                                    }
                                }
                            }
                            $data['title'] = get_the_title();
                            $json = json_encode($data);
                            
                            
                            ?>
                            
                          <img src="<?php the_post_thumbnail_url('schwuliisimo-slider-small')?>"
                               data-type="veranst-archive"
                               data-veranst="<?php echo htmlentities($json, ENT_QUOTES, 'UTF-8'); ?>" 
                               data-link="<?php echo get_the_permalink() ?>" 
                               data-medium-img="<?php the_post_thumbnail_url('schwuliisimo-slider-large')?>" 
                               data-big-img="<?php the_post_thumbnail_url('full')?>" 
                               data-title="<?php echo get_the_title()?>" alt="">  
                            <?php endwhile;endif;?>
                        </div>
                    </div>
            <?php //echo var_dump($dle)?>

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
        wp_reset_postdata();
        
        echo ob_get_clean();
        
        
    }
    
    function schwulissimo_versnt_archive_searchbar(){
        
        ?>
        <div class="col-xs-12">
                        
        </div>            
        <?php 
    }