<?php
/*
Plugin Name: dmkrtz ACF Remove Dashes
GitHub Plugin URI: dmkrtz/dmkrtz-acf-remove-dashes
Description: Removes Dashes from ACF fields in the frontend.
Version: 1.0.0
*/
register_activation_hook( __FILE__, 'child_plugin_activate' );
function child_plugin_activate(){

    // Require parent plugin
    if ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) && ! is_plugin_active( 'advanced-custom-fields/acf.php' )) {
        // Stop activation redirect and show error
        wp_die('Sorry, but this plugin requires ACF or ACF Pro installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}

/* ACF get rid of all dashes of sub-categories */
function acf_get_rid_of_dashes( $field ) {
	if($field['choices']) {
		$before = $field['choices'];
		
		$after = array();
		
		foreach($before as $k => $v) {
			preg_match('/\w+.*/', $v, $output);
			$after[$k] = $output[0];
		}
		
		$field['choices'] = $after;
	}
    return $field;
}
add_filter('acf/prepare_field', 'acf_get_rid_of_dashes', 20);