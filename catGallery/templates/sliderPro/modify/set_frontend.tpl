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
	<input type="hidden" name="page_id" value="{$page_id}">
	<input type="hidden" name="section_id" value="{$section_id}">
	<input type="hidden" name="gallery_id" value="{$gallery_id}">
	<input type="hidden" name="action" value="saveOptions">
	<input type="hidden" name="_cat_ajax" value="1">
	<input type="hidden" name="options" value="arrows,buttons,autoplay,fadeArrows,centerSelectedSlide,rightToLeft">
	
	<strong>{translate('Plugin for BC 1.3. (Slider-Pro by bqworks)')}<br><br></strong>
	<p class="cc_In200px">
		<input id="arrows_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="arrows" value="1" {if $options.arrows}checked="checked" {/if}/>
		<label for="arrows_{$section_id}">{translate('Arrows')}:</label>
	</p><br>
	<p class="cc_In200px">
		<input id="buttons_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="buttons" value="1" {if $options.buttons}checked="checked" {/if}/>
		<label for="buttons_{$section_id}">{translate('Show button')}:</label>
	</p><br>
	<p class="cc_In200px">
		<input id="autoplay_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="autoplay" value="1" {if $options.autoplay}checked="checked" {/if}/>
		<label for="autoplay_{$section_id}">{translate('Autoplay')}:</label>
	</p><br>
	<p class="cc_In200px">
		<input id="fadeArrows_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="fadeArrows" value="1" {if $options.fadeArrows}checked="checked" {/if}/>
		<label for="fadeArrows_{$section_id}">{translate('fadeArrows')}:</label>
	</p><br>
	<p class="cc_In200px">
		<input id="centerSelectedSlide_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="centerSelectedSlide" value="1" {if $options.centerSelectedSlide}checked="checked" {/if}/>
		<label for="centerSelectedSlide_{$section_id}">{translate('centerSelectedSlide')}:</label>
	</p><br>
	<p class="cc_In200px">
		<input id="rightToLeft_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="rightToLeft" value="1" {if $options.rightToLeft}checked="checked" {/if}/>
		<label for="rightToLeft_{$section_id}">{translate('rightToLeft')}:</label>
	</p><br>
	<input type="submit" name="speichern" value="{translate('Save')}">
</form>
