{**
 * This file is part of an ADDON for use with Black Cat CMS Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module			cc_cat_gallery
 * @version			see info.php of this module
 * @author			Matthias Glienke, creativecat
 * @copyright		2013, Black Cat Development
 * @link			http://blackcat-cms.org
 * @license			http://www.gnu.org/licenses/gpl.html
 *
 *}

<section class="cG_mit" style="background-color:{$options.color}">
	<h2>{$options.title}</h2>
	<div class="c_1000">
		{foreach $images image}<article>
			<img src="{$imgURL}{$image.picture}" alt="{$image.options.mitarbeiter}"><br>
			{if $image.options.mitarbeiter}<h5>{$image.options.mitarbeiter}</h5>{/if}
			{if $image.options.unternehmen}<p>{$image.options.unternehmen}</p>{/if}
			{if $image.options.aufgabe}<p><strong>{$image.options.aufgabe}</strong></p>{/if}
			{if $image.options.url}<a class="button external{if $image.options.icon} {$image.options.icon}{/if}" href="{$image.options.url}">Website besuchen</a>{/if}
		</article>{/foreach}
	</div>
</section>