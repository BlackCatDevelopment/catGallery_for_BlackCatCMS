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

<section class="cG_startNav c_960"{if $options.color} style="background-color:{$options.color}"{/if}>
	{foreach $images image}<article>
		{if $image.options.urlPage}<h2 class="icon-arrow-right">{$image.options.urlTitle}</h2>
		<a href="{cmsplink($image.options.urlPage)}">{if $image.options.urlSubTitle}{$image.options.urlSubTitle}{else}mehr erfahren...{/if}</a>{/if}
		<img src="{$imgURL}{$image.picture}" alt="{$image.options.urlTitle}"></article>{/foreach}
</section>