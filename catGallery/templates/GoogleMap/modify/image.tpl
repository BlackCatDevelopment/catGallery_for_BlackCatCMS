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
		{*<p class="icon-eye"></p>
		<p class="icon-scissors"></p>*}
	</div>
	<form action="{$CAT_URL}/modules/cc_catgallery/save.php" method="post" class="ajaxForm">
		<input type="hidden" name="page_id" value="{$page_id}" />
		<input type="hidden" name="section_id" value="{$section_id}" />
		<input type="hidden" name="gallery_id" value="{$gallery_id}" />
		<input type="hidden" name="imgID" value="{if !$image}__image_id__{else}{$image.image_id}{/if}" />
		<input type="hidden" name="action" value="saveIMG" />
		<input type="hidden" name="image_options" value="park" />
		<input type="hidden" name="_cat_ajax" value="1" />
		<div class="cc_catG_left dz-details">
			<p class="cc_catG_image">
				<img data-dz-thumbnail="" src="{$image.thumb}" width="auto" height="120" ><br>
			</p>
			<p class="dz-filename">
				<strong>{translate('Name of image')}: </strong><span data-dz-name="">{$image.picture}</span>
			</p>
		</div>
		{*<input type="submit" class="input_100p fc_br_bottom" value="{translate('Save image')}" {if !$image}disabled{/if}>*}
	</form>
	<div class="clear"></div>
	{if !$image}<div class="dz-progress fc_br_top"><span class="dz-upload fc_br_all" data-dz-uploadprogress=""></span></div>
	<div class="dz-error-message"><span data-dz-errormessage=""></span></div>{/if}
</li>
