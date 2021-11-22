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

<li class="dz-preview dz-image-preview fc_border_all fc_shadow_small fc_br_all {if !$image}prevTemp prevTemp_{$gallery_id}{/if}" id="catG_{if !$image}__image_id__{else}{$image.image_id}{/if}">
	<div class="catG_IMG_options">
		<p class="drag_corner icon-resize" title="{translate('Reorder image')}"></p>
		<p class="cG_icon-feed cG_publish{if $image.published} active{/if}" title="{translate('Publish this image')}"></p>
		<div class="cc_catG_del">
			<span class="icon-remove" title="{translate('Delete this image')}"></span>
			<p class="fc_br_right fc_shadow_small">
				<span class="cc_catG_del_res">{translate('Keep it!')}</span>
				<strong> | </strong>
				<span class="cc_catG_del_conf">{translate('Confirm delete')}</span>
			</p>
		</div>
	</div>
	<form action="{$CAT_URL}/modules/cc_catgallery/save.php" method="post" class="ajaxForm">
		<input type="hidden" name="page_id" value="{$page_id}">
		<input type="hidden" name="section_id" value="{$section_id}">
		<input type="hidden" name="gallery_id" value="{$gallery_id}">
		<input type="hidden" name="imgID" value="{if !$image}__image_id__{else}{$image.image_id}{/if}">
		<input type="hidden" name="action" value="saveIMG">
		<input type="hidden" name="image_options" value="alt,url,title,isH1,video,fullheight,showButton,darkVideo">
		<input type="hidden" name="_cat_ajax" value="1">
		<div class="cc_catG_left dz-details">
			<p class="cc_catG_image">
				<img data-dz-thumbnail="" src="{if $image}{$image.thumb}{/if}" width="auto" height="120" ><br>
			</p>
			<p class="dz-filename">
				<strong>{translate('Name of image')}: </strong><span data-dz-name="">{$image.picture}</span>
			</p>
			<p{if !$image} class="cc_catG_disabled"{/if}>
				<strong>{translate("Image Title")}:<br></strong>
				<input type="text" name="title" value="{if $image.options.title}{$image.options.title}{/if}" {if !$image}disabled{/if}><br>
				<input id="isH1_{if !$image}__image_id__{else}{$image.image_id}{/if}" class="fc_checkbox_jq" type="checkbox" name="isH1" value="1" {if $image.options.isH1}checked="checked" {/if}{if !$image}disabled{/if}>
				<label for="isH1_{if !$image}__image_id__{else}{$image.image_id}{/if}">{translate("H1 heading")}</label>
			</p>
			<p{if !$image} class="cc_catG_disabled"{/if}>
				<strong>{translate('Alternative text')}:<br></strong>
				<input type="text" name="alt" value="{if $image.options.alt}{$image.options.alt}{/if}" {if !$image}disabled{/if}>
				<strong>{translate('URL to video')} ({translate('optional')}):<br></strong>
				<input type="text" name="url" value="{if $image.options.url}{$image.options.url}{/if}" {if !$image}disabled{/if}>
			</p>
			<p{if !$image} class="cc_catG_disabled"{/if}>
				<input id="darkVideo_{if !$image}__image_id__{else}{$image.image_id}{/if}" class="fc_checkbox_jq" type="checkbox" name="darkVideo" value="1" {if $image.options.darkVideo}checked="checked" {/if}>
				<label for="darkVideo_{if !$image}__image_id__{else}{$image.image_id}{/if}">{translate("Dark video")}</label><br>
				
				<input id="showButton_{if !$image}__image_id__{else}{$image.image_id}{/if}" class="fc_checkbox_jq" type="checkbox" name="showButton" value="1" {if $image.options.showButton}checked="checked" {/if}>
				<label for="showButton_{if !$image}__image_id__{else}{$image.image_id}{/if}">{translate("Button down")}</label><br>

				<input id="fullheight_{if !$image}__image_id__{else}{$image.image_id}{/if}" class="fc_checkbox_jq" type="checkbox" name="fullheight" value="1" {if $image.options.fullheight}checked="checked" {/if}>
				<label for="fullheight_{if !$image}__image_id__{else}{$image.image_id}{/if}">{translate("Over full browser height")}</label><br><br>
				
				<small>{translate("The video must be uploaded to the /media/video/folder in mp4, ogg and webm formats. The name (without file extension) must then be entered here.")}</small><br><br>
				<label for="video_{if !$image}__image_id__{else}{$image.image_id}{/if}" class="cc_In300px">{translate("Video filename")}:</label>
				<input type="text" name="video" value="{if $image.options.video}{$image.options.video}{/if}">
			</p><br>
		</div>
		<button class="toggleWYSIWYG input_50p fc_br_bottomleft fc_gradient1 fc_gradient_hover" {if !$image}disabled{/if}>{translate('Modify description')}</button>
		<input type="submit" class="input_50p fc_br_bottomright" value="{translate('Save image')}" {if !$image}disabled{/if}>
	</form>
	<div class="clear"></div>
	{if !$image}<div class="dz-progress fc_br_top"><span class="dz-upload fc_br_all" data-dz-uploadprogress=""></span></div>
	<div class="dz-error-message"><span data-dz-errormessage=""></span></div>{/if}
</li>
