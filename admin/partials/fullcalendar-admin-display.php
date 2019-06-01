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


function custom_meta_box_date($object)
{
wp_nonce_field(basename(__FILE__), "meta-box-nonce");
?>
    <div style="text-align: center;">
        <label>Start date and time of the event</label>
        <br>
        <?php $time_start = explode('T', get_post_meta($object->ID, "_event_start_date", true)); ?>
        <input name="event-start-date-textarea" type="text" id="event-start-date-textarea" data-toggle='datepicker-start-admin' value="<?php echo $time_start[0]; ?>" size="30">
        <input name="event-start-time" type="time" id="event-start-time" style="margin: 0;" value="<?php echo $time_start[1]; ?>">
        <br>
        <label>End date and time of the event</label>
        <br>
        <?php $time_end = explode('T', get_post_meta($object->ID, "_event_end_date", true)); ?>
        <input name="event-end-date-textarea" type="text" id="event-end-date-textarea" data-toggle='datepicker-end-admin' value="<?php echo $time_end[0]; ?>" size="30">
        <input name="event-end-time" type="time" id="event-end-time" style="margin: 0;" value="<?php echo $time_end[1]; ?>">
        <br>
        <label>Add other users to the event</label>
            <br>
            <?php 
                $users = get_users( array( 'fields' => array( 'ID' ) ) );
                $html[] .= "<select name='event-users[]' id='event-users' multiple>";
                foreach($users as $user_id){
                    if ( get_current_user_id() != $user_id->ID ) { 
                        $user_meta = get_post_meta( $object->ID, '_event_other_user', true);
                        $i = 0;
                        if ($user_meta) {
                            foreach ($user_meta as $user_data) {
                                if ($user_data == $user_id->ID) {
                                    $data = get_user_meta ( $user_id->ID );
                                    $html[] .= "<option selected value='$user_id->ID'>";
                                    $html[] .= $user_id->ID;
                                    $html[] .= " - ";
                                    $html[] .= $data['first_name'][0];
                                    $html[] .= " ";
                                    $html[] .= $data['last_name'][0];
                                    $html[] .= "</option>";
                                    $i++;
                                }
                            }
                            if ($i == 0){
                                $data = get_user_meta ( $user_id->ID );
                                $html[] .= "<option value='$user_id->ID'>";
                                $html[] .= $user_id->ID;
                                $html[] .= " - ";
                                $html[] .= $data['first_name'][0];
                                $html[] .= " ";
                                $html[] .= $data['last_name'][0];
                                $html[] .= "</option>";
                                $i++;  
                            }
                        } elseif ($i == 0){
                            $data = get_user_meta ( $user_id->ID );
                            $html[] .= "<option value='$user_id->ID'>";
                            $html[] .= $user_id->ID;
                            $html[] .= " - ";
                            $html[] .= $data['first_name'][0];
                            $html[] .= " ";
                            $html[] .= $data['last_name'][0];
                            $html[] .= "</option>";
                            $i++; 
                        }
                    }
                } 
                $html[] .= "</select>";
                $arr = implode("", $html);
                echo $arr;
            ?>
    </div>

<?php  
}

function add_date_meta_box()
{
    add_meta_box("date-meta-box", "Event date and time", "custom_meta_box_date", "events", "normal", "low", null);
}
add_action("add_meta_boxes", "add_date_meta_box");

function save_date_meta_box($post_id, $post, $update) {
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
    return $post_id;
    if(!current_user_can("edit_post", $post_id))
        return $post_id;
    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;
    $slug = "events";
    if($slug != $post->post_type)
        return $post_id;
    if( ! isset( $_POST['event-start-date-textarea'] ) )
    return; 
    if( ! isset( $_POST['event-end-date-textarea'] ) )
    return; 

    if ( $_POST['event-end-time'] == '' ) {
        $post_time_start = $_POST['event-start-date-textarea'] . 'T' . $_POST['event-start-time'];
        $post_time_end = $_POST['event-end-date-textarea'];
    }

    if ( $_POST['event-start-time'] == '' ) {
        $post_time_start = $_POST['event-start-date-textarea'];
        $post_time_end = $_POST['event-end-date-textarea'] . 'T' . $_POST['event-end-time'];
    } 

    if ( $_POST['event-start-time'] == '' && $_POST['event-end-time'] == '' ) {
        $post_time_start = $_POST['event-start-date-textarea'];
        $post_time_end = $_POST['event-end-date-textarea'];
    }

    if ( $_POST['event-start-time'] != '' && $_POST['event-end-time'] != '' ) {
        $post_time_start = $_POST['event-start-date-textarea'] . 'T' . $_POST['event-start-time'];
        $post_time_end = $_POST['event-end-date-textarea'] . 'T' . $_POST['event-end-time'];
    }
    
    update_post_meta( $post_id, "_event_start_date", $post_time_start );
    update_post_meta( $post_id, "_event_end_date", $post_time_end );

    $select_user = array_map('intval', $_POST['event-users']);

    if($_POST['event-users'] != null){
        foreach ( $_POST['event-users'] as $user_id ) {
            $user_meta = get_post_meta( $post_id, '_event_other_user', true );
            if ($user_meta == null) {
                add_post_meta( $post_id, '_event_other_user', [$user_id]);
            } else {
                $i = 0;
                foreach ($user_meta as $user_data) {
                    if ($user_data == $user_id) {
                        array_splice($user_meta, $i, 1);
                    }
                $i++;
                }
                array_push( $user_meta, $user_id );
                update_post_meta( $post_id, '_event_other_user', $user_meta );
            }
            
        }
    } else {
        delete_post_meta( $post_id, '_event_other_user');
    }
}
add_action("save_post", "save_date_meta_box", 10, 3);

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
        $users = get_post_meta( $post->ID, '_event_other_user', true );
        foreach($users as $user_id){
            if ( get_current_user_id() != $user_id ) {
                $data = get_user_meta ( $user_id );
                echo $data['first_name'][0];
                echo " ";
                echo $data['last_name'][0];
                echo "<br>";
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
