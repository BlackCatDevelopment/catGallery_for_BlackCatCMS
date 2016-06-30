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
	var animSpeed	= {if $options.animSpeed}{$options.animSpeed}{else}700{/if};
</script>
<div id="cat_gallery_{$section_id}">
	<div class="wide_gallery_container" {if $options.winWidth}style="width: {$options.winWidth}px;"{/if}>
		<ul class="wide_gallery" style="width: {$countImg*$options.resize_x}px;">
			{foreach $images as image}{if $image.published}
			<li>
				<a href="{$folder_url}/{$image.picture}" class="fancybox">
					<span class="fancy_overlay"></span>
					<span class="icon-search"></span>
					<img src="{$imgURL}{$image.picture}" width="{$options.resize_x}" />
				</a>
			</li>
			{/if}{/foreach}
		</ul>
		<div class="clear"></div>
	</div>
	<nav class="wide_gallery_nav">
		<ul>
		</ul>
		<div class="clear"></div>
	</nav>
</div>