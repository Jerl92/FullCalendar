<?php

function calendar_shortcode() { ?>

    <div class='calendar-box-add-event'>
        <div class='calendar-box-add-event-wrapper'>
            <div style="display: table;">
                <button type="button" id='calendar-btn-add-event' class='fc-event-button fc-button fc-button-primary'>Add event</button>
            </div>

            <label>Title of the event</label>
            <textarea cols="100" id='event-title-textarea' class='form-control'></textarea>
            <label>Start date of the event</label>
            <textarea cols="100" id='event-start-date-textarea' class='form-control' data-toggle='datepicker-start'></textarea>
            <label>End date of the event</label>
            <textarea cols="100" id='event-end-date-textarea' class='form-control' data-toggle='datepicker-end'></textarea>
            <label>Detail of the event</label>
            <textarea cols="100" rows="5" id='event-detail-textarea' class='form-control'></textarea>

        </div>
    </div>
    <div id='calendar-container'>
        <div id='calendar'></div>
    </div>

<?php }

add_shortcode('calendar-shortcode', 'calendar_shortcode');

?>