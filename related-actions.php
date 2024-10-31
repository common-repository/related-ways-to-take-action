<?php

/*
Plugin Name: Related Ways to Take Action
Plugin URI: http://www.socialactions.com/labs
Description: The “Related Ways to Take Action” WordPress Plugin makes it super easy to connect your readers to ways to take action based on the content of your posts. The Plugin identifies the top three keywords for each post and then searches for related campaigns from from Change.org, GlobalGiving.com, Idealist.org, DonorsChoose.org, Kiva, Care2 and over twenty other social change websites. It then automatically loads the top three campaigns for those keywords at the bottom of each of your posts.
Version: 0.3
Author: Social Actions
Author URI: http://www.socialactions.com
*/

if ( !class_exists( 'raRequest' ) ) require_once( 'sa_request.php' );
if ( !class_exists( 'raKeywords' ) ) require_once( 'sa_keywords.php' );
if ( !class_exists( 'raWordPressCache' ) ) require_once( 'sa_cache.php' );

require_once( 'ra_body.php' );

register_activation_hook( __FILE__, 'ra_activate' );

add_action('admin_menu', 'ra_admin_menu');
add_filter( 'the_content', 'ra_display', 1002 );
add_action( 'wp_head',  'ra_get_style' );

?>
