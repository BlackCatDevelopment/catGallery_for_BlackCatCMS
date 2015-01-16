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
<script type="text/javascript">
	if (typeof cardSlider === 'undefined')
	\{
		cardSlider	= [];
	}
	cardSlider.push(
	\{
		'section_id'	: {$section_id},
		'animSpeed'		: {if $animSpeed}{$animSpeed}{else}500{/if},
		'pauseTime'		: {if $pauseTime}{$pauseTime}{else}4000{/if}
	});
</script>
<div class="header_slider">
	<div class="band"><div class="schleife"></div></div>
	<div id="header_slider_images_{$section_id}" class="header_slider_images">
		{foreach $images image}
		<img src="{$imgURL}{$image.picture}" width="{$options.resize_x}" height="{$options.resize_y}" alt="{$image.options.alt}">
		{/foreach}
	</div>
</div>