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
{foreach $images index image}{if $image.published}<section class="parallax-window" data-position-y="{$options.positiony}" data-position-x="{$options.positionx}" data-parallax="scroll" data-image-src="{$imgURL}/{$image.picture}" style="height:{if $options.height}{$options.height}{else}200{/if}px;"><div></div></section>{/if}{/foreach}
{else}{include('../default/view_no_image.tpl')}{/if}