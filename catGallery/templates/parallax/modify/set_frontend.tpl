{**
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author			Matthias Glienke
 *   @copyright			2019, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}


<form action="{$CAT_URL}/modules/cc_catgallery/save.php" method="post" class="ajaxForm">
	<input type="hidden" name="page_id" value="{$page_id}" />
	<input type="hidden" name="section_id" value="{$section_id}" />
	<input type="hidden" name="gallery_id" value="{$gallery_id}" />
	<input type="hidden" name="action" value="saveOptions" />
	<input type="hidden" name="_cat_ajax" value="1" />
	<input type="hidden" name="options" value="positionx,positiony,height" />
	<input type="hidden" name="image_options" value="alt" />
	<p>	
		<label for="positionx_{$section_id}" class="cc_In100px">{translate('Position X')}:</label>
		<select id="positionx_{$section_id}" class="cc_In300px" name="positionx">
			<option value="left" {if $options.positionx=="left"}selected="selected"{/if}>{translate('Left')}</option>
			<option value="right" {if $options.positionx=="right"}selected="selected"{/if}>{translate('Right')}</option>
			<option value="center" {if $options.positionx=="center"}selected="center"{/if}>{translate('Center')}</option>
		</select><br>
		
		<label for="positiony_{$section_id}" class="cc_In100px">{translate('Position Y')}:</label>
		<select id="positiony_{$section_id}" class="cc_In300px" name="positiony">
			<option value="top" {if $options.positionx=="top"}selected="selected"{/if}>{translate('Top')}</option>
			<option value="bottom" {if $options.positionx=="bottom"}selected="selected"{/if}>{translate('Bottom')}</option>
			<option value="center" {if $options.positionx=="center"}selected="center"{/if}>{translate('Center')}</option>
		</select><br>
		
		<label for="height_{$section_id}" class="cc_In100px">{translate('Height')}:</label>
		<input id="height_{$section_id}" type="text" class="cc_In300px" name="height" value="{if $options.title}{$options.height}{/if}">px
	</p><br>
	<input type="submit" name="speichern" value="{translate('Save')}" />
</form>
