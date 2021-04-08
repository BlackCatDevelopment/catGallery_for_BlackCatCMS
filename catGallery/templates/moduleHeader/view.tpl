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

{if $countImg}
<section id="cG_mH_{$section_id}" class="cG_mH{if $options.darkmode} cG_mHdarkMode{/if}">
	{foreach $images image}{if $image.published}<figure style="background-image:url({$imgURL}{$image.picture});">
		<figcaption>
			<h1>{$options.moduleName}</h1>
			{$image.image_content}
		</figcaption>
		<img src="{$imgURL}{$image.picture}" width="{$options.resize_x}" alt="{$image.options.alt}">
	</figure>{/if}{/foreach}
	{if $options.moduleName && $options.plattform}<aside class="cG_mH_Info">
		<div>
			<h3>{if $options.icon}<img src="{cat_url}/media/moduleHeader/{$options.icon}" alt="{$options.moduleName}" width="32" height="32" > {else}<span class="icon-module"></span>{/if}{$options.moduleName}</h3>
			<p>{$options.einsatz}</p>
			<dl>
				<dt>Version</dt><dd>Ab BlackCat CMS v{$options.plattform}</dd>
				<dt>Hauptautor</dt><dd>{$options.main_author}</dd>
				<dt>Unterstützung</dt><dd>{if $options.offiziell}Offizielles{else}Kompatibles{/if} Add On</dd>
				<dt>Kosten</dt><dd>{$options.kosten}</dd>
			</dl>
		</div>
	</aside>{/if}
</section>
{else}{include('../default/view_no_image.tpl')}{/if}