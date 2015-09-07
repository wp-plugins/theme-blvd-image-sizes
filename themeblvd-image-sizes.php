<?php
/*
Plugin Name: Theme Blvd Image Sizes
Description: Adjust the image crop sizes in a Theme Blvd theme through your WordPress admin.
Version: 1.1.1
Author: Jason Bobich
Author URI: http://jasonbobich.com
License: GPL2
*/

/*
Copyright 2015 JASON BOBICH

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

define( 'TB_IMAGE_SIZES_PLUGIN_VERSION', '1.1.1' );
define( 'TB_IMAGE_SIZES_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'TB_IMAGE_SIZES_PLUGIN_URI', plugins_url( '' , __FILE__ ) );

/**
 * Register text domain for localization.
 *
 * @since 1.0.3
 */
function tb_image_sizes_textdomain() {
	load_plugin_textdomain('theme-blvd-image-sizes');
}
add_action( 'init', 'tb_image_sizes_textdomain' );

/**
 * Display warning telling the user they must have a
 * theme with Theme Blvd framework v2.1+ installed in
 * order to run this plugin.
 *
 * @since 1.0.3
 */
function tb_image_sizes_warning() {
	echo '<div class="updated">';
	echo '<p>'.__( 'You currently have the "Theme Blvd Image Sizes" plugin activated, however you are not using a theme with Theme Blvd Framework v2.2+, and so this plugin will not do anything.', 'theme-blvd-image-sizes' ).'</p>';
	echo '</div>';
}

/*----------------------------------------------------*/
/* Setup Default Text Strings and Options
/*----------------------------------------------------*/

/**
 * Get Options to pass into Option Framework's function to generate form.
 *
 * @since 1.0.0
 */
function tb_image_sizes_get_options() {

	$sizes = themeblvd_get_image_sizes();

	// Crop mode options
	$crop_modes = array(
		'true' 		=> __('Hard Crop', 'theme-blvd-image-sizes'),
		'false' 	=> __('Soft Crop', 'theme-blvd-image-sizes'),
		'custom'	=> __('Custom', 'theme-blvd-image-sizes')
	);

	$crop_positions_x = array(
		'center' 	=> __('Center', 'theme-blvd-image-sizes'),
		'left' 		=> __('Left', 'theme-blvd-image-sizes'),
		'right'		=> __('Right', 'theme-blvd-image-sizes')
	);

	$crop_positions_y = array(
		'center' 	=> __('Center', 'theme-blvd-image-sizes'),
		'top' 		=> __('Top', 'theme-blvd-image-sizes'),
		'bottom'	=> __('Bottom', 'theme-blvd-image-sizes')
	);

	// Setup options
	$options = array();

	foreach ( $sizes as $size => $atts ) {

		$crop = 'soft';

		if ( $atts['crop'] ) {
			$crop = 'hard';
		}

		$desc = sprintf('%s: %sx%s (%s %s)', __('Theme Default', 'theme-blvd-image-sizes'), $atts['width'], $atts['height'], $crop, __('crop', 'theme-blvd-image-sizes'));

		if ( $crop == 'soft' ) {
			$crop = 'false';
		} else {
			$crop = 'true';
		}

		$size = str_replace( '-', '', $size );

		$options[] = array(
			'name'		=> $atts['name'],
			'desc'		=> $desc,
			'type' 		=> 'section_start'
		);

		$options[] = array(
			'name' 		=> __( 'Width', 'theme-blvd-image-sizes' ),
			'desc' 		=> __( 'Insert a width in pixels.', 'theme-blvd-image-sizes' ),
			'id' 		=> $size.'_width',
			'std' 		=> $atts['width'],
			'type' 		=> 'text'
		);

		$options[] = array(
			'name' 		=> __( 'Height', 'theme-blvd-image-sizes' ),
			'desc' 		=> __( 'Insert a height in pixels.', 'theme-blvd-image-sizes' ),
			'id' 		=> $size.'_height',
			'std' 		=> $atts['height'],
			'type' 		=> 'text'
		);

		$options[] = array(
			'type' 		=> 'subgroup_start',
			'class'		=> 'show-hide-toggle'
		);

		$options[] = array(
			'name' 		=> __( 'Crop Mode', 'theme-blvd-image-sizes' ),
			'desc' 		=> __( 'Select the crop mode for this image size.', 'theme-blvd-image-sizes' ),
			'id' 		=> $size.'_crop',
			'std' 		=> $crop,
			'type' 		=> 'select',
			'options' 	=> $crop_modes,
			'class'		=> 'trigger'
		);

		$options[] = array(
			'name' 		=> __( 'X-axis Crop Position', 'theme-blvd-image-sizes' ),
			'desc' 		=> __( 'Select from where you\'d like the image croped on the x-axis.', 'theme-blvd-image-sizes' ),
			'id' 		=> $size.'_x_crop_position',
			'std' 		=> 'center',
			'type' 		=> 'select',
			'options' 	=> $crop_positions_x,
			'class'		=> 'hide receiver receiver-custom'
		);

		$options[] = array(
			'name' 		=> __( 'Y-axis Crop Position', 'theme-blvd-image-sizes' ),
			'desc' 		=> __( 'Select from where you\'d like the image croped on the y-axis.', 'theme-blvd-image-sizes' ),
			'id' 		=> $size.'_y_crop_position',
			'std' 		=> 'center',
			'type' 		=> 'select',
			'options' 	=> $crop_positions_y,
			'class'		=> 'hide receiver receiver-custom'
		);

		$options[] = array(
			'type' 		=> 'subgroup_end'
		);

		$options[] = array(
			'type' 		=> 'section_end'
		);

	}

	return apply_filters('tb_image_sizes_options', $options);
}

/*----------------------------------------------------*/
/* Setup Admin Page
/*----------------------------------------------------*/

/**
 * Run admin panel
 *
 * @since 1.0.3
 */
function tb_image_sizes_admin() {

	if ( ! is_admin() ) {
		return;
	}

	global $_tb_string_swap_admin;
	global $image_sizes_page;

	// Check to make sure Theme Blvd Framework 2.2+ is running
	if ( ! defined( 'TB_FRAMEWORK_VERSION' ) || version_compare( TB_FRAMEWORK_VERSION, '2.2.0', '<' ) ) {
		add_action( 'admin_notices', 'tb_image_sizes_warning' );
		return;
	}

	// Add options page
	$args = array(
		'parent'		=> 'themes.php', // only used prior to framework 2.5.2
		'page_title' 	=> __( 'Theme Image Sizes', 'theme-blvd-image-sizes' ),
		'menu_title' 	=> __( 'Theme Image Sizes', 'theme-blvd-image-sizes' ),
		'cap'			=> apply_filters( 'tb_image_sizes_cap', 'edit_theme_options' ),
		'closer'		=> false // needed for framework 2.2-2.4, when options page has no tabs
	);

	$_tb_string_swap_admin = new Theme_Blvd_Options_Page( 'tb_image_sizes', tb_image_sizes_get_options(), $args );

	// Add "Help" tab
	$image_sizes_page = 'tools_page_tb_image_sizes';
	add_action( 'load-'.$image_sizes_page, 'tb_image_sizes_help' );

	// Tell user about re-generate thumbnails plugin
	add_action( 'themeblvd_admin_module_header', 'tb_image_sizes_note' );

}
add_action( 'init', 'tb_image_sizes_admin' );

/**
 * Explain to user that they need to re-generate thumbnails
 * after making any changes.
 *
 * @since 1.0.3
 */
function tb_image_sizes_note(){

	global $image_sizes_page;

    $screen = get_current_screen();

    if ( $screen->id == $image_sizes_page ) {
		echo '<div class="settings-error notice" style="border-color:#ffba00;max-width:750px;"><p><strong>'.__('Important', 'theme-blvd-image-sizes').':</strong> '.__('For settings saved to effect previously uploaded images, you must <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">regenerate your thumbnails</a>.', 'theme-blvd-image-sizes').'</div></p>';
	}
}

/*----------------------------------------------------*/
/* Help Tab
/*----------------------------------------------------*/

/**
 * Build contextual help tab
 *
 * @since 1.0.0
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
	        'title'		=> __( 'Regenerate Thumbnails', 'theme-blvd-image-sizes' ),
	        'content'	=> __( '<h3>Regenerate Thumbnails</h3><p>In WordPress, crop sizes are applied when you <em>upload</em> an image. So, simply changing image sizes will not change the sizes of the images you have previously uploaded. Any time you install a new theme or plugin with new crop sizes, or in the case of this plugin where you\'re adjusting crop sizes, you need to re-generate all of your thumbnails for images that you\'ve previously uploaded.</p><p>To accomplish this, simply install the <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails plugin</a>, then go to <em>Tools > Regen. Thumbnails</em>, and run it.</p>', 'theme-blvd-image-sizes' ),
	    )
    );

    // Crop Modes
    $screen->add_help_tab(
	    array(
	        'id'		=> 'crop_mode',
	        'title'		=> __( 'Crop Modes', 'theme-blvd-image-sizes' ),
	        'content'	=> __( '<h3>Crop Modes</h3><p>This can be a tricky topic to wrap your head around if noone has ever explained it to you. From the development side, when a theme or plugin author sets up an image size, one of the variables we can pass in is to designate whether the crop size will be a <em>hard crop</em> or a <em>soft crop</em>.</p><p><strong>Hard Crop:</strong> This is the simpler of the two to understand. A hard crop essentially means that the image will be cropped to the exact dimensions no matter what. So if the image you upload does not fit the dimesion ratio of the crop size, some of the image will always be cut off. Most of the crop sizes included with the Theme Blvd framework need to be set to hard crop or you may get some very strange results in different areas. See <em>Unknown Image Heights</em> section for more info and workarounds to this.</p><p><strong>Soft Crop:</strong> A soft-cropped image will maintain the dimension ratio of the images that you upload. The image will get scaled down to the point where it\'s largest side fits into the size specified. So, for example, let\'s say you have a crop size that is 200x200 that is set to be soft-cropped. Then, you upload an image that is 400x300. The resulting image would be 200x150. This method of cropping will ensure that none of the image ever actually gets cut off.</p>', 'theme-blvd-image-sizes' ),
	    )
    );

    // Crop Modes
    $screen->add_help_tab(
	    array(
	        'id'		=> 'image_heights',
	        'title'		=> __( 'Unknown Image Heights', 'theme-blvd-image-sizes' ),
	        'content'	=> __( '<h3>Unknown Image Heights</h3><p>In the previous <em>Crop Modes</em> section, I explained that most areas within Theme Blvd themes require a <em>hard crop</em> mode. This is because it\'s important that widths of your images match the widths of the sections throughout the theme.</p><p><strong>The Problem:</strong> This can obviously cause some problems for some. A very common issue is that some people are very particular about their photos. If you have some sort of portrait-orientated photo, maybe you don\'t want it cut down to a landscape-orientated photo.</p><p><strong>The Solution:</strong> The workaround for this it to leave the image size\'s crop mode at a "hard crop" however enter in a number for the height that will never be reached like "9999" for example. Doing this will ensure that your image sizes are always the correct width, but will never be cut off.</p>', 'theme-blvd-image-sizes' ),
	    )
    );

    // Crop Modes
    $screen->add_help_tab(
	    array(
	        'id'		=> 'switching_themes',
	        'title'		=> __( 'Switching Themes', 'theme-blvd-image-sizes' ),
	        'content'	=> __( '<h3>Switching Themes</h3><p>The options on this page are saved in your database with an ID that is not unique to the theme you\'re using. So, this means that it\'s absolutely crucial that if you\'re using this plugin with one Theme Blvd theme and then you switch to a different Theme Blvd theme, that you come back here and and click "Restore Defaults" at the bottom of the page. By doing this, all of the default crop sizes for the current theme you have activated will be applied here, which will give you a fresh starting point for changing your crop sizes.</p>', 'theme-blvd-image-sizes' ),
	    )
    );

    // Warning
    $screen->add_help_tab(
	    array(
	        'id'		=> 'warning',
	        'title'		=> __( 'Warning!', 'theme-blvd-image-sizes' ),
	        'content'	=> __( '<h3>Warning!</h3><p><strong>By using this plugin, you are choosing to <em>customize</em> the theme you\'re using and we cannot guarantee that everything is going to work perfectly.</strong></p><p>When we setup the crop sizes for each theme, there are many factors involved that are unique to both the Theme Blvd framework and the design of the current theme. We put a lot of thought into making these crop sizes work perfectly in just about every scenario that the images will get used. We do not suggest that you alter the crop sizes of the current theme you\'re using, however we have provided this plugin for those that feel they absolutely must.</p><p>We have done our best to provide you with sufficient information and documentation within this plugin. However, since changing these crop sizes are customizations you are making to the theme, guiding you through how to make these image size changes is not a part of the free theme support that we provide. So, edit at your own risk!</p><p>Our Support Policy: <a href="http://themeblvd.com/support" target="_blank">http://themeblvd.com/support</a></p>', 'theme-blvd-image-sizes' ),
	    )
    );
}

/*----------------------------------------------------*/
/* Filter changes
/*----------------------------------------------------*/

/**
 * Primary Filter
 *
 * This is the actual function that is used to add
 * the filter to "themeblvd_image_sizes" of the
 * theme framework.
 *
 * @since 1.0.0
 */
function tb_image_sizes_apply_changes( $sizes ) {

	$settings = get_option('tb_image_sizes');

	// DEBUG - View Saved Options
	// echo '<pre>'; print_r($settings); echo '</pre>';

	foreach ( $sizes as $size => $atts ) {

		$key = str_replace( '-', '', $size );

		if ( isset( $settings[$key.'_width'] ) && $settings[$key.'_width'] ) {
			$sizes[$size]['width'] = $settings[$key.'_width'];
		}

		if ( isset( $settings[$key.'_height'] ) && $settings[$key.'_height'] ) {
			$sizes[$size]['height'] = $settings[$key.'_height'];
		}

		if ( isset( $settings[$key.'_crop'] ) ) {
			if ( $settings[$key.'_crop'] == 'true' ) {
				$sizes[$size]['crop'] = true;
			} else if ( $settings[$key.'_crop'] == 'false' ) {
				$sizes[$size]['crop'] = false;
			} else if ( $settings[$key.'_crop'] == 'custom'  ) {
				$sizes[$size]['crop'] = array( $settings[$key.'_x_crop_position'], $settings[$key.'_y_crop_position'] );
			}
		}

	}

	return apply_filters('tb_image_sizes', $sizes, $settings);
}
add_filter( 'themeblvd_image_sizes', 'tb_image_sizes_apply_changes', 999 );
