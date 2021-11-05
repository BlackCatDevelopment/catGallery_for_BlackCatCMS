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
<section class="cG_cV" id="cG_cV_{$section_id}">
	{foreach $images image}{if $image.published}<figure>
		<div>{if $image.options.urlPage}<a href="{cmsplink($image.options.urlPage)}">{/if}<img src="{$imgURL}{$image.picture}" alt="{$image.options.alt}">{if $image.options.urlPage}</a>{/if}</div>
		<figcaption>{if $image.options.title}<h3>{$image.options.title}</h3>{/if}{if $image.options.subtitle}<strong>&bull; {$image.options.subtitle} &bull;</strong>{/if}{if $image.image_content}<div>{$image.image_content}</div>{/if}</figcaption>
		{if $image.options.urlPage}<a class="button" href="{cmsplink($image.options.urlPage)}">{$image.options.linkTitle}</a>{/if}
	</figure>{/if}{/foreach}
</section>
{else}{include('../default/view_no_image.tpl')}{/if}