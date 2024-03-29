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
 *   @copyright			2014, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}


<form action="{$CAT_URL}/modules/cc_catgallery/save.php" method="post" class="ajaxForm">
	<input type="hidden" name="page_id" value="{$page_id}">
	<input type="hidden" name="section_id" value="{$section_id}">
	<input type="hidden" name="gallery_id" value="{$gallery_id}">
	<input type="hidden" name="action" value="saveOptions">
	<input type="hidden" name="_cat_ajax" value="1">
	<input type="hidden" name="options" value="title,color">
	<span class="cc_In200px">Überschrift:</span>
	<input type="text" class="cc_In300px" name="title" value="{if $options.title}{$options.title}{/if}"><br>
	<span class="cc_In200px">Hintergrundfarbe (#...):</span>
	<input type="text" class="cc_In300px" name="color" value="{if $options.color}{$options.color}{/if}"><br>
	<input type="submit" name="speichern" value="{translate('Save')}">
</form>
