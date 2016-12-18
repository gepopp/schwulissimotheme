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
    
    function schwulissimo_versnt_archive_searchbar($searchterm, $region, $when) {
        
            
        
        ?>
                    <div class="row cityguide-searchbar" style="background-color: #373737">
                                <form class="form-inline" action="<?php echo get_post_type_archive_link('schwulissimo_veranst') ?>" method="post">
                                    <div class="col-sm-3">
                                        <div class="form-group" id="veranst-where-container">
                                            <label for="veranst-where">Wo:</label>
                                            <select class="form-control" name="veranst-where">
                                                <option value="all" <?php selected($region, 'all', true) ?> >Alle Regionen</option>
                                                <?php
                                                        $terms = get_terms('post_region', array('hide_empty' => true));
                                                        foreach($terms as $term){
                                                            echo '<option value="' . $term->term_id . '"  '. selected((int)$region, $term->term_id) .' >' . $term->name . '</option>';
                                                        }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group" id="veranst-what-container">
                                            <label for="veranst-when">Wann:</label>
                                            <input type="text" class="form-control" id="veranst-when" name="veranst-when" placeholder="Zeitraum" value="<?php echo $when ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group" id="varanst-what-container">
                                            <label for="veranst-what">Was:</label>
                                            <input type="text" class="form-control" id="veranst-what" name="veranst-what" placeholder="Stichwort" value="<?php echo $searchterm ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="submit" class="btn btn-default" name="search-submit" class="form-control" value="suchen">
                                    </div>
                                </form>
                            </div>           
                       
        <?php
    }
    
    function schwulissimo_veranst_get_date_id($when = false){
        
        
        $termine = false;
        $veranst = get_schwulissimo_veranst_meta_short(get_the_ID());
        $addTime = strtotime('now');
        $endTime = 999999999999;
       
        
        if($when){
        
            $dates = preg_split("/ - /", $when);
            $addTime =  strtotime($dates[0]);
            $endTime =  strtotime($dates[1]) + ( 23 * 60 * 60 ) + ( 59 * 60 );
        }
       
        $data = false;
        
        if(is_array($veranst)){
                foreach($veranst as $dl){
                        foreach($dl['termine'] as $t){
                                $time = strtotime($t['datum'] . ' ' . $t['stunde'] . ':' . $t['minute']);
                               
                            if( $time >= $addTime  && $time <= $endTime ){
                                
                                $data['date'] = date('d.m.', $time);
                                $data['time'] = $t['stunde'] . ':' . $t['minute'];
                                $data['id'] = $dl['veranstaltungsort'][0];
                                break 2;
                            }
                        }
                    }
        }elseif(get_field('event_date') != ''){
                $data['date'] = date('d.m.', strtotime(get_field('event_date')));
        }
        return $data;
    }