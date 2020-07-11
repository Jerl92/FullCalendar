<?php
/**
 * calender Widget Class
 */
class calender_text_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
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

                                    $my_query = new WP_Query( $args );

                                    if ( $my_query->have_posts() ) {
                                        while ( $my_query->have_posts() ) {
                                            $my_query->the_post();
                                            $eventdate = strtotime(get_post_meta( get_the_ID(), '_event_start_date', true));
                                            $data[$eventdate] = array(
                                                "postid" => get_the_ID()
                                            );
                                        }

                                    // Reset the `$post` data to the current post in main query.
                                        wp_reset_postdata();
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

                                        foreach ( $my_query_ as $post ) { 
                                            $eventdate = strtotime(get_post_meta( $post->ID, '_event_start_date', true));
                                            $eventdateend = strtotime(get_post_meta( $post->ID, '_event_end_date', true));
                                            $now = strtotime(current_time( 'mysql' ));
                                            $diff = abs($eventdateend - $now);

                                            $event_color = get_post_meta( $post->ID, "_event_color", true );

                                            $years = floor($diff / (365*60*60*24));
                                            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                                            $user = wp_get_current_user();
                                            $other_user = get_post_meta( $post->ID, '_event_other_user');

                                            if ($other_user == null ) {
                                                $other_user[] = null;
                                            }

                                            if ($eventdateend >= $now && $now >= $eventdate) {

                                                $other_user_loop = 0;
                                                foreach ( $other_user as $other_user_id ) {

                                                    if (get_post_meta( $post->ID, '_event_public', true) == '0' && get_the_author_meta( 'id' ) == $user->ID || $other_user_id == $user->ID ) {

                                                        if ($other_user_loop == 0) { 

                                                            if ($i == 0 ) {
                                                                ?> <span style="height:auto;overflow:auto;"><p style="margin: 0px;">Current Event :</p></span> <?php
                                                            } ?>

                                                            <div>
                                                                <a href="<?php echo esc_url( get_permalink($post->ID) ); ?>" style="color: <?php echo $event_color ?>"><?php echo $post->post_title ?></a>
                                                            </div>
                                                            <span>Event end: 
                                                                <?php echo date("F j, Y, g:i a", $eventdateend); ?>
                                                            </span>
                                                            </br>
                                                            <span>Day left: 
                                                                <?php echo sprintf("%d years, %d months, %d days\n", $years, $months, $days); ?>
                                                            </span>
                                                            </br></br>

                                                            <?php $i++; ?>

                                                        <?php } ?>
                                                
                                                    <?php } elseif (get_post_meta( $post->ID, '_event_public', true) == '1') { ?>

                                                        <?php if ($other_user_loop == 0) { ?>

                                                            <?php if ($i == 0 ) {
                                                                ?> <span style="height:auto;overflow:auto;"><p style="margin: 0px;">Current Event :</p></span> <?php
                                                            } ?>

                                                            <div>
                                                                <a href="<?php echo esc_url( get_permalink($post->ID) ); ?>" style="color: <?php echo $event_color ?>"><?php echo $post->post_title ?></a>
                                                            </div>
                                                            <span>Event end: 
                                                                <?php echo date("F j, Y, g:i a", $eventdateend); ?>
                                                            </span>
                                                            </br>
                                                            <span>Day left: 
                                                                <?php echo sprintf("%d years, %d months, %d days\n", $years, $months, $days); ?>
                                                            </span>
                                                            </br></br>

                                                            <?php $i++; ?>

                                                        <?php } ?>

                                                    <?php } ?>

                                                    <?php $other_user_loop++; ?>

                                                <?php } ?>

                                            <?php } else if ($now < $eventdate) {

                                                $other_user_loop = 0;
                                                foreach ( $other_user as $other_user_id ) { 

                                                    if (get_post_meta( $post->ID, '_event_public', true) == '0' && get_the_author_meta( 'id' ) == $user->ID || $other_user_id == $user->ID ) {

                                                        if ($other_user_loop == 0) { 

                                                            if ($y == 0 ) {
                                                                ?> <span style="height:auto;"><p style="margin: 0px;">Upcomming Event :</p></span> <?php
                                                            } ?>

                                                            <div>
                                                                <a href="<?php echo esc_url( get_permalink($post->ID) ); ?>" style="color: <?php echo $event_color ?>"><?php echo $post->post_title ?></a>
                                                            </div>
                                                            <?php echo date("F j, Y, g:i a", $eventdate); ?>
                                                            </br></br>

                                                            <?php $y++; ?>

                                                        <?php } ?>

                                                    <?php } elseif (get_post_meta( $post->ID, '_event_public', true) == '1') { ?>
                                                    
                                                        <?php if ($other_user_loop == 0) { ?>

                                                            <?php if ($y == 0 ) {
                                                                ?> <span style="height:auto;"><p style="margin: 0px;">Upcomming Event :</p></span> <?php
                                                            } ?>

                                                            <div>
                                                                <a href="<?php echo esc_url( get_permalink($post->ID) ); ?>" style="color: <?php echo $event_color ?>"><?php echo $post->post_title ?></a>
                                                            </div>
                                                            <?php echo date("F j, Y, g:i a", $eventdate); ?>
                                                            </br></br>

                                                            <?php $y++; ?>

                                                        <?php } ?>

                                                    <?php } ?>
                                                    
                                                    <?php $other_user_loop++; ?>
                                                
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
add_action('widgets_init', create_function('', 'return register_widget("calender_text_widget");'));
?>