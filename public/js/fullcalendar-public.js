var jQuery = jQuery.noConflict();


jQuery(document).ready(function() {      
    jQuery('[data-toggle="datepicker-start"]').datepicker({
      format: 'yyyy-mm-dd'
    });    
    jQuery('[data-toggle="datepicker-end"]').datepicker({
      format: 'yyyy-mm-dd'
    }); 
});

document.getElementById("calendar-btn-add-event").addEventListener("click", function(event){
  event.preventDefault();
});

$( function() {
  $( "#calendar-box-add-event" ).draggable();
} );