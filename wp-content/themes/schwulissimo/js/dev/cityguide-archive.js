/*!
 * @preserve
 * cityguide scripts
 */


jQuery(document).ready(function ($) {

    pwhere = $('#cityguide-where').val();
    pwhat = $('#cityguide-what-id').val();
    if(typeof pwhere != 'undefined'){
        setMapCenter(pwhere);
    }
    if(typeof pwhat != 'undefined' && pwhat != ''){
        console.log(pwhat);
        showSelectedMarkers(pwhat);
    }

    var markers = $.parseJSON(post_info.needles);
    var arrMarkers = {};
    
    /**
     * Comment
     */
    function showSelectedMarkers(marker) {
        
         $.post(
                        ajaxurl,
                        {
                            action: "get_tax_bounces",
                            data: marker
                        },
                function (rsp) {

                    bounce = $.parseJSON(rsp);
                    $.each(arrMarkers, function (i, v) {
                        v.setMap(null);
                    });
                    $(bounce).each(function (i, v) {
                        try {
                            arrMarkers[v].setMap(map);
                            marks = [];
                            marks.push(arrMarkers[v]);
                            for (var i = 0; i < marks.length; i++) {
                                bounds.extend(marks[i].getPosition());
                            }
                            map.fitBounds(bounds);
                        } catch (e) {
                        }
                    });
                });
        
        
    }
    
    

    //trigger new map center after search field change
    $("#cityguide-where").change(function () {
        setMapCenter($(this).val());
        where = $(this).val();
    });
    
    //set new map center after search
    function setMapCenter(search) {
        var geo = new google.maps.Geocoder();
        geo.geocode({address: search, region: "de"}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                map.setZoom(12);
            } else {
                //alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }
    var addresses = $.parseJSON(cityguide_addresses.unique);
    $("#cityguide-where").autocomplete({
        source: addresses, //ajaxurl + '?action=search_cityguide_where',
        minLength: 2,
        select: function (event, ui) {
            setMapCenter(ui.item.value);
            where = ui.item.value;
        },
        appendTo: '#cityguide-where-container',
    });

    var tax = $.parseJSON(cityguide_addresses.cats);
    $("#cityguide-what").autocomplete({
        source: tax,
        minLength: 2,
        select: function (event, ui) {
            $.each(arrMarkers, function (i, v) {
                this.setAnimation(null);
            });
            if (!isNaN(ui.item.value)) {
                $.each(arrMarkers, function (i, v) {
                    v.setMap(map);
                });
                arrMarkers[ui.item.value].setAnimation(google.maps.Animation.BOUNCE);
                latlng = arrMarkers[ui.item.value].getPosition();
                map.setCenter(latlng);
                map.setZoom(16);
            } else {
               showSelectedMarkers(ui.item.value);
            }
            $('#cityguide-what').val(ui.item.label);
            $('#cityguide-what-id').val(ui.item.value);
            this.value = ui.item.label;
            return false;
        },
        appendTo: '#cityguide-what-container',
        delay: 0,
        autoFocus: true
    });

    map = new google.maps.Map(document.getElementById('cityguide-archive-map'), {
            center: {lat: 51, lng: 9 },
            zoom: 5
            });
            
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    var image = {
                    url: post_info.markerIcon,
            };
            
            
    for (i = 0; i < markers.length; i++) {  
             
                marker = new google.maps.Marker({
                    position: { lat: parseFloat(markers[i].lat), lng: parseFloat( markers[i].lng)},
                    map: map,
                    icon: image,
                });
                arrMarkers[markers[i].post_id] = marker;
                
            
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                
                    infowindow.setContent('<img src="' + post_info.spinner + '">' ); 
                    infowindow.open(map, marker);    
                    $.post(
                    ajaxurl,
                    {
                        data: markers[i]['post_id'],
                        action: "get_map_infobox"
                    },
                    function(rsp){
                      infowindow.setContent( rsp ); 
                      
                    });
                }
            })(marker, i));
        }

});//ready