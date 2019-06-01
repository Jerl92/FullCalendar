<?php

function create_posttype_events() {
    register_post_type( 'events',
      array(
        'labels' => array(
          'name' => __( 'Calender events' ),
          'singular_name' => __( 'Event' )
        ),
            'rewrite' => array('slug' => 'events'),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,		
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'supports'      => array( 'title', 'page-attributes', 'editor'),
      )
    );
  }
  add_action( 'init', 'create_posttype_events' );

// force use of templates from plugin folder
function cpte_force_template( $template )
{	
	
	if( is_singular( 'events' ) ) {
        $template = plugin_dir_path( dirname( __FILE__ ) ) .'/templates/events-page-template.php';
	}
	
  return $template;
  
}
add_filter( 'template_include', 'cpte_force_template' );
?>