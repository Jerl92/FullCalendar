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
                calander_get_user_events($);
            },
            error: function(errorThrown){
                //error stuff here.text
            }
    });

}

function calander_add_window_user_events($) {
    jQuery("#calendar-btn-add-event").click(function($){
        jQuery('#calendar').empty();
        var title = jQuery("#event-title-textarea").val();
        var start_date = jQuery("#event-start-date-textarea").val();
        var end_date = jQuery("#event-end-date-textarea").val();
        var detail = jQuery("#event-detail-textarea").val();
        var users = jQuery("#event-users").val();
        var start_time = jQuery("#event-start-time").val();
        var end_time = jQuery("#event-end-time").val();
        var color = "#"+jQuery("#event-color").val();

        console.log(start_time);
        console.log(end_time);

        if ( end_time == '' && start_time == '' ) {
            var event = [title, start_date, end_date, detail, users, color];
        } else if ( end_time == '' && start_time != ''  ) {
            var event = [title, start_date+'T'+start_time, end_date, detail, users, color];
        } else if ( start_time == '' && end_time != '') {
            var event = [title, start_date, end_date+'T'+end_time, detail, users, color];
        } else {
            var event = [title, start_date+'T'+start_time, end_date+'T'+end_time, detail, users, color];
        }

        calander_add_user_events($, event);
        jQuery("#event-title-textarea").val('');
        jQuery("#event-start-date-textarea").val('');
        jQuery("#event-end-date-textarea").val('');
        jQuery("#event-detail-textarea").val('');
        jQuery("#event-users").val('');
        jQuery("#event-start-time").val('');
        jQuery("#event-end-time").val('');
    });
}

/*
jQuery(document).ready(function($) {
    jQuery("#calendar-btn-add-event-box").click(function($){
        jQuery('.calendar-box-add-event').toggleClass('toggle');        
        calander_add_window_user_events($);
    });
});
*/