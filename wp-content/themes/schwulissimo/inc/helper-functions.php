<?php
    /**
     * Delete all Files in tmp folder
     */
 function emptyTmp(){
     
         foreach(glob( get_stylesheet_directory() ) . '/inc/tmp/*' as $file){
             
                 if (file_exists($file)) {
                 
                     unlink($file);
                     
                 }
         }
 }
function schwulissimo_get_cityguide_needles(){
    
    $start = time();
    $sql = 'SELECT post_id,meta_value FROM wp_postmeta WHERE meta_key LIKE "cityguide_adresse"';
    global $wpdb;
    $markers = $wpdb->get_results($sql);
    foreach ($markers as $marker){
            $address = maybe_unserialize($marker->meta_value);
            if(is_array($address)){
                $needles[] = array('lat' => $address['lat'], 'lng' => $address['lng'], 'post_id' => $marker->post_id);
            }
    }
    return json_encode($needles);
}