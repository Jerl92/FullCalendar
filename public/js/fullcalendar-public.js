var jQuery = jQuery.noConflict();


jQuery(document).ready(function() {      
    jQuery('[data-toggle="datepicker"]').datepicker({
        format: 'yyyy-mm-dd'
      });    
});