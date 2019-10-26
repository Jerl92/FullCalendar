<?php
/**
 * calender Widget Class
 */
class calender_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function calender_widget() {
        parent::WP_Widget(false, $name = 'calender Text Widget');	
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