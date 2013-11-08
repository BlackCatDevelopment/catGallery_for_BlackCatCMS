{**
 * This file is part of an ADDON for use with Black Cat CMS Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module			cc_header_slider
 * @version			see info.php of this module
 * @author			Matthias Glienke, creativecat
 * @copyright		2013, Black Cat Development
 * @link			http://blackcat-cms.org
 * @license			http://www.gnu.org/licenses/gpl.html
 *
 *}

<form action="{$CAT_URL}/modules/cc_header_slider/save.php" method="post" class="cc_header_slider_form" enctype="multipart/form-data">
	<div class="cc_header_slider_header fc_gradient4">
		{translate('Administration for HeaderSlider')}
		<input type="hidden" name="page_id" value="{$page_id}" />
		<input type="hidden" name="section_id" value="{$section_id}" />
		<input type="hidden" name="header_slider_id" value="{$header_slider_id}" />
	</div>
	<div class="cc_header_slider_option fc_gradient1">
		{translate('Options for frontend')}
		<div class="cc_header_slider_show"></div>
	</div>
	<div class="cc_header_slider_option_content">
		<p>
			{translate('Skin')}:
			<select name="variant">
			{foreach $module_variants index variants}
				<option value="{$index}"{if $index == $variant} selected="selected"{/if}>{$variants}</option>
			{/foreach}
			</select>
		</p>
		<p class="cc_header_slider_dreispalten">{translate('Kind of animation')}:<br/>
			<select name="effect">
				<option value="0"{if !$effect} selected="selected"{/if}>{translate('No effect selected...')}</option>
				{foreach $easing_options as option}
				<option value="{$option}"{if $effect == $option} selected="selected"{/if}>{$option}</option>
				{/foreach}
			</select>
		</p>
		<p class="cc_header_slider_dreispalten">
			{translate('Time until animation')}:
			<input type="text" name="pauseTime" value="{if $pauseTime}{$pauseTime}{else}8000{/if}" /> ms
		</p>
		<p class="cc_header_slider_dreispalten">
			{translate('Time for animation')}:
			<input type="text" name="animSpeed" value="{if $animSpeed}{$animSpeed}{else}3000{/if}" /> ms
		</p>
		<p class="cc_header_slider_dreispalten clear">
			<input id="random_{$header_slider_id}" class="fc_checkbox_jq" type="checkbox" name="random" value="1" {if $random}checked="checked" {/if}/>
			<label for="random_{$header_slider_id}">{translate('Show images by chance')}:</label>
		</p>
		<div class="div_submit fc_gradient1">
			<input type="submit" name="speichern" value="{translate('Upload/ Save')}" />
		</div>
	</div>
	<div class="cc_header_slider_option fc_gradient1">
		{translate('Image option')}:
		<div class="cc_header_slider_show"></div>
	</div>
	<div class="cc_header_slider_option_content">
		<p class="cc_header_slider_dreispalten">{translate('Adjust horizontal')}:<br/>
			<input type="text" name="resize_x" value="{if $resize_x}{$resize_x}{else}724{/if}" /> px<br/>
			{translate('Adjust vertical')}:<br/>
			<input type="text" name="resize_y" value="{if $resize_x}{$resize_y}{else}407{/if}" /> px<br/>
		</p>
		<div class="div_submit fc_gradient1">
			<input type="submit" name="speichern" value="{translate('Upload/ Save')}" />
		</div>
	</div>
	<div class="cc_header_slider_option fc_gradient1 active">
		{translate('Upload new image')}:
		<div class="cc_header_slider_show"></div>
	</div>
	<div class="cc_header_slider_option_content show_on_startup">
		<p>
			<input type="hidden" name="upload_counter" value="1" />
			<input type="file" size="32" class="new_image" name="new_image_1" /><br/>
			<span class="small">{translate('Please notice, that loadingtime increases on more images')}</span>
		</p>
		<div class="div_submit fc_gradient1">
			<input type="submit" name="speichern" value="{translate('Upload/ Save')}" />
			<button class="upload fc_gradient1 fc_gradient_hover">{translate('Add another upload')}</button>
			<input type="reset" value="{translate('Cancel')}" onclick="javascript: window.location = '{$CAT_ADMIN_URL}/pages/modify.php?page_id={$page_id}';" />
		</div>
	</div>
	{if $images}
	<div class="cc_header_slider_option">
		{translate('Current images')}
		<div class="cc_header_slider_show"></div>
	</div>
	<div class="cc_header_slider_option_content">
		{$counter = 0}
		{foreach $images as image}
		<div class="cc_header_slider_dreispalten">
			<p>
				{translate('Name of image')}: {$image.picture}<br/>
				<input type="hidden" name="image_id[]" value="{$image.image_id}" />
				<input type="hidden" name="picture_{$image.image_id}" value="{$image.picture}" /><br/>
				<input type="checkbox" class="fc_checkbox_jq" name="delete_{$image.image_id}" value="{$image.picture}" id="cc_header_slider_{$image.image_id}" /><label for="cc_header_slider_{$image.image_id}">{translate('Delete this image during the next save')}</label><br/>
				{translate('Alternative text')}:
				<input type="text" name="alt_{$image.image_id}" value="{$image.alt}" />
			</p>
		</div>
		<p class="cc_header_slider_dreispalten">
			<img src="{$folder_url}/{$image.picture}" class="cc_preview" width="auto" height="140" />
		</p>
		<div class="clear"></div>
		<p>
			{translate('Description for Image')}:
		</p>
		{show_wysiwyg_editor($image.contentname,$image.contentname,$image.image_content,'100%','300px')}
		<div class="clear linie"></div>
		{$counter = $counter + 1}
		{/foreach}
	</div>
	<div class="div_submit fc_gradient1">
		<input type="submit" name="speichern" value="{translate('Upload/ Save')}" />
		<input type="reset" value="{translate('Cancel')}" onclick="javascript: window.location = '{$CAT_ADMIN_URL}/pages/modify.php?page_id={$page_id}';" />
	</div>
	{else}<h3>{translate('No images available')}</h3>{/if}
</form>