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
{if $section_id != 194 || $is_root}
<script type="text/javascript">
	if (typeof cGrec === 'undefined')
	\{
		cGrec	= [];
	}
	cGrec.push(
	\{
		'section_id'	: {$section_id},
		'cG_id'			: {$gallery_id}
	});
</script>
<section id="cG_rec_{$gallery_id}" class="cG_rec" style="background-image:url({cat_url}/media/{$options.image});">
	<h2>Empfehlungen</h2>
	{foreach $images index image}{if $image.published}
	<figure>
		<img src="{$imgURL}/{$image.picture}" alt="{$image.options.alt}">
		<figcaption>
			<div class="comment">{$image.image_content}</div>
			{if $image.options.mitarbeiter}<p>
				<span class="author">{$image.options.mitarbeiter}</span>
				{if $image.options.position}<span class="position">{$image.options.position}</span>{/if}
			</p>{/if}
			{if $image.options.firma}<p class="firma">
				{$image.options.firma}
			</p>{/if}
		</figcaption>
	</figure>
	{/if}{/foreach}
	<button class="prev"><</button>
	<button class="next{if count($images)>1} active{/if}">></button>
</section>
{/if}