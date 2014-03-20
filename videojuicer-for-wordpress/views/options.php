<?php
/*
Videojuicer For Wordpress
Copyright (C) <2012> <Videojuicer>

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

Full Terms can be found on the world wide web at http://opensource.org/licenses/GPL-2.0 or in license
*/
?>
<div class="wrap">
	<h2 class="vj_logo">
	<a href="http://www.videojuicer.com">Videojuicer</a></h2>
	<?php if ( isset($message) ) : ?>
	<div id="message" class="updated below-h2">
		<p><?php echo $message; ?></p>
	</div>
	<?php endif; ?>
	<form action="" method="POST">
		<div class="form-wrap">
			<h3>Settings</h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">Show Title</th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span>Show the title under the video if sent with the embed data</span>
									</legend>
									
									<label for="show_title">
										<input type="checkbox" <?php if ( $this->settings->show_title ) :?>checked="checked"<?php endif; ?> value="1" id="show_title" name="show_title" /> Show the title under the video (if sent with the embed data)
									</label>
								</fieldset>
							</td>
					</tr>

					<tr valign="top">
						<th scope="row">Show Author</th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span>Show the author under the video if sent with the embed data</span>
									</legend>

									<label for="show_author">
										<input type="checkbox" <?php if ( $this->settings->show_author ) :?>checked="checked"<?php endif; ?> value="1" id="show_author" name="show_author" /> Show the author under the video (if sent with the embed data)
									</label>
								</fieldset>
							</td>
					</tr>		
					
					<tr valign="top">
						<th scope="row">Show Description</th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span>Show the description under the video if sent with the embed data</span>
									</legend>

									<label for="show_description">
										<input type="checkbox" <?php if ( $this->settings->show_description ) :?>checked="checked"<?php endif; ?> value="1" id="show_description" name="show_description" /> Show the description under the video (if sent with the embed data)
									</label>
								</fieldset>
							</td>
					</tr>
					
					<tr><td colspan="2">&nbsp;</td></tr>
					
					<tr valign="top">
						<th scope="row">Default Embed Dimensions</th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span>Set the default dimensions to use when embedding</span>
									</legend>
									<div class="vj_dimensions">
										<div class="dim">
											<label for="width">Width</label>
											<input type='text' id='width' name='width' value='<?php echo $this->settings->width ? $this->settings->width : ''; ?>' />
										</div>
										<div class="dim_op">x</div>
										<div class="dim">
											<label for="height">Height</label>
											<input type='text' id='height' name='height' value='<?php echo $this->settings->height ? $this->settings->height : ''; ?>' />
										</div>
									</div>
									<div class="vj_clear">&nbsp;</div>
								</fieldset>
							</td>
					</tr>

					<tr valign="top">
						<th scope="row">Facebook</th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span>add facebook opengraph data to head</span>
									</legend>

									<label for="facebook">
										<input type="checkbox" <?php if ( $this->settings->facebook ) :?>checked="checked"<?php endif; ?> value="1" id="facebook" name="facebook" /> Add the facebook opengraph data. 
									</label>
								</fieldset>
							</td>
					</tr>

					<tr valign="top">
						<th scope="row">Facebook Additional</th>
							<td>
								<div class="form-field">
									<label for='fb_app'>Facebook App Id</label>
									<input type='text' id='fb_app' name='fb_app' value='<?php echo $this->settings->fb_app ? $this->settings->fb_app : ''; ?>' />
									<p> Your Facebook application ID 328227980312505 </p>
								</div>	
							</td>
					</tr>

					<tr valign="top">
						<th scope="row">Oembed</th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span>add oembed data to head</span>
									</legend>

									<label for="oembed">
										<input type="checkbox" <?php if ( $this->settings->oembed ) :?>checked="checked"<?php endif; ?> value="1" id="oembed" name="oembed" /> Add the oembed data. 
									</label>
								</fieldset>
							</td>
					</tr>	


							
				</tbody>
			</table>


			<input name="submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
		</div>
	</form>
</div>

<div class="vj_footer">
<p>Videojuicer and The Videojuicer Logo are Copyright (&copy;) <a href="http://www.videojuicer.com">Videojuicer</a> <?php echo date('Y'); ?>.  All Rights Reserved.</p>
<p>Videojuicer for Wordpress Plugin , Version <?php echo Videojuicer::VERSION; ?> </p>
</div>
