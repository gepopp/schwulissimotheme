<?php
  
    add_action('wp_ajax_nopriv_load_adress_data', 'load_adress_data');
    add_action('wp_ajax_load_adress_data', 'load_adress_data');
    function load_adress_data(){
        
        $id = $_POST['data'];
        
        $addressarr = get_field('field_581702c7588d1', $id);
            if(is_array($addressarr)){
                echo json_encode($addressarr);
                die();
            }else{
                echo '';
                die();
            }
        
    };
    add_action('wp_ajax_get_map_infobox', 'get_map_infobox');
    add_action('wp_ajax_nopriv_get_map_infobox', 'get_map_infobox');
    function get_map_infobox(){
        
        $id = $_POST['data'];
        
                $cityguide_logo = get_field('field_583199e7aaf58', $id);
                $cityguide_logo_url = $cityguide_logo['sizes']['schwuliisimo-slider-small'];
                $address = get_field('cityguide_adresse', $id);
                
                $string = '<h5>'. get_the_title($id) . '</h5>'
                    . '<p>' . $address['address'] . '</p>';
                
                if($cityguide_logo_url != ''){
                    $string .= '<img src="' . $cityguide_logo_url .  '" width="200" height="100" alt="logo" />';
                }
                $string .= '<p><a href="' . get_the_permalink($id) . '">mehr...</a>';
                echo $string;
            die();
        
    };
    add_action('wp_ajax_search_cityguide_where', 'search_cityguide_where');
    add_action('wp_ajax_nopriv_search_cityguide_where', 'search_cityguide_where');
    function search_cityguide_where(){
        
        $sql  = 'SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key = "cityguide_adresse"';
        global $wpdb;
        $res = $wpdb->get_results($sql);

        if(is_array($res)):
        foreach($res as $r){
              $arr =  maybe_unserialize($r->meta_value);
              $arr1 = explode(',', $arr['address']);
              $where[] = trim($arr1[1]);
        }
        endif;
            echo json_encode(array_unique($where));
        die();
    }
    add_action('wp_ajax_search_cityguide_what', 'search_cityguide_what');
    add_action('wp_ajax_nopriv_search_cityguide_what', 'search_cityguide_what');
    function search_cityguide_what(){
       $sql  = 'SELECT post_title, ID FROM `wp_posts` LEFT JOIN wp_postmeta '
           . 'ON wp_posts.ID = wp_postmeta.post_id '
           . 'WHERE wp_posts.post_title LIKE "%'.$_GET['term'].'%" '
           . 'AND wp_posts.post_type = "post_citygiude" AND wp_postmeta.meta_key = "cityguide_adresse" '
           . 'AND wp_postmeta.meta_value LIKE "%'.$_GET['ort'].'%" LIMIT 50';
       
        global $wpdb;
        $res = $wpdb->get_results($sql);
        if(is_array($res)):
        foreach($res as $r){
              $what[] = array('label' => $r->post_title, 'value' => $r->ID);
        }
        endif;
      
        echo json_encode($what);
        die();
    }
    
    
    
    
    
    add_action('wp_ajax_get_tax_bounces', 'get_tax_bounces');
    add_action('wp_ajax_nopriv_get_tax_bounces', 'get_tax_bounces');
    function get_tax_bounces(){
        
            $term = str_replace('term_', '', $_POST['data']);
        $args = array(
            
            'post_type' => 'post_citygiude',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'tax_query' => array(
		array(
			'taxonomy' => 'cityguide_category',
			'field'    => 'term_id',
                        'terms'    =>  array($term),
		),
            ),
            'fields' => 'ids'
        );
        $query = new WP_Query($args);
        echo json_encode($query->posts);
        die();
        
        
    }
    
    
    
    
    
    
    
    