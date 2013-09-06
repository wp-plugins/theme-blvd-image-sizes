<?php
/*
Plugin Name: Theme Blvd Image Sizes
Description: Adjust the image crop sizes in a Theme Blvd theme through your WordPress admin.
Version: 1.0.4
Author: Jason Bobich
Author URI: http://jasonbobich.com
License: GPL2
*/

/*
Copyright 2013 JASON BOBICH

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'TB_IMAGE_SIZES_PLUGIN_VERSION', '1.0.4' );
define( 'TB_IMAGE_SIZES_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'TB_IMAGE_SIZES_PLUGIN_URI', plugins_url( '' , __FILE__ ) );

/**
 * Register text domain for localization.
 *
 * @since 1.0.3
 */

function tb_image_sizes_textdomain() {
	load_plugin_textdomain( 'tb_image_sizes', false, TB_IMAGE_SIZES_PLUGIN_DIR . '/lang' );
}
add_action( 'plugins_loaded', 'tb_image_sizes_textdomain' );

/**
 * Display warning telling the user they must have a
 * theme with Theme Blvd framework v2.1+ installed in
 * order to run this plugin.
 *
 * @since 1.0.3
 */

function tb_image_sizes_warning() {
	echo '<div class="updated">';
	echo '<p>'.__( 'You currently have the "Theme Blvd Image Sizes" plugin activated, however you are not using a theme with Theme Blvd Framework v2.1+, and so this plugin will not do anything.', 'tb_image_sizes' ).'</p>';
	echo '</div>';
}

/*-----------------------------------------------------------------------------------*/
/* Setup Default Text Strings and Options
/*-----------------------------------------------------------------------------------*/

/**
 * Get defaults
 */

function tb_image_sizes_get_defaults() {

	global $_wp_additional_image_sizes;

	// Set widths/heights
	$defaults = array(
		'slider-large' => array(
			'width' => $_wp_additional_image_sizes['slider-large']['width'],
			'height' => $_wp_additional_image_sizes['slider-large']['height']
		),
		'slider-staged' => array(
			'width' => $_wp_additional_image_sizes['slider-staged']['width'],
			'height' => $_wp_additional_image_sizes['slider-staged']['height']
		),
		'grid_fifth_1' => array(
			'width' => $_wp_additional_image_sizes['grid_fifth_1']['width'],
			'height' => $_wp_additional_image_sizes['grid_fifth_1']['height']
		),
		'grid_3' => array(
			'width' => $_wp_additional_image_sizes['grid_3']['width'],
			'height' => $_wp_additional_image_sizes['grid_3']['height']
		),
		'grid_4' => array(
			'width' => $_wp_additional_image_sizes['grid_4']['width'],
			'height' => $_wp_additional_image_sizes['grid_4']['height']
		),
		'grid_6' => array(
			'width' => $_wp_additional_image_sizes['grid_6']['width'],
			'height' => $_wp_additional_image_sizes['grid_6']['height']
		),
		'tb_small' => array(
			'width' => $_wp_additional_image_sizes['tb_small']['width'],
			'height' => $_wp_additional_image_sizes['tb_small']['height']
		),
		'square_small' => array(
			'width' => $_wp_additional_image_sizes['square_small']['width'],
			'height' => $_wp_additional_image_sizes['square_small']['height']
		),
		'square_smaller' => array(
			'width' => $_wp_additional_image_sizes['square_smaller']['width'],
			'height' => $_wp_additional_image_sizes['square_smaller']['height']
		),
		'square_smallest' => array(
			'width' => $_wp_additional_image_sizes['square_smallest']['width'],
			'height' => $_wp_additional_image_sizes['square_smallest']['height']
		)
	);
	// Set crop modes
	foreach( $defaults as $id => $size ) {
		if( $_wp_additional_image_sizes[$id]['crop'] )
			$defaults[$id]['crop'] = 'true';
		else
			$defaults[$id]['crop'] = 'false';
	}
	return $defaults;
}

/**
 * Get Options to pass into Option Framework's function to generate form.
 */

function tb_image_sizes_get_options() {

	// Grab default values for current theme
	$defaults = tb_image_sizes_get_defaults();

	// Crop mode options
	$crop_modes = array(
		'true' => 'Hard Crop',
		'false' => 'Soft Crop'
	);

	/*-------------------------------------------------------*/
	/* Slider Images
	/*-------------------------------------------------------*/

	$options[] = array(
		'name' => __( 'Slider Images', 'tb_image_sizes' ),
		'type' => 'heading'
	);

	// Full-Width Slide Images

	$options[] = array(
		'name'	=> __( 'Full-Width Slide Images', 'tb_image_sizes' ),
		'desc'	=> __( '<p>This size applies to images used in full-width slides of your sliders. If your slider consists of only full-width image slides, this image size will <em>generally</em> determine the height.</p><p><strong>WARNING:</strong> When this size was originally created, it was targeted for the maximum size of a slider. This is imperative because sliders can get used in so many places with different widths within your current theme\'s responsive structure. So, for example, when you use the slider within the content of a 2-column page, the size will not actually be what you designate here, but will be shrinked down proportinally. Edit at your own risk!</p><p><strong>Internal ID:</strong> slider-large<br><strong>Current Image Size:</strong> '.$defaults['slider-large']['width'].'x'.$defaults['slider-large']['height'].'</p>', 'tb_image_sizes' ),
		'type' 	=> 'section_start'
	);
	$options[] = array(
		'name' 	=> __( 'Width', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a width in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'slider-large_width',
		'std' 	=> $defaults['slider-large']['width'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Height', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a height in pixels.' ),
		'id' 	=> 'slider-large_height',
		'std' 	=> $defaults['slider-large']['height'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Crop Mode', 'tb_image_sizes' ),
		'desc' 	=> __( 'Select the crop mode for this image size. We would advise that you do not change the crop mode for this image size. Click the <em>Help</em> tab above to learn more about crop modes.', 'tb_image_sizes' ),
		'id' 	=> 'slider-large_crop',
		'std' 	=> $defaults['slider-large']['crop'],
		'type' 	=> 'select',
		'options' => $crop_modes
	);
	$options[] = array(
		'type' => 'section_end'
	);

	// Staged Slide Images

	$options[] = array(
		'name'	=> __( 'Staged Slide Images', 'tb_image_sizes' ),
		'desc'	=> __( '<p>This size applies to images used in slides of your sliders with staged images (i.e. images aligned right or left). <em>Generally</em> when we design the height of the slider, we base it around the proportional size of the full-width slide image size from above. This staged image size can also vary from theme-to-theme depending on the theme\'s CSS stylings of the slider.</p><p><strong>WARNING:</strong> When this size was originally created, it was targeted for the maximum size of a slider and also designed to compensate both the theme\'s slider CSS along with the dimensions of the full-width slide image size from above. This is all imperative because sliders can get used in so many places with different widths within your current theme\'s responsive structure. So, for example, when you use the slider within the content of a 2-column page, the size will not actually be what you designate here, but will be shrinked down proportinally. This all makes editing this size even trickier than the full-width size above; so again, edit at your own risk!</p><p><strong>Internal ID:</strong> slider-staged<br><strong>Current Image Size:</strong> '.$defaults['slider-staged']['width'].'x'.$defaults['slider-staged']['height'].'</p>', 'tb_image_sizes' ),
		'type' 	=> 'section_start'
	);
	$options[] = array(
		'name' 	=> __( 'Width', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a width in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'slider-staged_width',
		'std' 	=> $defaults['slider-staged']['width'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Height', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a height in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'slider-staged_height',
		'std' 	=> $defaults['slider-staged']['height'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Crop Mode', 'tb_image_sizes' ),
		'desc' 	=> __( 'Select the crop mode for this image size. We would advise that you do not change the crop mode for this image size. Click the <em>Help</em> tab above to learn more about crop modes.', 'tb_image_sizes' ),
		'id' 	=> 'slider-staged_crop',
		'std' 	=> $defaults['slider-staged']['crop'],
		'type' 	=> 'select',
		'options' => $crop_modes
	);
	$options[] = array(
		'type' => 'section_end'
	);

	/*-------------------------------------------------------*/
	/* Grid Images
	/*-------------------------------------------------------*/

	$options[] = array(
		'name' => __( 'Grid Images', 'tb_image_sizes' ),
		'type' => 'heading'
	);

	// 1/5

	$options[] = array(
		'name'	=> __( '1/5 Columns', 'tb_image_sizes' ),
		'desc'	=> __( '<p>This size applies to images used in columns that are set as 1/5. Keep in mind that because of the responsive structure of your theme and the virtually infinite possibilities of setting up columns, your images of this size will rarely show at the the exact dimensions that you enter here. However, they will always be scaled proportionally to the dimensions you set here.</p><p><strong>Internal ID:</strong> grid_fifth_1<br><strong>Current Image Size:</strong> '.$defaults['grid_fifth_1']['width'].'x'.$defaults['grid_fifth_1']['height'].'</p>', 'tb_image_sizes' ),
		'type' 	=> 'section_start'
	);
	$options[] = array(
		'name' 	=> __( 'Width', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a width in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'grid_fifth_1_width',
		'std' 	=> $defaults['grid_fifth_1']['width'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Height', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a height in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'grid_fifth_1_height',
		'std' 	=> $defaults['grid_fifth_1']['height'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Crop Mode', 'tb_image_sizes' ),
		'desc' 	=> __( 'Select the crop mode for this image size. We would advise that you do not change the crop mode for this image size. Click the <em>Help</em> tab above to learn more about crop modes.', 'tb_image_sizes' ),
		'id' 	=> 'grid_fifth_1_crop',
		'std' 	=> $defaults['grid_fifth_1']['crop'],
		'type' 	=> 'select',
		'options' => $crop_modes
	);
	$options[] = array(
		'type' => 'section_end'
	);

	// 1/4

	$options[] = array(
		'name'	=> __( '1/4 Columns', 'tb_image_sizes' ),
		'desc'	=> __( '<p>This size applies to images used in columns that are set as 1/4. Keep in mind that because of the responsive structure of your theme and the virtually infinite possibilities of setting up columns, your images of this size will rarely show at the the exact dimensions that you enter here. However, they will always be scaled proportionally to the dimensions you set here.</p><p><strong>Internal ID:</strong> grid_3<br><strong>Current Image Size:</strong> '.$defaults['grid_3']['width'].'x'.$defaults['grid_3']['height'].'</p>', 'tb_image_sizes' ),
		'type' 	=> 'section_start'
	);
	$options[] = array(
		'name' 	=> __( 'Width', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a width in pixels.', 'tb_image_sizes'),
		'id' 	=> 'grid_3_width',
		'std' 	=> $defaults['grid_3']['width'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Height', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a height in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'grid_3_height',
		'std' 	=> $defaults['grid_3']['height'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Crop Mode', 'tb_image_sizes' ),
		'desc' 	=> __( 'Select the crop mode for this image size. We would advise that you do not change the crop mode for this image size. Click the <em>Help</em> tab above to learn more about crop modes.', 'tb_image_sizes' ),
		'id' 	=> 'grid_3_crop',
		'std' 	=> $defaults['grid_3']['crop'],
		'type' 	=> 'select',
		'options' => $crop_modes
	);
	$options[] = array(
		'type' => 'section_end'
	);

	// 1/3

	$options[] = array(
		'name'	=> __( '1/3 Columns', 'tb_image_sizes' ),
		'desc'	=> __( '<p>This size applies to images used in columns that are set as 1/3. Keep in mind that because of the responsive structure of your theme and the virtually infinite possibilities of setting up columns, your images of this size will rarely show at the the exact dimensions that you enter here. However, they will always be scaled proportionally to the dimensions you set here.</p><p><strong>Internal ID:</strong> grid_4<br><strong>Current Image Size:</strong> '.$defaults['grid_4']['width'].'x'.$defaults['grid_4']['height'].'</p>', 'tb_image_sizes' ),
		'type' 	=> 'section_start'
	);
	$options[] = array(
		'name' 	=> __( 'Width', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a width in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'grid_4_width',
		'std' 	=> $defaults['grid_4']['width'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Height', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a height in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'grid_4_height',
		'std' 	=> $defaults['grid_4']['height'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Crop Mode', 'tb_image_sizes' ),
		'desc' 	=> __( 'Select the crop mode for this image size. We would advise that you do not change the crop mode for this image size. Click the <em>Help</em> tab above to learn more about crop modes.', 'tb_image_sizes' ),
		'id' 	=> 'grid_4_crop',
		'std' 	=> $defaults['grid_4']['crop'],
		'type' 	=> 'select',
		'options' => $crop_modes
	);
	$options[] = array(
		'type' => 'section_end'
	);

	// 1/2

	$options[] = array(
		'name'	=> __( '1/2 Columns', 'tb_image_sizes' ),
		'desc'	=> __( '<p>This size applies to images used in columns that are set as 1/2. Keep in mind that because of the responsive structure of your theme and the virtually infinite possibilities of setting up columns, your images of this size will rarely show at the the exact dimensions that you enter here. However, they will always be scaled proportionally to the dimensions you set here.</p><p><strong>Internal ID:</strong> grid_6<br><strong>Current Image Size:</strong> '.$defaults['grid_6']['width'].'x'.$defaults['grid_6']['height'].'</p>', 'tb_image_sizes' ),
		'type' 	=> 'section_start'
	);
	$options[] = array(
		'name' 	=> __( 'Width', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a width in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'grid_6_width',
		'std' 	=> $defaults['grid_6']['width'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Height', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a height in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'grid_6_height',
		'std' 	=> $defaults['grid_6']['height'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Crop Mode', 'tb_image_sizes' ),
		'desc' 	=> __( 'Select the crop mode for this image size. We would advise that you do not change the crop mode for this image size. Click the <em>Help</em> tab above to learn more about crop modes.', 'tb_image_sizes' ),
		'id' 	=> 'grid_6_crop',
		'std' 	=> $defaults['grid_6']['crop'],
		'type' 	=> 'select',
		'options' => $crop_modes
	);
	$options[] = array(
		'type' => 'section_end'
	);

	/*-------------------------------------------------------*/
	/* Thumbnails
	/*-------------------------------------------------------*/

	$options[] = array(
		'name' => __( 'Thumbnails', 'tb_image_sizes' ),
		'type' => 'heading'
	);
	$options[] = array(
		'name'	=> __( 'Small Thumbnails', 'tb_image_sizes' ),
		'desc'	=> __( '<p>When you setup a standard Post List or you\'re dealing with single posts, and in your options you select to show "small thumbnails" this is the size that will get used. Unlike the other image sizes in this plugin, this image size will show the true image dimensions without scaling in most scenarios.</p><p><strong>Internal ID:</strong> small<br><strong>Current Image Size:</strong> '.$defaults['tb_small']['width'].'x'.$defaults['tb_small']['height'].'</p>', 'tb_image_sizes' ),
		'type' 	=> 'section_start'
	);
	$options[] = array(
		'name' 	=> __( 'Width', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a width in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'tb_small_width',
		'std' 	=> $defaults['tb_small']['width'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Height', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a height in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'tb_small_height',
		'std' 	=> $defaults['tb_small']['height'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Crop Mode', 'tb_image_sizes' ),
		'desc' 	=> __( 'Select the crop mode for this image size. This is generally the one soft-cropped image size we setup and it\'s definitely okay to change this to hard crop mode. Click the <em>Help</em> tab above to learn more about crop modes.', 'tb_image_sizes' ),
		'id' 	=> 'tb_small_crop',
		'std' 	=> $defaults['tb_small']['crop'],
		'type' 	=> 'select',
		'options' => $crop_modes
	);
	$options[] = array(
		'type' => 'section_end'
	);

	/*-------------------------------------------------------*/
	/* Small Square Images
	/*-------------------------------------------------------*/

	$options[] = array(
		'name' => __( 'Mini Thumbnails', 'tb_image_sizes' ),
		'type' => 'heading'
	);

	// Small

	$options[] = array(
		'name'	=> __( 'Small Square', 'tb_image_sizes' ),
		'desc'	=> __( '<p>When you\'re working with a Mini Post Grid or Mini Post List, this is the "small" choice.</p><p><strong>Internal ID:</strong> square_small<br><strong>Current Image Size:</strong> '.$defaults['square_small']['width'].'x'.$defaults['square_small']['height'].'</p>', 'tb_image_sizes' ),
		'type' 	=> 'section_start'
	);
	$options[] = array(
		'name' 	=> __( 'Width', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a width in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'square_small_width',
		'std' 	=> $defaults['square_small']['width'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Height', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a height in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'square_small_height',
		'std' 	=> $defaults['square_small']['height'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Crop Mode', 'tb_image_sizes' ),
		'desc' 	=> __( 'Select the crop mode for this image size. This is generally the one soft-cropped image size we setup and it\'s definitely okay to change this to hard crop mode. Click the <em>Help</em> tab above to learn more about crop modes.', 'tb_image_sizes' ),
		'id' 	=> 'square_small_crop',
		'std' 	=> $defaults['square_small']['crop'],
		'type' 	=> 'select',
		'options' => $crop_modes
	);
	$options[] = array(
		'type' => 'section_end'
	);

	// Smaller

	$options[] = array(
		'name'	=> __( 'Smaller Square', 'tb_image_sizes' ),
		'desc'	=> __( '<p>When you\'re working with a Mini Post Grid or Mini Post List, this is the "smaller" choice.</p><p><strong>Internal ID:</strong> square_smaller<br><strong>Current Image Size:</strong> '.$defaults['square_smaller']['width'].'x'.$defaults['square_smaller']['height'].'</p>', 'tb_image_sizes' ),
		'type' 	=> 'section_start'
	);
	$options[] = array(
		'name' 	=> __( 'Width', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a width in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'square_smaller_width',
		'std' 	=> $defaults['square_smaller']['width'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Height', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a height in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'square_smaller_height',
		'std' 	=> $defaults['square_smaller']['height'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Crop Mode', 'tb_image_sizes' ),
		'desc' 	=> __( 'Select the crop mode for this image size. This is generally the one soft-cropped image size we setup and it\'s definitely okay to change this to hard crop mode. Click the <em>Help</em> tab above to learn more about crop modes.', 'tb_image_sizes' ),
		'id' 	=> 'square_smaller_crop',
		'std' 	=> $defaults['square_smaller']['crop'],
		'type' 	=> 'select',
		'options' => $crop_modes
	);
	$options[] = array(
		'type' => 'section_end'
	);

	// Smallest

	$options[] = array(
		'name'	=> __( 'Smallest Square', 'tb_image_sizes' ),
		'desc'	=> __( '<p>When you\'re working with a Mini Post Grid or Mini Post List, this is the "smallest" choice.</p><p><strong>Internal ID:</strong> square_smallest<br><strong>Current Image Size:</strong> '.$defaults['square_smallest']['width'].'x'.$defaults['square_smallest']['height'].'</p>', 'tb_image_sizes' ),
		'type' 	=> 'section_start'
	);
	$options[] = array(
		'name' 	=> __( 'Width', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a width in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'square_smallest_width',
		'std' 	=> $defaults['square_smallest']['width'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Height', 'tb_image_sizes' ),
		'desc' 	=> __( 'Insert a height in pixels.', 'tb_image_sizes' ),
		'id' 	=> 'square_smallest_height',
		'std' 	=> $defaults['square_smallest']['height'],
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' 	=> __( 'Crop Mode', 'tb_image_sizes' ),
		'desc' 	=> __( 'Select the crop mode for this image size. This is generally the one soft-cropped image size we setup and it\'s definitely okay to change this to hard crop mode. Click the <em>Help</em> tab above to learn more about crop modes.', 'tb_image_sizes' ),
		'id' 	=> 'square_smallest_crop',
		'std' 	=> $defaults['square_smallest']['crop'],
		'type' 	=> 'select',
		'options' => $crop_modes
	);
	$options[] = array(
		'type' => 'section_end'
	);

	return $options;
}

/*-----------------------------------------------------------------------------------*/
/* Setup Admin Page
/*-----------------------------------------------------------------------------------*/

/**
 * Run admin panel
 *
 * @since 1.0.3
 */

function tb_image_sizes_admin() {

	// Check to make sure Theme Blvd Framework 2.0+ is running
	if( ! defined( 'TB_FRAMEWORK_VERSION' ) || version_compare( TB_FRAMEWORK_VERSION, '2.1.0', '<' ) ) {
		add_action( 'admin_notices', 'tb_image_sizes_warning' );
		return;
	}

	// If using framework v2.2+, we can use the framework's
	// internal options system and if not, we can do it the
	// old-fashioned way.

	if( class_exists( 'Theme_Blvd_Options_Page' ) ) {

		// DEBUG - View Registered Image Sizes
		// echo '<pre>'; print_r($GLOBALS['_wp_additional_image_sizes']); echo '</pre>';

		// Use new options system incorporated in v2.2.

		global $_tb_string_swap_admin;
		global $image_sizes_page;

		$options = tb_image_sizes_get_options();

		$args = array(
			'parent'		=> 'tools.php',
			'page_title' 	=> __( 'Theme Blvd Image Sizes', 'tb_image_sizes' ),
			'menu_title' 	=> __( 'TB Image Sizes', 'tb_image_sizes' ),
			'cap'			=> apply_filters( 'tb_image_sizes_cap', 'edit_theme_options' )
		);

		$_tb_string_swap_admin = new Theme_Blvd_Options_Page( 'tb_image_sizes', $options, $args );

		// Add "Help" tab
		$image_sizes_page = 'tools_page_tb_image_sizes';
		add_action( 'load-'.$image_sizes_page, 'tb_image_sizes_help' );

		// Tell user about re-generate thumbnails plugin
		add_action( 'themeblvd_admin_module_header', 'tb_image_sizes_note' );

	}
}
add_action( 'init', 'tb_image_sizes_admin' );

/**
 * Run legacy admin panel for framework 2.1.
 *
 * @since 1.0.4
 */

function tb_image_sizes_admin_legacy() {
	if( ! class_exists( 'Theme_Blvd_Options_Page' ) ) {
		add_action( 'init', 'tb_image_sizes_rolescheck' );
	}
}
add_action( 'after_setup_theme', 'tb_image_sizes_admin_legacy' );

/**
 * Explain to user that they need to re-generate thumbnails
 * after making any changes.
 *
 * @since 1.0.3
 */

function tb_image_sizes_note(){

	global $image_sizes_page;
    $screen = get_current_screen();

    if( $screen->id == $image_sizes_page )
		echo '<div style="max-width:780px"><p style="border:1px solid #dddddd;background:#f5f5f5;padding:10px;margin:10px 0 0 0">'.__( '<strong>IMPORTANT:</strong> After you change any settings on this page, they will only effect newly uploaded images moving forward. To apply changes to previously uploaded images, you must re-generate your thumbnails. Click the <em>"Help"</em> tab above to learn more about this and get more useful information about working with this plugin including an important warning disclaimer for using this plugin.', 'tb_image_sizes' ).'</div></p>';
}

/**
 * Hook everything in to being the process only if the user can
 * edit theme options, or else no use running this plugin.
 *
 * NOTE: Only used with framework v2.1
 */

function tb_image_sizes_rolescheck (){
	if ( current_user_can( 'edit_theme_options' ) ) {
		add_action( 'admin_init', 'tb_image_sizes_init' );
		add_action( 'admin_menu', 'tb_image_sizes_add_page');
	}
}

/**
 * Add a menu page for this plugin.
 *
 * NOTE: Only used with framework v2.1
 */

function tb_image_sizes_add_page() {
	global $image_sizes_page;
	// Create sub menu page
	$image_sizes_page = add_submenu_page( 'tools.php', 'TB Image Sizes', 'TB Image Sizes', 'administrator', 'tb_image_sizes', 'tb_image_sizes_page' );
	// Adds actions to hook in the required css and javascript
	add_action( "admin_print_styles-$image_sizes_page", 'optionsframework_load_styles' );
	add_action( "admin_print_scripts-$image_sizes_page", 'optionsframework_load_scripts' );
	add_action( "admin_print_styles-$image_sizes_page", 'optionsframework_mlu_css', 0 );
	add_action( "admin_print_scripts-$image_sizes_page", 'optionsframework_mlu_js', 0 );
	// Add Contextual help
	add_action('load-'.$image_sizes_page, 'tb_image_sizes_help');
}

/**
 * Inititate anything needed for the plugin.
 *
 * NOTE: Only used with framework v2.1
 */

function tb_image_sizes_init() {
	// Register settings
	register_setting( 'tb_image_sizes_settings', 'tb_image_sizes', 'tb_image_sizes_validate' );
}

/**
 * Validate settings when updated.
 *
 * Note: This function realistically has more than it needs.
 * In this specific plugin, we're only working with a couple kinds
 * of options, which are the "text" and "select" type of option, however
 * I'm keeping all validation types in this plugin as to setup
 * a nice model for making more plugins in the future that
 * may also include different kinds of options.
 *
 * NOTE: Only used with framework v2.1
 */

function tb_image_sizes_validate( $input ) {

	// Reset Settings
	if( isset( $_POST['reset'] ) ) {
		$empty = array();
		add_settings_error( 'tb_image_sizes', 'restore_defaults', __( 'Default options restored.', 'tb_image_sizes' ), 'updated fade' );
		return $empty;
	}

	// Save Options
	if ( isset( $_POST['update'] ) && isset( $_POST['options'] ) ) {
		$clean = array();
		$options = tb_image_sizes_get_options();
		foreach ( $options as $option ) {

			// Verify we have what need from options
			if ( ! isset( $option['id'] ) ) continue;
			if ( ! isset( $option['type'] ) ) continue;

			$id = preg_replace( '/\W/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST['options']
			if ( 'checkbox' == $option['type'] && ! isset( $_POST['options'][$id] ) ) {
				$_POST['options'][$id] = '0';
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST['options']
			if ( 'multicheck' == $option['type'] && ! isset( $_POST['options'][$id] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$_POST['options'][$id][$key] = '0';
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
				$clean[$id] = apply_filters( 'of_sanitize_' . $option['type'], $_POST['options'][$id], $option );
			}
		}
		add_settings_error( 'tb_image_sizes', 'save_options', __( 'Options saved.', 'tb_image_sizes' ), 'updated fade' );
		return $clean;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display Admin Page
/*-----------------------------------------------------------------------------------*/

/**
 * Build contextual help tab
 */

function tb_image_sizes_help() {

	global $image_sizes_page;
    $screen = get_current_screen();

    // Check if current screen is My Admin Page.
    // Don't add help tab if it's not
    if ( $screen->id != $image_sizes_page )
        return;

	// Regenerate
    $screen->add_help_tab(
	    array(
	        'id'		=> 'regenerate',
	        'title'		=> __( 'Regenerate Thumbnails', 'tb_image_sizes' ),
	        'content'	=> __( '<h3>Regenerate Thumbnails</h3><p>In WordPress, crop sizes are applied when you <em>upload</em> an image. So, simply changing image sizes will not change the sizes of the images you have previously uploaded. Any time you install a new theme or plugin with new crop sizes, or in the case of this plugin where you\'re adjusting crop sizes, you need to re-generate all of your thumbnails for images that you\'ve previously uploaded.</p><p>To accomplish this, simply install the <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails plugin</a>, then go to <em>Tools > Regen. Thumbnails</em>, and run it.</p>', 'tb_image_sizes' ),
	    )
    );

    // Crop Modes
    $screen->add_help_tab(
	    array(
	        'id'		=> 'crop_mode',
	        'title'		=> __( 'Crop Modes', 'tb_image_sizes' ),
	        'content'	=> __( '<h3>Crop Modes</h3><p>This can be a tricky topic to wrap your head around if noone has ever explained it to you. From the development side, when a theme or plugin author sets up an image size, one of the variables we can pass in is to designate whether the crop size will be a <em>hard crop</em> or a <em>soft crop</em>.</p><p><strong>Hard Crop:</strong> This is the simpler of the two to understand. A hard crop essentially means that the image will be cropped to the exact dimensions no matter what. So if the image you upload does not fit the dimesion ratio of the crop size, some of the image will always be cut off. Most of the crop sizes included with the Theme Blvd framework need to be set to hard crop or you may get some very strange results in different areas. See <em>Unknown Image Heights</em> section for more info and workarounds to this.</p><p><strong>Soft Crop:</strong> A soft-cropped image will maintain the dimension ratio of the images that you upload. The image will get scaled down to the point where it\'s largest side fits into the size specified. So, for example, let\'s say you have a crop size that is 200x200 that is set to be soft-cropped. Then, you upload an image that is 400x300. The resulting image would be 200x150. This method of cropping will ensure that none of the image ever actually gets cut off.</p>', 'tb_image_sizes' ),
	    )
    );

    // Crop Modes
    $screen->add_help_tab(
	    array(
	        'id'		=> 'image_heights',
	        'title'		=> __( 'Unknown Image Heights', 'tb_image_sizes' ),
	        'content'	=> __( '<h3>Unknown Image Heights</h3><p>In the previous <em>Crop Modes</em> section, I explained that most areas within Theme Blvd themes require a <em>hard crop</em> mode. This is because it\'s important that widths of your images match the widths of the sections throughout the theme.</p><p><strong>The Problem:</strong> This can obviously cause some problems for some. A very common issue is that some people are very particular about their photos. If you have some sort of portrait-orientated photo, maybe you don\'t want it cut down to a landscape-orientated photo.</p><p><strong>The Solution:</strong> The workaround for this it to leave the image size\'s crop mode at a "hard crop" however enter in a number for the height that will never be reached like "9999" for example. Doing this will ensure that your image sizes are always the correct width, but will never be cut off.</p>', 'tb_image_sizes' ),
	    )
    );

    // Crop Modes
    $screen->add_help_tab(
	    array(
	        'id'		=> 'switching_themes',
	        'title'		=> __( 'Switching Themes', 'tb_image_sizes' ),
	        'content'	=> __( '<h3>Switching Themes</h3><p>The options on this page are saved in your database with an ID that is not unique to the theme you\'re using. So, this means that it\'s absolutely crucial that if you\'re using this plugin with one Theme Blvd theme and then you switch to a different Theme Blvd theme, that you come back here and and click "Restore Defaults" at the bottom of the page. By doing this, all of the default crop sizes for the current theme you have activated will be applied here, which will give you a fresh starting point for changing your crop sizes.</p>', 'tb_image_sizes' ),
	    )
    );

    // Warning
    $screen->add_help_tab(
	    array(
	        'id'		=> 'warning',
	        'title'		=> __( 'Warning!', 'tb_image_sizes' ),
	        'content'	=> __( '<h3>Warning!</h3><p><strong>By using this plugin, you are choosing to <em>customize</em> the theme you\'re using and we cannot guarantee that everything is going to work perfectly.</strong></p><p>When we setup the crop sizes for each theme, there are many factors involved that are unique to both the Theme Blvd framework and the design of the current theme. We put a lot of thought into making these crop sizes work perfectly in just about every scenario that the images will get used. We do not suggest that you alter the crop sizes of the current theme you\'re using, however we have provided this plugin for those that feel they absolutely must.</p><p>We have done our best to provide you with sufficient information and documentation within this plugin. However, since changing these crop sizes are customizations you are making to the theme, guiding you through how to make these image size changes is not a part of the free theme support that we provide. So, edit at your own risk!</p><p>Our Support Policy: <a href="http://themeblvd.com/support" target="_blank">http://themeblvd.com/support</a></p>', 'tb_image_sizes' ),
	    )
    );
}

/**
 * Builds out the full admin page.
 *
 * NOTE: Only used with framework v2.1
 */

function tb_image_sizes_page() {

	// DEBUG - View Saved Options
	// $settings = get_option('tb_image_sizes');
	// echo '<pre>'; print_r($settings); echo '</pre>';

	// DEBUG - View Registered Image Sizes
	// global $_wp_additional_image_sizes;
	// echo '<pre>'; print_r($_wp_additional_image_sizes); echo '</pre>';

	// Build form
	$options = tb_image_sizes_get_options();
	$settings = get_option('tb_image_sizes');
	$form = optionsframework_fields( 'options', $options, $settings, true );
	settings_errors();
	?>
	<div id="tb_image_sizes">
		<div class="wrap">
		    <?php screen_icon( 'themes' ); ?>
		    <h2 class="nav-tab-wrapper">
		        <?php echo $form[1]; ?>
		    </h2>
		    <div class="metabox-holder">
			    <div id="optionsframework">
			    	<p style="border:1px solid #dddddd;background:#f5f5f5;padding:10px;margin:0 0 15px 0"><?php _e( '<strong>IMPORTANT:</strong> After you change any settings on this page, they will only effect newly uploaded images moving forward. To apply changes to previously uploaded images, you must re-generate your thumbnails. Click the <em>"Help"</em> tab above to learn more about this and get more useful information about working with this plugin including an important warning disclaimer for using this plugin.', 'tb_image_sizes' ); ?></p>
					<form action="options.php" method="post">
						<?php settings_fields('tb_image_sizes_settings'); ?>
						<?php echo $form[0]; /* Settings */ ?>
				        <div id="optionsframework-submit">
							<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e( 'Save Options' ); ?>" />
				            <input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e( 'Restore Defaults' ); ?>" onclick="return confirm( '<?php print esc_js( __( 'Click OK to reset. Any theme settings will be lost!', TB_GETTEXT_DOMAIN ) ); ?>' );" />
				            <div class="clear"></div>
						</div><!-- #optionsframework-submit (end) -->
					</form>
					<div class="tb-footer-text">
						<?php do_action( 'themeblvd_options_footer_text' ); ?>
					</div><!-- .tb-footer-text (end) -->
				</div><!-- #optionsframework (end) -->
			</div><!-- .metabox-holder (end) -->
		</div><!-- .wrap (end) -->
	</div><!-- #tb_image_sizes (end) -->
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Filter changes
/*-----------------------------------------------------------------------------------*/

/**
 * Primary Filter
 *
 * This is the actual function that is used to add
 * the filter to "themeblvd_image_sizes" of the
 * theme framework.
 */

function tb_image_sizes_apply_changes( $sizes ) {

	// Get current settings
	$settings = get_option('tb_image_sizes');

	// Full Width Image Slides

	if( isset( $settings['sliderlarge_width'] ) && $settings['sliderlarge_width'] )
		$sizes['slider-large']['width'] = $settings['sliderlarge_width'];

	if( isset( $settings['sliderlarge_height'] ) && $settings['sliderlarge_height'] )
		$sizes['slider-large']['height'] = $settings['sliderlarge_height'];

	if( isset( $settings['sliderlarge_crop'] ) ) {
		if( $settings['sliderlarge_crop'] == 'true' )
			$sizes['slider-large']['crop'] = true;
		else if( $settings['sliderlarge_crop'] == 'false' )
			$sizes['slider-large']['crop'] = false;
	}

	// Staged Image Slides

	if( isset( $settings['sliderstaged_width'] ) && $settings['sliderstaged_width'] )
		$sizes['slider-staged']['width'] = $settings['sliderstaged_width'];

	if( isset( $settings['sliderstaged_height'] ) && $settings['sliderstaged_height'] )
		$sizes['slider-staged']['height'] = $settings['sliderstaged_height'];

	if( isset( $settings['sliderstaged_crop'] ) ) {
		if( $settings['sliderstaged_crop'] == 'true' )
			$sizes['slider-staged']['crop'] = true;
		else if( $settings['sliderstaged_crop'] == 'false' )
			$sizes['slider-staged']['crop'] = false;
	}

	// 1/5

	if( isset( $settings['grid_fifth_1_width'] ) && $settings['grid_fifth_1_width'] )
		$sizes['grid_fifth_1']['width'] = $settings['grid_fifth_1_width'];

	if( isset( $settings['grid_fifth_1_height'] ) && $settings['grid_fifth_1_height'] )
		$sizes['grid_fifth_1']['height'] = $settings['grid_fifth_1_height'];

	if( isset( $settings['grid_fifth_1_crop'] ) ) {
		if( $settings['grid_fifth_1_crop'] == 'true' )
			$sizes['grid_fifth_1']['crop'] = true;
		else if( $settings['grid_fifth_1_crop'] == 'false' )
			$sizes['grid_fifth_1']['crop'] = false;
	}

	// 1/4

	if( isset( $settings['grid_3_width'] ) && $settings['grid_3_width'] )
		$sizes['grid_3']['width'] = $settings['grid_3_width'];

	if( isset( $settings['grid_3_height'] ) && $settings['grid_3_height'] )
		$sizes['grid_3']['height'] = $settings['grid_3_height'];

	if( isset( $settings['grid_3_crop'] ) ) {
		if( $settings['grid_3_crop'] == 'true' )
			$sizes['grid_3']['crop'] = true;
		else if( $settings['grid_3_crop'] == 'false' )
			$sizes['grid_3']['crop'] = false;
	}

	// 1/3

	if( isset( $settings['grid_4_width'] ) && $settings['grid_4_width'] )
		$sizes['grid_4']['width'] = $settings['grid_4_width'];

	if( isset( $settings['grid_4_height'] ) && $settings['grid_4_height'] )
		$sizes['grid_4']['height'] = $settings['grid_4_height'];

	if( isset( $settings['grid_4_crop'] ) ) {
		if( $settings['grid_4_crop'] == 'true' )
			$sizes['grid_4']['crop'] = true;
		else if( $settings['grid_4_crop'] == 'false' )
			$sizes['grid_4']['crop'] = false;
	}

	// 1/2

	if( isset( $settings['grid_6_width'] ) && $settings['grid_6_width'] )
		$sizes['grid_6']['width'] = $settings['grid_6_width'];

	if( isset( $settings['grid_6_height'] ) && $settings['grid_6_height'] )
		$sizes['grid_6']['height'] = $settings['grid_6_height'];

	if( isset( $settings['grid_6_crop'] ) ) {
		if( $settings['grid_6_crop'] == 'true' )
			$sizes['grid_6']['crop'] = true;
		else if( $settings['grid_6_crop'] == 'false' )
			$sizes['grid_6']['crop'] = false;
	}

	// Small Thumbs

	if( isset( $settings['tb_small_width'] ) && $settings['tb_small_width'] )
		$sizes['tb_small']['width'] = $settings['tb_small_width'];

	if( isset( $settings['tb_small_height'] ) && $settings['tb_small_height'] )
		$sizes['tb_small']['height'] = $settings['tb_small_height'];

	if( isset( $settings['tb_small_crop'] ) ) {
		if( $settings['tb_small_crop'] == 'true' )
			$sizes['tb_small']['crop'] = true;
		else if( $settings['tb_small_crop'] == 'false' )
			$sizes['tb_small']['crop'] = false;
	}

	// Small Squares

	if( isset( $settings['square_small_width'] ) && $settings['square_small_width'] )
		$sizes['square_small']['width'] = $settings['square_small_width'];

	if( isset( $settings['square_small_height'] ) && $settings['square_small_height'] )
		$sizes['square_small']['height'] = $settings['square_small_height'];

	if( isset( $settings['square_small_crop'] ) ) {
		if( $settings['square_small_crop'] == 'true' )
			$sizes['square_small']['crop'] = true;
		else if( $settings['square_small_crop'] == 'false' )
			$sizes['square_small']['crop'] = false;
	}

	// Smaller Squares

	if( isset( $settings['square_smaller_width'] ) && $settings['square_smaller_width'] )
		$sizes['square_smaller']['width'] = $settings['square_smaller_width'];

	if( isset( $settings['square_smaller_height'] ) && $settings['square_smaller_height'] )
		$sizes['square_smaller']['height'] = $settings['square_smaller_height'];

	if( isset( $settings['square_smaller_crop'] ) ) {
		if( $settings['square_smaller_crop'] == 'true' )
			$sizes['square_smaller']['crop'] = true;
		else if( $settings['square_smaller_crop'] == 'false' )
			$sizes['square_smaller']['crop'] = false;
	}


	// Smallest Squares

	if( isset( $settings['square_smallest_width'] ) && $settings['square_smallest_width'] )
		$sizes['square_smallest']['width'] = $settings['square_smallest_width'];

	if( isset( $settings['square_smallest_height'] ) && $settings['square_smallest_height'] )
		$sizes['square_smallest']['height'] = $settings['square_smallest_height'];

	if( isset( $settings['square_smallest_crop'] ) ) {
		if( $settings['square_smallest_crop'] == 'true' )
			$sizes['square_smallest']['crop'] = true;
		else if( $settings['square_smallest_crop'] == 'false' )
			$sizes['square_smallest']['crop'] = false;
	}

	return $sizes;
}
add_filter( 'themeblvd_image_sizes', 'tb_image_sizes_apply_changes', 999 );