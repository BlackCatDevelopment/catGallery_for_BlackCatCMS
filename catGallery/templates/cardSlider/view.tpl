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
 *   @copyright			2019, Black Cat Development
 *   @link				https://blackcat-cms.org
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
		'pauseTime'		: {if $options.pauseTime}{$options.pauseTime}{else}5000{/if}
	});
</script>
<section id="cG_cardS_{$section_id}" class="cG_cardSlider" style="height:{$options.resize_y}px;">
		{foreach $images image}{if $image.published}<img src="{$imgURL}{$image.picture}" width="{$options.resize_x}" height="{$options.resize_y}" alt="{$image.options.alt}" class="cG_r{rand(1,6)}">{/if}{/foreach}
</section>