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
	
	wp_register_script( 'wp-calander-ajax-add-user-events', $url . "js/ajax.calander.add.js", array( 'jquery' ), '1.0.0', true );
    wp_localize_script( 'wp-calander-ajax-add-user-events', 'add_user_calander_ajax_url', admin_url( 'admin-ajax.php' ) );
    wp_enqueue_script( 'wp-calander-ajax-add-user-events' );
}

/* AJAX action callback */
add_action( 'wp_ajax_get_user_events', 'get_user_events' );
add_action( 'wp_ajax_nopriv_get_user_events', 'get_user_events' );

function get_user_events($posts) {
	$posts  = array();

	if ( is_user_logged_in() ) {

		$args = array(
			'post_status'		=> 'publish',
			'post_type'			=> 'events',
			'post_author' 		=> get_current_user_id(),
			'posts_per_page'	=> -1
		);
		$posts = get_posts( $args );

		foreach( $posts as $post ) {
			
			if ( get_current_user_id() == $post->post_author) {
					
				$event_start_date = get_post_meta( $post->ID, '_event_start_date', true);

				$event_end_date = get_post_meta( $post->ID, '_event_end_date', true);

				$html[] = array('title'=>$post->post_title, 'url'=>get_permalink($post->ID), 'start'=>$event_start_date, 'end'=>$event_end_date);

			}

		}

		$user_meta = get_user_meta( get_current_user_id(), '_event_from_other', true);

		if ( $user_meta ) {
			foreach( $user_meta as $post_id ) {

				$post_user_meta = get_post( $post_id ); 

				if ( get_current_user_id() != $post_user_meta->post_author && $post_user_meta->post_status != 'trash') {
					
					$event_start_date = get_post_meta( $post_user_meta->ID, '_event_start_date', true);

					$event_end_date = get_post_meta( $post_user_meta->ID, '_event_end_date', true);
		
					$html[] = array('title'=>$post_user_meta->post_title, 'url'=>get_permalink($post_user_meta->ID), 'start'=>$event_start_date, 'end'=>$event_end_date);

				}
				
			}

		}

		return wp_send_json ( $html );

	}
}

/* AJAX action callback */
add_action( 'wp_ajax_add_user_events', 'add_user_events' );
add_action( 'wp_ajax_nopriv_add_user_events', 'add_user_events' );

function add_user_events($post) {
	$posts  = array();

	if ( is_user_logged_in() ) {
    
    	$data = $_POST['object_id'];

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

		if ($data[4]) {
			foreach ( $data[4] as $user_id ) {
				$user_meta = get_user_meta( $user_id, '_event_from_other', true);
				if (!$user_meta) {
					add_user_meta( $user_id, '_event_from_other', [$post_id] );
				} else {
					array_push( $user_meta, $post_id );
					update_user_meta( $user_id, '_event_from_other', $user_meta );
				}
				
			}
		}

		return wp_send_json ( $post_id );
        
	} 
}

?>