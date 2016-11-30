<?php
// Register Custom Post Type
function schwulissimo_veranstaltung_post_type() {

	$labels = array(
		'name'                  => _x( 'Veranstaltungen', 'Post Type General Name', 'schwulissimo' ),
		'singular_name'         => _x( 'Veranstaltung', 'Post Type Singular Name', 'schwulissimo' ),
		'menu_name'             => __( 'Veranstaltung', 'schwulissimo' ),
		'name_admin_bar'        => __( 'Veranstaltung', 'schwulissimo' ),
		'archives'              => __( 'Veranstaltung Archiv', 'schwulissimo' ),
		'parent_item_colon'     => __( 'Übergeordnete Veranstaltung', 'schwulissimo' ),
		'all_items'             => __( 'Alle Veranstaltungen', 'schwulissimo' ),
		'add_new_item'          => __( 'Neue Veranstaltung', 'schwulissimo' ),
		'add_new'               => __( 'Hinzuf&uuml;gen', 'schwulissimo' ),
		'new_item'              => __( 'Neue Veranstaltung', 'schwulissimo' ),
		'edit_item'             => __( 'Veranstaltung bearbeiten', 'schwulissimo' ),
		'update_item'           => __( 'Veranstaltung speichern', 'schwulissimo' ),
		'view_item'             => __( 'Veranstaltung ansehen', 'schwulissimo' ),
		'search_items'          => __( 'Suchen', 'schwulissimo' ),
		'not_found'             => __( 'Nichts gefunden', 'schwulissimo' ),
		'not_found_in_trash'    => __( 'Nichts gefunden', 'schwulissimo' ),
		'featured_image'        => __( 'Titelbild', 'schwulissimo' ),
		'set_featured_image'    => __( 'Set featured image', 'schwulissimo' ),
		'remove_featured_image' => __( 'Remove featured image', 'schwulissimo' ),
		'use_featured_image'    => __( 'Use as featured image', 'schwulissimo' ),
		'insert_into_item'      => __( 'Insert into item', 'schwulissimo' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'schwulissimo' ),
		'items_list'            => __( 'Items list', 'schwulissimo' ),
		'items_list_navigation' => __( 'Items list navigation', 'schwulissimo' ),
		'filter_items_list'     => __( 'Filter items list', 'schwulissimo' ),
	);
	$args = array(
		'label'                 => __( 'Veranstaltung', 'schwulissimo' ),
		'description'           => __( 'Veranstaltugnen', 'schwulissimo' ),
		'labels'                => $labels,
		'supports'              => array( 'title','editor', 'thumbnail', 'author', 'revisions', 'comments', 'excerpt'),
		'taxonomies'            => array( 'category', 'post_tag', ' post_region' ),
		'hierarchical'          => false,
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
		'capability_type'       => 'page',
                'rewrite'               => array('slug' => 'veranstaltungen')
	);
	register_post_type( 'schwulissimo_veranst', $args );

}
add_action( 'init', 'schwulissimo_veranstaltung_post_type', 0 );