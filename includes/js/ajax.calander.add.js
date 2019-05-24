function calander_add_user_events($, object_id) {
   
    jQuery.ajax({    
            type: 'post',
            url: add_user_calander_ajax_url,
            data: {
                'object_id': object_id,
                'action': 'add_user_events'
            },
            dataType: 'json',
            success: function(data){
            	console.log(object_id);
                console.log(data);
                jQuery('#calendar').empty();
                calander_get_user_events($);
            },
            error: function(errorThrown){
                //error stuff here.text
            }
    });

}

function calander_add_window_user_events($) {
    jQuery("#calendar-btn-add-event").click(function($){
        var title = jQuery("#event-title-textarea").val();
        var date = jQuery("#event-textarea").val();
        var event = [title, date];
        calander_add_user_events($, event);
    });
}

jQuery(document).ready(function($) {
    jQuery("#calendar-btn-add-event-box").click(function($){
        jQuery('.calendar-box-add-event').toggleClass('toggle');
        
        calander_add_window_user_events($);
    });
});