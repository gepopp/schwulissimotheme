<?php
   /**
    * @TODO update for ajax speed
    */
    
    
    $func =  $_POST['action'].'_fast';
   $func();
    
   
   
    function search_cityguide_where_fast(){
        
        require_once '../../../../wp-config.php';
        
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);
        $conn->select_db(DB_NAME);
        $sql  = 'SELECT meta_value FROM wp_postmeta WHERE meta_key LIKE "cityguide_adresse" AND meta_value LIKE "%'.$_POST['data'].'%" LIMIT 5;';
        
       $prep =  $conn->prepare($sql);
       $prep->execute();
       $result = $prep->get_result();
        while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            foreach ($row as $r)
            {
              $arr =  maybe_unserialize($r);
              $arr1 = explode(',', $arr['address']);
              $cityZip = $arr1[1];
              $cityZip = trim($cityZip);
              $arr2 = explode(' ', $cityZip);
              $where[] = array('label' => $arr2[1]);
            }
        }
        echo json_encode(array_unique($where)); 
        die();
    }