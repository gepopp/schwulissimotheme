<?php
  // Register Custom Taxonomy
function post_region() {

	$labels = array(
		'name'                       => _x( 'Regionen', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Region', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Regionen', 'text_domain' ),
		'all_items'                  => __( 'Alle Regionen', 'text_domain' ),
		'parent_item'                => __( '&Uuml;bergeordnete Regionen', 'text_domain' ),
		'parent_item_colon'          => __( '&Uuml;bergeordnete Region:', 'text_domain' ),
		'new_item_name'              => __( 'Neue Region', 'text_domain' ),
		'add_new_item'               => __( 'Neue Region zuf&uuml;gen', 'text_domain' ),
		'edit_item'                  => __( 'Region bearbeiten', 'text_domain' ),
		'update_item'                => __( 'speichern', 'text_domain' ),
		'view_item'                  => __( 'Region ansehen', 'text_domain' ),
		'separate_items_with_commas' => __( 'Regionen durch Kommas trennen', 'text_domain' ),
		'add_or_remove_items'        => __( 'Zuf&uuml;gen / Entfernen', 'text_domain' ),
		'choose_from_most_used'      => __( 'Meist verwendete', 'text_domain' ),
		'popular_items'              => __( 'Beliebte', 'text_domain' ),
		'search_items'               => __( 'Suchen', 'text_domain' ),
		'not_found'                  => __( 'Nicht gefunden', 'text_domain' ),
		'no_terms'                   => __( 'keine Regionen', 'text_domain' ),
		'items_list'                 => __( 'Regionen Liste', 'text_domain' ),
		'items_list_navigation'      => __( 'Regionen Naviagation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'post_region', array( 'post', 'schwulissimo_veranst' ), $args );

}
add_action( 'init', 'post_region', 0 );

// Register Custom Taxonomy
function cityguide_category() {

	$labels = array(
		'name'                       => _x( 'Cityguide Kategorien', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Cityguide Kategorie', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Cityguide Kategorien', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'cityguide_category', array( 'post_citygiude' ), $args );

}
add_action( 'init', 'cityguide_category', 0 );


function veranst_category() {

	$labels = array(
		'name'                       => _x( 'Veranstaltung Kategorien', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Veranstaltung Kategorie', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Veranstaltung Kategorien', 'text_domain' ),
		'all_items'                  => __( 'All Veranstaltungen', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'veranstaltung_category', array( 'schwulissimo_veranst' ), $args );

}
add_action( 'init', 'veranst_category', 0 );