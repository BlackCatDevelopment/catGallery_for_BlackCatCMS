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
 *   @author			Matthias Glienke, letima development
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}
{if $countImg}
<section class="cG_Team">
	{if $options.title}<h2>{$options.title}</h2>{/if}
	{foreach $images i image}{if $image.published}
	<figure data-aos="fade-up" data-aos-delay="{$i*50}">
		<img src="{$imgURL}/{$image.picture}" alt="{$image.options.mitarbeiter}" class="cG_MAimg">
		<figcaption>
			<h3 class="title">{$image.options.mitarbeiter}</h3>
			<h4 class="position">{$image.options.mitarbeiter_title}</h4>
			{if $image.image_content}<div class="cG_mitInfo">
				{$image.image_content}
			</div>{/if}
			{if $image.options.telephone_int}<span class="teamTel"><a href="tel:{$image.options.telephone_int}" class="ics-mobile"> {$image.options.telephone}</a></span>{/if}
			{if $image.options.email}<span class="teamMail">{hide_email($image.options.email,'ics-envelop')}</span>{/if}
		</figcaption>
	</figure>
	{/if}{/foreach}
	{*<img class="cG_t1" src="{cat_url}/templates/ics/css/default/images/triangle.svg" >*}
</section>
{else}{include('../default/view_no_image.tpl')}{/if}