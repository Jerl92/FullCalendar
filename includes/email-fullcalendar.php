<?php

// define the wp_mail_failed callback 
function action_wp_mail_failed($wp_error) 
{
    return error_log(print_r($wp_error, true));
}
          
// add the action 
// add_action('wp_mail_failed', 'action_wp_mail_failed', 10, 1);

function ns_email( $to_email, $subject, $email_subhead, $message, $reply_to_email = '' ) {
    
    if( empty($to_email) || empty($subject) || empty($email_subhead) || empty($message) )
        return;

    ob_start();
    // ns_get_template_part( 'content-email.php' );
    $email_content  = ob_get_clean();
    $email_content  = $message;

    $sender         = get_bloginfo( 'name' );
    $from_email     = 'noreply@yourdomain.dom'; //noreply@yourdomain.dom
    $reply_to_email = ! empty($reply_to_email) ? $reply_to_email : $from_email;

    $headers        = "From: ". $sender ." <". $from_email .">\r\n";
    $headers        .= "Reply-To: ". $reply_to_email ."\r\n";
    $headers        .= "MIME-Version: 1.0\r\n";
    $headers        .= "Content-Type: text/html; charset=UTF-8";

    add_filter( 'wp_mail_content_type', 'nanosupport_mail_content_type' );

    echo $headers;

    //send the email
    $ns_email = wp_mail( $to_email, $subject, $email_content, $headers );

    //to stop conflict
    remove_filter( 'wp_mail_content_type', 'nanosupport_mail_content_type' );

    //return true || false
    return $ns_email;
}

/**
 * Force HTML mail.
 * @return string HTML content type.
 * ------------------------------------------------------------------------------
 */
function nanosupport_mail_content_type() {
    return "text/html";
}

function svd_deactivate() {
    wp_clear_scheduled_hook( 'check_event' );
}
 
/*
add_action('init', function() {
    add_action( 'check_event', 'check_event_cron' );
    register_deactivation_hook( __FILE__, 'svd_deactivate' );
 
    if (! wp_next_scheduled ( 'check_event' )) {
        wp_schedule_event( time(), 'every_minute', 'check_event' );
    }
});
*/
 
function check_event_cron() {
    $args = array(
        'post_type' => 'events',
        'posts_per_page' => -1
    );
    
    $posts = get_posts( $args );
    
    foreach ($posts as $post) {
    
        $eventdate = get_post_meta( $post->ID, '_event_start_date', true);
        $eventnodifsend = get_post_meta( $post->ID, '_event_nodif_send', true);
        $eventnodifs = get_post_meta( $post->ID, '_event_other_nodification');
    
        $i = 0;
        $y = 0;
    
        print_r($eventnodifs);
    
        if ($eventnodifs) {
            foreach ($eventnodifs as $eventnodif_) {
                foreach ($eventnodif_ as $eventnodif) {
    
                $time = $eventnodif[0];
                $send = $eventnodif[1];
    
                $date = strtotime( $eventdate . '+' . $time);
    
                echo   date('H:i:s', strtotime( $eventdate . '+' . $time));
                echo ' - ';
    
                if ( $date <= strtotime(current_time( 'mysql' )) && $send === '0' ) {
                    $eventnodifs[$y][$i][1] = 1;
                    nanosupport_email_on_ticket_response($post->ID, $time, null);
                } 
    
                $i++;
                }
            $y++;
            }
        }
    
        print_r($eventnodifs);
    
        // delete_post_meta( $post->ID, '_event_other_nodification' );
        update_post_meta( $post->ID, '_event_other_nodification', $eventnodifs[0] );
    
        if (strtotime(current_time( 'mysql' )) >= strtotime($eventdate) ) {
            if ($eventnodifsend == null ) {
                nanosupport_email_on_ticket_response($post->ID, 'now', '1');
                update_post_meta( $post->ID, '_event_nodif_send', '1' );
            }
        }
    
        //delete_post_meta( $post->ID, '_event_nodif_send' );
    
    }
}

function nanosupport_email_on_ticket_response( $post_id, $time, $now ) {

    $author_id      = get_post_field( 'post_author', $post_id );
    $author_email   = get_the_author_meta( 'user_email', $author_id );
    $event_name     = get_the_title($post_id);

    if ($now = null) {

        // Don't send email on self-response
        $subject = sprintf ( esc_html__( '%s - Your event is now current', 'nanosupport' ), $event_name );

        $email_subhead = sprintf ( esc_html__( '%s - Your event is now current', 'nanosupport' ), $event_name );

        // Email Content
        $message = 'The event ' . $event_name . ' is now current';

    } else {

        // Don't send email on self-response
        $subject = sprintf ( esc_html__( '%s - Your event is starting in %s', 'nanosupport' ), $event_name, $time );

        $email_subhead = sprintf ( esc_html__( '%s - Your event is starting in %s', 'nanosupport' ), $event_name, $time  );

        // Email Content
        $message = 'The event ' . $event_name . ' is starting in ' . $time;

    }

    echo $author_email;

    // Send the email
    ns_email( $author_email, $subject, $email_subhead, $message );

}

?>