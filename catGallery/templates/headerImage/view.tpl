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
{*<script type="text/javascript">
	var animSpeed	= {if $options.animSpeed}{$options.animSpeed}{else}700{/if};
</script>*}

<section id="cG_hIMG_{$section_id}" class="cG_hIMG{if $options.darkmode} cG_hIMGdarkMode{/if}">
	{foreach $images image}{if $image.published}<figure style="height:calc( 6em + {$options.resize_y}px);background-image:url({$imgURL}{$image.picture});">
		<figcaption>
			<p class="c_960">{if $image.options.subTitle}{$image.options.subTitle}{else}Ernst-Penzoldt-Mittelschule{/if}</p>
			<h1 class="c_960">{if $image.options.Title}{$image.options.Title}{else}{$MENU_TITLE}{/if}</h1>
		</figcaption>
		<img src="{$imgURL}{$image.picture}" width="{$options.resize_x}" alt="{$image.options.alt}">
	</figure>{/if}{/foreach}
</section>