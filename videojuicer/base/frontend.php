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
This handles front end work 
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
		
		$embed = null;
	
		try {
			$embed = new videojuicer_embed( $request , TRUE);
		}
		catch( Exception $e ) {
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

		Ion_Log::debug("facebook is ".var_export($this->settings->facebook , true));
		Ion_Log::debug("oembed is ".var_export($this->settings->oembed , true));

		if ( !$this->settings->facebook && !$this->settings->oembed ) return;

		Ion_Log::debug("Determining required header information");

		if ( count($posts) > 1 ) return;

		// \[v(ideo)?j(uicer)?(.*)\] 
		if ( preg_match_all( '|(?mi-Us)\[(v(ideo)?j(uicer)?.*)\]|', $posts[0]->post_content, $matchs) == true) {

			$other = array(
				"og:locale" => get_locale(),
				"og:site_name" => get_site_option("blogname" , "Videojuicer" , true),
				"fb:app_id" => ($this->settings->fb_app ? $this->settings->fb_app : null)
			);

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

			if ( count($attr) < 1 || !array_key_exists('presentation', $attr)) return;

			if ( !array_key_exists('seed', $attr) || is_null($attr['seed'])) {
				$attr['seed'] = $this->settings->seed_id;
			}

			$oembed = $this->get_embed($attr);

			$oembed_url_json = htmlspecialchars($oembed->build_url());
			$oembed_url_xml = str_replace("json", "xml", $oembed_url_json);

			$oembed_data = $oembed->__toArray();
			unset($oembed_data["og:site_name"]);
			$ogdata = array_merge($other , $oembed_data);

			// Oembed
			if ( $this->settings->oembed) {
				Ion_Log::debug("insert oembed data");
				// Oembed data
				echo "<link type=\"application/json+oembed\" href=\"{$oembed_url_json}\" title=\"{$ogdata["title"]} (oEmbed profile, JSON format)\" rel=\"alternate\" />".PHP_EOL;
				echo "<link type=\"application/xml+oembed\" href=\"{$oembed_url_xml}\" title=\"{$ogdata["title"]} (oEmbed profile, XML format)\" rel=\"alternate\" />".PHP_EOL;
			}

			// Facebook
			if ( $this->settings->facebook ) {
				Ion_Log::debug("insert facebook data");
				// OpenGraph Meta data 
				foreach ( $ogdata as $key => $value ) {
					if ( preg_match( '/(?mi-Us)(og|fb+):(.*)/', $key) // if an Opengraph or Facebook Namespace og: or fb:
							 && is_string($value) // The value is a string
							 && !is_null($value) // The value is no null
							 && $value != "" // The value is not blank
							 && !preg_match('|(?m-Usi)^No\s*.+|', $value) //the value is not "No something"
							) {
						$value = htmlspecialchars($value);
						echo "<meta property=\"{$key}\" content=\"{$value}\" />".PHP_EOL;
					}
				}

				// OpenGraph Video data
				foreach ( $ogdata["og:videos"] as $video ) {
					foreach ( $video as $video_data ) {
						 foreach ( $video_data as $key => $value) {
						 	$value = htmlspecialchars($value);		
							echo "<meta property=\"{$key}\" content=\"{$value}\" />".PHP_EOL;
						}
					}
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