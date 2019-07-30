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
	if (typeof cG_logo === 'undefined')
	\{
		cG_logo	= [];
	}
	cG_logo.push(
	\{
		'section_id'	: {$section_id},
		'cG_id'			: {$gallery_id}
	});
</script>
<section id="cG_logo_{$gallery_id}" class="cG_logo">
	<div class="cG_logo_wrap">{foreach $images index image}{if $image.published}<img src="{$imgURL}/{$image.picture}" alt="{$image.options.alt}"{if $image.options.title} title="{$image.options.title}"{/if}>{/if}{/foreach}</div>
	<span class="cG_logo_sh_l"></span><span class="cG_logo_sh_r"></span>
</section>