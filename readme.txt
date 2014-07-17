=== Theme Blvd Image Sizes ===
Contributors: themeblvd
Tags: themeblvd, images, add_image_size, crop
Requires at least: Theme Blvd Framework 2.1
Stable tag: 1.0.5

When using a theme with Theme Blvd framework version 2.1+, this plugin is will allow to change your theme's image sizes.

== Description ==

When using a theme with Theme Blvd framework version 2.1+, this plugin is will provide you with a user-friendly interface to change your current theme's image sizes.

= Who is this plugin for? =

This plugin is mainly designed for non-developers who feel they need to alter the image sizes for their theme, but do not have the necessary development knowledge to manually make the changes from their child theme.

= How does this plugin work? =

As in any WordPress theme, we setup the image sizes by using WordPress's *add_image_size* function for each crop size. In the version 2.0.5 update to the Theme Blvd framework, we adjusted how we call the add_image_size function by first putting all image sizes into an array, which we applied the filter: *themeblvd_image_sizes*

This allows for all of the image sizes of the theme to easily be filtered from your child theme or from a plugin... and this would be an example of a plugin that utilizes that. :-)

= Do I have to use this plugin to change image sizes? =

Absolutely not. In fact, if you understand the basics of PHP and the WordPress filters API, I would suggest that you do not use this plugin and instead, you manually make the changes from your child theme. Realistically, running this plugin requires extra resources on your server that can be avoided by just manually make the change you want from your child theme.

If you'd like to dive into a little development action, and accomplish the gist of what this plugin does, you'd simply do something like this from your child theme:

`function my_image_sizes( $sizes ) {
	$sizes['slider-large'] = array(
		'width' => '960', // Your new width
		'height' => '350' // Your new height
	);
	return $sizes;
}
add_filter( 'themeblvd_image_sizes', 'my_image_sizes' );`

== Installation ==

1. Upload `theme-blvd-image-sizes` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to *Tools > TB Image Sizes* to use.

== Screenshots ==

1. Admin interface for plugin under *Tools > TB Image Sizes*.
2. Contextual help included with plugin.

== Changelog ==

= 1.0.5 =

* Added selection for custom crop mode on all image sizes (requires WordPress 3.9+).

= 1.0.4 =

* Added control for Mini Post Grid/List thumbnail sizes.
* Fixed issue with "Current Image Size" not showing for each image section.

= 1.0.3 =

* Added compatibility for framework v2.2.

= 1.0.2 =

* Fixed small thumbnail sizes to match new "tb_small" ID used by updated themes. 

= 1.0.1 =

* Added high priority to filter so it happens after the theme runs. This is needed in conjunction with the [Theme Blvd Framework 2.1 update](http://www.wpjumpstart.com/framework-updates/theme-blvd-2-1-0-framework-update/).
* On options page, adjusted changelog link at bottom to match Theme Blvd 2.1 framework's slightly modified format.
* On options page, changed "Default Theme's Size" string to say "Current Image Size" as it actually reflects what the current image size is set to.

= 1.0.0 =

* This is the first release.
