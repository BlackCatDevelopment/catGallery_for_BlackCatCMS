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
<section class="cG_slogan">
	{foreach $images index image}{if $image.published}<article style="background:url({$imgURL}/{$image.picture});">
		<div>
			{$image.image_content}
		</div>
	</article>{/if}{/foreach}
</section>