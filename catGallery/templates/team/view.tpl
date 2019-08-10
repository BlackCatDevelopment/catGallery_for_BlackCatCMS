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
{$count = 0}
<section class="cG_Team">
	{if $options.title}<h2>{$options.title}</h2>{/if}
	{foreach $images image}
	<figure>
		<img src="{$imgURL}/{$image.picture}" alt="{$image.options.mitarbeiter}">
		<figcaption>
			<h3 class="title">{$image.options.mitarbeiter}</h3>
			<h4 class="position">{$image.options.mitarbeiter_title}</h4>
			<div class="cG_mitInfo">
				{$image.image_content}
			</div>
			<span><a href="tel:{$image.options.telephone_int}" class="tel icon-phone"> {$image.options.telephone}</a></span><br>
			<span>{hide_email($image.options.email,'icon-envelop')}</span>
		</figcaption>
	</figure>
	{$count = $count+1}
	{/foreach}
</section>