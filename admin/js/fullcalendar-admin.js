var jQuery = jQuery.noConflict();


jQuery(document).ready(function() {      
    jQuery('[data-toggle="datepicker-start-admin"]').datepicker({
      format: 'yyyy-mm-dd'
    });    
    jQuery('[data-toggle="datepicker-end-admin"]').datepicker({
      format: 'yyyy-mm-dd'
    }); 
});