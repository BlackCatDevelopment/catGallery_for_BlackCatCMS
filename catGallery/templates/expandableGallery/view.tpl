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
<script type="text/javascript">
	if (typeof cG_eG === 'undefined')
	\{
		cG_eG	= [];
	}
	cG_eG.push(
	\{
		'section_id'	: {$section_id},
		'cG_id'			: {$gallery_id}
	});
</script>

<section id="cG_eG_{$gallery_id}" class="cG_eG"><figure><div>{foreach $images index image}{if $image.published}<img src="{$image.thumb}" data-src="{$imgURL}{$image.picture}" class="b-lazy" alt="{$image.options.alt}">{/if}{/foreach}</div><figcaption>{$options.wysiwygContent}</figcaption><button class="cG_eG-prev inactive"></button><button class="cG_eG-next{if count($images)>1} active{else} inactive{/if}"></button><button class="cG_eG-cancel"></button><button class="cG_eG-zoom-in"></button></figure></section>