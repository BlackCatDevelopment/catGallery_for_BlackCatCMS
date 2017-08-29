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
	if (typeof sliderProIDs === 'undefined')
	\{
		sliderProIDs	= [];
	}
	sliderProIDs.push(
	\{
		'gallery_id'	: {$gallery_id},
		'resX'			: {$options.resize_x},
		'resY'			: {$options.resize_y},
		'arrows'		: {if $options.arrows}true{else}false{/if},
		'buttons'		: {if $options.buttons}true{else}false{/if},
		'autoplay'		: {if $options.autoplay}true{else}false{/if}
	});
</script>

<div class="slider-pro" id="my-slider_{$gallery_id}">
	<div class="sp-slides">
		{foreach $images image}{if $image.published}
		<div class="sp-slide">
			<img src="{$imgURL}{$image.picture}" class="sp-image" alt="{$image.options.alt}">
			{if $image.image_content != ''}<div class="sp-layer">{$image.image_content}</div>{/if}
		</div>
		{/if}{/foreach}
	</div>
</div>