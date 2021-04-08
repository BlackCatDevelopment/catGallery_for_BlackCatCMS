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
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}
{if $countImg}
<section id="columnGrid_{$gallery_id}" class="columnGrid c_960">
	<div>{$options.wysiwygContent}</div>{$title=""}
	{foreach $branchen branche}{foreach $branche image}{if $image.published}
		<figure>
			<figcaption>
                {if $title!=$image.options.title}{$title=$image.options.title}<h5>{$title}</h5>{/if}
			    <img src="{$imgURL}{$image.picture}" {*src="{$image.thumb}" data-src="{$imgURL}{$image.picture}" class="b-lazy"*} alt="{$image.options.alt}{if $image.options.urheber} - ({$image.options.urheber}){/if}">
			    <div>
			    	<p>{if $image.options.alt}<strong>{$image.options.alt}</strong><br>{/if}</p>
			    	{if $image.image_content}<h6>Studiengänge:</h6>
                    {$image.image_content}{/if}
			    	
			    </div>
            </figcaption>    
		</figure>
	{/if}{/foreach}{/foreach}
</section>
{else}{include('../default/view_no_image.tpl')}{/if}