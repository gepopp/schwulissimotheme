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
