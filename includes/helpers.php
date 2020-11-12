<?php
function bs_ajax_output( $output ) {
	echo json_encode( $output );
	exit();
}

function bs_generate_random_string( $length = 6 ) {
	$characters       = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen( $characters );
	$randomString     = '';
	for ( $i = 0; $i < $length; $i ++ ) {
		$randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
	}

	return $randomString;
}

function bs_all_url( $list = false ) {
	static $cache;
	if ( ! empty( $cache ) ) {
		$results = $cache;
	} else {
		global $wpdb;
		$table   = $wpdb->prefix . BS_PLUGIN_TABLE;
		$sql     = "SELECT * FROM {$table} ORDER BY id DESC";
		$results = $wpdb->get_results( $sql );
	}

	return $cache = $list ? $results : wp_list_pluck( $results, 'real_url', 'short_url' );
}

function bs_get_by_id( $id ) {
	global $wpdb;
	$table = $wpdb->prefix . BS_PLUGIN_TABLE;
	$sql   = "SELECT short_url FROM {$table} WHERE id = {$id}";

	return $wpdb->get_var( $sql );
}

function bs_generate_url( $short_url ) {
	return get_home_url( null, $short_url );
}

function bs_check_exists_url( $real_url ) {
	if ( ! $real_url ) {
		return false;
	}
	$all_url   = bs_all_url();
	$short_url = array_search( $real_url, $all_url );
	if ( $short_url ) {
		return bs_generate_url( $short_url );
	}

	return false;
}

function bs_check_exists_short_url( $short_url ) {
	if ( ! $short_url ) {
		return false;
	}
	$all_url = bs_all_url();
	if ( isset( $all_url[ $short_url ] ) ) {
		return bs_generate_url( $short_url );
	}

	return false;
}