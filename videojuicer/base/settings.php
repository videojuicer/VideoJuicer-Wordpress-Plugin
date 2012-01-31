<?php
/*
VideoJuicer For Wordpress
Copyright (C) <2012> <VideoJuicer>

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

Full Terms can be found on the world wide web at http://opensource.org/licenses/GPL-2.0 or in license
*/
/**

	Settings handler , connects the plugin to the settings in options , currently NOT using settings API as it causes to many issues. 

	Note this class Assumes the options are stored as any array , as recommended by wordpress

	@todo : implement wordpress setting API when api is better documentated / more stabily 

	@param Sting $option - The option to load and store the settings.
	@param Array $allowed - An array of fields that this instance is allowed to change
	@param Bool $auto_save - If true the plugin will save the settings everytime a setting is set (default TRUE)

	@var Array $data - stores all the setting data as an array
	@var Array $allowed - stores an array of fields this instance can change as set by param $allowed
	@var String $option - The option to use based by param $option
	@var Bool $auto_save - Whether to automatically update the database set by param $auto_save

	@return null
**/
if ( !class_exists('videojuicer_settings') ) {
	class videojuicer_settings 
	{
		protected $data;
		protected $allowed;
		protected $option;
		protected $auto_save;

		public function __construct( $option , array $allowed , $auto_save = TRUE )
		{
			$this->option = $option;
			$this->auto_save = $auto_save;
			$this->allowed = $allowed;

			if ( get_option( $this->option , FALSE) ) {
				$this->data = get_option( $this->option );
			}
			else {
				wp_die(__('Can\'t find plugin\'s settings , please try deactivating and reactivating plugin or fully re-installing the plugin. If the problem continues please contact plugin developer') );
			}
		}

		/**

		Magic __get function allows you to get settings by going $class->some_setting , 

		@param String $name The name of the setting you wish to retrieve

		@return Mixed returns the value of the setting , return false if setting doesn't exist in $data , similar behaviour to the get_option function 

		**/
		public function __get($name)
		{
			if ( array_key_exists($name, $this->data) ) {
				return $this->data[$name];
			}
			
			return FALSE;
		}

		/**

		Magic __set function allows you to set a setting using $class->some_setting = some_value. 
		( please note , the $name must be allowed in the videojuicer_settings::allowed array )

		@param String $name The name of the setting you to set
		@param Mixed $value The value to set the setting to

		@return videojuicer_settings returns an instance of this class to allow chaining

		**/

		public function __set($name , $value) {
			if ( !in_array($name, $this->allowed ) ) {
				return $this;
			}

			$this->data[$name] = $value;

			if ( $this->auto_save ) {
				$this->save();
			}

			return $this;
		}

		/**

		Clears the current settings , or an array of settings

		**/

		public function clear( $settings_to_clear = null )
		{
			$list = array();

			if ( !is_null($settings_to_clear) ) {
				$list = $settings_to_clear;
			} else {
				$list = array_keys($this->data);
			}

			foreach ( $list as $setting ) {
				$this->__set($setting , 0 );
			}
		}

		/**

		Write the plugin settings to the database 

		@param null
		@return null

		**/
		public function save() {
			update_option( $this->option , $this->data );
		}
	}
}