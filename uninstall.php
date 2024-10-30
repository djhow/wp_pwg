<?php
/**
 * Trigger this file on uninstall
 * 
 * @package PWG
 */

if (! defined( 'WP_UNINSTALL_PLUGIN' )) {
    die;
}

// clear database stored plugin data
// access the database via SQL
global $wpdb;
//delete golfclubs

/*
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'golfclub" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );

//delete golfcourses
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'golfcourse" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );

//delete scorecards
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'scorecards" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );

//delete holes
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'holes" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );
*/