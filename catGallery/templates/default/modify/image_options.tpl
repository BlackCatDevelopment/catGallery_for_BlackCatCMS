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

<div class="catG_IMG_options">
	<p class="drag_corner icon-resize" title="{translate('Reorder image')}"></p>
	<p class="cG_icon-feed cG_publish{if $image.published} active{/if}" title="{translate('Publish this image')}"></p>
	<div class="cc_catG_del">
		<span class="icon-remove" title="{translate('Delete this image')}"></span>
		<p class="fc_br_right fc_shadow_small">
			<span class="cc_catG_del_res">{translate('Keep this image')}!</span>
			<strong> | </strong>
			<span class="cc_catG_del_conf">{translate('Confirm delete')}</span>
		</p>
	</div>
	{*<p class="icon-eye"></p>
	<p class="icon-scissors"></p>*}
</div>