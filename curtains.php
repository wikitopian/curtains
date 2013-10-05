<?php
/*
Plugin Name: Curtains
Plugin URI: http://www.github.com/wikitopian/curtains
Description: Curtains Opening Animation with jQuery
Version: 0.1.0
Author: @wikitopian
Author URI: http://www.github.com/wikitopian
License: GPLv2
 */

class Curtains {
	private $prefix;

	public function __construct() {
		$this->prefix = 'curtains';

		add_action( 'wp_enqueue_scripts', array( &$this, 'do_style' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'do_script' ) );
	}
	public function do_style() {
		wp_enqueue_style(
			$this->prefix,
			plugins_url( 'css/curtains.css', __FILE__ )
		);
	}
	public function do_script() {
		wp_enqueue_script(
			$this->prefix,
			plugins_url( 'js/curtains.js', __FILE__ ),
			'jquery',
			false,
			true
		);
	}
	public function do_curtains() {
		include_once 'inc/curtains-template.php';
	}
}
$curtains = new Curtains();

?>
