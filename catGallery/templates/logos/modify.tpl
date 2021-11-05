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
 *   @author			Matthias Glienke, letima
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}

{include(../default/modify/javascript.tpl)}

<div class="cc_catG_form" id="cc_catG_{$gallery_id}">
	{include(../default/modify/set_skin.tpl)}
	<div class="clear"></div>
	<div class="cc_catG_settings">
		<ul class="cc_catG_nav fc_br_left" id="cc_catG_nav_{$gallery_id}">
			<li class="active fc_br_topleft">{translate('Upload new images')}</li>
			<li>{translate('Options for frontend')}</li>
			<li class="fc_br_bottomleft">{translate('Image option')}</li>
		</ul>
		<ul class="cc_catG_tabs fc_br_right">
			<li class="cc_catG_tab active">{include(../default/modify/set_dropzone.tpl)}</li>
			<li class="cc_catG_tab">{include(modify/set_frontend.tpl)}</li>
			<li class="cc_catG_tab">{include(../default/modify/set_image.tpl)}</li>
		</ul>
		<div class="clear"></div>
	</div>
	<p class="catG_IMG_y">{translate('Existing images')}</p>
	<p class="catG_IMG_n">{translate('No images available')}</p>
	<ul id="cc_catG_imgs_{$gallery_id}" class="cc_catG_imgs">
		{foreach $images as image}
		{include(modify/image.tpl)}
		{/foreach}
		{assign var=image value=NULL}
		{include(modify/image.tpl)}
	</ul>
</div>

{include(../default/modify/wysiwyg.tpl)}