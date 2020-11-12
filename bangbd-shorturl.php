<?php

/*
Plugin Name: Shorturl
Plugin URI: https://github.com/bangbuiduc
Description: Shorturl Plugin.
Version: 1.0
Author: bangbd
Author URI: https://github.com/bangbuiduc
License: A "Slug" license name e.g. GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 404 );
}

define( 'BS_PLUGIN_URL', plugins_url( 'bangbd-shorturl' ) );
define( 'BS_PLUGIN_ASSETS_URL', BS_PLUGIN_URL . '/assets' );
define( 'BS_PLUGIN_TABLE', 'bangbd_shorturl' );

function bs_active() {
	require_once 'includes/active.php';
}

register_activation_hook( __FILE__, 'bs_active' );

require_once 'includes/helpers.php';

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( $hook == 'toplevel_page_shorturl' ) {
		wp_enqueue_script( 'bs_custom_script', BS_PLUGIN_ASSETS_URL . '/js/bangbd-shorturl.js', array( 'jquery-core' ) );
		wp_enqueue_style( 'bs_bootstrap_style', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css' );
		wp_enqueue_style( 'bs_custom_style', BS_PLUGIN_ASSETS_URL . '/css/bangbd-shorturl.css' );
	}
} );

add_action( 'admin_menu', function () {
	add_menu_page( 'ShortUrl', 'ShortUrl', 'manage_options', 'shorturl',
		'bs_page' );
} );

function bs_page() {
	require_once 'templates/index.php';
}

//action create url
add_action( 'admin_action_bs_create_url', function () {
	$output = [ 'message' => '', 'url' => '' ];

	if ( ! isset( $_POST['_wpnonce'] )
	     || ! wp_verify_nonce( $_POST['_wpnonce'], 'bs-create-url' )
	) {
		$output['message'] = 'Sorry, your nonce did not verify.';
		bs_ajax_output( $output );
	}

	//$referer   = $_POST['_wp_http_referer'];
	$real_url  = $_POST['real_url'];
	$short_url = $_POST['short_url'];

	//kiem tra url da dc rut gon tu truoc chua
	$exists_url = bs_check_exists_url( $real_url );
	if ( $exists_url ) {
		$output['url'] = $exists_url;
		bs_ajax_output( $output );
	}
	//neu co $short_url kiem tra short url co bi trung khong
	$exists_url = bs_check_exists_short_url( $short_url );
	if ( $exists_url ) {
		$output['url'] = $exists_url;
		bs_ajax_output( $output );
	}
	//neu ko co $short_url thi tao $short_url
	$output['url'] = bs_create_short_url( $real_url, $short_url );
	bs_ajax_output( $output );
} );

function bs_create_short_url( $real_url, $short_url = '' ) {
	$all_url = bs_all_url();
	if ( ! $short_url ) {
		while ( $short_url == '' ) {
			$string = bs_generate_random_string();
			if ( ! isset( $all_url[ $string ] ) ) {
				$short_url = bs_generate_url( $string );
				break;
			}
		}
	}

	global $wpdb;
	$wpdb->insert( $wpdb->prefix . BS_PLUGIN_TABLE,
		[
			'short_url'  => $short_url,
			'real_url'   => $real_url,
			'user_id'    => get_current_user_id(),
			'created_at' => current_time( 'Y-m-d H:i:s' ),
		],
		[ '%s', '%s', '%d', '%s' ]
	);

	return bs_generate_url( $short_url );
}
//ajax get table view
