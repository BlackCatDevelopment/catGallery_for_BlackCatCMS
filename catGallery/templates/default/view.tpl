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
{if $countImg}
<script >
	if (typeof cG_def === 'undefined')
	\{
		cG_def	= [];
	}
	cG_def.push(
	\{
		'section_id'	: {$section_id},
		'cG_id'			: {$gallery_id},
		{if $options.effect}animation:		"{$options.effect}",{/if}
		interval:		{if $pauseTime}{$pauseTime}{else}4000{/if},
		velocity:		{if $options.velocity}"{$options.velocity}"{else}"1.0"{/if},
		stop_over:		{if $options.stop_over}true{else}false{/if},
		auto_play:		{if $options.auto_play}true{else}false{/if},
		navigation:		{if $options.navigation}true{else}false{/if},
		thumbs:			{if $options.thumbs}true{else}false{/if},
		progressbar:	{if $options.progressbar}true{else}false{/if},
		numbers:		{if $options.numbers}true{else}false{/if},
		controls:		{if $options.controls}true{else}false{/if},
		dots:			{if $options.dots}true{else}false{/if},
		focus:			{if $options.focus}true{else}false{/if},
		label:			{if $options.label}true{else}false{/if},
		preview:		{if $options.preview}true{else}false{/if}
	});

</script>

<div class="skitter" id="slider_skitter_{$gallery_id}">
	<ul>
		{foreach $images as image}{if $image.published}
		<li>
			<a href="#"><img src="{$imgURL}{$image.picture}" alt="{$image.options.alt}" /></a>
			{if $options.label && $image.image_content != ''}<div class="label_text">
				{$image.image_content}
			</div>{/if}
		</li>
		{/if}{/foreach}
	</ul>
</div>
{else}{include('view_no_image.tpl')}{/if}