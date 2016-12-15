<?php
   
add_action( 'admin_menu', 'add_partypics_importer_new_options_page' );
function add_partypics_importer_new_options_page(){
    add_submenu_page( 'edit.php?post_type=post_partypics', 'Importer New', 'Importer New', 'manage_options', 'pics_importer_new', 'post_partypics_importer_new');
}
/**
 * Importer Options Page Content
 */
function post_partypics_importer_new(){
     
    echo '<h1>Partypics New Importer</h1>';
    ?>
    <button id="start-import">Import starten</button>
    <hr>
    <div id="import-status"></div>
   

    <script>
        jQuery(document).ready(function($){
            
            var range = [];
            var images = [];
            
            $('#start-import').click(function(){
            $.post(
               ajaxurl,
            {
            action: "retreive_txt"
            },
            function(data){
            
           range = JSON.parse(data);
           $('#import-status').append('<ul>');
           $(range).each(function(i,v){
               
               liid = v.replace('.txt', '');
               $('#import-status').append('<li id="'+ liid + '">' + i + ': ' + v + '</li>');
           });
           $('#import-status').append('</ul>');
           getShelfRecursive();
           
           });
        });
    
     var counter = 0;
     function getShelfRecursive() {

    // terminate if array exhausted
    if (range.length === 0)
        return;
   
    // pop top value
    var id = range[0];
    range.shift();
   
    // ajax request
    jQuery.ajax(
            {
            type: 'POST',
            url:   ajaxurl,
            data: {
            data:    id,
            action: 'set_post_parypics'
        },
            async:true,
            success:  function(rsp){
            
            try{
            responseArr = $.parseJSON(rsp);
            
            
            liid = id.replace('.txt', '');
            $('#' + liid).append(responseArr.link + '<ul>');
            $(responseArr.images).each(function(i,v){
                if(v !== '.' || v !== '..'){
                $('#' + liid).append('<li>' + v + '</li>');
                }
            });
            $('#' + liid).append('</ul>');
            
            images = responseArr.images;
            $(images).each(function(i,v){
                if(v != '.' || v != '..'){
                $.post(
                        ajaxurl,
                {
                    action: 'import_partypic',
                    img: v,
                    folder: responseArr.folder,
                    post: responseArr.post
                },
                function(rsp){
                    $('li:contains('+rsp+')').remove();
                });
                
             }   
            });
        
            
            }catch(e){
                console.log(rsp);
            }
            getShelfRecursive();
            }
        }).fail(function(){
        getShelfRecursive();
        });
     }       
});//ready

   </script>
   <style>
       tr, td{
           max-height: 30px;
           height: 30px;
           overflow: hidden;
       }
   </style>
    <?php 
}
add_action('wp_ajax_retreive_txt', function(){
    
            $files = scandir(get_template_directory() . '/inc/tmp/galerien/_');
            foreach($files as $file){
               if( preg_match("/^[0-9]+\.txt$/", $file)){
                   $filearr[] = $file;
               }
            }
            echo json_encode($filearr);
            die();
    
    
    
});

add_action('wp_ajax_set_post_parypics', function(){
    
        $string =  file_get_contents(get_stylesheet_directory() . '/inc/tmp/galerien/_/' . $_POST[data]);
        
        $dateOld = str_replace('.txt','', $_POST['data']);
        $date = DateTime::createFromFormat('Ymd', $dateOld);
        $post_date = $date->format('Y-m-d H:i:s');
        
        $parts = preg_split("/\|\||<br \/>/", $string);
        
            if(file_exists(get_stylesheet_directory() . '/inc/tmp/galerien/_/' . $dateOld . 'yt.txt')){
                
                    $yt = '<p>' . file_get_contents(get_stylesheet_directory() . '/inc/tmp/galerien/_/' . $dateOld . 'yt.txt') . '</p>';
                    $parts[1] .= $yt;
                
            }
            
            
            $place = [];
            if($parts[2]){
                $args = array(
                    'post_type' => 'post_citygiude',
                    's' => $parts[2]
                );
                    $query = new WP_Query($args);
                    if($query->have_posts()):
                        while($query->have_posts()):
                        $query->the_post();
                            $place[] = get_the_ID();
                        endwhile;
                    endif;
                    
                    if(count($place) != 1){
                    $parts[1] .= '<p>Location: ' . $parts[2] . '</p>';
                }
                    
            }
           
        
            if(is_array($parts)){
                
                $args = array(
                   'post_type' => 'post_partypics',
                   'post_status' => 'publish',
                   'post_title' => $parts[0],
                   'post_content' => $parts[1],
                   'post_date' => $post_date
                );
            $post_id  =  wp_insert_post($args); 
           
                if(count($place) == 1){
                    
                    update_field('field_584ea0519c356', $place, $post_id);
                    
                }
            
            
                
            if(is_dir(get_stylesheet_directory() . '/inc/tmp/galerien/_/' . $dateOld )){
                
                
                    $images = scandir(get_stylesheet_directory() . '/inc/tmp/galerien/_/' . $dateOld);
                    foreach($images as $img){
                        if($img != '.' && $img != '..'){
                            $imgs[] = $img;
                        }
                    }
                   
            }
            
            
            
        }//$parts
        $return = array(
            'post' => $post_id,
            'link' => '<a href="' . get_the_permalink($post_id) . '" target="__blank">' . get_the_title() . '</a>',
            'title' => $parts[0],
            'imagecount' => count($images),
            'images' => $imgs,
            'folder' => $dateOld
        );
        echo json_encode($return);
        die();
    
});
add_action('wp_ajax_import_partypic', function(){
    
    
    
    
    require_once get_stylesheet_directory() . '/inc/SimpleImage.php';
    
    $folder = $_POST['folder'];
    $img = $_POST['img'];
    
    if($img == '.' || $img == '..'){
        echo $img;
        die();
    }
    
    
    $date = DateTime::createFromFormat('Ymd', $folder);
    $post_date = $date->format('Y-m-d H:i:s');

    $file = get_stylesheet_directory() . '/inc/tmp/galerien/_/' . $folder . '/' . $img;
    
    $simpleImage = new abeautifulsite\SimpleImage($file);
    $simpleImage->best_fit(1005,500)->save();

    $filename = basename($file);
                    $upload_file = wp_upload_bits($filename, null, file_get_contents($file));
                    if (!$upload_file['error']) {
                            $wp_filetype = wp_check_filetype($filename, null );
                            $attachment = array(
                                    'post_mime_type' => $wp_filetype['type'],
                                    'post_parent' => $_POST['post'],
                                    'post_title' => $filename, //preg_replace('/\.[^.]+$/', '', $filename),
                                    'post_status' => 'inherit',
                                    'post_date' => $post_date
                            );
                            $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
                            if (!is_wp_error($attachment_id)) {
                                    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                                    $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
                                    wp_update_attachment_metadata( $attachment_id,  $attachment_data );
                        }
                    }     
                        $value = get_field('field_58069b05d9441', $_POST['post']);
                        $value[] = $attachment_id;
                        update_field('field_58069b05d9441', $value, $_POST['post']);
                    
                        echo $img;
                        die();    
    
});


