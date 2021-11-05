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

<form action="{$CAT_URL}/modules/catGallery/save.php" method="post" class="ajaxForm">
	<input type="hidden" name="page_id" value="{$page_id}" />
	<input type="hidden" name="section_id" value="{$section_id}" />
	<input type="hidden" name="gallery_id" value="{$gallery_id}" />
	<input type="hidden" name="action" value="saveOptions" />
	<input type="hidden" name="_cat_ajax" value="1" />
	<input type="hidden" name="options" value="msize,mpos,mbackdrop,ititle,icontent" />

	<strong>{translate('Bootstrap 4 variant for BC 1.3.')}<br><br></strong>
	<p>
	<label for="msize_{$section_id}" class="cc_In200px">{translate('Modal size')}:</label>
    <select id="msize_{$section_id}" name="msize" class="cc_In100px">
		<option value=""{if $options.msize && $options.msize == ''} selected="selected"{/if}>{translate('Default')}</option>
		<option value="modal-sm"{if $options.msize && $options.msize == 'modal-sm'} selected="selected"{/if}>{translate('Small')}</option>
		<option value="modal-lg"{if $options.msize && $options.msize == 'modal-lg'} selected="selected"{/if}>{translate('Large')}</option>
		<option value="modal-xl"{if $options.msize && $options.msize == 'modal-xl'} selected="selected"{/if}>{translate('Extra large')}</option>
	</select>
	</p>
	<p>
	<input id="mpos_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="mpos" value="1" {if $options.mpos != 0} checked="checked" {/if} />
	<label for="mpos_{$section_id}" class="cc_In300px">{translate('Modal position')}:</label>
	<br />	
	<input id="mbackdrop_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="mbackdrop" value="1" {if $options.mbackdrop != 0} checked="checked" {/if} />
	<label for="mbackdrop_{$section_id}" class="cc_In300px">{translate('Static backdrop')}:</label>
	<br />	
	<input id="ititle_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="ititle" value="1" {if $options.ititle != 0} checked="checked" {/if} />
	<label for="ititle_{$section_id}" class="cc_In300px">{translate('Show image title')}:</label>
	<br />	
	<input id="icontent_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="icontent" value="1"{if $options.icontent != 0} checked="checked" {/if} />
	<label for="icontent_{$section_id}" class="cc_In300px">{translate('Show image description')}:</label>
	</p>
	<input type="submit" name="speichern" value="{translate('Save')}" />
</form>