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
 *   @author			Dirk Grebe
 *   @copyright			2021, Black Cat Development
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
	<input type="hidden" name="options" value="cfade,cindicators,ititle,icontent" />

	<strong>{translate('Bootstrap 4 variant for BC 1.3.')}<br><br></strong>
	<p>
	<input id="cfade_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="cfade" value="1" {if $options.cfade != 0} checked="checked" {/if} />
	<label for="cfade_{$section_id}" class="cc_In300px">{translate('Activate fade')}:</label>
	<br />
	<input id="cindicators_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="cindicators" value="1" {if $options.cindicators != 0} checked="checked" {/if} />
	<label for="cindicators_{$section_id}" class="cc_In300px">{translate('Show indicators')}:</label>
	<br />	
	<input id="ititle_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="ititle" value="1" {if $options.ititle != 0} checked="checked" {/if} />
	<label for="ititle_{$section_id}" class="cc_In300px">{translate('Show image title')}:</label>
	<br />	
	<input id="icontent_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="icontent" value="1"{if $options.icontent != 0} checked="checked" {/if} />
	<label for="icontent_{$section_id}" class="cc_In300px">{translate('Show image description')}:</label>
	</p>
	<input type="submit" name="speichern" value="{translate('Save')}" />
</form>