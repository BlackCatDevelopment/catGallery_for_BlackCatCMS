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
 *   @copyright			2019, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}
{if $countImg}
<script type="text/javascript">if (typeof cGrec === 'undefined')\{cGrec= [];}cGrec.push(\{'section_id': {$section_id},'cG_id': {$gallery_id}});</script><section id="cG_rec_{$gallery_id}" class="cG_rec" style="background-image:url({cat_url}/media/{$options.image});"><h2>Empfehlungen</h2>{foreach $images index image}{if $image.published}<figure><img src="{$imgURL}/{$image.picture}" alt="{$image.options.alt}"><figcaption{if $options.color} style="color:#{$options.color}"{/if}><div class="comment">{$image.image_content}</div>{if $image.options.mitarbeiter}<p><span class="author">{$image.options.mitarbeiter}</span>{if $image.options.position}<span class="position">{$image.options.position}</span>{/if}</p>{/if}{if $image.options.firma}<p class="firma">{$image.options.firma}</p>{/if}</figcaption></figure>{/if}{/foreach}<button class="prev">&lt;</button><button class="next{if count($images)>1} active{/if}">&gt;</button></section>
{else}{include('../default/view_no_image.tpl')}{/if}