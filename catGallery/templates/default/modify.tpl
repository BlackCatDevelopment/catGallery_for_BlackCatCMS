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

<form action="{$CAT_URL}/modules/cc_catgallery/save.php" method="post" class="cc_catG_form" enctype="multipart/form-data">
	<div class="cc_catG_skin fc_br_top">
		<p class="icon-cog cc_toggle_set"> {translate('Set skin')}</p>
		<div class="fc_gradient1 fc_border_all_light fc_br_bottom fc_shadow_small">
			<select name="variant">
			{foreach $module_variants index variants}
				<option value="{$index}"{if $index == $options.variant} selected="selected"{/if}>{$variants}</option>
			{/foreach}
			</select><br/>
			<input type="submit" name="speichern" value="{translate('Save skin &amp; reload')}" /><br/>
			<input type="reset" name="reset" value="{translate('Close')}" />
		</div>
	</div>
	<div class="clear"></div>
	<div class="cc_catG_settings">
		<input type="hidden" name="page_id" value="{$page_id}" />
		<input type="hidden" name="section_id" value="{$section_id}" />
		<input type="hidden" name="gallery_id" value="{$gallery_id}" />
		<input type="hidden" name="options" value="effect,resize_x,resize_y,animSpeed,pauseTime,random,label" />
		<input type="hidden" name="image_options" value="alt" />
		<ul class="cc_catG_nav fc_br_left">
			<li class="active fc_br_topleft">{translate('Upload new image')}</li>
			<li>{translate('Options for frontend')}</li>
			<li class="fc_br_bottomleft">{translate('Image option')}</li>
		</ul>
		<ul class="cc_catG_tabs fc_br_right">
			<li class="cc_catG_tab active">
				<div class="cc_dropzone fc_br_all">
					{translate('Drag &amp; drop')}<span>{translate('your images here to upload')}.</span>
				</div>
			</li>
			<li class="cc_catG_tab">
				<span class="cc_In200px">{translate('Kind of animation')}:</span>
				<select name="effect">
					<option value="0"{if !$options.effect} selected="selected"{/if}>{translate('No effect selected...')}</option>
					{foreach $effects as option}
					<option value="{$option}"{if $options.effect == $option} selected="selected"{/if}>{$option}</option>
					{/foreach}
				</select><br/>
				<span class="cc_In200px">{translate('Time until animation')}:</span>
				<input type="text" class="cc_In100px" name="pauseTime" value="{if $options.pauseTime}{$options.pauseTime}{else}8000{/if}" /> ms<br/>
				<span class="cc_In200px">{translate('Time for animation')}:</span>
				<input type="text" class="cc_In100px" name="animSpeed" value="{if $options.animSpeed}{$options.animSpeed}{else}3000{/if}" /> ms<br/>
				<span class="cc_In200px">{translate('Width of label (Set to 0 for no labels)')}:</span>
				<input type="text" class="cc_In100px" name="label" value="{if $options.label}{$options.label}{else}0{/if}" /> px<br/>
				<p class="cc_In300px">
					<input id="random_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="random" value="1" {if $options.random}checked="checked" {/if}/>
					<label for="random_{$section_id}">{translate('Show images by chance')}:</label>
				</p><br/>
				<input type="submit" name="speichern" value="{translate('Save')}" />
			</li>
			<li class="cc_catG_tab">
				<p class="cc_catG_dreispalten">
					<span class="cc_In200px">{translate('Adjust horizontal')}:</span>
					<input type="text" class="cc_In100px" name="resize_x" value="{if $options.resize_x}{$options.resize_x}{else}724{/if}" /> px<br/>
					<span class="cc_In200px">{translate('Adjust vertical')}:</span>
					<input type="text" class="cc_In100px" name="resize_y" value="{if $options.resize_x}{$options.resize_y}{else}407{/if}" /> px<br/>
				</p>
				<input type="submit" name="speichern" value="{translate('Save')}" />
			</li>
			<li class="cc_catG_tab">
				<p>
					<input type="hidden" name="upload_counter" value="1" />
					<input type="file" size="32" class="new_image" name="new_image_1" /><br/>
					<span class="small">{translate('Please notice, that loadingtime increases on more images')}</span>
				</p>
				<div class="fc_gradient1">
					<input type="submit" name="speichern" value="{translate('Upload/ Save')}" />
					<button class="upload fc_gradient1 fc_gradient_hover">{translate('Add another upload')}</button>
					<input type="reset" value="{translate('Cancel')}" onclick="javascript: window.location = '{$CAT_ADMIN_URL}/pages/modify.php?page_id={$page_id}';" />
				</div>
			</li>
		</ul>
		<div class="clear"></div>
	</div>
	<p>{translate('Existing images')}</p>
	{if $images}
	<ul class="cc_catG_imgs">
		{$counter = 0}
		{foreach $images as image}
		<li class="fc_border_all fc_shadow_small fc_br_all">
			<p class="cc_catG_del">
				<span class="fc_close" title="{translate('Delete this image')}"></span>
				<span class="cc_catG_del_res">{translate('Keep it!')}</span>
				<strong> | </strong>
				<span class="cc_catG_del_conf">{translate('Confirm delete')}</span>
			</p>
			<input type="hidden" name="image_ids[]" value="{$image.image_id}" >
			<input type="hidden" name="picture_{$image.image_id}" value="{$image.picture}" >
			<div class="cc_catG_left">
				<p class="cc_catG_image">
					<img src="{$folder_url}/{$image.picture}" width="auto" height="120" ><br>
				</p>
				<p>
					<strong>{translate('Name of image')}:</strong> {$image.picture}
				</p>
				<p>
					<strong>{translate('Alternative text')}:<br></strong>
					<input type="text" name="alt_{$image.image_id}" value="{if $image.options.alt}{$image.options.alt}{/if}" >
				</p>
				<button class="toggleWYSIWYG">Bearbeiten</button>
			</div>
			<div class="cc_catG_right">
				<p>
					<strong>{translate('Description for Image')}:</strong>
				</p>
				{show_wysiwyg_editor($image.contentname,$image.contentname,$image.image_content,'100%','150px')}
			</div>
			<div class="clear"></div>
		{$counter = $counter + 1}
		</li>
		{/foreach}
	</ul>
	{else}<p>{translate('No images available')}</p>{/if}
</form>