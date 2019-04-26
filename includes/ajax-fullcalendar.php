<?php

/* Enqueue Script */
add_action( 'wp_enqueue_scripts', 'wp_playlist_ajax_scripts' );

/**
 * Scripts
 */
function wp_playlist_ajax_scripts() {
	/* Plugin DIR URL */
	$url = trailingslashit( plugin_dir_url( __FILE__ ) );
	//
    wp_register_script( 'wp-calander-ajax-get-user-events', $url . "js/ajax.calander.get.js", array( 'jquery' ), '1.0.0', true );
    wp_localize_script( 'wp-calander-ajax-get-user-events', 'get_user_calander_ajax_url', admin_url( 'admin-ajax.php' ) );
    wp_enqueue_script( 'wp-calander-ajax-get-user-events' );
}

/* 3. AJAX CALLBACK
------------------------------------------ */
/* AJAX action callback */
add_action( 'wp_ajax_get_user_events', 'get_user_events' );
add_action( 'wp_ajax_nopriv_get_user_events', 'get_user_events' );

function get_user_events($post) {
		$posts  = array();
		if ( is_user_logged_in() ) {

			// Function call with passing the start date and end date 
			$Dates = getDatesFromRange('2019-04-15', '2019-04-26'); 
			$i = 0;

			foreach ($Dates as $date) {
				$html[] = array('title'=>'Day ' . $i, 'start'=>$date);
				$i++;
			}

			return wp_send_json ( $html );	 
		} 
}	

?>