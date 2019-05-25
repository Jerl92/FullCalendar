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
            <label>Add other users to the event</label>
            <br>
            <?php 
                $users = get_users( array( 'fields' => array( 'ID' ) ) );
                $html[] .= "<select id='event-users' multiple>";
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
        </div>
    </div>
    <div id='calendar-container'>
        <div id='calendar'></div>
    </div>

<?php }

add_shortcode('calendar-shortcode', 'calendar_shortcode');

?>