<?php
/*
Videojuicer For Wordpress
Copyright (C) <2012> <Videojuicer>

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

Full Terms can be found on the world wide web at http://opensource.org/licenses/GPL-2.0 or in license
*/
/**

	This class handles all the admin functionality for the plugin , it has some hooked functions that are called by wordpress actions hooks defined in videojuicer.php

**/

class videojuicer_admin
{
	private $view_path;
	private $settings;

	/**

	The construct sets up the class ready for use 

	**/
	public function __construct() 
	{
		$this->view_path = dirname(__FILE__).'/../'.Videojuicer::VIEWS;
		$this->settings = new videojuicer_settings( Videojuicer::OPTION , array('seed_id' , 'show_title' , 'show_author' , 'show_description' , 'width' , 'height'));
	}
	/**

		Attach the head , this can include js and css links  

	**/

	public function head() 
	{
		include_once($this->view_path.'admin_head.php');
	}

	/**

		Connected to the admin_init hook 

	**/
	public function init() 
	{

	}

	/**

		Connected to the admin_menu hook
		 
	**/
	public function menu() 
	{
		add_options_page(__('Videojuicer'),
				 		 __('Videojuicer'),
				 		 Videojuicer::ROLE,
				 		 'videojuicer',
				 		 array($this , 'options_page'));

		Ion_Log::debug("finished loading options");
	}

	/**

		This allows the user to alter the options for their Videojuicer account 

	**/
	public function options_page() 
	{

		if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->save_post();
			$message = 'Settings updated';
		}

		Ion_Log::debug("options");

		include $this->view_path.'options.php';			
	}

	private function save_post() {

		$this->settings->clear(array('show_title' , 'show_author' , 'show_description'));

		foreach ( $_POST as $setting => $value ) {
				$this->settings->__set($setting , trim($value) );
		}
	}

	/**

	This adds the Videojuicer button to the TinyMCE editor

	**/

	public function tinymce ( $plugins ) 
	{
		$plugin_path = dirname(__FILE__).'/../'.Videojuicer::TINY_MCE;

	//	if ( ! file_exists($plugin_path)) return $plugins;

		$url_to_plugin = WP_PLUGIN_URL.'/videojuicer/'.Videojuicer::TINY_MCE;

		$plugins['videojuicer'] = $url_to_plugin;

		return $plugins;
	}

	public function tinymce_button( $buttons )
	{
		array_push( $buttons , '|' , 'videojuicer' );
		return $buttons;
	}
}