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
{if !$ajax}
<script type="text/javascript">
	if (typeof catGalMapIDs === 'undefined')
	\{
		catGalMapIDs	= [];
	}
	catGalMapIDs.push(
	\{
		'page_id'		: {$page_id},
		'section_id'	: {$section_id},
		'gallery_id'	: {$gallery_id},
		'resize_y'		: {$options.resize_y},
		'options'		: \{
			'lat'			: {if $options.lat}{$options.lat}{/if},
			'lon'			: {if $options.lon}{$options.lon}{/if},
			'zoom'			: {if $options.zoom}{$options.zoom}{else}6{/if},
			{if $options.water}'water'			: '{$options.water}',{/if}
			'park'			: '{if $options.park}{$options.park}{/if}',
			'r_hway_fill'	: '{if $options.r_hway_fill}{$options.r_hway_fill}{/if}',
			'r_hway_stroke'	: '{if $options.r_hway_stroke}{$options.r_hway_stroke}{/if}',
			'r_a_fill'		: '{if $options.r_a_fill}{$options.r_a_fill}{/if}',
			'r_a_stroke'	: '{if $options.r_a_stroke}{$options.r_a_stroke}{/if}',
			'r_l'			: '{if $options.r_l}{$options.r_l}{/if}',
			'man_made'		: '{if $options.man_made}{$options.man_made}{/if}',
			'la_natural'	: '{if $options.la_natural}{$options.la_natural}{/if}',
			'rail'			: '{if $options.rail}{$options.rail}{/if}'
		}
	});
</script>
{/if}
{if $section_name != 'no name'}<div id="{$section_name}">{/if}{foreach $images as image}{if $image.published}<div id="map_{$section_id}" class="paraScroll" style="height: {$options.resize_y}px;background:url({$image.original}) center center;"><a href="https://maps.apple.com/?{if $options.address}q={$options.address}{else}ll={$options.lat},{$options.lon}{/if}&z={$options.zoom}" class="mapsLink"></a></div>{/if}{/foreach}{if $section_name != 'no name'}</div>{/if}