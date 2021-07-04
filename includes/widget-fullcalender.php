<?php
/**
 * calender Widget Class
 */
class calender_text_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function __construct() {
        parent::__construct( 'calender_text_widget', 'Calender events Widget' );
    }

    function calender_text_widget() {
        parent::WP_Widget(false, $name = 'Calender events Widget');	
    }
 
    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {	
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $url 	= $instance['url'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . '<a href="' . $url . '">' . $title . '</a>' . $after_title; ?>
                            <div id='calendar-container'>
                                <div id='calendar-events-widget'> <?php

                                    $args = array(
                                        'post_type' => 'events',
                                        'posts_per_page' => -1
                                    );

                                    $x = 0;
                                    $my_query = get_posts( $args );

                                    if ($my_query) {
                                        foreach ( $my_query as $post ) { 
                                            $eventdate = strtotime(get_post_meta( $post->ID, '_event_start_date', true)) + $x;
                                            $data[$eventdate] = array(
                                                "eventdate" => $eventdate,
                                                "postid" => $post->ID
                                            );
                                            $x++;
                                        }
                                       
                                    }
                                    
                                    ksort($data);  

                                    foreach ($data as $event) {
                                        $postid[] = $event['postid'];
                                    }

                                    $args_ = array(
                                        'post_type' => 'events',
                                        'posts_per_page' => -1,
                                        'post__in' => $postid,
                                        'orderby' => 'post__in'
                                    );

                                    $my_query_ = get_posts( $args_ );

                                    if ($my_query_) {

                                        $i = 0;
                                        $y = 0;

                                        $user = new \stdClass();
                                        $user->ID = false;

                                        if ( is_user_logged_in() ) {
                                            $user = wp_get_current_user();
                                        } else {
                                            $user->ID = "-1";
                                        }

                                        foreach ( $my_query_ as $post ) {
                                            $eventdate = strtotime(get_post_meta( $post->ID, '_event_start_date', true));
                                            $eventdateend = strtotime(get_post_meta( $post->ID, '_event_end_date', true));
                                            $now = strtotime(current_time( 'mysql' ));
                                            $diff = abs($eventdateend - $now);

                                            $event_color = get_post_meta( $post->ID, "_event_color", true );

                                            $years = floor($diff / (365*60*60*24));
                                            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                                            $other_user = get_post_meta( $post->ID, '_event_other_user');

                                            if ($other_user == null ) {
                                                $other_user[] = null;
                                            }

                                            foreach ( $other_user as $other_user_id ) {
                                                $other_user_id_array[] = $other_user_id;
                                            }

                                            if ($eventdateend >= $now && $now >= $eventdate) { ?>
                                                <?php if (in_array($user->ID, $other_user_id_array) || $post->post_author == $user->ID || get_post_meta( $post->ID, '_event_public', true) == "1") { ?>
                                                    <?php $i++; ?>

                                                    <?php if ($i == 1) { ?>
                                                        <span style="height:auto;overflow:auto;"><p style="margin: 0px;">Current Event :</p></span>
                                                    <?php } ?>

                                                    <div>
                                                        <a href="<?php echo esc_url( get_permalink($post->ID) ); ?>" style="color: <?php echo $event_color ?>"><?php echo $post->post_title ?></a>
                                                    </div>
                                                    <span>End: 
                                                        <?php echo date("F j, Y, g:i a", $eventdateend); ?>
                                                    </span>
                                                    </br></br>
                                                <?php } ?>
                                            <?php } ?>

                                        <?php } ?>

                                        <?php foreach ( $my_query_ as $post ) {
                                            $eventdate = strtotime(get_post_meta( $post->ID, '_event_start_date', true));
                                            $eventdateend = strtotime(get_post_meta( $post->ID, '_event_end_date', true));
                                            $now = strtotime(current_time( 'mysql' ));
                                            $diff = abs($eventdateend - $now);

                                            $event_color = get_post_meta( $post->ID, "_event_color", true );

                                            $years = floor($diff / (365*60*60*24));
                                            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                                            $other_user = get_post_meta( $post->ID, '_event_other_user');

                                            if ($other_user == null ) {
                                                $other_user[] = null;
                                            }

                                            foreach ( $other_user as $other_user_id ) {
                                                $other_user_id_array[] = $other_user_id;
                                            }

                                            if ($now < $eventdate) {
                                                if (in_array($user->ID, $other_user_id_array) || $post->post_author == $user->ID || get_post_meta( $post->ID, '_event_public', true) == "1") { ?>
                                                    <?php $y++; ?>

                                                    <?php if ($y == 1) { ?>
                                                        <span style="height:auto;"><p style="margin: 0px;">Upcomming Event :</p></span>
                                                    <?php } ?>

                                                    <div>
                                                        <a href="<?php echo esc_url( get_permalink($post->ID) ); ?>" style="color: <?php echo $event_color ?>"><?php echo $post->post_title ?></a>
                                                    </div>
                                                    <span> 
                                                        <?php echo date("F j, Y, g:i a", $eventdate); ?>
                                                    </span>
                                                    </br></br>
                                                <?php } ?>
                                            <?php }
                                        }

                                    }

                                ?> </div>
                            </div>
              <?php echo $after_widget; ?>
        <?php
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['url'] = strip_tags($new_instance['url']);
        return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {	
 
        $title 		= esc_attr($instance['title']);
        $url	= esc_attr($instance['url']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Calendar url'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
        </p>
        <?php 
    }
 
 
} // end class calender_widget
add_action( 'widgets_init', function(){	register_widget( 'calender_text_widget' );});
?>