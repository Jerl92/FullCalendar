<?php
/**
 * calender Widget Class
 */
class calender_text_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function calender_text_widget() {
        parent::WP_Widget(false, $name = 'Calender events Text Widget');	
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
                                        
                                        ?> <div style="height:auto;overflow:auto;"><p style="margin-bottom: 0px;">Next event :</p><?php

                                        while ( $my_query->have_posts() ) {
                                            $my_query->the_post();
                                            $eventdate = strtotime(get_post_meta( get_the_ID(), '_event_start_date', true));
                                            $data[$eventdate] = array(
                                                "postid" => get_the_ID()
                                            );
                                        } 
                                        ?> </div> <?php

                                    // Reset the `$post` data to the current post in main query.
                                        wp_reset_postdata();
                                    }

                                    function sortevents( $a, $b ) {
                                        return strtotime($a["date"]) - strtotime($b["date"]);
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

                                        foreach ( $my_query_ as $post ) {
                                            $my_query->the_post();
                                            $eventdate = strtotime(get_post_meta( $post->ID, '_event_start_date', true));
                                            $now = strtotime('today GMT');

                                            if($now < $eventdate){ ?>
                                                <div style="color:<?php echo get_post_meta( $post->ID, '_event_color', true);  ?>">
                                                    <?php echo $post->post_title; ?>
                                                </div>
                                                <?php echo date("F j, Y, g:i a", $eventdate); ?>
                                                </br></br>

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

/**
 * calender Widget Class
 */
class calender_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function calender_widget() {
        parent::WP_Widget(false, $name = 'calender Widget');	
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
							<ul>
                                <h3>
                                    <div id='calendar-title'>
                                    </div>
                                </h3>
                                </br>
                                <div id='calendar-container'>
                                    <div id='calendar-widget'></div>
                                </div>
							</ul>
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
add_action('widgets_init', create_function('', 'return register_widget("calender_widget");'));
?>