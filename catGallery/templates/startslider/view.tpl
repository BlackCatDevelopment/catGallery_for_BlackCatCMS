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

<div class="startslider" id="cat_gallery_{$section_id}" style="height: {$resize_y}px;">
	<ul>
		{foreach $images as image}
		<li style="background-image: url('{$tmp_url}/{$image.picture}'); height: {$resize_y}px;">
			<div class="cat_gallery_shadow" style="{*margin-left: -{$resize_x/2}px; *}width: {$resize_x}px; height: {$resize_y}px;"></div>
			<div class="cat_gallery_overlay" style="margin-top: -{$resize_y}px; height: {$resize_y}px;">
				<div class="label_text" style="height: {$resize_y}px;">
					{$image.image_content}
				</div>
			</div>
		</li>
		{/foreach}
	</ul>
</div>