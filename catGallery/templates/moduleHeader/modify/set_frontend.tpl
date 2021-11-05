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
 *   @author			Matthias Glienke, letima
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
	<input type="hidden" name="options" value="version,kosten,einsatz,main_author,icon,plattform,offiziell,moduleName,darkmode">

	<p class="cc_In300px">
		<input id="darkmode_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="darkmode" value="1" {if $options.darkmode}checked="checked" {/if}>
		<label for="darkmode_{$section_id}">{translate('Dark image')}:</label>
	</p><br>

	<p class="cc_In300px">
		<input id="offiziell_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="offiziell" value="1" {if $options.offiziell}checked="checked" {/if}>
		<label for="offiziell_{$section_id}">{translate('Official addon')}:</label>
	</p><br>

	<span class="cc_In300px">{translate('Name of addon')}:</span>
	<input type="text" class="cc_In100px" name="moduleName" value="{if $options.moduleName}{$options.moduleName}{/if}"><br>

	<span class="cc_In300px">{translate('Current version of addon')}:</span>
	<input type="text" class="cc_In100px" name="version" value="{if $options.version}{$options.version}{/if}"><br>
	<span class="cc_In300px">{translate('Minimum version of BC')}:</span>
	<input type="text" class="cc_In100px" name="plattform" value="{if $options.plattform}{$options.plattform}{/if}"><br>
	<span class="cc_In300px">{translate('Main author of addon')}:</span>
	<input type="text" class="cc_In100px" name="main_author" value="{if $options.main_author}{$options.main_author}{/if}"><br>
	<span class="cc_In300px">{translate('Addon icon')} (/media/moduleHeader/...):</span>
	<input type="text" class="cc_In100px" name="icon" value="{if $options.icon}{$options.icon}{/if}"><br>
	<span class="cc_In300px">{translate('Where to use')}:</span>
	<textarea class="cc_In300px" name="einsatz">{if $options.einsatz}{$options.einsatz}{/if}</textarea><br>
	<span class="cc_In300px">{translate('Costs')}:</span>
	<input type="text" class="cc_In100px" name="kosten" value="{if $options.kosten}{$options.kosten}{/if}"><br>
	<input type="submit" name="speichern" value="{translate('Save')}">
</form>