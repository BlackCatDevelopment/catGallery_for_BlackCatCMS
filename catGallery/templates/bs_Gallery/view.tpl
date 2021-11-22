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
 *   @author			Dirk Grebe
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}
 
{if $countImg}
<div id="bsgallery_{$gallery_id}" class="container-fluid p-0">
<!-- Section header begin -->
	<div class="container py-4">
		{if $options.shead || $options.sleadtext}
		<div class="row my-4">
			<div class="col-md-12 heading {$options.stextalign}">
				{if $options.shead}<h1 class="display-{$options.sheadlevel} {$options.stextstyle}">{$options.shead}</h1>{/if}
				{if $options.sdivider}
				<div class="divider-custom my-2">
					<div class="divider-line bg-{$options.sdcolor}"></div>
					{if $options.sdicon}<div class="divider-icon text-{$options.sdcolor}"><i style="vertical-align: 0.75rem;" class="bi-{$options.sdicon}"></i></div>
					<div class="divider-line bg-{$options.sdcolor}"></div>{/if}
				</div>
				{/if}
				{if $options.sleadtext}<p class="lead">{$options.sleadtext}</p>{/if}
			</div>
		</div>{/if}
	</div>
	<div class="row no-gutters">
<!-- Gallery content begin -->
	{foreach $images image}{if $image.published}
		<figure class="col-lg-{$options.icount} col-sm-{$options.icount}">
			{if $options.ihover!=''}<div class="{$options.ihover}">{/if}
				<img class="img-fluid {if $options.iborder}img-thumbnail{/if}" src="{$imgURL}/{$image.picture}" alt="{$image.options.alt}">
				{if $options.ihover!=''}
					{if $options.ihover=='box1'}{include(modify/style1.tpl)}
					{elseif $options.ihover=='box2'}{include(modify/style2.tpl)}
					{elseif $options.ihover=='box3'}{include(modify/style3.tpl)}
					{elseif ($options.ihover=='box4')||($options.ihover=='box6')||($options.ihover=='box7')||($options.ihover=='box11')||($options.ihover=='box13') ||($options.ihover=='box14')||($options.ihover=='box16')||($options.ihover=='box18')}{include(modify/style4.tpl)}
					{elseif ($options.ihover=='box5') || ($options.ihover=='box17')}{include(modify/style5.tpl)}
					{elseif $options.ihover=='box8'}{include(modify/style6.tpl)}
					{elseif ($options.ihover=='box9') || ($options.ihover=='box10') || ($options.ihover=='box12') || ($options.ihover=='box15')}{include(modify/style7.tpl)}
					{elseif $options.ihover=='box19'}{include(modify/style8.tpl)}
					{else $options.ihover=='box21'}{include(modify/style10.tpl)}{/if}
				{/if}
            {if $options.ihover!=''}</div>{/if}
			{include(modify/bs_modal.tpl)}
		</figure>
	{/if}{/foreach}
	</div>
</div>
{else}{include('../default/view_no_image.tpl')}{/if}