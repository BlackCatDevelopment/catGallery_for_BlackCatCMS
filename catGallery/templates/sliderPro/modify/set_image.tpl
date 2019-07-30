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
	<input type="hidden" name="options" value="resize_x,resize_y" />
	<p class="cc_catG_dreispalten">
		<span class="cc_In200px">{translate('Picture width')}:</span>
		<input type="text" class="cc_In100px" name="resize_x" value="{if $options.resize_x}{$options.resize_x}{else}640{/if}" /> px<br/>
		<span class="cc_In200px">{translate('Picture height')}:</span>
		<input type="text" class="cc_In100px" name="resize_y" value="{if $options.resize_y}{$options.resize_y}{else}480{/if}" /> px<br/><br/>
	</p>
	<input type="submit" name="speichern" value="{translate('Save')}" />
</form>
