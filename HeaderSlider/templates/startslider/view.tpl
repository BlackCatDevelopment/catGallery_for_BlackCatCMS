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

<div class="startslider" id="header_slider_{$header_slider_id}" style="height: {$resize_y}px;">
	<ul>
		{foreach $images as image}
		<li style="background-image: url('{$tmp_url}/{$image.picture}'); height: {$resize_y}px;">
			<div class="header_slider_shadow" style="{*margin-left: -{$resize_x/2}px; *}width: {$resize_x}px; height: {$resize_y}px;"></div>
			<div class="header_slider_overlay" style="margin-top: -{$resize_y}px; height: {$resize_y}px;">
				<div class="label_text" style="height: {$resize_y}px;">
					{$image.image_content}
				</div>
			</div>
		</li>
		{/foreach}
	</ul>
</div>