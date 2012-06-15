<?php
/*
Plugin Name: Videojuicer for Wordpress
Plugin URI: http://www.videojuicer.com
Description: This adds some Videojuicer Functionality to Wordpress
Version: 1.3.0
Author: VideoJucier
Author URI: http://www.videojuicer.com
License: GNU General Public License, version 2 (GPL-2.0)

Videojuicer For Wordpress
Copyright (C) <2012> <Videojuicer>

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

Full Terms can be found on the world wide web at http://opensource.org/licenses/GPL-2.0 or in license
*/

/**

Set The Enviroment Type 

**/

if ( !defined('ION_LOGENV') ) define('ION_LOGENV' , 'production');

/**

Load Required Fields 

**/

 foreach ( array('log' , 'admin' , 'settings' , 'frontend' , 'embed') as $file ) 
 {
 	require_once dirname(__FILE__).'/base/'.$file.'.php';
 }

 /**

Set the path to write the log to. 

**/

Ion_Log::$logpath = dirname(__FILE__).'/error.log';
Ion_Log::message("welcome to videojuicer wordpress plugin developer");

/**

This gets called when the plugin gets activated , according to the wordpress docs , it should be outside any class , and can not be registered by the init action. 

**/
register_activation_hook( WP_PLUGIN_DIR.'/videojuicer/videojuicer.php' , array('Videojuicer' , 'on_activation'));

/**
	Base Class , acts as a Namespace wrapper, to stop name conflicts with other plugins the user may have installed. All methods in this class should be static , this is to allow interface with wordpress. 

	@version 1.0
	@author Videojuicer 
**/

class Videojuicer {
	/**

	The Videojuicer oembed end point , should never change 

	**/

	const OEMBED_ENDPOINT = 'http://{seed}.api.videojuicer.com/oembed';

	/**

	The Videojuicer URL Schema for embeding
	The protocol is intentionally left of so the embed uses ssl if needed.

	**/

	const URL_SCHEMA = '{seed}.videojuicer.com/presentations/{presentation}.html';

	/**

	Plugin version , used for updates

	**/
	const VERSION = '1.3.0';

	/**

	Stores the user level required to administrate the plugin 
	see http://codex.wordpress.org/Roles_and_Capabilities

	NOTE : Must be all lower case , not title case as used in the documents i.e. author not Author.

	**/

	const ROLE = 'administrator';

	/**

	The name of the option stored in the options API with the plugin's settings in 

	**/

	const OPTION = 'videojuicer_settings';

	/**

	This is the relative location to the views folder

	**/

	const VIEWS = 'views/';

	/**

	This is the path with in the plugin where the Tinymce plugin lives

	**/

	const TINY_MCE = 'resources/editor_plugin.js';

	/**

	These are static class stores for the worker classes

	**/

	private static $admin_class;
	private static $frontend_class;


	/**

	This starts the plugin , it is attached to the init hook , outside of the class. 
	It adds all the actions and connects them to functions within the static namespace. This is again done to get round some issues with the way wordpress works. 

	@param null
	@return null

	**/
	public static function init() 
	{
		add_action('admin_init' , array(__CLASS__ , 'on_admin_init'));
		add_action('admin_menu' , array(__CLASS__ , 'on_admin_menu'));
		add_action('admin_head' , array(__CLASS__ , 'on_admin_head'));

		add_action('mce_external_plugins' , array(__CLASS__ , 'tinymce'));
		add_action('mce_buttons' , array(__CLASS__ , 'tinymce_button'));

		add_action('wp_head' , array(__CLASS__ , 'og_tags'));
		add_shortcode('vj' , array(__CLASS__ , 'shortcode_embed'));
		add_shortcode('videojuicer' , array(__CLASS__ , 'shortcode_embed'));
	}

	public static function get( $class ) {
		if ( !isset(self::${$class}) ) {
			$call = str_replace('_class', '', $class);
			$call = __CLASS__ . '_' . $call;
			self::${$class} = new $call();
		}

		return self::${$class};
	}

	public static function on_admin_init() 
	{
		Ion_Log::debug("booting admin");
		self::get('admin_class')->init();
	}

	public static function on_admin_menu()
	{
		Ion_Log::debug("attaching admin menu");
		self::get('admin_class')->menu();
	}

	public static function on_admin_head() 
	{
		Ion_Log::debug("generating admin head");
		self::get('admin_class')->head();
	}

	public static function tinymce( $plugins ) 
	{
		return self::get('admin_class')->tinymce( $plugins );
	}

	public static function tinymce_button( $buttons ) 
	{
		return self::get('admin_class')->tinymce_button( $buttons );
	}

	public static function shortcode_embed( $params ) 
	{
		return self::get('frontend_class')->shortcode( $params );
	}

	public static function og_tags() 
	{
		global $posts;
		self::get('frontend_class')->og_metadata($posts);
	}

	public static function on_activation() 
	{
		if ( !get_option(self::OPTION , FALSE) ) {
			add_option(self::OPTION , array('version' => self::VERSION , 'facebook' => true , 'oembed' => true) , '' , 'no');
		}
	}

}

/**

This boots the Plugin

**/
add_action('init' , array('Videojuicer' , 'init') );
