{**
 *
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
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}

<script>
	if (typeof cG_headerVideo === 'undefined')
	\{ cG_headerVideo	= []; }
	cG_headerVideo.push(
	\{ 'cG_id': {$gallery_id} });
</script>
{foreach $images image}{if $image.published}
<section id="cG_headerVideo_{$gallery_id}" class="cG_headerVideo{if $image.options.fullheight} cG_fullHeight{/if}{if $image.options.darkVideo} cG_darkVideo{/if}">
	<div class="c_1024">{if $image.options.title}{if $image.options.isH1}<h1>{else}<h2>{/if}{$image.options.title}{if $image.options.isH1}</h1>{else}</h2>{/if}{/if}
	{if $image.image_content != ''}{$image.image_content}{/if}</div>
	<video id="videoTest{$image.image_id}" preload="metadata" muted autoplay playsInline loop="" poster="{$image.original}" style="background-image: url({$image.original}); top: 0; background-position: center top; background-repeat: no-repeat no-repeat;">

		<source src="{cat_url}/media/videos/{$image.options.video}.mp4" type="video/mp4">
		<source src="{cat_url}/media/videos/{$image.options.video}.webm" type="video/webm">
		<source src="{cat_url}/media/videos/{$image.options.video}.ogv" type="video/ogg">
		<source src="{cat_url}/media/videos/{$image.options.video}-mobile.mp4" type="video/mp4" media="(max-width:512px)">
		<source src="{cat_url}/media/videos/{$image.options.video}-mobile.webm" type="video/webm" media="(max-width:512px)">
		<source src="{cat_url}/media/videos/{$image.options.video}-mobile.ogv" type="video/ogg" media="(max-width:512px)">
		<object data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" height="1340" width="1920" type="application/x-shockwave-flash">
			<param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
			<param name="allowFullScreen" value="false">
			<param name="wmode" value="transparent">{$url="/media/videos/{$image.options.video}.mp4"}
			<param name="flashVars" value="config=\{'playlist':['{urlencode($url)}',\{'url':'{urlencode($url)}','autoPlay':true}]}">
			<img alt="{$image.options.alt}" height="1340" src="{$image.original}" title="Dieser Browser unterstützt keinerlei Videos.">
			<p>Dieser Browser unterstützt HTML5 Video nicht. Sie können es jedoch herunterladen: <a href="{cat_url}/media/videos/{$image.options.video}.mp4">Download</a></p>
		</object>
	</video>
	{if $image.options.showButton}<span></span>{/if}
</section>{/if}{/foreach}