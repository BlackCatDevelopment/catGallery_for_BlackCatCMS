{**
 * This file is part of an ADDON for use with Black Cat CMS Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module			cc_header_slider
 * @version			see info.php of this module
 * @author			Matthias Glienke, creativecat
 * @copyright		2013, Black Cat Development
 * @link			http://blackcat-cms.org
 * @license			http://www.gnu.org/licenses/gpl.html
 *
 *}

<script type="text/javascript">
	$(document).ready( function()
	\{
		$("#slider_skitter_{$header_slider_id}").skitter(
		\{
			{if $effect}animation:		"{$effect}",{/if}
			interval:		{if $pauseTime}{$pauseTime}{else}4000{/if},
			stop_over:		false,
			navigation:		false,
			numbers:		false,
			width_label:	"{$label}px"
		});
	});
</script>

<div class="slider_skitter" id="slider_skitter_{$header_slider_id}" style="width: {$resize_x}px; height: {$resize_y}px;">
	<ul>
		{foreach $images as image}
		<li>
			<a href="#"><img src="{$folder_url}/{$image.picture}" width="{$resize_x}" height="{$resize_y}" alt="{$image.alt}" /></a>
			{if $image.image_content}<div class="label_text">
				{$image.image_content}
			</div>{/if}
		</li>
		{/foreach}
	</ul>
</div>