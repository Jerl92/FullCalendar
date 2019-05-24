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
            'capability_type'       => 'page'
      )
    );
  }
  add_action( 'init', 'create_posttype_events' );


?>