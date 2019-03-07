<?php
/*
Plugin Name:       Knoppys WP - Logic Melon XML Integration
Plugin URI:        https://github.com/knoppys/
Description:       This plugin will feed your Logic Melon XML feed into a custom post type and display on the front end of your website. 
Version:           1
Author:            Knoppys Digital Limited
License:           GNU General Public License v2
License URI:       http://www.gnu.org/licenses/gpl-2.0.html
GitHub Plugin URI: https://github.com/knoppys/knoppys-wp-melon.git
GitHub Branch:     master
*/
/***************************
*Load Native & Custom wordpress functionality plugin files. 
****************************/ 
foreach ( glob( dirname( __FILE__ ) . '*.php' ) as $root ) {
    require $root;
}
foreach ( glob( dirname( __FILE__ ) . '/inc/*.php' ) as $root ) {
    require $root;
}


// Run the vacancy update when someone loads the home page
function knoppys_vacancy_update() {

	if(is_home() || is_page('home')){
		melon_vacancies();
		vacancies_clean_up();				
	}

}
add_action('wp', 'knoppys_vacancy_update');

/*Page for testing*/
add_action( 'admin_menu', 'my_plugin_menu' );
function my_plugin_menu() {
	add_options_page( 'Logic Melon XML', 'Logic Melon XML', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
}
function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo status_report();
}
