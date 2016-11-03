<?php
    add_shortcode('administration_post_form', function($args) {

        ob_start();

        ?>
        
        
        <?php 
        
        acf_form(array(
            'post_id' => 'new_post',
            'post_content' => true,
            'post_title' => true,
            'new_post' => array(
                'post_type' => 'post',
                'post_status' => 'publish'
            ),
            'label_placement' => 'left',
            'title_label' => 'Beitragstitle',
            'submit_value' => 'speichern'
        ));

        $content = ob_get_clean();
        echo $content;
    });
    