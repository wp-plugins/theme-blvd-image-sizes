=== Theme Blvd Image Sizes ===
Contributors: themeblvd
Tags: themeblvd, images, add_image_size, crop
Requires at least: Theme Blvd Framework 2.2
Stable tag: 1.1.1

When using a theme with Theme Blvd Framework version 2.2+, this plugin allows you to change your theme's image sizes.

== Description ==

When using a theme with Theme Blvd Framework version 2.2+, this plugin allows you to change your theme's image sizes.

= Who is this plugin for? =

This plugin is mainly designed for non-developers who want to alter the image sizes for their Theme Blvd theme, but do not have the necessary development knowledge to manually make the changes from their child theme.

= How does this plugin work? =

As in any WordPress theme, we setup the image sizes by using WordPress's *add_image_size* function for each crop size. However, before these images are registered, the Theme Blvd framework applies a filter to an array of the sizes to be registered.

This allows for all of the image sizes of the theme to be easily filtered from your child theme or from a plugin... and this would be an example of a plugin that utilizes that. :-)

= Do I have to use this plugin to change image sizes? =

Nope. In fact, if you understand the basics of PHP and the WordPress filters API, I would suggest that you do not use this plugin and instead, you manually make the changes from your child theme’s *functions.php*. Realistically, running this plugin requires extra resources on your server that can be avoided by just manually make the change you want from your child theme.

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
3. Go to *Appearance > Theme Image Sizes* to use.

== Screenshots ==

1. Admin interface for plugin under *Appearance > Theme Image Sizes*.

== Changelog ==

= 1.1.1 - 09/07/2015 =

* Admin page moved to *Appearance > Theme Image Sizes*.

= 1.1.0 - 05/29/2015 =

* GlotPress compatibility.
* Added compatibility for themes with Theme Blvd Framework 2.5+.
* Removed compatibility for themes prior to Theme Blvd Framework 2.2.

= 1.0.5 - 07/17/2014 =

* Added selection for custom crop mode on all image sizes (requires WordPress 3.9+).

= 1.0.4 - 09/06/2013 =

* Added control for Mini Post Grid/List thumbnail sizes.
* Fixed issue with "Current Image Size" not showing for each image section.

= 1.0.3 - 09/19/2012 =

* Added compatibility for framework v2.2.

= 1.0.2 - 07/02/2012 =

* Fixed small thumbnail sizes to match new "tb_small" ID used by updated themes.

= 1.0.1 - 05/18/2012 =

* Added high priority to filter so it happens after the theme runs. This is needed in conjunction with the [Theme Blvd Framework 2.1 update](http://www.wpjumpstart.com/framework-updates/theme-blvd-2-1-0-framework-update/).
* On options page, adjusted changelog link at bottom to match Theme Blvd 2.1 framework's slightly modified format.
* On options page, changed "Default Theme's Size" string to say "Current Image Size" as it actually reflects what the current image size is set to.

= 1.0.0 - 02/12/2012 =

* This is the first release.
