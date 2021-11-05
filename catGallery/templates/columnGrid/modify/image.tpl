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
{$cont=preg_split('/<br[^>]*>/i',$image.image_content)}
<li class="dz-preview dz-image-preview fc_border_all fc_shadow_small fc_br_all {if !$image}prevTemp prevTemp_{$gallery_id}{/if}" id="catG_{if !$image}__image_id__{else}{$image.image_id}{/if}">
	{include(../../default/modify/image_options.tpl)}
	<form action="{$CAT_URL}/modules/catGallery/save.php" method="post" class="ajaxForm">
		<input type="hidden" name="page_id" value="{$page_id}">
		<input type="hidden" name="section_id" value="{$section_id}">
		<input type="hidden" name="gallery_id" value="{$gallery_id}">
		<input type="hidden" name="imgID" value="{if !$image}__image_id__{else}{$image.image_id}{/if}">
		<input type="hidden" name="action" value="saveIMG">
		<input type="hidden" name="image_options" value="alt,title,tel,url,adr1,adr2,urheber">
		<input type="hidden" name="_cat_ajax" value="1">
		<div class="cc_catG_left dz-details">
			<p class="cc_catG_image">
				<img data-dz-thumbnail="" src="{$image.thumb}" width="auto" height="120" ><br>
			</p>
			<p class="dz-filename">
				<strong>{translate('Name image')}: </strong><span data-dz-name="">{$image.picture}</span>
			</p>
			<p{if !$image} class="cc_catG_disabled"{/if}>
				
				<label for="title_{if !$image}__image_id__{else}{$image.image_id}{/if}">{translate('Title of category')}:</label>
				<input id="title_{if !$image}__image_id__{else}{$image.image_id}{/if}" type="text" name="title" value="{if $image.options.title}{$image.options.title}{/if}" {if !$image}disabled{/if}>
				<label for="alt_{if !$image}__image_id__{else}{$image.image_id}{/if}">{translate('Company')}:</label>
				<input id="alt_{if !$image}__image_id__{else}{$image.image_id}{/if}" type="text" name="alt" value="{if $image.options.alt}{$image.options.alt}{/if}" {if !$image}disabled{/if}>


				<label for="tel{if !$image}__image_id__{else}{$image.image_id}{/if}">{translate('Telephone')}:</label>
				<input id="tel{if !$image}__image_id__{else}{$image.image_id}{/if}" type="text" name="tel" value="{if $image.options.tel}{$image.options.tel}{/if}" {if !$image}disabled{/if}>
				<label for="url{if !$image}__image_id__{else}{$image.image_id}{/if}">{translate('Internetaddress')}:</label>
				<input id="url{if !$image}__image_id__{else}{$image.image_id}{/if}" type="text" name="url" value="{if $image.options.url}{$image.options.url}{/if}" {if !$image}disabled{/if}>
				<label for="adr1{if !$image}__image_id__{else}{$image.image_id}{/if}">{translate('Address line')} 1:</label>
				<input id="adr1{if !$image}__image_id__{else}{$image.image_id}{/if}" type="text" name="adr1" value="{if $image.options.adr1}{$image.options.adr1}{/if}" {if !$image}disabled{/if}>
				<label for="adr2{if !$image}__image_id__{else}{$image.image_id}{/if}">{translate('Address line')} 2:</label>
				<input id="adr2{if !$image}__image_id__{else}{$image.image_id}{/if}" type="text" name="adr2" value="{if $image.options.adr2}{$image.options.adr2}{/if}" {if !$image}disabled{/if}>
				<label for="urheber_{if !$image}__image_id__{else}{$image.image_id}{/if}">{translate('Author')}:</label>
				<input id="urheber_{if !$image}__image_id__{else}{$image.image_id}{/if}" type="text" name="urheber" value="{if $image.options.urheber}{$image.options.urheber}{/if}" {if !$image}disabled{/if}>
			</p>
		</div>
		<button class="toggleWYSIWYG input_50p fc_br_bottomleft fc_gradient1 fc_gradient_hover" {if !$image}disabled{/if}>{translate('Modify description')}</button>
		<input type="submit" class="input_50p fc_br_bottomright" value="{translate('Save image')}" {if !$image}disabled{/if}>
	</form>
	<div class="clear"></div>
	{if !$image}<div class="dz-progress fc_br_top"><span class="dz-upload fc_br_all" data-dz-uploadprogress=""></span></div>
	<div class="dz-error-message"><span data-dz-errormessage=""></span></div>{/if}
</li>
