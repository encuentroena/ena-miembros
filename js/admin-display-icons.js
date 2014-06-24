jQuery(document).ready(function($){
     $('.cmb_metabox input[type="radio"]').each(function(){
            //console.log($(this).val());
         $(this).after('<img src="http://wpmapmarkers.com/wp-content/plugins/wp-map-markers/markers/' + $(this).val() + '.png" />') ;
     });
});