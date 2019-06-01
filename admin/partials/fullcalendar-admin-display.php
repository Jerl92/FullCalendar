<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://jerl92.tk
 * @since      1.0.0
 *
 * @package    Fullcalendar
 * @subpackage Fullcalendar/admin/partials
 */

function my_edit_events_columns( $columns ) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __( 'Title' ),
        'author' => __( 'Author' ),
        'others_pepole' => __( 'Others Pepole' ),
        'start_date' => __( 'Start Date' ),
        'end_date' => __( 'End Date' ),
        'date' => __( 'Date' )
    );

    return $columns;
}
add_filter( 'manage_edit-events_columns', 'my_edit_events_columns' ) ;


////////////////////////////
//
//  Style for admin CPT events colums track
//  width 50px
//
///////////////////////////
function my_column_width() {

}
add_action('admin_head', 'my_column_width');

////////////////////////////
//
//  my_manage_events_columns( $column, $post_id )
//  events CPT admin colums, case
//
///////////////////////////
function my_manage_events_columns( $column, $post_id ) {
    global $post;

    switch( $column ) {

        case 'author' :
            echo the_author();
        break;

        case 'others_pepole' :
            $users = get_users( array( 'fields' => array( 'ID' ) ) );
            foreach($users as $user_id){
                $user_meta = get_user_meta( $user_id->ID, '_event_from_other', true);
                if ( $user_meta ) {
                    foreach( $user_meta as $post_id ) {
                        if ($post_id == $post->ID) {
                            if ( get_current_user_id() != $user_id->ID || get_current_user_id() == $user_id->ID ) {
                                $data = get_user_meta ( $user_id->ID );
                                echo $data['first_name'][0];
                                echo " ";
                                echo $data['last_name'][0];
                                echo "<br>";
                            }
                        }
                    }
                }
            }
        break;

        case 'start_date' :
            echo get_post_meta( $post->ID, '_event_start_date', true);
        break;

        case 'end_date' :
            echo get_post_meta( $post->ID, '_event_end_date', true);
        break;

        /* Just break out of the switch statement for everything else. */
        default :
        break;
    }
}
add_action( 'manage_events_posts_custom_column', 'my_manage_events_columns', 10, 2 );
?>
