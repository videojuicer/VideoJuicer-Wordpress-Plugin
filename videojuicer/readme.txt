=== VideoJuicer For Wordpress ===
Contributors: vj_martin
Tags: video , media , videojuicer , video jucier , helper
Requires at least: 3.0.0
Tested up to: 3.3.1
Stable tag: trunk

A helper plugin to embed Video content hosted by VideoJuicer 

== Description ==


Allowing you to quickly embed video content from [VideoJuicer]: http://www.videojuicer.com into any 
wordpress page or post. 

You can configure the plug-in to show the video's meta data in the post ( where available ) , as 
well as default dimensions to display the video at and a default account to use. 

Usage
-----

Inserting the content is a simple as inserting [videojuicer {presentation id}] in to the post / page body 
for example [videojuicer 16]. 

For convenience there is also a button on the editor that allows you to insert the shortcode.

You can setup other options in the shortcode to, ether by naming them of placing them in a certain order. 

**example**

[videojuicer {presentation id} {width} {height} {seed id}]

or 

[videojuicer presentation="{id}" width="{width}" height="{height}" seed="{seed}"]

Please note: for the first example to work correctly you need to place the parameters in that order. 

**Alternative**

For those of you who like to keep things short you can also use the alias [vj] 

Options
-------

	Presentation* : The id of the presentation if you do not know this please contact VideoJuicer
	width		  : The width to embed the video at in pixels ( note you do not need the px 
				    i.e use 800 not 800px)
	height        : The height at which to embed the video again in pixals
	seed		  : Your VideoJuicer seed ID please contact VideoJuicer if you are unsure as to what this is

*Required

Settings
--------

Default configuration settings can be set up by visiting Settings => VideoJuicer in the Wordpress admin area.
Normally located at http://www.{your domain}/wp-admin. These settings are used when you don't specify anything different. This allows you to insert video without setting up the seed id or dimensions. It also allows you to setup whether or not you want the meta data about the video displayed in the post, such as 
Title

	Seed Id     	 : A default Seed ID to use 
	Show Title  	 : Displays the Video's title below the video $
	Show Author 	 : Display the Video's author below the video $
	Show Description : Display the Video's description below the video $

	Default Embed Dimensions: The default Width and Height to use when embeding video content. This is 
	Pixels , please note you don't need to including the 'px' as above.

$ Depending on the data been supplied by the VideoJuicer Oembed endpoint. 

== Installation ==

Installation instruction may change depending on VideoJuicer submitting the plugin to the wordpress plugin directory.

1. Download the plugin from VideoJuicer's GitHub at 
2. copy / upload the videojuicer directory to /wp-content/plugins/ so you end up with /wp-content/plugins/videojuicer
3. Activate the plugin in the Wordpress admin area , normally located at /wp-admin
4. Setup the defaults in Setting => VideoJuicer

== Screenshots ==

1. The Editor Showing the VideoJuicer button
2. The Editor Showing the VideoJuicer easy insert dialogue
3. The Editor Showing the Shortcodes
4. The Options Screen.

== Changelog ==

= 1.0 =
* Intial release.

== License ==

GNU General Public License, version 2 (GPL-2.0)

VideoJuicer For Wordpress
Copyright (C) <2012> <VideoJuicer>

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

Full Terms can be found on the world wide web at http://opensource.org/licenses/GPL-2.0 or in license