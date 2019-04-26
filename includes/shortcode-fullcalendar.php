<?php

function calendar_shortcode() {
	
    echo "<div id='calendar-container'>";
        echo "<div id='calendar'></div>";
    echo "</div>";

}

add_shortcode('calendar-shortcode', 'calendar_shortcode');

?>