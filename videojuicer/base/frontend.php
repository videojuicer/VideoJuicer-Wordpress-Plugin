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
This handles font end work 
**/

class videojuicer_frontend
{
	private $settings;

	private $embed;

	public function __construct()
	{
		$this->settings = new videojuicer_settings(VideoJuicer::OPTION, array());
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

		$endpoint = $this->build_string( VideoJuicer::OEMBED_ENDPOINT , array('seed' => $final['seed'] ));
		$url = $this->build_string(  VideoJuicer::URL_SCHEMA , array('seed' => $final['seed'] , 'presentation' => $final['presentation'] ));

		$request = array( 'endpoint' => $endpoint,
						  'url' => $url,	
						  'maxwidth' => $final['width'],
						  'maxheight' => $final['height']
		);	

		try {
			$this->embed = new videojuicer_embed( $request , TRUE);
		}
		catch( Exception $e ) {
			return 'Sorry an Error as occured';
		}

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

	private function build_string( $template , array $tags ) 
	{

		foreach ( $tags as $tag => $value ) {
			$template = str_replace('{'.$tag.'}', $value, $template);
		}

		return $template;
	}
}