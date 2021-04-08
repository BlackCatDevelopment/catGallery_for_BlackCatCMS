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
 *   @author			Matthias Glienke, letima
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}

{if $countImg}<section id="logoGrid_{$gallery_id}" class="logoGrid">
	{if $options.wysiwygContent} <div class="c_1024">{$options.wysiwygContent}</div>{/if}
	<div class="logoGridContainer c_1024">
		{foreach $images image}{if $image.published}<figure>
			{if $image.options.href}<a href="{$image.options.href}" target="_blank">{/if}
			<img src="{$imgURL}{$image.picture}" alt="{$image.options.alt}" title="{$image.options.alt}">
			{if $image.options.href}</a>{/if}
			{if $image.image_content}<figcaption>{$image.image_content}</figcaption>{/if}
		</figure>{/if}{/foreach}
	</div>
</section>{/if}