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
	private $options;

	public function __construct() {
		$this->prefix = 'curtains';

		add_action( 'init', array( &$this, 'set_options' ) );

		add_action( 'wp_enqueue_scripts', array( &$this, 'do_style' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'do_script' ) );

		add_shortcode( 'curtains', array( &$this, 'do_shortcode' ) );
	}
	public function set_options() {
		$defaults = array(
			'description' => '',
			'width'       => 400,
			'height'      => 300,
			'image-left'  => plugins_url( 'images/curtain-left.jpg', __FILE__ ),
			'image-right' => plugins_url( 'images/curtain-right.jpg', __FILE__ ),
		);
		$this->options = get_option( $this->prefix, $defaults );
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
	public function do_curtains( $description, $content, $width, $height ) {

		$image_left  = $this->options['image-left'];
		$image_right = $this->options['image-right'];

		$curtains = <<<HTML

<!--START THE WRAPPER-->
<div class='curtain_wrapper'>

	<!-- 2 CURTAIN IMAGES START HERE  -->
	<img class='curtain curtainLeft'   src='{$image_left}' />
	<img class='curtain curtainRight'  src='{$image_right}' />
    <!-- END IMAGES -->

    <!-- START THE CONTENT DIV -->
	<div class='content'>
		<!-- YOUR CONTENT HERE -->
		{$content}
	<!-- END YOUR CONTENT -->
    </div>
    <!-- END THE CONTENT DIV -->

    <!-- START DESCRIPTION DIV, WHICH WILL BE SHOWN ON TOP OF THE CURTAIN AND REMOVED WHEN THE CURTAINS OPEN -->
    <div class='description'>
		{$description}
    </div>
    <!-- END DESCRIPTION DIV -->

</div>
<!--END THE WRAPPER-->

HTML;
		return $curtains;
	}
	public function do_shortcode( $atts, $content = '' ) {
		do_shortcode( $content ); // recursion

		extract(
			shortcode_atts(
				array(
					'description' => $this->options['description'],
					'width'       => $this->options['width'],
					'height'      => $this->options['height'],
				),
				$atts
			)
		);

		return $this->do_curtains( $description, $content, $width, $height );
	}
}
$curtains = new Curtains();

?>
