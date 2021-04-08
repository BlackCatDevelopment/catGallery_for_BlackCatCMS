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
 *   @author			Matthias Glienke, letima
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}
{if $countImg}
<section id="cG_roundImage_{$section_id}" class="cG_roundImage{if $options.960grid} c_1024{/if}">
	{foreach $images image}{if $image.published}
	<article class="cG_rI cG_rI_{if $image.options.side}{$image.options.side}{else}right{/if}">
<img src="{$imgURL}{$image.picture}" width="{$options.resize_x}" height="{$options.resize_y}" alt="{$image.options.alt}">
		{if $image.image_content != ''}<div class="cG_rI_cont">{$image.image_content}</div>{/if}
	</article>
	{/if}{/foreach}
</section>
{else}{include('../default/view_no_image.tpl')}{/if}