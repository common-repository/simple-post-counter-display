=== Display Simple Post View Count  ===
Contributors: aistechnolabspvtltd
Donate link: 
Tags: Simple Post Counter Display, Custom post count display, Posts view count, Display view count of post
Requires at least: 5.4
Tested up to: 5.4
Stable tag: 1.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple Post Counter Display plugin will display post count.

== Description ==

Display Simple Post View Count allows you to display how many times a post, page or custom post type had been viewed with this simple, fast and easy to use plugin.

In count display to configure settings, navigate to **[ Wordpress Admin -> Settings -> SPCD Options ]**, where you can see three options:

1. Add css for counter display
2. Add display text with count text
3. Post views display position

= FEATURES =

* You will get an option to select post types for which post views will be counted and displayed.
* Used different methods of collecting post views data: PHP, Javascript, Fast AJAX and REST API for greater flexibility
* Capability to query posts according to its views count
* Count display shortcode
* Dashboard post views stats widget
* Option to select post types for which post views will be counted and displayed.
* Post views display position, automatic or manual via shortcode
* W3 Cache/WP SuperCache compatible

= Example Display shortcode: =

<pre>[spcd_display]</pre>


= NOTE =

We have this plugin compatible gutenberg.

== Installation ==

1. Upload `simple-post-counter-display` folder to your `/wp-content/plugins/` directory.
2. Activate the plugin from Admin > Plugins menu.
3. Once activated you should check with Settings > SPCD Options

== Frequently Asked Questions ==

= Where can I find the settings configuration? =

It is under Settings > SPCD Options.

= When and how to use spcd_display shortcode? =

You can use below mentioned shortcode in count view to display any pages.


= How to apply the custom view count shortcode =

Check code example below:
`&lt;?php echo do_shortcode('[spcd_display']'); ?&gt;`


== Changelog ==

= 1.0 =
 - Initial Release
 
== Upgrade Notice ==

Make sure you get the latest version.

== Screenshots ==

1. Simple Post Count Display General Settings
2. Simple Post Count Display before content 
3. Simple Post Count Display after content 
3. Simple Post Count Display widget 