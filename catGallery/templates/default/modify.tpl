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

<script type="text/javascript">
	$(document).ready(function()
	\{
		$(".cc_dropzone").dropzone(
		\{
			url:		'{$CAT_URL}/modules/cc_catgallery/save.php',
			paramName:	'new_image',
			thumbnailWidth:		300,
			thumbnailHeight:	200,
			sending:	function(file, xhr, formData)
			\{
				formData.append('page_id',	{$page_id});
				formData.append('section_id', {$section_id});
				formData.append('gallery_id', {$gallery_id});
				formData.append('action', 'uploadIMG');
				formData.append('_cat_ajax', 1);
			},
			previewsContainer:	'.cc_catG_imgs',
			previewTemplate:	$('.prevTemp').clone().removeClass('prevTemp')[0].outerHTML,
			success:	function(file, xhr, formData)
			\{
				console.log(file, xhr, formData);
				var $newIMG	= $(file.previewElement),
					xhr		= JSON.parse(xhr),
					newID	= $newIMG.attr('id') + xhr.newIMG.image_id;
				$('.cc_catG_imgs').sortable( "refresh" );

				$newIMG.find('.dz-progress').remove();
				$newIMG.find('.dz-filename span').text(xhr.newIMG.picture);
				$newIMG.attr('id', newID );
				$newIMG.find('input[name=imgID]').val(xhr.newIMG.image_id);
				$newIMG.find('.cc_catG_image img').attr('src',xhr.newIMG.thumb);
				$newIMG.find('input:disabled, button:disabled').prop('disabled',false);
				$newIMG.find('.cc_catG_disabled').removeClass('cc_catG_disabled');
				dialog_form( $newIMG.find('.ajaxForm') );
				ceckIMG( $('.cc_catG_imgs') );
				console.log(xhr);
				console.log(newID);
				console.log(xhr.newIMG);
			}
		});
	});
</script>

<div class="cc_catG_form">
	<div class="cc_catG_skin fc_br_top">
		<p class="icon-cog cc_toggle_set"> {translate('Set skin')}</p>
		<form action="{$CAT_URL}/modules/cc_catgallery/save.php" method="post" class="fc_gradient1 fc_border_all_light fc_br_bottom fc_shadow_small">
			<input type="hidden" name="page_id" value="{$page_id}" />
			<input type="hidden" name="section_id" value="{$section_id}" />
			<input type="hidden" name="gallery_id" value="{$gallery_id}" />
			<input type="hidden" name="options" value="variant" />
			<select name="variant">
			{foreach $module_variants index variants}
				<option value="{$index}"{if $index == $options.variant} selected="selected"{/if}>{$variants}</option>
			{/foreach}
			</select><br/>
			<input type="submit" name="speichern" value="{translate('Save skin &amp; reload')}" /><br/>
			<input type="reset" name="reset" value="{translate('Close')}" />
		</form>
	</div>
	<div class="clear"></div>
	<div class="cc_catG_settings">
		<ul class="cc_catG_nav fc_br_left">
			<li class="active fc_br_topleft">{translate('Upload new image')}</li>
			<li>{translate('Options for frontend')}</li>
			<li class="fc_br_bottomleft">{translate('Image option')}</li>
		</ul>
		<ul class="cc_catG_tabs fc_br_right">
			<li class="cc_catG_tab active">
				<div class="cc_dropzone fc_br_all">
					{translate('Drag &amp; drop')}<span>{translate('your images here or click to upload')}.</span>
				</div>
			</li>
			<li class="cc_catG_tab">
				<form action="{$CAT_URL}/modules/cc_catgallery/save.php" method="post" class="ajaxForm">
					<input type="hidden" name="page_id" value="{$page_id}" />
					<input type="hidden" name="section_id" value="{$section_id}" />
					<input type="hidden" name="gallery_id" value="{$gallery_id}" />
					<input type="hidden" name="action" value="saveOptions" />
					<input type="hidden" name="_cat_ajax" value="1" />
					<input type="hidden" name="options" value="effect,animSpeed,pauseTime,random,label" />
					<input type="hidden" name="image_options" value="alt" />
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
				</form>
			</li>
			<li class="cc_catG_tab">
				<form action="{$CAT_URL}/modules/cc_catgallery/save.php" method="post" class="ajaxForm">
					<input type="hidden" name="page_id" value="{$page_id}" />
					<input type="hidden" name="section_id" value="{$section_id}" />
					<input type="hidden" name="gallery_id" value="{$gallery_id}" />
					<input type="hidden" name="action" value="saveOptions" />
					<input type="hidden" name="_cat_ajax" value="1" />
					<input type="hidden" name="options" value="resize_x,resize_y" />
					<p class="cc_catG_dreispalten">
						<span class="cc_In200px">{translate('Adjust horizontal')}:</span>
						<input type="text" class="cc_In100px" name="resize_x" value="{if $options.resize_x}{$options.resize_x}{else}724{/if}" /> px<br/>
						<span class="cc_In200px">{translate('Adjust vertical')}:</span>
						<input type="text" class="cc_In100px" name="resize_y" value="{if $options.resize_x}{$options.resize_y}{else}407{/if}" /> px<br/>
					</p>
					<input type="submit" name="speichern" value="{translate('Save')}" />
				</form>
			</li>
		</ul>
		<div class="clear"></div>
	</div>
	<p class="catG_IMG_y">{translate('Existing images')}</p>
	<p class="catG_IMG_n">{translate('No images available')}</p>
	<ul class="cc_catG_imgs">
		{$counter = 0}
		{foreach $images as image}
		<li class="fc_border_all fc_shadow_small fc_br_all" id="catG_{$image.image_id}">
			<div class="catG_IMG_options">
				<p class="drag_corner icon-resize" title="{translate('Reorder image')}"></p>
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
				<input type="hidden" name="action" value="saveIMG" />
				<input type="hidden" name="imgID" value="{$image.image_id}" />
				<input type="hidden" name="image_options" value="alt" />
				<input type="hidden" name="_cat_ajax" value="1" />
				<div class="cc_catG_left">
					<p class="cc_catG_image">
						<img src="{$image.thumb}" ><br>
					</p>
					<p>
						<strong>{translate('Name of image')}:</strong> {$image.picture}
					</p>
					<p>
						<strong>{translate('Alternative text')}:<br></strong>
						<input type="text" name="alt" value="{if $image.options.alt}{$image.options.alt}{/if}" >
					</p>
				</div>
				<button class="toggleWYSIWYG input_50p fc_br_bottomleft fc_gradient1 fc_gradient_hover">{translate('Modify description')}</button>
				<input type="submit" class="input_50p fc_br_bottomright" value="{translate('Save image')}">
			</form>
			<div class="clear"></div>
		{$counter = $counter + 1}
		</li>
		{/foreach}
		<li class="dz-preview dz-image-preview fc_border_all fc_shadow_small fc_br_all prevTemp" id="catG_">
			<div class="catG_IMG_options">
				<p class="drag_corner icon-resize" title="{translate('Reorder image')}"></p>
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
				<input type="hidden" name="imgID" value="" />
				<input type="hidden" name="action" value="saveIMG" />
				<input type="hidden" name="image_options" value="alt" />
				<input type="hidden" name="_cat_ajax" value="1" />
				<div class="cc_catG_left dz-details">
					<p class="cc_catG_image">
						<img data-dz-thumbnail="" src="" width="auto" height="120" ><br>
					</p>
					<p class="dz-filename">
						<strong>{translate('Name of image')}: </strong><span data-dz-name=""></span>
					</p>
					<p class="cc_catG_disabled">
						<strong>{translate('Alternative text')}:<br></strong>
						<input type="text" name="alt" value="" disabled>
					</p>
				</div>
				<button class="toggleWYSIWYG input_50p fc_br_bottomleft fc_gradient1 fc_gradient_hover">{translate('Modify description')}</button>
				<input type="submit" class="input_50p fc_br_bottomright" value="{translate('Save image')}">
			</form>
			<div class="clear"></div>
			<div class="dz-progress fc_br_top"><span class="dz-upload fc_br_all" data-dz-uploadprogress=""></span></div>
			{*<div class="dz-success-mark"><span>✔</span></div>
			<div class="dz-error-mark"><span>✘</span></div>*}
			<div class="dz-error-message"><span data-dz-errormessage=""></span></div>
			{*<a class="dz-remove" href="javascript:undefined;" data-dz-remove="">Remove</a>*}
		</li>
	</ul>
</div>

<form action="{$CAT_URL}/modules/cc_catgallery/save.php" method="post" class="catG_WYSIWYG fc_br_all fc_gradient2 fc_shadow_big">
	<input type="hidden" name="page_id" value="{$page_id}" />
	<input type="hidden" name="section_id" value="{$section_id}" />
	<input type="hidden" name="gallery_id" value="{$gallery_id}" />
	<input type="hidden" name="imgID" value="" />
	<input type="hidden" name="action" value="saveContent" />
	<input type="hidden" name="_cat_ajax" value="1" />
	{show_wysiwyg_editor($catG_WYSIWYG,$catG_WYSIWYG,'','100%','150px')}
	<p>
		<br>
		<input type="submit" value="{translate('Save & Close')}" class="left">
		<input type="reset" value="{translate('Close without saving')}" class="right">
	</p>
</form>