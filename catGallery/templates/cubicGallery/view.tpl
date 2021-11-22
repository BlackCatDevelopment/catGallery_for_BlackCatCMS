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
	if (typeof catGalcGalIDs === 'undefined')
	\{
		catGalcGalIDs	= [];
	}
	catGalcGalIDs.push(
	\{
		'gallery_id'	: {$gallery_id}
	});
</script>

<section id="cG_cGal_{$gallery_id}" class="cG_cGal{if $options.960grid} cG_960{/if}">
	{foreach $images image}{if $image.published}<figure>
		<img src="{$imgURL}/{$image.picture}" alt="{$image.options.alt}">
		<figcaption>
			<a class="cg_cGalOpen" href="{$image.original}" title="{$image.options.title}">+</a>
			<div>{if $image.options.title}<h3>{$image.options.title}</h3>{/if}
			{if $image.image_content}<div class="cG_cGal_ImageContent">{$image.image_content}</div>{/if}</div>
		</figcaption>
	</figure>{/if}{/foreach}
</section>
{else}{include('../default/view_no_image.tpl')}{/if}