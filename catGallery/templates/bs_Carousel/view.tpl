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
<div id="bscarousel_{$gallery_id}" class="container p-0">
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
	<div id="carousel" class="carousel slide {if $options.cfade}carousel-fade{/if}" data-ride="carousel">
<!-- Carousel content begin -->
		<div class="carousel-inner">
			{$firstitem = true}
			{foreach $images image}{if $image.published}
				<div class="carousel-item {if $firstitem}active{/if}">
					<img class="d-block w-100" src="{$imgURL}{$image.picture}" alt="{$image.options.alt}">
					<div class="carousel-caption d-none d-md-block">
						{if $options.ititle}<h4>{$image.options.title}</h4>{/if}
						{if $options.icontent}<p>{$image.image_content}</p>{/if}
					</div>
				</div>
			{$firstitem = false}
			{/if}{/foreach}
		</div>
<!-- Carousel indicators begin -->
		{if $options.cindicators}
			<ol class="carousel-indicators">
				{$slideto=0;}{foreach $images image}{if $image.published}
					<li data-target="#carousel" data-slide-to="{$slideto++}"></li>
				{/if}{/foreach}
			</ol>
		{/if}
<!-- Carousel buttons begin -->
		<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Zurück</span>
		</a>
		<a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Weiter</span>
		</a>
	</div>
</div>
{else}{include('../default/view_no_image.tpl')}{/if}