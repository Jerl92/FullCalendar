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
			$html[] = array('title'=>$post->post_title, 'start'=>$post->post_content);
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
		'post_content' => $data[1],
		'post_status' => 'publish',
		'post_author' => get_current_user_id(),
		'post_type' => 'events'
		);

		$post_id = wp_insert_post($new_post);

		return wp_send_json ( $post_id );
        
	} 
}

?>