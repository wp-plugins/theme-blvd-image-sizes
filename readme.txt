=== Theme Blvd Image Sizes ===
Contributors: themeblvd
Tags: themeblvd, images, add_image_size, crop
Requires at least: 3.3
Tested up to: 3.3.1
Stable tag: 1.0.0

When using a theme with Theme Blvd framework version 2.0.5+, this plugin is will allow to change your theme's image sizes.

== Description ==

When using a theme with Theme Blvd framework version 2.0.5+, this plugin is will provide you with a user-friendly interface to change your current theme's image sizes.

= Who is this plugin for? =

This plugin is mainly designed for non-developers who feel they need to alter the image sizes for their theme, but do not have the necessary development knowledge to manually make the changes from their child theme.

= How does this plugin work? =

As in any WordPress theme, we setup the image sizes by using WordPress's [add_image_size](http://codex.wordpress.org/Function_Reference/add_image_size “add_image_size function”) function for each crop size. In the version 2.0.5 update to the Theme Blvd framework, we adjusted how we call the add_image_size function by first putting all image sizes into an array, which we applied the filter: *themeblvd_image_sizes*

This allows for all of the image sizes of the theme to easily be filtered from your child theme or from a plugin... and this would be an example of a plugin that utilizes that. :-)

= Do I have to use this plugin to change image sizes? =

Absolutely not. In fact, if you understand the basics of PHP and the WordPress filters API, I would suggest that you do not use this plugin and instead, you manually make the changes from your child theme. Realistically, running this plugin requires extra resources on your server that can be avoided by just manually make the change you want from your child theme.

If you'd like to dive into a little development action, and accomplish the gist of what this plugin does, you'd simply do something like this from your child theme:

‘function my_image_sizes( $sizes ) {
	$sizes['slider-large'] = array(
		'width' => '960', // Your new width
		'height' => '350' // Your new height
	);
	return $sizes;
}
add_filter( 'themeblvd_image_sizes', 'my_image_sizes' );’

*Note: To see all current image sizes of the theme you're using simply look in the first function in functions.php of the theme you're using. This function will be named {theme_name}_setup. Remember that while it may be tempting, never make any changes directly to theme files and always make your customizations from a child theme plugin.*

= Warning! =

**By using this plugin, you are choosing to *customize* the theme you're using and we cannot guarantee that everything is going to work perfectly.**

When we setup the crop sizes for each theme, there are many factors involved that are unique to both the Theme Blvd framework and the design of the current theme. We put a lot of thought into making these crop sizes work perfectly in just about every scenario that the images will get used. We do not suggest that you alter the crop sizes of the current theme you're using, however we have provided this plugin for those that feel they absolutely must.

We have done our best to provide you with sufficient information and documentation within this plugin. However, since changing these crop sizes are customizations you are making to the theme, guiding you through how to make these image size changes is not a part of the free theme support that we provide. So, edit at your own risk!

Our Support Policy: <http://www.themeblvd.com/support>

== Installation ==

1. Upload `theme-blvd-image-sizes` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to *Tools > TB Image Sizes* to use.

== Screenshots ==

1. Admin interface for plugin under *Tools > TB Image Sizes*.
2. Contextual help included with plugin.

== Changelog ==

= 1.0.0 =

* This is the first release.
