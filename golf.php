<?php
/**
 * @package PWG
 */
/*
Plugin Name: Golf: Play the World of Golf
Plugin URI: https://playtheworldatgolf.com/
Description: Play the world at golf
Version: 1.0
Requires at least: 5.0
Requires PHP: 5.2
Author: djhowdydoo
Author URI: https://playtheworldatgolf.com/wordpress-plugins/
License:
Text Domain: pwg
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there! Out of bounds, drop a shot!';
	exit;
}

// Define Constants
define( 'PWG__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Required files
require_once( PWG__PLUGIN_DIR . 'pwgGolfClub.php' );
require_once( PWG__PLUGIN_DIR . 'pwgGolfCourse.php' );
require_once( PWG__PLUGIN_DIR . '/inc/custom_posts.php' );

// Include files

// Register hooks
//register_activation_hook( __FILE__, array( 'Golf', 'plugin_activation' ) );
//register_deactivation_hook( __FILE__, array( 'Golf', 'plugin_deactivation' ) );

// add actions
add_action( 'admin_post_club_form_submission', ['pwgGolfClub','club_form_submission'] );

// Add filters



// Add Shortcodes
add_shortcode('pwg_display', 'pwg_golf_club');

function pwg_golf_club()

{
    $club_ID = 8;
    $golf_club =  new pwgGolfClub($club_ID);
    $golf_club->show_golf_club();
    $golf_club->show_scorcard();
    //$golf_club->show_golf_club_submission(); 
    //$golf_club->delete_golf_club(2);
    echo "<p>The Code to mess around with this shortcode is in golf.php</p>";
}

function plugin_activation()

{

}

function plugin_deactivation()

{

}

