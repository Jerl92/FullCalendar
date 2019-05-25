function calander_get_user_events($) {
    
        jQuery.ajax({    
            type: 'post',
            url: get_user_calander_ajax_url,
            data: {
                'object_id': null,
                'action': 'get_user_events'
            },
            dataType: 'json',
            success: function(data){
				console.log(data);
                calendar_render($, data);
            },
            error: function(errorThrown){
                //error stuff here.text
            }
    });

}

function calendar_render($, data)  {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        height: 'parent',
        customButtons: {
            AddEventButton: {
              text: 'Add event',
              click: function() {
                jQuery('.calendar-box-add-event').toggleClass('toggle');        
                calander_add_window_user_events($);
              }
            }
          },
        header: {
            left: 'prev,next today AddEventButton',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        defaultView: 'dayGridMonth',
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: data
    });

    if ( calendar ) {
        calendar.render();
    }
}

jQuery(document).ready(function($) {
    calander_get_user_events($);
});