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
{$count = 0}
<section class="cG_Team">
	{if $options.title}<h2>{$options.title}</h2>{/if}
	{foreach $images image}
	<figure>
		<img src="{$imgURL}/{$image.picture}" alt="{$image.options.mitarbeiter}">
		<figcaption>
			<h3 class="title">{$image.options.mitarbeiter}</h3>
			<h4 class="position">{$image.options.mitarbeiter_title}</h4>
			<div class="cG_mitInfo">
				{$image.image_content}
			</div>
			<span><a href="tel:{$image.options.telephone_int}" class="tel icon-phone"> {$image.options.telephone}</a></span><br>
			<span>{hide_email($image.options.email,'icon-envelop')}</span>
		</figcaption>
	</figure>
	{$count = $count+1}
	{/foreach}
</section>
{else}{include('../default/view_no_image.tpl')}{/if}