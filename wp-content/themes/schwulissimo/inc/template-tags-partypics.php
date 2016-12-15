<?php
  function schwulissimo_partypics_archive_slider(){
        
        ob_start();
        $date = date('Ymd');
        $args = array(
            'post_type' => 'post_partypics',
            'post_status' => 'publish',
            'posts_per_page' => 5
            
        );
            $query = new WP_Query($args);
            ?>
                    <div class="eagle-gallery img500" style="margin-top: 20px">
                        <div class="owl-carousel">
                            <?php if($query->have_posts()): while ($query->have_posts()): $query->the_post(); ?>
                            <?php 
                                    $gallery = get_field('field_58069b05d9441');
                                    $img =  $gallery[0];
                                   
                                ?>
                                <img src="<?php echo $img['sizes']['schwuliisimo-slider-small']?>"
                                 data-type="category-archive"
                                 data-link="<?php echo get_the_permalink() ?>" 
                                 data-medium-img="<?php echo $img['sizes']['schwuliisimo-slider-large']?>" 
                                 data-big-img="<?php echo $img['sizes']['full']?>" 
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
        wp_reset_postdata();
        echo ob_get_clean();
    }
    
  function schwulissimo_partypics_archive_metabox(){
    ?>  
                    <div class="partypics-archive-metabox">
                        <div class="col-xs-12 title-bar">
                            <span class="title-bar-date red"><?php the_time('d.m.Y') ?></span>
                            <h6><a class="partypics-archive-metabox-title" href="<?php get_the_permalink()?>"><?php the_title() ?></a></h6>
                            <?php if (function_exists('pvc_get_post_views')):?>
                            <span class="pull-right hidden-xs red"><span class="glyphicon glyphicon-eye-open"></span>
                                    <span class="view-count"><?php echo pvc_get_post_views(get_the_ID())?></span>
                                </span>
                            <?php else:?>
                                <?php echo 'pleas install <a href="https://wordpress.org/plugins/post-views-counter/">post view counter plugin</a>'?>
                            <?php endif;?>
                        </div><!-- END Title Bar -->
                        <?php 
                            $galery = get_field('field_58069b05d9441');
                        ?>
                           <?php if(has_post_thumbnail()):
                               $image = get_the_post_thumbnail_url(null, 'schwuliisimo-story-index');
                               $counter = 0;
                           else:
                                $image = $galery[0]['sizes']['large'];
                                $counter = 1;
                            endif;?>
                            <div class="col-xs-12 image-holder" >
                            
                                <div class="main-image" style="background-image: url('<?php echo $image ?>')"></div> 
                                <div class="side-images">
                                    
                                    <img src="<?php echo $galery[$counter]['sizes']['schwuliisimo-detail-cols'] ?>" />
                                    <img src="<?php echo $galery[++$counter]['sizes']['schwuliisimo-detail-cols'] ?>" />
                                    <div class="image-count-overlay"><span>+ <?php echo count($galery) ?></span></div>
                                
                                </div>
                            </div>
                        
                        <div class="col-xs-12 footer-bar">
                            <?php 
                                $place = get_field('field_584ea0519c356');
                                    if(!empty($place)){
                                        $place = '<a class="white" href="' . get_the_permalink($place[0]) . '">' . get_the_title($place[0]) . '</a>';
                                    }else{
                                        $place = get_field('field_585181af894f6');
                                            if(!empty($place)){
                                                $place = $place['address'];
                                            }
                                    }
                                        if(empty($place)){
                                            $place = 'Keine Ortsangabe';
                                        }    
                                ?>

                            <div class="col-sm-3 red"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $place ?></div>
                            
                            <?php $author = new BP_Core_User( get_the_author_meta('ID') ); ?>                     
                            <div class="col-sm-3 red"><span class="glyphicon glyphicon-camera"></span> <a href="<?php echo $author->user_url ?>" class="white" ><?php echo $author->profile_data['Name']['field_data']?></a></div>
                            <div class="col-sm-6 red">
                                <ul class="list-unstyled list-inline pull-right">
                                    <li>
                                         <a href="https://twitter.com/home?status=<?php the_permalink() ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/img/twitter.svg' ?>" width="15" height="15" />
                                         </a>
                                         </li>
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/img/facebook.svg' ?>" width="15" height="15" />
                                        </a>
                                        </li>
                                    <li>
                                        <a href="https://plus.google.com/share?url=<?php the_permalink() ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/img/g+.svg' ?>" width="15" height="15" />
                                        </a>
                                        </li>
                                    <li>
                                        <a href="mailto:?subject=Schwulissimo Galerie&body=<?php the_permalink() ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/img/e-mail.svg' ?>" width="15" height="15" />
                                        </a>
                                        </li>
                                        <?php if(wp_is_mobile()):?>
                                        <li>
                                        <a href="whatsapp://send?text=<?php the_permalink() ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/img/whatsapp.svg' ?>" width="15" height="15" />
                                        </a>
                                        </li>
                                        
                                        <?php endif;?>


                                </ul>
                            </div>
                        </div><!-- END Title Bar -->
                        
                    </div><!-- END Metabox -->  
    
      
    <?php 
  }
  
  function schwulissimo_partypics_archive_searchbar(){
      ?>
        <div class="col-xs-12 partypics-searchbar">
            <form class="form-inline" action="<?php echo get_post_type_archive_link('post_citygiude') ?>" method="post">
                <div class="col-sm-5">
                    <div class="form-group" id="partypics-where-container">
                        <label for="partypics-where">Wo:</label>
                        <input type="text" class="form-control" id="partypics-where" name="partypics-where" placeholder="Region" value="<?php echo $where ?>" >
                    </div>
                </div><div class="col-sm-5">
                    <div class="form-group" id="partypics-what-container">
                        <label for="partypics-what">Was:</label>
                        <input type="text" class="form-control" id="partypics-what" name="partypics-what" placeholder="Stichwort" value="<?php echo $what ?>">
                        <input type="hidden" class="form-control" id="partypics-what-id" name="partypics-what-id" value="<?php echo $whatid ?>">
                    </div>
                </div><div class="col-sm-2">
                    <input type="submit" class="btn btn-default" name="search-submit" class="form-control" value="suchen">
                </div>
            </form>
        </div>
      <?php 
  }