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
 *   @copyright			2019, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}


<form action="{$CAT_URL}/modules/cc_catgallery/save.php" method="post" class="ajaxForm">
	<input type="hidden" name="page_id" value="{$page_id}" />
	<input type="hidden" name="section_id" value="{$section_id}" />
	<input type="hidden" name="gallery_id" value="{$gallery_id}" />
	<input type="hidden" name="action" value="saveOptions" />
	<input type="hidden" name="_cat_ajax" value="1" />
	<input type="hidden" name="options" value="resize_y,zoom,park,water,r_hway_fill,r_hway_stroke,r_a_fill,r_a_stroke,r_l,man_made,la_natural,lon,lat,rail,address" />
	<p class="cc_In300px">
		<strong>Latitude</strong>
		<input id="lat_{$section_id}" type="text" name="lat" value="{if $options.lat}{$options.lat}{/if}">
	</p>
	<p class="cc_In300px">
		<strong>Longitude</strong>
		<input id="lon_{$section_id}" type="text" name="lon" value="{if $options.lon}{$options.lon}{/if}">
	</p>
	<p class="cc_In300px">
		<strong>Adresse:</strong>
		<input id="address_{$section_id}" type="text" name="address" value="{if $options.address}{$options.address}{/if}">
	</p><br>
	<p class="cc_In300px">
		<strong>Höhe der Karte</strong>
		<input id="resize_y_{$section_id}" type="text" name="resize_y" value="{if $options.resize_y}{$options.resize_y}{/if}">
	</p>
	<p class="cc_In300px">
		<strong>Zoom:<br></strong>
		<input type="text" name="zoom" value="{if $options.zoom}{$options.zoom}{/if}">
	</p><br>
	<p class="cc_In300px">
		<strong>Autobahn Füllung:<br></strong>
		<input type="text" name="r_hway_fill" value="{if $options.r_hway_fill}{$options.r_hway_fill}{/if}">
	</p>
	<p class="cc_In300px">
		<strong>Autobahn Linie:<br></strong>
		<input type="text" name="r_hway_stroke" value="{if $options.r_hway_stroke}{$options.r_hway_stroke}{/if}">
	</p>
	<p class="cc_In300px">
		<strong>Hauptverkehrsstraße Füllung:<br></strong>
		<input type="text" name="r_a_fill" value="{if $options.r_a_fill}{$options.r_a_fill}{/if}">
	</p>
	<p class="cc_In300px">
		<strong>Hauptverkehrsstraße Linie:<br></strong>
		<input type="text" name="r_a_stroke" value="{if $options.r_a_stroke}{$options.r_a_stroke}{/if}">
	</p>
	<p class="cc_In300px">
		<strong>Straße lokal:<br></strong>
		<input type="text" name="r_l" value="{if $options.r_l}{$options.r_l}{/if}">
	</p>
	<p class="cc_In300px">
		<strong>Gleise:<br></strong>
		<input type="text" name="rail" value="{if $options.rail}{$options.rail}{/if}">
	</p><br>
	<p class="cc_In300px">
		<strong>Parks:<br></strong>
		<input type="text" name="park" value="{if $options.park}{$options.park}{/if}">
	</p>
	<p class="cc_In300px">
		<strong>Natur:<br></strong>
		<input type="text" name="la_natural" value="{if $options.la_natural}{$options.la_natural}{/if}">
	</p>
	<p class="cc_In300px">
		<strong>Wasser:<br></strong>
		<input type="text" name="water" value="{if $options.water}{$options.water}{/if}">
	</p>
	<p class="cc_In300px">
		<strong>Vom Menschen geschaffene Strukturen:<br></strong>
		<input type="text" name="man_made" value="{if $options.man_made}{$options.man_made}{/if}">
	</p><br>
	<input type="submit" name="speichern" value="{translate('Save')}" />
</form>