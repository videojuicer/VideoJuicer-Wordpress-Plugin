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
This handles font end work 
**/

class videojuicer_frontend
{
	private $settings;

	private $embed;

	private static $embeds = array();

	public function __construct()
	{
		$this->settings = new videojuicer_settings(Videojuicer::OPTION, array());
	}

	public function get_embed( $using )
	{

		if ( array_key_exists("{$using['seed']}_{$using['presentation']}" , self::$embeds) ) {
			return self::$embeds["{$using['seed']}_{$using['presentation']}"];
		}

		$endpoint = $this->build_string( Videojuicer::OEMBED_ENDPOINT , array('seed' => $using['seed'] ));
		$url = $this->build_string(  Videojuicer::URL_SCHEMA , array('seed' => $using['seed'] , 'presentation' => $using['presentation'] ));

		$request = array( 'endpoint' => $endpoint,
						  'url' => $url,	
						  'maxwidth' => $using['width'],
						  'maxheight' => $using['height']
		);	
		
		Ion_Log::debug(var_export($request , true));

		$embed = null;
	
		try {
			$embed = new videojuicer_embed( $request , TRUE);
		}
		catch( Exception $e ) {
			Ion_Log::error($e->message);
			return 'Sorry an Error has occured';
		}

		self::$embeds["{$using['seed']}_{$using['presentation']}"] = $embed;

		return $embed;
	}

	public function shortcode( $attr ) 
	{
		$defaults = array('presentation' => '',
						  'width' => ($this->settings->width ? $this->settings->width : ''),
						  'height' => ($this->settings->height ? $this->settings->height : ''),
						  'seed' => $this->settings->seed_id);

		$final = shortcode_atts( $defaults , $attr );

		$count = 0;


		foreach ( $final as $key => $value ) 
		{
			if ( !empty($attr[$count]) ) {
				$final[$key] = $attr[$count];
			}
			$count++;
		}


		$this->embed = $this->get_embed($final);


		$string = '';

		if ( $this->settings->show_title && strlen($this->embed->title) > 0 ) {
			$string .= "<p>{$this->embed->title} </p>";
		}
		if ( $this->settings->show_author && strlen($this->embed->author_name) > 0 ) {
			$string .= "<p>{$this->embed->author_name}</p>";
		}

		if ( $this->settings->show_description && 
			strlen($this->embed->ogDescription ) > 0 && 
			$this->embed->ogDescription != 'No description' ) 
		{
			$string .= "<p>{$this->embed->ogDescription}</p>";
		}

		return ( '<div>'.$this->embed->html.$string.'</div>' );
	}

	public function og_metadata( $posts ) {

		if ( count($posts) > 1 ) return;

		// \[v(ideo)?j(uicer)?(.*)\] 

		if ( preg_match_all( '|(?mi-Us)\[(v(ideo)?j(uicer)?.*)\]|', $posts[0]->post_content, $matchs) == true) {

			$other = array(
				"og:local" => get_locale(),
				"og:site_name" => get_site_option("blogname" , "Videojuicer" , true)
			);

			Ion_Log::debug(print_r($other , true));

			$params = explode(' ', $matchs[1][0]);

			$ordered = array("presentation" , "width" , "height" , "seed");
			$attr = array();
			$c =0;

			foreach ( $params as $parameter ) {

	  		if ( preg_match('/(?mi-Us)(videojuicer|vj)/', $parameter) ) continue;

				if ( false !== strpos($parameter , "=") ) {
					$parts = explode("=", $parameter);

					$attr[$parts[0]] = $parts[1];

				}
				else {
					$attr[$ordered[$c]] = $parameter;
				}

				$c++;
			}

			$oembed_data = $this->get_embed($attr)->__toArray();

			unset($oembed_data["og:site_name"]);

			$ogdata = array_merge($other , $oembed_data);

			Ion_Log::debug(print_r($ogdata , true));

			foreach ( $ogdata as $key => $value ) {

				if ( preg_match_all( '|(?mi-Us)(og+):(.*)|', $key, $results) && is_string($value) && !is_null($value) ) {
					
					Ion_Log::debug($key);

					$value = htmlspecialchars($value);

					echo "<meta property=\"{$key}\" content=\"{$value}\" />".PHP_EOL;
				}
			}

		}
	}

	private function build_string( $template , array $tags ) 
	{

		foreach ( $tags as $tag => $value ) {
			$template = str_replace('{'.$tag.'}', $value, $template);
		}

		return $template;
	}
}