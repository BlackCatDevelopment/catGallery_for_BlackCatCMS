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
{if $count_img}
<script type="text/javascript">
	$(document).ready( function()
	\{
		$("#slider_skitter_{$section_id}").skitter(
		\{
			{if $effect}animation:		"{$effect}",{/if}
			interval:		{if $pauseTime}{$pauseTime}{else}4000{/if},
			stop_over:		false,
			navigation:		false,
			numbers:		false,
			width_label:	"902px"{*"{$label}px"*}
		});
	});
</script>
{/if}
<div class="slider_skitter" id="slider_skitter_{$section_id}" style="width: {$resize_x}px; height: {$resize_y}px;">
	<ul>
		{foreach $images as image}
		<li>
			<a href="#"><img src="{$tmp_url}/{$image.picture}" width="{$resize_x}" height="{$resize_y}" alt="{$image.alt}" /></a>
			{if $image.image_content}<div class="label_text">
				{$image.image_content}
			</div>{/if}
		</li>
		{/foreach}
	</ul>
</div>