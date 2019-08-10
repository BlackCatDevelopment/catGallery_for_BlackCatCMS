{**
 * This file is part of an ADDON for use with Black Cat CMS Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module			cc_cat_gallery
 * @version			see info.php of this module
 * @author			Matthias Glienke, creativecat
 * @copyright		2013, Black Cat Development
 * @link			https://blackcat-cms.org
 * @license			http://www.gnu.org/licenses/gpl.html
 *
 *}

{foreach $images index image}{if $image.published}<div class="parallax-window" data-position-y="{$options.positiony}" data-position-x="{$options.positionx}" data-parallax="scroll" data-image-src="{$imgURL}/{$image.picture}" style="height:{$options.height}px;"></div>{*<div class="parallax-window" data-parallax="scroll" data-image-src="{$imgURL}/{$image.picture}" data-z-index="5" style="height:{$options.resize_y}"></div>*}{/if}{/foreach}