{**
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
{if $countImg}
<script type="text/javascript">
	if (typeof cG_logo === 'undefined')
	\{
		cG_logo	= [];
	}
	cG_logo.push(
	\{
		'section_id'	: {$section_id},
		'cG_id'			: {$gallery_id}
	});
</script>
<section id="cG_logo_{$gallery_id}" class="cG_logo">
	<div class="cG_logo_wrap">{foreach $images index image}{if $image.published}<img src="{$imgURL}/{$image.picture}" alt="{$image.options.alt}"{if $image.options.title} title="{$image.options.title}"{/if}>{/if}{/foreach}</div>
	<span class="cG_logo_sh_l"></span><span class="cG_logo_sh_r"></span>
</section>
{else}{include('../default/view_no_image.tpl')}{/if}