/**
 * Comment
 */
jQuery(document).ready(function($){

$.post(
            ajaxurl,
            {
                action: "load_adress_data",
                data: post_info.ID
            },
    function (rsp) {
        if(rsp !== ''){
            var address = $.parseJSON(rsp);
            var lat = parseFloat( address.lat );
            var lng = parseFloat( address.lng );
            
            map = new google.maps.Map(document.getElementById('cityguide-single-map'), {
            center: {lat: lat, lng: lng },
            zoom: 14
            });
            
            var infowindow = new google.maps.InfoWindow();
            var image = {
                    url: post_info.markerIcon,
            };
            marker = new google.maps.Marker({
                    position: { lat: lat, lng: lng},
                    map: map,
                    icon: image,
                });
                
            
        }//if (rsp) 
    
    });//post
});//ready