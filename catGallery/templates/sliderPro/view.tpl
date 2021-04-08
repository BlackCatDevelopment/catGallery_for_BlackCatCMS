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
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}
{if $countImg}
<script >
	if (typeof sliderProIDs === 'undefined')
	\{
		sliderProIDs	= [];
	}
	sliderProIDs.push(
	\{
		'gallery_id'			: {$gallery_id},
		'resX'					: {$options.resize_x},
		'resY'					: {$options.resize_y},
		'arrows'				: {if $options.arrows}true{else}false{/if},
		'buttons'				: {if $options.buttons}true{else}false{/if},
		'autoplay'				: {if $options.autoplay}true{else}false{/if},
		'fadeArrows'			: {if $options.fadeArrows}true{else}false{/if},
		'centerSelectedSlide'	: {if $options.centerSelectedSlide}true{else}false{/if},
		'rightToLeft'			: {if $options.rightToLeft}true{else}false{/if}
	});
</script>

<div class="slider-pro" id="my-slider_{$gallery_id}">
	<div class="sp-slides">
		{foreach $images image}
		<div class="sp-slide">
			<img src="{$imgURL}{$image.picture}" class="sp-image" alt="{$image.options.alt}" />
			{if $image.options.caption != ''}<p class="sp-caption">{$image.options.caption}</p>{/if}
			{if $image.image_content != ''}<div class="sp-layer sp-{$image.options.layercolor} {$image.options.layerrounded} {$image.options.layerpadding}" data-position="{$image.options.layerposition}" data-width="{$image.options.layerwidth}" data-height="{$image.options.layerheight}" data-horizontal="{$image.options.layerhoffset}" data-vertical="{$image.options.layervoffset}">{$image.image_content}</div>{/if}
			{if $image.options.thumbnail != ''}<p class="sp-thumbnail">{$image.options.thumbnail}</p>{/if}
		</div>
		{/foreach}
	</div>
</div>
{else}{include('../default/view_no_image.tpl')}{/if}