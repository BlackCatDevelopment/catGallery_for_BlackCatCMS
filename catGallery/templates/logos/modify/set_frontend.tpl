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
 *   along with this program; if not, see <http://www.gnu.org/licenses>.
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
	<input type="hidden" name="page_id" value="{$page_id}" >
	<input type="hidden" name="section_id" value="{$section_id}" >
	<input type="hidden" name="gallery_id" value="{$gallery_id}" >
	<input type="hidden" name="action" value="saveOptions" >
	<input type="hidden" name="_cat_ajax" value="1" >
	<input type="hidden" name="options" value="image,color,animSpeed,pauseTime,random,imageMethod,buttonText,urlPage" >
	<input type="hidden" name="image_options" value="alt" >

	<span class="cc_In200px">{translate('Image')} (Relativ zu /media/):</span>
	<input type="text" class="cc_In100px" name="image" value="{if $options.image}{$options.image}{/if}" ><br>
	<span class="cc_In200px">{translate('Color')} (#.....):</span>
	<input type="text" class="cc_In100px" name="color" value="{if $options.color}{$options.color}{/if}" ><br>

	<span class="cc_In200px">{translate('Pause time')}:</span>
	<input type="text" class="cc_In100px" name="pauseTime" value="{if $options.pauseTime}{$options.pauseTime}{else}8000{/if}" > ms<br>
	<span class="cc_In200px">{translate('Time animation')}:</span>
	<input type="text" class="cc_In100px" name="animSpeed" value="{if $options.animSpeed}{$options.animSpeed}{else}3000{/if}" > ms<br>

    <label class="cc_In200px">Text Button</label>
    <input type="text" class="cc_In100px" name="buttonText" value="{if $options.buttonText}{$options.buttonText}{/if}"><br>

    <p><label for="urlPage_{$section_id}">{translate('Linked page')}:</label>
    <select name="urlPage" id="urlPage_{$section_id}">
        <option value="">--- {translate('No link')} ---</option>
        {foreach $pages page}
        <option value="{$page.page_id}"{if $options.urlPage == $page.page_id} selected="selected"{/if}>{if $page.level > 0}{for i 0 $page.level-1}|--{/for}{/if}{$page.menu_title}</option>
        {/foreach}
    </select></p>

    <p class="cc_In300px">
        <input id="random_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="random" value="1" {if $options.random}checked="checked" {/if}>
        <label for="random_{$section_id}">{translate('Show pictures randomly')}:</label>
    </p><br>
	<p class="cc_In300px">
        <label for="imageMethod_{$section_id}">Bild beschneiden</label>
        <select name="imageMethod" id="imageMethod_{$section_id}">
            <option {if $options.imageMethod=="crop"}selected="selected" {/if}value="crop">Crop</option>
            <option {if $options.imageMethod=="fit"}selected="selected" {/if}value="fit">Fit</option>
            <option {if $options.imageMethod=="fill"}selected="selected" {/if}value="fill">Fill</option>
        </select>
	</p><br>
	<input type="submit" name="speichern" value="{translate('Save')}" >
</form>
