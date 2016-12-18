jQuery(document).ready(function($){
    
    
    
   map = new google.maps.Map(document.getElementById('partypics-single-map'), {
            center: {lat: parseFloat(adr_data.lat), lng: parseFloat(adr_data.lng) },
            zoom: 14
            });
            
           
            var image = {
                    url: post_info.markerIcon,
            };
            marker = new google.maps.Marker({
                    position: { lat: parseFloat(adr_data.lat), lng: parseFloat(adr_data.lng)},
                    map: map,
                    icon: image,
                });
    
    
}); //ready