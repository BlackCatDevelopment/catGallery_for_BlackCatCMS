{**
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
	if (typeof cG_eG === 'undefined')
	\{
		cG_eG	= [];
	}
	cG_eG.push(
	\{
		'section_id'	: {$section_id},
		'cG_id'			: {$gallery_id}
	});
</script>

<section id="cG_eG_{$gallery_id}" class="cG_eG"><figure><div>{foreach $images index image}{if $image.published}<img src="{$imgURL}{$image.picture}" {*src="{$image.thumb}" data-src="{$imgURL}{$image.picture}" class="b-lazy"*} alt="{$image.options.alt}">{/if}{/foreach}</div><figcaption>{$options.wysiwygContent}</figcaption><button class="cG_eG-prev inactive"></button><button class="cG_eG-next{if count($images)>1} active{else} inactive{/if}"></button><button class="cG_eG-cancel"></button><button class="cG_eG-zoom-in"></button></figure></section>
{else}{include('../default/view_no_image.tpl')}{/if}