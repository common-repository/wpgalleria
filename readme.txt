=== Wordpress Galleria ===
Contributors: kennethrapp
Tags: galleria, gallery, image
Donate Link:https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=92XWZSS88YF9C
Requires at least: 3.0
Tested up to: 3.6
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Wordpress Galleria provides a simple way to collect image attachments into a <a href="//galleria.io">galleria.io</a> image gallery. This plugin uses the Classic theme. 


== Installation ==

Upload /wpgalleria/ into the /wp-content/plugins/ directory, and activate the plugin through the plugins menu.

Attach images to a page via the media gallery panel. On that page, add the shortcode '[wpgalleria]' and the
attached images will be displayed as an image gallery.


**shortcode options: none**

**formatting gallery contents**

The title of an image will be added as the caption in the gallery. By default, this is the name of the image file. 

*Index links*

links to image galleries (as an index) can be generated using another
shortcode: '[wpgalleria-index]', which has the following
options:

* **id** the id of the page containing the gallery
* **title** or optionally the title of the page containing the galery

* **index** can be the title of the image, 'random' to pick a random thumbnail, or the numeric index of the image. Default is to pick the first image. This will be displayed as a thumbnail for the gallery link

* **caption** 'true' to display the caption with the image, or 'false' not to. Default is false.

Note that the title of the page will appear as a link to the gallery itself. 

== Frequently Asked Questions ==

= Galleria what now? =
Galleria is a rather nice and feature-rich javascript image gallery. I am not affiliated in any way with it or its developers, just providing a way to use it in wordpress. Galleria wth the Classic theme is licensed under the MIT license. 

= How do I change the Galleria settings? =
Refer to the Galleria site, then go into the /js/galleria folder inside the plugins folder and do whatever. The script is initialized in /js/main.js

= You mean I can't change settings in the editor? =
No. The plugin just provides a shortcode and an interface with post attachments. You'll have to do it the old fashioned way. 

= How do I add images to a gallery? =
Attach new images to the page with the gallery using the media panel

= How do I remove images from the gallery =
Unattach images from the page with the gallery using the media panel

= How do I change the theme? =
This plugin uses the Classic theme, which is free. Refer to the Galleria.io page for their other themes. 

== Changelog ==
=1.0.1=
* changed echos to returns, fixed rendering errors related to output buffering.*

=0.11=
*updated readme, added screenshots

=0.10=
* did the thing

== Upgrade Notice ==

= 0.11 =
Updated readme