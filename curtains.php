<?php
/*
 * Plugin Name: Curtains
 * Plugin URI:  http://www.github.com/wikitopian/curtains
 * Description: Curtains Opening Animation with jQuery
 * Version:     0.1.0
 * Author:      @wikitopian
 * Author URI:  http://www.github.com/wikitopian
 * License:     GPLv2
 */

require_once 'Wordpress-Timthumb-alternative/resize.php';

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
			'count'       => 3,
			'width'       => 200,
			'height'      => 200,
			'post_type'   => 'post',
			'taxonomy'    => 'category',
			'category'    => 0,
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
	public function do_shortcode( $atts ) {

		extract(
			shortcode_atts(
				array(
					'description' => $this->options['description'],
					'count'       => $this->options['count'],
					'width'       => $this->options['width'],
					'height'      => $this->options['height'],
					'post_type'   => $this->options['post_type'],
					'taxonomy'    => $this->options['taxonomy'],
					'category'    => $this->options['category'],
				),
				$atts
			)
		);

		$this->do_dimensions( $count, $width, $height );

		$items = $this->get_items(
			$post_type,
			$taxonomy,
			$category,
			$count,
			$width,
			$height
		);

		$content = '';
		foreach( $items as $url => $image ) {
			$content .= "<a href=\"{$url}\">\n";
			$content .= "<img src=\"{$image['url']}\" ";
			$content .= "alt=\"{$image['title']}\" ";
			$content .= "title=\"{$image['title']}\" ";
			$content .= "width=\"{$image['width']}\" height=\"{$image['height']}\" />\n";
			$content .= "</a>\n";
		}

		return $this->do_curtains( $items, $description, $content );
	}
	public function do_dimensions( $count, $width, $height ) {
		wp_localize_script(
			$this->prefix,
			$this->prefix,
			array(
				'image_width' => $width,
				'width'       => $width * $count,
				'height'      => $height,
				'count'       => $count,
			)
		);
	}
	public function get_items(
		$post_type,
		$taxonomy,
		$category,
		$count,
		$width,
		$height
	) {
		$items_posts = get_posts(
			array(
				'numberposts' => $count,
				'post_type'   => $post_type,
				'taxonomy'    => $taxonomy,
				'category'    => $category,
				'meta_key'    => '_thumbnail_id', // thumbnail required
			)
		);

		$items = array();
		foreach( $items_posts as $items_post_key => $item_post ) {
			$permalink = get_permalink( $item_post->ID );
			$thumbnail = wp_get_attachment_image_src( $item_post->_thumbnail_id, 'full' );
			$thumbnail = matthewruddy_image_resize( $thumbnail[0], $width, $height );
			$thumbnail['title'] = $item_post->post_title;
			$items[$permalink] = $thumbnail;
		}

		return $items;
	}
	public function do_curtains( $items, $description, $content ) {

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
<div class='curtain_content'>
<!-- YOUR CONTENT HERE -->
{$content}
<!-- END YOUR CONTENT -->
</div>
<!-- END THE CONTENT DIV -->

<!-- START DESCRIPTION DIV, WHICH WILL BE SHOWN ON TOP OF THE CURTAIN AND REMOVED WHEN THE CURTAINS OPEN -->
<div class='curtain_description'>
{$description}
</div>
<!-- END DESCRIPTION DIV -->

</div>
<!--END THE WRAPPER-->

HTML;
		return $curtains;
	}
}
$curtains = new Curtains();

?>
