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

<li class="dz-preview dz-image-preview fc_border_all fc_shadow_small fc_br_all {if !$image}prevTemp prevTemp_{$gallery_id}{/if}" id="catG_{if !$image}__image_id__{else}{$image.image_id}{/if}">
	{include(../../default/modify/image_options.tpl)}
	<form action="{$CAT_URL}/modules/cc_catgallery/save.php" method="post" class="ajaxForm">
		<input type="hidden" name="page_id" value="{$page_id}" />
		<input type="hidden" name="section_id" value="{$section_id}" />
		<input type="hidden" name="gallery_id" value="{$gallery_id}" />
		<input type="hidden" name="imgID" value="{if !$image}__image_id__{else}{$image.image_id}{/if}" />
		<input type="hidden" name="action" value="saveIMG" />
		<input type="hidden" name="image_options" value="caption,alt,layercolor,layerrounded,layerpadding,layerwidth,layerheight,layerhoffset,layervoffset,layerposition,thumbnail" />
		<input type="hidden" name="_cat_ajax" value="1" />
		<div class="cc_catG_left dz-details">
			<p class="cc_catG_image">
				<img data-dz-thumbnail="" src="{$image.thumb}" width="auto" height="120" ><br>
			</p>
			<p class="dz-filename">
				<strong>{translate('Name of image')}: </strong><span data-dz-name="">{$image.picture}</span>
			</p>
			<p{if !$image} class="cc_catG_disabled"{/if}>
				<strong>{translate('Picture Caption')}:<br></strong>
				<input type="text" name="caption" value="{if $image.options.caption}{$image.options.caption}{/if}" {if !$image}disabled{/if}>
				<strong>{translate('Alternative Text')}:<br></strong>
				<input type="text" name="alt" value="{if $image.options.alt}{$image.options.alt}{/if}" {if !$image}disabled{/if}>
				<strong>{translate('Text Layer Color')}:<br></strong>
				<select name="layercolor"{if !$image}disabled{/if}>
					<option value="white"{if $image.options.layercolor == 'white'}selected="selected"{/if}>{translate('white')}</option>
					<option value="black" {if $image.options.layercolor == 'black'}selected="selected"{/if}>{translate('black')}</option>
				</select>
			<br><br>
				<input id="layerrounded_{$image.picture}" name="layerrounded" class="fc_checkbox_jq" type="checkbox" value="sp-rounded" {if $image.options.layerrounded}checked="checked" {/if}/>
				<label for="layerrounded_{$image.picture}">{translate('Text Layer Rounded')}:</label>	
				<input id="layerpadding{$image.picture}" name="layerpadding" class="fc_checkbox_jq" type="checkbox" value="sp-padding" {if $image.options.layerpadding}checked="checked" {/if}/>
				<label for="layerpadding{$image.picture}">{translate('Text Layer Padding')}:</label>
			<br>
				<strong>{translate('Text Layer Width')}:<br></strong>	
				<input type="text" name="layerwidth" placeholder="{translate('Value in px or %')}" value="{if $image.options.layerwidth}{$image.options.layerwidth}{else} {/if}" {if !$image}disabled{/if}>
				<strong>{translate('Text Layer Height')}:<br></strong>
				<input type="text" name="layerheight" placeholder="{translate('Value in px or %')}" value="{if $image.options.layerheight}{$image.options.layerheight}{else} {/if}" {if !$image}disabled{/if}>
				<strong>{translate('Text Layer Offset Horizontal')}:<br></strong>
				<input type="text" name="layerhoffset" value="{if $image.options.layerhoffset}{$image.options.layerhoffset}{else}0px{/if}" {if !$image}disabled{/if}>
				<strong>{translate('Text Layer Offset Vertical')}:<br></strong>
				<input type="text" name="layervoffset" value="{if $image.options.layervoffset}{$image.options.layervoffset}{else}0px{/if}" {if !$image}disabled{/if}>
				<strong>{translate('Text Layer Position')}:<br></strong>
				<select name="layerposition"{if !$image}disabled{/if}>
					<option value="topLeft"{if $image.options.layerposition == 'topLeft'}selected="selected"{/if}>{translate('topLeft')}</option>
					<option value="topCenter" {if $image.options.layerposition == 'topCenter'}selected="selected"{/if}>{translate('topCenter')}</option>
					<option value="topRight" {if $image.options.layerposition == 'topRight'}selected="selected"{/if}>{translate('topRight')}</option>
					<option value="centerLeft"{if $image.options.layerposition == 'centerLeft'}selected="selected"{/if}>{translate('centerLeft')}</option>
					<option value="centerCenter" {if $image.options.layerposition == 'centerCenter'}selected="selected"{/if}>{translate('centerCenter')}</option>
					<option value="centerRight" {if $image.options.layerposition == 'centerRight'}selected="selected"{/if}>{translate('centerRight')}</option>
					<option value="bottomLeft"{if $image.options.layerposition == 'bottomLeft'}selected="selected"{/if}>{translate('bottomLeft')}</option>
					<option value="bottomCenter" {if $image.options.layerposition == 'bottomCenter'}selected="selected"{/if}>{translate('bottomCenter')}</option>
					<option value="bottomRight" {if $image.options.layerposition == 'bottomRight'}selected="selected"{/if}>{translate('bottomRight')}</option>
				</select>
				<strong>{translate('Thumbnail')}:<br></strong>
				<textarea class="cc_In50pc" name="thumbnail" value="{if $image.options.thumbnail}{$image.options.thumbnail}{/if}" {if !$image}disabled{/if}></textarea>
			</p>
		</div>
		<button class="toggleWYSIWYG input_50p fc_br_bottomleft fc_gradient1 fc_gradient_hover" {if !$image}disabled{/if}>{translate('Text Layer Content')}</button>
		<input type="submit" class="input_50p fc_br_bottomright" value="{translate('Save image')}" {if !$image}disabled{/if}>
	</form>
	<div class="clear"></div>
	{if !$image}<div class="dz-progress fc_br_top"><span class="dz-upload fc_br_all" data-dz-uploadprogress=""></span></div>
	<div class="dz-error-message"><span data-dz-errormessage=""></span></div>{/if}
</li>

