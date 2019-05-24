<?php

function calendar_shortcode() { ?>
    
    <div id='calendar-btn-add-event-box' class='fc-event-button fc-button fc-button-primary'>Add event</div>

    <div class='calendar-box-add-event'>
        <div class='calendar-box-add-event-wrapper'>
            <div id='calendar-btn-add-event' class='fc-event-button fc-button fc-button-primary'>Add event</div>
            <br>
            <textarea id='event-title-textarea' class='form-control'></textarea>
            <textarea id='event-textarea' class='form-control' data-toggle='datepicker'></textarea>
        </div>
    </div>
    <div id='calendar-container'>
        <div id='calendar'></div>
    </div>

<?php }

add_shortcode('calendar-shortcode', 'calendar_shortcode');

?>