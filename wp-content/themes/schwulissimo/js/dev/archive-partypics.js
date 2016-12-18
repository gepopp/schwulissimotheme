jQuery(document).ready(function($){
  
    
    var regions = [];
    $(partypics.regions).each(function(i,v){
        regions.push(
                { label: v.name , value: v.term_id }  
                );
    });
    console.log(regions);
   $('#partypics-where-container').autocomplete(
           {
            source: regions
           }
    );
    
});