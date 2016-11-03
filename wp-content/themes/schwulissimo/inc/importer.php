<?php
    /* 
 * 
 */
add_action( 'admin_menu', 'add_post_importer_options_page' );
function add_post_importer_options_page(){
    add_submenu_page( 'edit.php', 'Importer', 'Importer', 'manage_options', 'post_importer', 'post_content_importer');
}
/**
 * Importer Options Page Content
 */
function post_content_importer(){
     
    echo '<h1>Posts Importer</h1>';
    
    ?>
<form action="<?php echo home_url() ?>/wp-admin/admin-post.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action"       value="upload-importer-file" />
    <input type="file"   name="importer-file" />
    <input type="submit" value="senden" />
</form>
<hr>
    <?php if(isset($_GET['file'])):?>

    <button id="start-import">Import starten</button>
    <hr>
    <div id="import-status"></div>
   

    <script>
        jQuery(document).ready(function($){
            
            
        var snd = new Audio("<?php echo get_stylesheet_directory_uri() . '/inc/beep-08b.wav' ?>"); // buffers automatically when created

            
            var file = "<?php echo $_GET['file'] ?>";
            var range = [];
            
            $('#start-import').click(function(){
                
                $.post(
                    ajaxurl,
            {
            data: file,
            action: "importer_get_fileinfo"
            },
            function(data){
            
           response = JSON.parse(data);
           $('#import-status').append('<h5>Zeilen gesamt: ' + response.lines + '</h5>');
           table = '<table border="1" id="status-lines"><thead><tr class="headline">';
           table += '<th>lfd</th>';
           $(response.firstLine).each(function(i,v){
                table += '<th style="height:20px;overflow:hidden;">' + v + '</th>';
           });
           $('#status-lines tr.headline').append('<th>ID neu</th>');
           table += '</tr></thead><tbody id="table-body"></tbody></table>';
           $('#import-status').append(table);
           range = response.range;
           getShelfRecursive();
           
           });
    });
     function getShelfRecursive() {

    // terminate if array exhausted
    if (range.length === 0)
        return;
   
    // pop top value
    var id = range[0];
    range.shift();
   
    // ajax request
    jQuery.ajax({
            type: 'POST',
            url:   ajaxurl,
            data: {
            data:    [id, file],
            action: 'importer_add_article'
        },
            async:true,
            success:  function(rsp){
                
           cellstring = "<tr>";    
           cells = JSON.parse(rsp);
           $(cells).each(function(i,v){
           cellstring += '<td style="height:20px;overflow:hidden;">' + v + '</td>'; 
           });
           cellstring += '</tr>';
           $('#table-body').prepend(cellstring);
           /*
           if(id%1000 == 0){
               thsd = id / 1000;
               var hun = new Audio("<?php// echo get_stylesheet_directory_uri() . '/inc/wav/' ?>" + thsd + '.wav');
               var hund = new Audio("<?php //echo get_stylesheet_directory_uri() . '/inc/wav/thousend.wav' ?>");
              // hun.play();
               hun.addEventListener("ended", function() {
                // hund.play();
               });
           }
           if(id%100 == 0 && id%1000 != 0){
               hundret = id / 100;
               var hun = new Audio("<?php// echo get_stylesheet_directory_uri() . '/inc/wav/' ?>" + hundret + '.wav');
               var hund = new Audio("<?php //echo get_stylesheet_directory_uri() . '/inc/wav/hundred.wav' ?>");
             //  hun.play();
              // hun.addEventListener("ended", function() {
                // hund.play();
               });
           }else{
            var sin = new Audio("<?php //echo get_stylesheet_directory_uri() . '/inc/wav/' ?>" + id%100 + '.wav');
              sin.play();
            }
            */
            getShelfRecursive();
            }
        }).fail(function(){
        getShelfRecursive();
        snd.play();
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
    <?php endif;?>
    <?php 
}
/**
 * Handle uploaded Files and save it to tmp
 */
add_action('admin_post_upload-importer-file', function(){
    
    
        $uploaddir = get_template_directory() . '/inc/tmp/';
        $uploadfile = $uploaddir . basename($_FILES['importer-file']['name']);

        echo '<pre>';
        if (move_uploaded_file($_FILES['importer-file']['tmp_name'], $uploadfile)) {
            emptyTmp();
            wp_redirect(add_query_arg('file', $_FILES['importer-file']['name'], wp_get_referer() ));
        } else {
            echo "M�glicherweise eine Dateiupload-Attacke!\n";
        }

        echo 'Weitere Debugging Informationen:';
        print_r($_FILES);

        print "</pre>";
    }); 
    
    
    /**
     * ajax action to get importer file information
     */
    add_action('wp_ajax_importer_get_fileinfo', function(){
        
       
        
            $filepath = get_stylesheet_directory() . '/inc/tmp/' . $_POST['data'];
       
        
            if (file_exists($filepath)) {
                
               if (($handle = file("$filepath")) !== FALSE) {
                $data = explode(';', $handle[0]);
   
                }
                
                $output = array(
                    'lines'  => count($handle),
                    'firstLine' => $data,
                    'range' => range(1, count($handle))
                );
                
                
            }else{
                $output = array('error' => 'file not found');
                
            }
            
        echo json_encode($output);
        die();
    });
    
    
    
add_action('wp_ajax_importer_add_article', function(){
        
            $data = $_POST['data'];
            $filepath = get_stylesheet_directory() . '/inc/tmp/' . $data[1];

            if (file_exists($filepath)) {
                
               if (($handle = file("$filepath")) !== FALSE) {
                    $row = str_getcsv( $handle[$data[0]], ";", '"', '\\');
                } 
            }
           
           
            if($row[8] == 1){
                $post_status = 'publish';
            }else{
                $post_status = 'draft';
            }
            
            $args = array(
                'post_type' => 'schwulissimo_veranst',
                'post_status' => $post_status,
                'post_title' => $row[1],
                'post_content' => $row[4],
                'post_date' => date('Y-m-d H:i:s', $row[6])
            );
          
                $post_id = wp_insert_post($args);
          
                switch($row[10]){
                    
                    case(50):
                       wp_set_post_terms( $post_id, '7', 'post_region', true );  
                       break;
                   case(51):
                       wp_set_post_terms( $post_id, '8', 'post_region', true );  
                       break;
                    case(52):
                       wp_set_post_terms( $post_id, '9', 'post_region', true );  
                       break;
                    case(53):
                       wp_set_post_terms( $post_id, '10', 'post_region', true );  
                       break;
                    case(54):
                       wp_set_post_terms( $post_id, '11', 'post_region', true );  
                       break;
                   case(55):
                       wp_set_post_terms( $post_id, '12', 'post_region', true );  
                       break;
                   case(56):
                       wp_set_post_terms( $post_id, '13', 'post_region', true );  
                       break;
                   case(57):
                       wp_set_post_terms( $post_id, '14', 'post_region', true );  
                       break;
                   case(58):
                       wp_set_post_terms( $post_id, '15', 'post_region', true );  
                       break;
                   case(59):
                       wp_set_post_terms( $post_id, '16', 'post_region', true );  
                       break;
                   
                   case(60):
                       wp_set_post_terms( $post_id, '17', 'post_region', true );  
                       break;
                  case(61):
                       wp_set_post_terms( $post_id, '18', 'post_region', true );  
                       break; 
                    case(62):
                       wp_set_post_terms( $post_id, '19', 'post_region', true );  
                       break;
                    case(63):
                       wp_set_post_terms( $post_id, '20', 'post_region', true );  
                       break;
                    case(64):
                       wp_set_post_terms( $post_id, '21', 'post_region', true );  
                       break;
                    case(65):
                       wp_set_post_terms( $post_id, '22', 'post_region', true );  
                       break;
                 
                        default:
                        break;
              }
                
                wp_set_post_terms( $post_id, '6', 'category', true );
                //wp_set_post_terms( $post_id, '32', 'category', true );
                
                
                update_field('field_58108608ea5bc', trim($row[2] ,'"'), $post_id); //Sub Titelsub_titel Text einzeilig
                update_field('field_581085e1ea5bb', trim($row[0] ,'"'), $post_id); // ID alt id_alt Numerisch
                update_field('field_581086a0ea5bd', trim($row[3] ,'"'), $post_id); // Text alt text_alt Text mehrzeilig
                update_field('field_581086f2ea5be', trim($row[7] ,'"'), $post_id); // Redakteur redakteur Text einzeilig
                update_field('field_58108711ea5bf', trim($row[9] ,'"'), $post_id); // Hauptkategorie hauptkategorie Numerisch
                update_field('field_5810871dea5c0', trim($row[10],'"'), $post_id); // Subkategorie subkategorie Numerisch
                update_field('field_5810877cea5c1', trim($row[11],'"'), $post_id); // User alt user_alt Text einzeilig
                update_field('field_58108842ea5c2', date('Y-m-d H:i:s', trim($row[12],'"')), $post_id); // Online von online_von Numerisch
                update_field('field_58108850ea5c3', date('Y-m-d H:i:s', trim($row[13], '"')), $post_id); // Online bis online_bis Text einzeilig
                update_field('field_58108863ea5c4', trim($row[14], '"'), $post_id); // Suche suche Text einzeilig
                update_field('field_5810886aea5c5', trim($row[15], '"'), $post_id); // Newsletter newsletter Text einzeilig
                update_field('field_58108882ea5c6', trim($row[16], '"'), $post_id); // show_date show_date Text einzeilig
                update_field('field_58108892ea5c7', date('Y-m-d H:i:s', trim( $row[17], '"')), $post_id); // event_date event_date Text einzeilig
                update_field('field_5810889bea5c8', trim($row[18], '"'), $post_id); // url_old url_old Text einzeilig
                update_field('field_581088a6ea5c9', trim($row[19], '"'), $post_id); // kaufen kaufen Text einzeilig
                
                
                
            
                array_unshift($row, $data[0]);
                $row[] = '<a href="' .get_the_permalink($post_id) . '">' . $post_id . '</a>';
            
            echo json_encode($row);
            die(); 
        });
        
        
        
        //-------------------------------------------------------------------------------------------------------------
        add_action( 'admin_menu', 'add_post_importer_options_pageII' );
function add_post_importer_options_pageII(){
    add_submenu_page( 'edit.php', 'Importer II', 'ImporterII', 'manage_options', 'post_importerII', 'post_content_importerII');
}
function post_content_importerII(){
    echo '<h1>Importer 2</h1>';
    echo '<button type="button" id="delete" >Del</button>';
    echo '<li id="results"></li>';
    ?>
    <script>
        jQuery(document).ready(function($){
            
            var range = [];
            
            $('#delete').on('click', function(){
              
            $.post(
            ajaxurl,
            {
            data: '1',
            action: "delete_nrw"
            },
            function(data){
            
           console.log(data);
           response = JSON.parse(data);
           range = response.range;
           getShelfRecursive();
           console.log(range);
           }); 
                
           });

            
          
     function getShelfRecursive() {

    // terminate if array exhausted
    if (range.length === 0)
        return;
   
    // pop top value
    var page = range[0];
    range.shift();
   
    // ajax request
    jQuery.ajax({
            type: 'POST',
            url:   ajaxurl,
            data: {
            data:    page,
            action: 'delete_page'
        },
            async:true,
            success:  function(rsp){
           
        $('#results').append(rsp);
            
            getShelfRecursive();
            }
        }).fail(function(){
        getShelfRecursive();
        });
}       
            
            
            
            
        });//ready

   </script>
   
   
   <?php 

    
}

add_action('wp_ajax_delete_page', function(){
    
    $args = array(
               
               'post_type' => 'schwulissimo_veranst',
               'paged' => $_POST['data'],
               'posts_per_page' => 100,
               'tax_query' => array(
               'relation' => 'AND',
		array(
			'taxonomy' => 'post_region',
			'field'    => 'term_id',
			'terms'    => array( 16 ),
		),
            )
          
           );
           
            $query = new WP_Query($args);
            
                if($query->have_posts()){
                        while($query->have_posts()){
                                $query->the_post();
                                
                                    wp_delete_post(get_the_ID(), true);
                                
                        }
                }
            
            echo '<li>' . $_POST['data'] . ' von ' . $query->max_num_pages . '</li>';
            die();
    
    
    
});


 add_action('wp_ajax_delete_nrw', function(){
           
         
           $args = array(
               
               'post_type' => 'schwulissimo_veranst',
               'posts_per_page' => 100,
               'tax_query' => array(
               'relation' => 'AND',
		array(
			'taxonomy' => 'post_region',
			'field'    => 'term_id',
			'terms'    => array( 16 ),
		),
            )
          
           );
           
            $query = new WP_Query($args);
            $pages = $query->max_num_pages;
            $range = range(1, $pages);
           
            $return = array('range' => $range);
            
            echo json_encode($return);
            die();
           
       });
   //------------------------------------------------ Cityguide --------------------------------------------------------

add_action( 'admin_menu', 'add_cityguide_importer_options_page' );
function add_cityguide_importer_options_page(){
    add_submenu_page( 'edit.php?post_type=post_citygiude', 'Importer', 'Importer', 'manage_options', 'cityguide_importer', 'cityguide_content_importer');
}
function cityguide_content_importer(){  
    echo '<h1>Cityguide Importer</h1>';
    ?>
<form action="<?php echo home_url() ?>/wp-admin/admin-post.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action"       value="upload-importer-file" />
    <input type="file"   name="importer-file" />
    <input type="submit" value="senden" />
</form>
<hr>
    <?php if(isset($_GET['file'])):?>

    <button id="start-import">Import starten</button>
    <hr>
    <div id="import-status"></div>
   

    <script>
        jQuery(document).ready(function($){
            
            
        var snd = new Audio("<?php echo get_stylesheet_directory_uri() . '/inc/beep-08b.wav' ?>"); // buffers automatically when created

            
            var file = "<?php echo $_GET['file'] ?>";
            var range = [];
            
            $('#start-import').click(function(){
                
                $.post(
                    ajaxurl,
            {
            data: file,
            action: "importer_get_fileinfo"
            },
            function(data){
            
           response = JSON.parse(data);
           $('#import-status').append('<h5>Zeilen gesamt: ' + response.lines + '</h5>');
           table = '<table border="1" id="status-lines"><thead><tr class="headline">';
           table += '<th>lfd</th>';
           $(response.firstLine).each(function(i,v){
                table += '<th style="height:20px;overflow:hidden;">' + v + '</th>';
           });
           $('#status-lines tr.headline').append('<th>ID neu</th>');
           table += '</tr></thead><tbody id="table-body"></tbody></table>';
           $('#import-status').append(table);
           range = response.range;
           getShelfRecursive();
           
           });
    });
     function getShelfRecursive() {

    // terminate if array exhausted
    if (range.length === 0)
        return;
   
    // pop top value
    var id = range[0];
    range.shift();
   
    // ajax request
    jQuery.ajax({
            type: 'POST',
            url:   ajaxurl,
            data: {
            data:    [id, file],
            action: 'importer_add_cityguide'
        },
            async:true,
            success:  function(rsp){
                
           cellstring = "<tr>";    
           cells = JSON.parse(rsp);
           $(cells).each(function(i,v){
           cellstring += '<td style="height:20px;overflow:hidden;">' + v + '</td>'; 
           });
           cellstring += '</tr>';
           $('#table-body').prepend(cellstring);
           /*
           if(id%1000 == 0){
               thsd = id / 1000;
               var hun = new Audio("<?php// echo get_stylesheet_directory_uri() . '/inc/wav/' ?>" + thsd + '.wav');
               var hund = new Audio("<?php //echo get_stylesheet_directory_uri() . '/inc/wav/thousend.wav' ?>");
              // hun.play();
               hun.addEventListener("ended", function() {
                // hund.play();
               });
           }
           if(id%100 == 0 && id%1000 != 0){
               hundret = id / 100;
               var hun = new Audio("<?php// echo get_stylesheet_directory_uri() . '/inc/wav/' ?>" + hundret + '.wav');
               var hund = new Audio("<?php //echo get_stylesheet_directory_uri() . '/inc/wav/hundred.wav' ?>");
             //  hun.play();
              // hun.addEventListener("ended", function() {
                // hund.play();
               });
           }else{
            var sin = new Audio("<?php //echo get_stylesheet_directory_uri() . '/inc/wav/' ?>" + id%100 + '.wav');
              sin.play();
            }
            */
            getShelfRecursive();
            }
        }).fail(function(){
        getShelfRecursive();
        snd.play();
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
    <?php endif;?>
    <?php 
}
add_action('wp_ajax_importer_add_cityguide', function(){
        
            $data = $_POST['data'];
            $filepath = get_stylesheet_directory() . '/inc/tmp/' . $data[1];

            if (file_exists($filepath)) {
                
               if (($handle = file("$filepath")) !== FALSE) {
                    $row = str_getcsv( $handle[$data[0]], ";", '"', '\\');
                } 
            }
            $args = array(
                'post_type' => 'post_citygiude',
                'post_status' => 'publish',
                'post_title' => $row[1],
                'post_content' => $row[10],
            );
          
            $post_id = wp_insert_post($args);
          
                switch($row[19]){
                    
                    case(2):
                       wp_set_post_terms( $post_id, '103', 'cityguide_category', true );  
                       break;
                   case(3):
                       wp_set_post_terms( $post_id, '104', 'cityguide_category', true );  
                       break;
                    case(4):
                       wp_set_post_terms( $post_id, '105', 'cityguide_category', true );  
                       break;
                    case(5):
                       wp_set_post_terms( $post_id, '106', 'cityguide_category', true );  
                       break;
                    case(6):
                       wp_set_post_terms( $post_id, '107', 'cityguide_category', true );  
                       break;
                   case(7):
                       wp_set_post_terms( $post_id, '108', 'cityguide_category', true );  
                       break;
                   case(8):
                       wp_set_post_terms( $post_id, '109', 'cityguide_category', true );  
                       break;
                   case(9):
                       wp_set_post_terms( $post_id, '110', 'cityguide_category', true );  
                       break;
                   case(10):
                       wp_set_post_terms( $post_id, '66', 'cityguide_category', true );  
                       break;
                   case(11):
                       wp_set_post_terms( $post_id, '111', 'cityguide_category', true );  
                       break;
                   case(12):
                       wp_set_post_terms( $post_id, '112', 'cityguide_category', true );  
                       break;
                  case(13):
                       wp_set_post_terms( $post_id, '113', 'cityguide_category', true );  
                       break; 
                    case(14):
                       wp_set_post_terms( $post_id, '114', 'cityguide_category', true );  
                       break;
                    case(15):
                       wp_set_post_terms( $post_id, '115', 'cityguide_category', true );  
                       break;
                    case(16):
                       wp_set_post_terms( $post_id, '116', 'cityguide_category', true );  
                       break;
                    case(17):
                       wp_set_post_terms( $post_id, '117', 'cityguide_category', true );  
                       break;
                    case(18):
                       wp_set_post_terms( $post_id, '118', 'cityguide_category', true );  
                       break;
                   case(19):
                       wp_set_post_terms( $post_id, '119', 'cityguide_category', true );  
                       break;
                    case(20):
                       wp_set_post_terms( $post_id, '120', 'cityguide_category', true );  
                       break;
                    case(21):
                       wp_set_post_terms( $post_id, '121', 'cityguide_category', true );  
                       break;
                    case(22):
                       wp_set_post_terms( $post_id, '122', 'cityguide_category', true );  
                       break;
                   case(23):
                       wp_set_post_terms( $post_id, '123', 'cityguide_category', true );  
                       break;
                   case(24):
                       wp_set_post_terms( $post_id, '124', 'cityguide_category', true );  
                       break;
                   case(25):
                       wp_set_post_terms( $post_id, '125', 'cityguide_category', true );  
                       break;
                   case(26):
                       wp_set_post_terms( $post_id, '126', 'cityguide_category', true );  
                       break;
                   case(27):
                       wp_set_post_terms( $post_id, '127', 'cityguide_category', true );  
                       break;
                   case(28):
                       wp_set_post_terms( $post_id, '128', 'cityguide_category', true );  
                       break;
                  case(29):
                       wp_set_post_terms( $post_id, '129', 'cityguide_category', true );  
                       break; 
                  case(30):
                       wp_set_post_terms( $post_id, '130', 'cityguide_category', true );  
                       break;
                    case(31):
                       wp_set_post_terms( $post_id, '50', 'cityguide_category', true );  
                       break;
                   case(32):
                       wp_set_post_terms( $post_id, '51', 'cityguide_category', true );  
                       break;
                    case(33):
                       wp_set_post_terms( $post_id, '52', 'cityguide_category', true );  
                       break;
                    case(34):
                       wp_set_post_terms( $post_id, '53', 'cityguide_category', true );  
                       break;
                    case(35):
                       wp_set_post_terms( $post_id, '54', 'cityguide_category', true );  
                       break;
                   case(36):
                       wp_set_post_terms( $post_id, '55', 'cityguide_category', true );  
                       break;
                   case(37):
                       wp_set_post_terms( $post_id, '56', 'cityguide_category', true );  
                       break;
                   case(38):
                       wp_set_post_terms( $post_id, '57', 'cityguide_category', true );  
                       break;
                   case(39):
                       wp_set_post_terms( $post_id, '58', 'cityguide_category', true );  
                       break;
                   case(40):
                       wp_set_post_terms( $post_id, '59', 'cityguide_category', true );  
                       break;
                   case(41):
                       wp_set_post_terms( $post_id, '60', 'cityguide_category', true );  
                       break;
                  case(42):
                       wp_set_post_terms( $post_id, '61', 'cityguide_category', true );  
                       break; 
                    case(43):
                       wp_set_post_terms( $post_id, '62', 'cityguide_category', true );  
                       break;
                    case(45):
                       wp_set_post_terms( $post_id, '63', 'cityguide_category', true );  
                       break;
                    case(46):
                       wp_set_post_terms( $post_id, '64', 'cityguide_category', true );  
                       break;
                    case(47):
                       wp_set_post_terms( $post_id, '65', 'cityguide_category', true );  
                       break;
                    case(48):
                       wp_set_post_terms( $post_id, '66', 'cityguide_category', true );  
                       break;
                   case(49):
                       wp_set_post_terms( $post_id, '67', 'cityguide_category', true );  
                       break;
                    case(50):
                       wp_set_post_terms( $post_id, '68', 'cityguide_category', true );  
                       break;
                    case(51):
                       wp_set_post_terms( $post_id, '69', 'cityguide_category', true );  
                       break;
                    case(52):
                       wp_set_post_terms( $post_id, '70', 'cityguide_category', true );  
                       break;
                   case(53):
                       wp_set_post_terms( $post_id, '71', 'cityguide_category', true );  
                       break;
                   case(54):
                       wp_set_post_terms( $post_id, '72', 'cityguide_category', true );  
                       break;
                   case(55):
                       wp_set_post_terms( $post_id, '73', 'cityguide_category', true );  
                       break;
                   case(56):
                       wp_set_post_terms( $post_id, '74', 'cityguide_category', true );  
                       break;
                   case(57):
                       wp_set_post_terms( $post_id, '75', 'cityguide_category', true );  
                       break;
                   case(58):
                       wp_set_post_terms( $post_id, '76', 'cityguide_category', true );  
                       break;
                  case(59):
                       wp_set_post_terms( $post_id, '77', 'cityguide_category', true );  
                       break; 
                  case(60):
                       wp_set_post_terms( $post_id, '78', 'cityguide_category', true );  
                       break;
                    case(61):
                       wp_set_post_terms( $post_id, '79', 'cityguide_category', true );  
                       break;
                    case(62):
                       wp_set_post_terms( $post_id, '80', 'cityguide_category', true );  
                       break;
                   case(63):
                       wp_set_post_terms( $post_id, '81', 'cityguide_category', true );  
                       break;
                    case(64):
                       wp_set_post_terms( $post_id, '82', 'cityguide_category', true );  
                       break;
                    case(65):
                       wp_set_post_terms( $post_id, '83', 'cityguide_category', true );  
                       break;
                    case(66):
                       wp_set_post_terms( $post_id, '84', 'cityguide_category', true );  
                       break;
                   case(67):
                       wp_set_post_terms( $post_id, '85', 'cityguide_category', true );  
                       break;
                   case(68):
                       wp_set_post_terms( $post_id, '86', 'cityguide_category', true );  
                       break;
                   case(69):
                       wp_set_post_terms( $post_id, '87', 'cityguide_category', true );  
                       break;
                   case(70):
                       wp_set_post_terms( $post_id, '88', 'cityguide_category', true );  
                       break;
                   case(71):
                       wp_set_post_terms( $post_id, '89', 'cityguide_category', true );  
                       break;
                   case(72):
                       wp_set_post_terms( $post_id, '90', 'cityguide_category', true );  
                       break;
                  case(73):
                       wp_set_post_terms( $post_id, '91', 'cityguide_category', true );  
                       break; 
                    case(74):
                       wp_set_post_terms( $post_id, '92', 'cityguide_category', true );  
                       break;
                    case(75):
                       wp_set_post_terms( $post_id, '93', 'cityguide_category', true );  
                       break;
                    case(76):
                       wp_set_post_terms( $post_id, '94', 'cityguide_category', true );  
                       break;
                    case(77):
                       wp_set_post_terms( $post_id, '95', 'cityguide_category', true );  
                       break;
                    case(78):
                       wp_set_post_terms( $post_id, '96', 'cityguide_category', true );  
                       break;
                   case(79):
                       wp_set_post_terms( $post_id, '97', 'cityguide_category', true );  
                       break;
                    case(80):
                       wp_set_post_terms( $post_id, '98', 'cityguide_category', true );  
                       break;
                    case(81):
                       wp_set_post_terms( $post_id, '99', 'cityguide_category', true );  
                       break;
                    case(82):
                       wp_set_post_terms( $post_id, '100', 'cityguide_category', true );  
                       break;
                   case(83):
                       wp_set_post_terms( $post_id, '101', 'cityguide_category', true );  
                       break;
                   case(84):
                       wp_set_post_terms( $post_id, '102', 'cityguide_category', true );  
                       break;
                        default:
                        break;
              }
                
                update_field('field_581085e1ea5bb', trim($row[0] ,'"'), $post_id); // ID alt id_alt Numerisch
                
                if($row[20] != ''){
                
                $latlng = explode(',', $row[20]); 
                
                
                
                $formatted = $row[2] . ' ' . $row[3] . ', ' . $row[4] . ' ' . $row[5];
                
                
                  $address = array(
                    'address' => $formatted,
                    'lat' => $latlng[0],
                    'lng' => $latlng[1],
                    'zoom' => 14
                    ); 
                 
                  update_field('field_581702c7588d1', array(
                    'address' => $formatted,
                    'lat' => $latlng[0],
                    'lng' => $latlng[1],
                    'zoom' => 14
                    ), $post_id); //Cityguide Adresse cityguide_adresse Google Maps
                  update_field('field_5817062d588e0', $row[20], $post_id); // Cityguide lat lng alt Text einzeilig
                }
                
                
                
                
                
                update_field('field_5817031f588d2', $row[7], $post_id); // Cityguide Telefonnummer cityguide_telefonnummer Text einzeilig
                update_field('field_58170336588d3', $row[8], $post_id); // Cityguide E-Mail cityguide_e-mail E-Mail 
                update_field('field_58170355588d4', $row[9], $post_id); // Cityguide Homepage cityguide_homepage URL
                update_field('field_58170363588d5', $row[11], $post_id); // Cityguide Zusatz Schwulissimio cityguide_zusatz_schwulissimio Ja/Nein
                update_field('field_581703cc588d6', $row[12], $post_id); // Cityguide Zusatz Schwul cityguide_zusatz_schwul Ja/Nein
                update_field('field_581703e4588d7', $row[13], $post_id); // Cityguide Zusatz Lesbisch cityguide_zusatz_lesbisch Ja/Nein
                update_field('field_581703f6588d8', $row[14], $post_id); // Cityguide Zusatz Schwul-Lesbisch cityguide_zusatz_schwul_lesbisch Ja/Nein
                update_field('field_58170423588d9', $row[15], $post_id); // Cityguide Zusatz Hetero cityguide_zusatz_hetero Ja/Nein
                update_field('field_58170433588da', $row[16], $post_id); // Cityguide Zusatz Jung cityguide_zusatz_jung Ja/Nein
                update_field('field_58170447588db', $row[17], $post_id); // Cityguide Zusatz Alt cityguide_zusatz_alt Ja/Nein
                update_field('field_58170467588dc', $row[18], $post_id); // Cityguide Zusatz Gayfriendly cityguide_zusatz_gayfriendly Ja/Nein
                update_field('field_58170602588dd', $row[2] . ' ' . $row[3], $post_id); // Cityguide Adresse cityguide_adresse Text einzeilig
                update_field('field_5817060e588de', $row[4], $post_id); // Cityguide Postleitzahl cityguide_postleitzahl Numerisch
                update_field('field_5817061b588df', $row[5], $post_id); // Cityguide Ort cityguide_ort Text einzeilig
                
                
                
                
            
                array_unshift($row, $data[0]);
                $row[] = '<a href="' .get_the_permalink($post_id) . '">' . $post_id . '</a>';
            
            echo json_encode($row);
            die(); 
        });
        
        //--------------------------------------------------------------- media
add_action( 'admin_menu', 'add_image_importer_options_page' );
function add_image_importer_options_page(){
    add_submenu_page( 'upload.php', 'Importer', 'Importer', 'manage_options', 'cityguide_importer', 'media_content_importer');
}
function media_content_importer(){  
    echo '<h1>Media Importer</h1>';
    
    $url = 'http://www.schwulissimo.de//bilder/190182/niederlande.jpg.jpg';

    file_put_contents(get_stylesheet_directory() . '/inc/img/test.jgp', file_get_contents($url));
    
    $ch = curl_init();

    // set url
    curl_setopt($ch, CURLOPT_URL, "http://www.schwulissimo.de//bilder/190182/niederlande.jpg.jpg");

    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

    // $output contains the output string
    $output = curl_exec($ch);
    
    echo var_dump($output);

    // close curl resource to free up system resources
    curl_close($ch); 
    
    
    
}
function _import_photo( $postid, $photo_name, $photo_id ) {
	$post = get_post( $postid );
	if( empty( $post ) )
		return false;

	if( !class_exists( 'WP_Http' ) )
	  include_once( ABSPATH . WPINC. '/class-http.php' );

	$photo = new WP_Http();
	$photo = $photo->request( 'http://www.schwulissimo.de//bilder/190182/niederlande.jpg.jpg' );
	if( $photo['response']['code'] != 200 )
		echo $photo['response']['code']; //return false;

	$attachment = wp_upload_bits( $user_login . '.jpg', null, $photo['body'], date("Y-m", strtotime( $photo['headers']['last-modified'] ) ) );
	if( !empty( $attachment['error'] ) )
		return false;

	$filetype = wp_check_filetype( basename( $attachment['file'] ), null );

	$postinfo = array(
		'post_mime_type'	=> $filetype['type'],
		'post_title'		=> $post->post_title,
		'post_content'		=> '',
		'post_status'		=> 'inherit',
	);
	$filename = $attachment['file'];
	$attach_id = wp_insert_attachment( $postinfo, $filename, $postid );

	if( !function_exists( 'wp_generate_attachment_data' ) )
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
	wp_update_attachment_metadata( $attach_id,  $attach_data );
	return $attach_id;
}


// ------------------------------------ verkn�fung    
add_action( 'admin_menu', 'add_termin_importer_options_page' );
function add_termin_importer_options_page(){
    add_submenu_page( 'edit.php?post_type=schwulissimo_veranst', 'Importer verkn�pfung', 'Importer verkn�pfung', 'manage_options', 'veranst_importer_v', 'veranst_content_importer');
}
/**
 * Importer Options Page Content
 */
function veranst_content_importer(){

    echo '<h1>Veranstaltung Importer</h1>';
    
    ?>
<form action="<?php echo home_url() ?>/wp-admin/admin-post.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action"       value="upload-importer-file" />
    <input type="file"   name="importer-file" />
    <input type="submit" value="senden" />
</form>
<hr>
    <?php if(isset($_GET['file'])):?>

    <button id="start-import">Import starten</button>
    <hr>
    <div id="import-status"></div>
   

    <script>
        jQuery(document).ready(function($){
            
            
       
            var file = "<?php echo $_GET['file'] ?>";
            var range = [];
            
            $('#start-import').click(function(){
                
                $.post(
                    ajaxurl,
            {
            data: file,
            action: "importer_get_fileinfo"
            },
            function(data){
            
           response = JSON.parse(data);
           $('#import-status').append('<h5>Zeilen gesamt: ' + response.lines + '</h5>');
           table = '<table border="1" id="status-lines"><thead><tr class="headline">';
           table += '<th>lfd</th>';
           $(response.firstLine).each(function(i,v){
                table += '<th style="height:20px;overflow:hidden;">' + v + '</th>';
           });
           $('#status-lines tr.headline').append('<th>ID neu</th>');
           table += '</tr></thead><tbody id="table-body"></tbody></table>';
           $('#import-status').append(table);
           range = response.range;
           getShelfRecursive();
           
           });
    });
     function getShelfRecursive() {

    // terminate if array exhausted
    if (range.length === 0)
        return;
   
    // pop top value
    var id = range[0];
    range.shift();
   
    // ajax request
    jQuery.ajax({
            type: 'POST',
            url:   ajaxurl,
            data: {
            data:    [id, file],
            action: 'importer_add_veranst'
        },
            async:true,
            success:  function(rsp){
                
           cellstring = "<tr>";    
           cells = JSON.parse(rsp);
           $(cells).each(function(i,v){
           cellstring += '<td style="height:20px;overflow:hidden;">' + v + '</td>'; 
           });
           cellstring += '</tr>';
           $('#table-body').prepend(cellstring);
            getShelfRecursive();
            }
        }).fail(function(){
        getShelfRecursive();
        snd.play();
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
    <?php endif;?>
    <?php 
}

    
    
    
    
add_action('wp_ajax_importer_add_veranst', function(){
        
            $data = $_POST['data'];
            $filepath = get_stylesheet_directory() . '/inc/tmp/' . $data[1];

            if (file_exists($filepath)) {
                
               if (($handle = file("$filepath")) !== FALSE) {
                    $row = str_getcsv( $handle[$data[0]], ";", '"', '\\');
                } 
            }
           
            $args = array(
                'post_type' => 'schwulissimo_veranst',
                'meta_query' => array(
                    'realtion' => 'AND',
                    array(
                        'key' => 'id_alt',
                        'value' => $row[1],
                        'compare' => '='
                    )
                ),
                'fields' => 'ids'
            );
               $veranst_ids = new WP_Query($args);
               
               $args = array(
                   'post_type' => 'post_citygiude',
                   's' => "Willi's",
                   'fields' => 'ids'
               );
                   $cityduide_id = new WP_Query($args);
                   
             $ids[] = $veranst_ids;
             $ids[] = $cityduide_id;
             
                   
            
            
            echo json_encode($ids);
            die(); 
        });
      