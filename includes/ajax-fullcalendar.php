<?php

/* Enqueue Script */
add_action( 'wp_enqueue_scripts', 'wp_playlist_ajax_scripts' );

/**
 * Scripts
 */
function wp_playlist_ajax_scripts() {
	/* Plugin DIR URL */
	$url = trailingslashit( plugin_dir_url( __FILE__ ) );
	
    wp_register_script( 'wp-calander-ajax-get-user-events', $url . "js/ajax.calander.get.js", array( 'jquery' ), '1.0.0', true );
    wp_localize_script( 'wp-calander-ajax-get-user-events', 'get_user_calander_ajax_url', admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'wp-calander-ajax-get-user-events' );
	
	wp_register_script( 'wp-calander-ajax-add-user-events', $url . "js/ajax.calander.add.js", array( 'jquery' ), '1.0.0', true );
    wp_localize_script( 'wp-calander-ajax-add-user-events', 'add_user_calander_ajax_url', admin_url( 'admin-ajax.php' ) );
    wp_enqueue_script( 'wp-calander-ajax-add-user-events' );
}

/* AJAX action callback */
add_action( 'wp_ajax_get_user_events', 'get_user_events' );
add_action( 'wp_ajax_nopriv_get_user_events', 'get_user_events' );

function get_user_events($posts) {
	$posts  = array();

	$args = array(
		'post_status'		=> 'publish',
		'post_type'			=> 'events',
		'posts_per_page'	=> -1
	);
	$posts = get_posts( $args );

	foreach( $posts as $post ) {

		if ( is_user_logged_in() ) {
		
			if ( get_current_user_id() == $post->post_author) {
					
				$event_start_date = get_post_meta( $post->ID, '_event_start_date', true);

				$event_end_date = get_post_meta( $post->ID, '_event_end_date', true);

				$event_color = get_post_meta( $post->ID, '_event_color', true);

				$html[] = array('title'=>$post->post_title, 'url'=>get_permalink($post->ID), 'start'=>$event_start_date, 'end'=>$event_end_date, 'color'=>$event_color);

			}

			$user_meta = get_post_meta( $post->ID, '_event_other_user', true );

			foreach ($user_meta as $user_id) {

				if ( get_current_user_id() == $user_id && $post->post_status != 'trash') {
					
					$event_start_date = get_post_meta( $post->ID, '_event_start_date', true);

					$event_end_date = get_post_meta( $post->ID, '_event_end_date', true);

					$event_color = get_post_meta( $post->ID, '_event_color', true);
		
					$html[] = array('title'=>$post->post_title, 'url'=>get_permalink($post->ID), 'start'=>$event_start_date, 'end'=>$event_end_date, 'color'=>$event_color);

				}


			}

		} else {

			if (get_post_meta( $post->ID, '_event_public', true) == 1) {

				$event_start_date = get_post_meta( $post->ID, '_event_start_date', true);

				$event_end_date = get_post_meta( $post->ID, '_event_end_date', true);

				$event_color = get_post_meta( $post->ID, '_event_color', true);

				$html[] = array('title'=>$post->post_title, 'url'=>get_permalink($post->ID), 'start'=>$event_start_date, 'end'=>$event_end_date, 'color'=>$event_color);

			}

		}

	}

	return wp_send_json ( $html );

}

/* AJAX action callback */
add_action( 'wp_ajax_add_user_events', 'add_user_events' );
add_action( 'wp_ajax_nopriv_add_user_events', 'add_user_events' );

function add_user_events($post) {
	$posts  = array();

	if ( is_user_logged_in() ) {
    
		$data = $_POST['object_id'];
		
		if ( $data[1] != '' ) {

			$new_post = array(
			'post_title' => $data[0],
			'post_content' => $data[3],
			'post_status' => 'publish',
			'post_author' => get_current_user_id(),
			'post_type' => 'events'
			);

			$post_id = wp_insert_post($new_post);

			add_post_meta( $post_id, '_event_start_date', $data[1] );

			add_post_meta( $post_id, '_event_end_date', $data[2] );

			add_post_meta( $post_id, '_event_color', $data[4] );

			if ($data[5] == "1") {
				add_post_meta( $post_id, '_event_public', '1' );
			} else {
				add_post_meta( $post_id, '_event_public', '0' );
			}
			
			add_post_meta( $post_id, '_event_other_user', $data[6] );

		} else {
			return wp_send_json ( null );
		}

		return wp_send_json ( $data );
        
	} 
}

?>