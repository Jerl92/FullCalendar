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
                calendar_widget_render($, data);
                calendar_render_public($, data);
            },
            error: function(errorThrown){
                //error stuff here.text
            }
    });

}

function calendar_render($, data)  {

    var calendarEl = document.getElementById('calendar');

    if (calendarEl) {

        calendarEl.innerHTML = "";

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'dayGrid', 'timeGrid', 'list' ],
            height: 'parent',
            customButtons: {
                AddEventButton: {
                text: 'Add event',
                    click: function() {
                        jQuery('.calendar-box-add-event').toggleClass('toggle');
                    }
                }
            },
            header: {
                left: 'prev,next,today,AddEventButton',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            defaultView: 'dayGridMonth',
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: data
        });
        calendar.render();
    }
}

function calendar_render_public($, data)  {

    var calendarEl = document.getElementById('calendar-public');

    if (calendarEl) {

        calendarEl.innerHTML = "";

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'dayGrid', 'timeGrid', 'list' ],
            height: 'parent',
            header: {
                left: 'prev,next,today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            defaultView: 'dayGridMonth',
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: data
        });
        calendar.render();

    }

}

function calendar_widget_render($, data)  {

    var calendarEl = document.getElementById('calendar-widget');

    if (calendarEl) {

        calendarEl.innerHTML = "";

        var calendar_widget = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'dayGrid', 'timeGrid', 'list' ],
            height: 'parent',
            header: {
                left: 'prev,next,today',
                center: '',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            defaultView: 'dayGridMonth',
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            nowIndicator: true,
            events: data
        });
        calendar_widget.render();

    }

}

jQuery(document).ready(function($) {
    calander_get_user_events($);
    jQuery("#calendar-btn-add-event").click(function($){
        // jQuery('#calendar').empty();
        var title = jQuery("#event-title-textarea").val();
        var start_date = jQuery("#event-start-date-textarea").val();
        var end_date = jQuery("#event-end-date-textarea").val();
        var detail = jQuery("#event-detail-textarea").val();
        var users = jQuery("#event-users").val();
        var start_time = jQuery("#event-start-time").val();
        var end_time = jQuery("#event-end-time").val();
        var color = "#"+jQuery("#event-color").val();

        if(document.getElementById("public-event").checked) {
            var public = '1';
        } else {
            var public = '0';
        }

        console.log(start_time);
        console.log(end_time);
        console.log(color);

        if ( end_time == '' && start_time == '' ) {
            var event = [title, start_date, end_date, detail, color, public, users];
        } else if ( end_time == '' && start_time != ''  ) {
            var event = [title, start_date+'T'+start_time, end_date, detail, color, public, users];
        } else if ( start_time == '' && end_time != '') {
            var event = [title, start_date, end_date+'T'+end_time, detail, color, public, users];
        } else {
            var event = [title, start_date+'T'+start_time, end_date+'T'+end_time, detail, color, public, users];
        }

        calander_add_user_events($, event);
        jQuery("#event-title-textarea").val('');
        jQuery("#event-start-date-textarea").val('');
        jQuery("#event-end-date-textarea").val('');
        jQuery("#event-detail-textarea").val('');
        jQuery("#event-users").val('');
        jQuery("#event-start-time").val('');
        jQuery("#event-end-time").val('');
        jQuery("#public-event").prop("checked", false);
        jQuery('.calendar-box-add-event').removeClass('toggle');
    });
});