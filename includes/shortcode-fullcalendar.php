<?php

function calendar_shortcode() { ?>

<?php if ( is_user_logged_in() ) { ?>
    <div id="calendar-box-add-event" class='calendar-box-add-event'>
        <div class='calendar-box-add-event-wrapper'>
            <label>Title of the event</label>
            <br>
            <textarea cols="100" id='event-title-textarea' class='form-control'></textarea>
            <br>
            <br>
            <label>Start date and time of the event</label>
            <br>
            <textarea cols="100" id='event-start-date-textarea' class='form-control' data-toggle='datepicker-start'></textarea>
            <input type="time" id="event-start-time" style="margin: 0;">
            <br>
            <label>End date and time of the event</label>
            <br>
            <textarea cols="100" id='event-end-date-textarea' class='form-control' data-toggle='datepicker-end'></textarea>
            <input type="time" id="event-end-time" style="margin: 0;">
            <br>
            <label>Color of the event</label>
            <br>
            <input id="event-color" class="jscolor" value="3788d8">
            <br>
            <label>Add other users to the event</label>
            <br>
            <?php 
                $users = get_users( array( 'fields' => array( 'ID' ) ) );
                $html[] = "<select id='event-users' multiple>";
                foreach($users as $user_id){
                    if ( get_current_user_id() != $user_id->ID ) {
                        $data = get_user_meta ( $user_id->ID );
                        $html[] .= "<option value='$user_id->ID'>";
                        $html[] .= $user_id->ID;
                        $html[] .= " - ";
                        $html[] .= $data['first_name'][0];
                        $html[] .= " ";
                        $html[] .= $data['last_name'][0];
                        $html[] .= "</option>";
                    }
                } 
                $html[] .= "</select>";
                $arr = implode("", $html);
                echo $arr;
            ?>
            <br>
            <label>Detail of the event</label>
            <textarea rows="5" cols="100" id='event-detail-textarea' class='form-control-text-area'></textarea>     
            <br>
            <label>Public event</label>
            <input type="checkbox" name="public-event" id="public-event">
            <div style="display: table; padding-top: 15px;">
                <button type="button" id='calendar-btn-add-event' class='fc-event-button fc-button fc-button-primary'>Add event</button>
                <button type="button" id='calendar-btn-add-nodification' class='fc-event-button fc-button fc-button-primary' style="right: 15px; position: absolute;">Add email nodification</button>
            </div>
            <div id='nodification-container'>
                <li class="calendar-btn-add-nodification">
                    <input type="number" id="calendar-btn-add-nodification-time-hour" name="calendar-btn-add-nodification-time-hour" style="margin: 0;float: left;max-width: 25%;" value ="0"/>hours
                    <input type="number" id="calendar-btn-add-nodification-time-minute" name="calendar-btn-add-nodification-time-minute" style="margin: 0;;max-width: 25%;" value ="0"/>minutes
                </li>
            </div>
        </div>
    </div>
    <div id='calendar-container'>
        <div id='calendar'></div>
    </div>
<?php } else { ?>
    <div id="calendar-container">
        <div id="calendar-public"></div>
    </div>
<?php } ?>

<?php }

add_shortcode('calendar-shortcode', 'calendar_shortcode');
?>