<?php
// Register Custom Vacancy
function custom_post_type_jobs() {
	$labels = array(
		'name'                  => 'Vacancies',
		'singular_name'         => 'Vacancy',
		'menu_name'             => 'Vacancies',
		'name_admin_bar'        => 'Vacancy',
		'archives'              => 'Vacancy Archives',
		'attributes'            => 'Vacancy Attributes',
		'parent_item_colon'     => 'Parent Vacancy:',
		'all_items'             => 'All Vacancys',
		'add_new_item'          => 'Add New Vacancy',
		'add_new'               => 'Add New',
		'new_item'              => 'New Vacancy',
		'edit_item'             => 'Edit Vacancy',
		'update_item'           => 'Update Vacancy',
		'view_item'             => 'View Vacancy',
		'view_items'            => 'View Vacancys',
		'search_items'          => 'Search Vacancy',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into item',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'Vacancys list',
		'items_list_navigation' => 'Vacancys list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Vacancy',
		'description'           => 'Jobs posted over from TROY',
		'labels'                => $labels,
		'supports'              => array('custom-fields', 'editor', 'title'),
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
		'menu_icon'				=> 'dashicons-welcome-learn-more',
		'taxonomies'			=> array('job_type','no_of_hours','sector')
	);
	register_post_type( 'vacancy', $args );
}
add_action( 'init', 'custom_post_type_jobs', 0 );

// Register Custom Taxonomy
function JobType() {

	$labels = array(
		'name'                       => 'Job Types',
		'singular_name'              => 'Job Type',
		'menu_name'                  => 'Job Type',
		'all_items'                  => 'All Job Types',
		'parent_item'                => 'Parent Job Type',
		'parent_item_colon'          => 'Parent Job Type:',
		'new_item_name'              => 'New Job Type Name',
		'add_new_item'               => 'Add New Job Type',
		'edit_item'                  => 'Edit Job Type',
		'update_item'                => 'Update Job Type',
		'view_item'                  => 'View Job Type',
		'separate_items_with_commas' => 'Separate items with commas',
		'add_or_remove_items'        => 'Add or remove items',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Job Types',
		'search_items'               => 'Search Job Types',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No items',
		'items_list'                 => 'Job Types list',
		'items_list_navigation'      => 'Job Types list navigation',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'JobType', array( 'vacancy' ), $args );

}
add_action( 'init', 'JobType', 0 );


function Industry() {

	$labels = array(
		'name'                       => 'Industry',
		'singular_name'              => 'Industry',
		'menu_name'                  => 'Industries',
		'all_items'                  => 'All Industries',
		'parent_item'                => 'Parent Industry',
		'parent_item_colon'          => 'Parent Industry:',
		'new_item_name'              => 'New Industry Name',
		'add_new_item'               => 'Add New Industry',
		'edit_item'                  => 'Edit Industry',
		'update_item'                => 'Update Industry',
		'view_item'                  => 'View Industry',
		'separate_items_with_commas' => 'Separate items with commas',
		'add_or_remove_items'        => 'Add or remove items',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Industries',
		'search_items'               => 'Search Industries',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No items',
		'items_list'                 => 'Industries list',
		'items_list_navigation'      => 'Industries list navigation',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'Industry', array( 'vacancy' ), $args );

}
add_action( 'init', 'Industry', 0 );