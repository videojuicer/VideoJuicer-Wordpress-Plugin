=== Videojuicer For Wordpress ===
Contributors: vj_martin
Tags: video , media , videojuicer , video jucier , helper
Requires at least: 3.0
Tested up to: 3.4
Stable tag: trunk
License: GPLv2

A helper plugin to embed Video content hosted by Videojuicer 

== Description ==

Allowing you to quickly embed video content from [Videojuicer](http://www.videojuicer.com) into any 
wordpress page or post. 

You can configure the plug-in to show the video's meta data in the post ( where available ) , as 
well as default dimensions to display the video at and a default seed to use. 

The plugin also adds in the required meta data tags to support both open graph integration with facebook
and Oembed integration. 

## Usage

There is also a PDF visual start guide inside the folder. 

Inserting the content is a simple as inserting [videojuicer {presentation id}] in to the post / page body 
for example [videojuicer 16]. 

For convenience there is also a button on the editor that allows you to insert the shortcode.

You can setup other options in the shortcode to, ether by naming them of placing them in a certain order. 

**example**

[videojuicer {presentation id} {width} {height} {seed id}]

e.g [videojuicer 16 640 480]

or 

[videojuicer presentation={id} width={width} height={height} seed={seed}]

e.g [videojuicer presentation=16 width=640 height=480 seed=demo] 

Please note: for the first example to work correctly you need to place the parameters in that order. 

**Alternative**

For those of you who like to keep things short you can also use the alias [vj] 

## Options

* Presentation (**required**) : The id of the presentation if you do not know this please contact Videojuicer
* width		  : The width to embed the video at in pixels ( note you do not need the px i.e use 800 not 800px)
* height     : The height at which to embed the video again in pixels
* seed		  : Your Videojuicer seed ID please contact Videojuicer if you are unsure as to what this is

## Settings

Default configuration settings can be set up by visiting Settings => Videojuicer in the Wordpress admin area.
Normally located at http://www.yourdomain.com/wp-admin. These settings are used when you don't specify anything different. This allows you to insert video without setting up the seed id or dimensions. It also allows you to setup whether or not you want the meta data about the video displayed in the post, such as 
Title

* Seed Id     	 : A default Seed ID to use 
* Show Title  	 : Displays the Video's title below the video $
* Show Author 	 : Display the Video's author below the video $
* Show Description : Display the Video's description below the video $

* Default Embed Dimensions: The default Width and Height to use when embedding video content. This is in Pixels. *Please note you don't need to including the 'px' as above.*

* Facebook : Whether you want to include the facebook Opengraph meta data to allow better integration with Facebook 
*Please note this has not been tested with other facebook plugins and may cause problems*

* Facebook additional 
  * Facebook App Id : This allows you to add your facebook app ID

* Oembed : Whether you want to include the Oembed link tags.

$ Depending on the data been supplied by the Videojuicer Oembed endpoint. 

== Installation ==

Installation instruction may change depending on Videojuicer submitting the plugin to the Wordpress plugin directory.

1. Download the plugin from Videojuicer's GitHub at 
2. copy / upload the Videojuicer directory to /wp-content/plugins/ so you end up with /wp-content/plugins/videojuicer
3. Activate the plugin in the Wordpress admin area , normally located at /wp-admin
4. Setup the defaults in Setting => Videojuicer

== Frequently Asked Questions ==

How do I report a bug / request a new feature?
*At our github issue tracker https://github.com/videojuicer/VideoJuicer-Wordpress-Plugin/issues*

Why should I use this plugin?
*The plugin allows you to easily insert the latest Videojuicer embed codes and can take care of facebook opengraph tags , allowing you to get on with what you do, producing content. Safe in the knowledge that you will automatically get the latest features and updates for your seed.*

What is Videojuicer?
*Videojuicer is all about getting more from video and gaining the attention of audiences in a crowded social space. Our strategy is to look at the right combination of video content, the context in which it’s viewed and the kinds of calls to action to which audiences might respond. for more visit us at http://www.videojuicer.com/*

How do I get a Videojuicer account?
*Please visit our website at http://www.videojuicer.com/ to see what we do. Alternatively you can contact a member of the Videojuicer team at info@videojuicer.com

== Screenshots ==

1. The Editor Showing the Videojuicer button
2. The Editor Showing the Videojuicer easy insert dialog
3. The Editor Showing the Shortcodes
4. The Options Screen.

== Changelog ==

= 1.3.2 =
* Added fb:app_id support 
* Tested up to 3.4 

= 1.3.1 =
* Added Visual Quick start guide
* Spell checked this readme document. 

= 1.3.0 =
* Added support for Opengraph Meta tags
* Added support for Oembed Meta tags
* Added debugging tool "Ion_Log"

= 1.0 =
* Intial release.

== License ==

GNU General Public License, version 2 (GPL-2.0)

Videojuicer For Wordpress
Copyright (C) <2012> <Videojuicer>

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

Full Terms can be found on the world wide web at http://opensource.org/licenses/GPL-2.0 or in license