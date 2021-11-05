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
 *   @author			Matthias Glienke, letima development
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}


<form action="{$CAT_URL}/modules/catGallery/save.php" method="post" class="ajaxForm">
	<input type="hidden" name="page_id" value="{$page_id}">
	<input type="hidden" name="section_id" value="{$section_id}">
	<input type="hidden" name="gallery_id" value="{$gallery_id}">
	<input type="hidden" name="action" value="saveOptions">
	<input type="hidden" name="_cat_ajax" value="1">
	<input type="hidden" name="options" value="960grid,interval,showArrow">
	<p>
		<label for="interval_{$section_id}" class="cc_In200px">{translate('Interval')}:</label>
		<input id="interval_{$section_id}" type="text" class="cc_In100px" name="interval" value="{if $options.interval}{$options.interval}{else}5000{/if}"> ms
	</p>
	<p class="cc_In300px">
		<input id="showArrow_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="showArrow" value="1" {if $options.showArrow}checked="checked" {/if}>
		<label for="showArrow_{$section_id}">{translate('Show arrow for scrolling down')}:</label>
	</p><br>
	<p class="cc_In300px">
		<input id="960grid_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="960grid" value="1" {if $options.960grid}checked="checked" {/if}>
		<label for="960grid_{$section_id}">{translate('Maximum width 960px')}:</label>
	</p><br>
	<input type="submit" name="speichern" value="{translate('Save')}">
</form>