<?php

include_once('/var/www/jerl92.ca/wp-blog-header.php');

// define the wp_mail_failed callback 
function action_wp_mail_failed($wp_error) 
{
    return error_log(print_r($wp_error, true));
}
          
// add the action 
add_action('wp_mail_failed', 'action_wp_mail_failed', 10, 1);

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

$args = array(
    'post_type' => 'events',
    'posts_per_page' => -1
);

$posts = get_posts( $args );

foreach ($posts as $post) {

    $eventdate = strtotime(get_post_meta( $post->ID, '_event_start_date', true));
    $eventnodifsend = get_post_meta( $post->ID, '_event_nodif_send', true);

    if (strtotime(current_time( 'mysql' )) >= $eventdate ) {
        if ($eventnodifsend == null ) {
            nanosupport_email_on_ticket_response($post->ID);
            add_post_meta( $post->ID, '_event_nodif_send', '1' );
        }
    }

    //delete_post_meta( $post->ID, '_event_nodif_send' );

}

function nanosupport_email_on_ticket_response( $post_id ) {

    $author_id      = get_post_field( 'post_author', $post_id );
    $author_email   = get_the_author_meta( 'user_email', $author_id );
    $event_name     = get_the_title();

    // Don't send email on self-response
    $subject = sprintf ( esc_html__( 'Your event is now current  — %s', 'nanosupport' ), $event_name );

    $email_subhead = sprintf ( esc_html__( 'Your event is now current — %s', 'nanosupport' ), $event_name );

    // Email Content
    $message = 'The event ' . $event_name . ' is now current';

    echo $author_email;

    // Send the email
    ns_email( $author_email, $subject, $email_subhead, $message );

}

?>