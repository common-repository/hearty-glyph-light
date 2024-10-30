<?php

/**
*   Plugin Name: Hearty Glyph Light
*   Plugin URI: http://www.heartyplugins.com/hearty-glyph-light
*   Description: Hearty Glyph Light is a free responsive WordPress plugin that uses any icon from Font Awesome and assigns it a short description and a title
*   Version: 1.1
*   Author: Hearty Plugins
*   Author URI: http://www.heartyplugins.com
*   License: http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
*/

// no direct access

if (!defined('ABSPATH')) { die; }

function heartyglyphlight_add_css() {

	//------

	wp_register_style('hrty-bootstrap-css', plugins_url('/theme/bootstrap/hrty-bootstrap.css', __FILE__));
	wp_register_style('hrty-fontawesome-css', '//use.fontawesome.com/releases/v5.0.13/css/all.css');

	wp_register_style('heartyglyphlight-css', plugins_url('/theme/css/frontend.css', __FILE__));

	//------

	wp_enqueue_style('hrty-bootstrap-css');
	wp_enqueue_style('hrty-fontawesome-css');

  wp_enqueue_style('heartyglyphlight-css');

}

function heartyglyphlight_add_admin_css() {

	wp_register_style('hrty-bootstrap-css', plugins_url('/theme/bootstrap/hrty-bootstrap.css', __FILE__));
	wp_register_style('hrty-fontawesome-css', '//use.fontawesome.com/releases/v5.0.13/css/all.css');
	wp_register_style('heartyglyphlight-admin-css', plugins_url('/theme/css/admin.css', __FILE__));

  wp_enqueue_style('hrty-bootstrap-css');
  wp_enqueue_style('hrty-fontawesome-css');
	wp_enqueue_style('heartyglyphlight-admin-css');

	// Add the color picker css file
  wp_enqueue_style( 'wp-color-picker' );

}

function heartyglyphlight_add_js() {

	wp_register_script('hrty-bootstrap-js', plugins_url('/theme/bootstrap/hrty-bootstrap.js', __FILE__), array('jquery'));
	wp_register_script('hrty-viewportchecker-js', plugins_url('/theme/js/viewportchecker/viewportchecker.js', __FILE__), array('jquery'));

	wp_enqueue_script('hrty-bootstrap-js');
	wp_enqueue_script('hrty-viewportchecker-js');

}

function heartyglyphlight_add_admin_js() {

	wp_enqueue_media();

	wp_register_script('hrty-bootstrap-js', plugins_url('/theme/bootstrap/hrty-bootstrap.js', __FILE__), array('jquery'));
	wp_register_script('heartycolorpicker-js', plugins_url('/theme/js/colorpicker.js', __FILE__), array('wp-color-picker'), false, true);
	wp_register_script('heartyglyphlight-admin-js', plugins_url('/theme/js/admin.js', __FILE__), array('jquery'));

	wp_enqueue_script('hrty-bootstrap-js');
	wp_enqueue_script('heartycolorpicker-js');
	wp_enqueue_script('heartyglyphlight-admin-js');

}

function heartyglyphlight($atts) {

	require_once('inc/view.php');

	$atts = shortcode_atts(array('settings_instance' => 1), $atts, 'heartyglyphlight');
	$settings_instance = $atts['settings_instance'];
	$output = HeartyGlyphLightView::generate_view($settings_instance);

	return $output;

}

function heartyglyphlight_widget() {

	require_once('inc/widget.php');

	register_widget('HeartyGlyphLightWidget');

}

if (is_admin()) {

	require_once('inc/options.php');
	$heartyglyphlight_settings_page = new HeartyGlyphLightSettingsPage();

	if (isset($_GET['page']) && $_GET['page'] == 'heartyglyphlight-setting-admin') {

		add_action('admin_enqueue_scripts', 'heartyglyphlight_add_admin_css');
		add_action('admin_enqueue_scripts', 'heartyglyphlight_add_admin_js');

	} else {

		add_action('widgets_init', 'heartyglyphlight_widget');

	}

} else {

	add_action('wp_enqueue_scripts', 'heartyglyphlight_add_css');
	add_action('wp_enqueue_scripts', 'heartyglyphlight_add_js');

	add_action('widgets_init', 'heartyglyphlight_widget');
	add_shortcode('heartyglyphlight', 'heartyglyphlight');

}

