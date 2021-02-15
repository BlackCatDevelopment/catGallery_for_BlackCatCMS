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
	<input type="hidden" name="page_id" value="{$page_id}">
	<input type="hidden" name="section_id" value="{$section_id}">
	<input type="hidden" name="gallery_id" value="{$gallery_id}">
	<input type="hidden" name="action" value="saveOptions">
	<input type="hidden" name="_cat_ajax" value="1">
	<input type="hidden" name="options" value="stextalign,shead,sheadlevel,stextstyle,sdivider,sdcolor,sdicon,sleadtext">

	<strong>{translate('Bootstrap 4 variant for BC 1.3.')}<br><br></strong>
	<p>
	<label class="cc_In200px">{translate('Section Header Text Pos.')}:</label>
		<select name="stextalign" class="cc_In100px">
		<option value=""{if $options.stextalign && $options.stextalign == ''} selected="selected"{/if}>{translate('Default')}</option>
        <option value="text-center"{if $options.stextalign && $options.stextalign == 'text-center'} selected="selected"{/if}>{translate('Align Centered')}</option>
        <option value="text-right"{if $options.stextalign && $options.stextalign == 'text-right'} selected="selected"{/if}>{translate('Align Right')}</option>
        </select>
	</p>
	<p>
	<label for="shead" class="cc_In200px">{translate('Section Headline')}:</label>
	<br />
		<input class="cc_In50pc" type="text" name="shead" id="shead_{$section_id}" placeholder="{translate('Headline')}" value="{if $options.shead}{$options.shead}{/if}" />
		&nbsp;&nbsp;
		<label class="cc_In50px">{translate('Size')}:</label>
		<select name="sheadlevel">
		{foreach array(1,2,3,4) i}
		<option value="{$i}"{if $options.sheadlevel && $i == $options.sheadlevel} selected="selected"{/if}>Level {$i}</option>
		{/foreach}
		</select>
		&nbsp;&nbsp;
		<label class="cc_In50px">{translate('Style')}:</label>
		<select name="stextstyle">
		<option value=""{if $options.stextstyle && $options.stextstyle == ''} selected="selected"{/if}>{translate('Default')}</option>
		<option value="text-uppercase"{if $options.stextstyle && $options.stextstyle == 'text-uppercase'} selected="selected"{/if}>{translate('Uppercase')}</option>
        </select>
	</p>
	<p class="cc_In300px">
		<input type="checkbox" name="sdivider" class="fc_checkbox_jq" value="1"{if $options.sdivider != 0} checked="checked"{/if} id="sdivider_{$section_id}" ><label for="sdivider_{$section_id}">{translate('Divider')}:</label>
	</p>
	<br />
	<p>
		<label class="cc_In200px">{translate('Divider Icon')}:</label>
		<input type="text" class="cc_In100px" name="sdicon" id="sdicon_{$section_id}" placeholder="{translate('star')}" value="{if $options.sdicon}{$options.sdicon}{/if}" />
	</p>
	<p>
		<label class="cc_In200px">{translate('Divider Color')}:</label>
        <select name="sdcolor" class="cc_In100px">
		<option value="white"{if $options.sdcolor && $options.sdcolor == 'white'} selected="selected"{/if}>{translate('White')}</option>
		<option value="primary"{if $options.sdcolor && $options.sdcolor == 'primary'} selected="selected"{/if}>{translate('Primary')}</option>
		<option value="secondary"{if $options.sdcolor && $options.sdcolor == 'secondary'} selected="selected"{/if}>{translate('Secondary')}</option>
		<option value="success"{if $options.sdcolor && $options.sdcolor == 'success'} selected="selected"{/if}>{translate('Success')}</option>
		<option value="danger"{if $options.sdcolor && $options.sdcolor == 'danger'} selected="selected"{/if}>{translate('Danger')}</option>
		<option value="warning"{if $options.sdcolor && $options.sdcolor == 'warning'} selected="selected"{/if}>{translate('Warning')}</option>
		<option value="info"{if $options.sdcolor && $options.sdcolor == 'info'} selected="selected"{/if}>{translate('Info')}</option>
		<option value="light"{if $options.sdcolor && $options.sdcolor == 'light'} selected="selected"{/if}>{translate('Light')}</option>
		<option value="dark"{if $options.sdcolor && $options.sdcolor == 'dark'} selected="selected"{/if}>{translate('Dark')}</option>
        </select>
	</p>
	<p>
    <label for="sleadtext" class="cc_In200px">{translate('Section Lead Text')}:</label>
	<br />
    <textarea class="cc_In50pc" name="sleadtext">{if $options.sleadtext}{$options.sleadtext}{/if}</textarea><br />
	</p>
	<input type="submit" name="speichern" value="{translate('Save')}">
</form>