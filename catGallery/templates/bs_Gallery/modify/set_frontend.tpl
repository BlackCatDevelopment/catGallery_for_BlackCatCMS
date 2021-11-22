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
 *   @author			Dirk Grebe
 *   @copyright			2021, Black Cat Development
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
	<input type="hidden" name="options" value="icount,iborder,zicon,ihover,stextalign,shead,sheadlevel,stextstyle,sdivider,sdcolor,sdicon,sleadtext" />

	<strong>{translate('Bootstrap 4 variant for BC 1.3.')}<br><br></strong>
	<p>
	<label for="icount_{$section_id}" class="cc_In200px">{translate('Picture Count hor.')}:</label>
    <select id="icount_{$section_id}" name="icount" class="cc_In100px">
		<option value="6"{if $options.icount && $options.icount == '6'} selected="selected"{/if}>{translate('2 Pictures')}</option>
		<option value="4"{if $options.icount && $options.icount == '4'} selected="selected"{/if}>{translate('3 Pictures')}</option>
		<option value="3"{if $options.icount && $options.icount == '3'} selected="selected"{/if}>{translate('4 Pictures')}</option>
	</select>
	</p>
	<p>
	<input id="iborder_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="iborder" value="1" {if $options.iborder != 0} checked="checked" {/if} />
	<label for="iborder_{$section_id}" class="cc_In300px">{translate('Image Border')}:</label>
	<br />	
	<input id="zicon_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="zicon" value="1"{if $options.zicon != 0} checked="checked" {/if} />
	<label for="zicon_{$section_id}" class="cc_In300px">{translate('Zoom In')}:</label>
	</p>
	<p>
	<label for="ihover_{$section_id}" class="cc_In200px">{translate('Hover Effects')}:</label>
    <select id="ihover_{$section_id}" name="ihover" class="cc_In100px">
		<option value=""{if $options.ihover && $options.ihover == ''} selected="selected"{/if}>{translate('None')}</option>
		<option value="box1"{if $options.ihover && $options.ihover == 'box1'} selected="selected"{/if}>{translate('Style 1')}</option>
		<option value="box2"{if $options.ihover && $options.ihover == 'box2'} selected="selected"{/if}>{translate('Style 2')}</option>
		<option value="box3"{if $options.ihover && $options.ihover == 'box3'} selected="selected"{/if}>{translate('Style 3')}</option>
		<option value="box4"{if $options.ihover && $options.ihover == 'box4'} selected="selected"{/if}>{translate('Style 4')}</option>
		<option value="box5"{if $options.ihover && $options.ihover == 'box5'} selected="selected"{/if}>{translate('Style 5')}</option>
		<option value="box6"{if $options.ihover && $options.ihover == 'box6'} selected="selected"{/if}>{translate('Style 6')}</option>
		<option value="box7"{if $options.ihover && $options.ihover == 'box7'} selected="selected"{/if}>{translate('Style 7')}</option>
		<option value="box8"{if $options.ihover && $options.ihover == 'box8'} selected="selected"{/if}>{translate('Style 8')}</option>
		<option value="box9"{if $options.ihover && $options.ihover == 'box9'} selected="selected"{/if}>{translate('Style 9')}</option>
		<option value="box10"{if $options.ihover && $options.ihover == 'box10'} selected="selected"{/if}>{translate('Style 10')}</option>
		<option value="box11"{if $options.ihover && $options.ihover == 'box11'} selected="selected"{/if}>{translate('Style 11')}</option>
		<option value="box12"{if $options.ihover && $options.ihover == 'box12'} selected="selected"{/if}>{translate('Style 12')}</option>
		<option value="box13"{if $options.ihover && $options.ihover == 'box13'} selected="selected"{/if}>{translate('Style 13')}</option>
		<option value="box14"{if $options.ihover && $options.ihover == 'box14'} selected="selected"{/if}>{translate('Style 14')}</option>
		<option value="box15"{if $options.ihover && $options.ihover == 'box15'} selected="selected"{/if}>{translate('Style 15')}</option>
		<option value="box16"{if $options.ihover && $options.ihover == 'box16'} selected="selected"{/if}>{translate('Style 16')}</option>
		<option value="box17"{if $options.ihover && $options.ihover == 'box17'} selected="selected"{/if}>{translate('Style 17')}</option>
		<option value="box18"{if $options.ihover && $options.ihover == 'box18'} selected="selected"{/if}>{translate('Style 18')}</option>
		<option value="box19"{if $options.ihover && $options.ihover == 'box19'} selected="selected"{/if}>{translate('Style 19')}</option>
<!-- 	<option value="box20"{if $options.ihover && $options.ihover == 'box20'} selected="selected"{/if}>{translate('Style 20')}</option> -->
		<option value="box21"{if $options.ihover && $options.ihover == 'box21'} selected="selected"{/if}>{translate('Style 21')}</option>
    </select>
	</p>
	<p>
	<label for="stextalign_{$section_id}" class="cc_In200px">{translate('Section Header Text Pos.')}:</label>
	<select id="stextalign_{$section_id}" name="stextalign" class="cc_In100px">
		<option value=""{if $options.stextalign && $options.stextalign == ''} selected="selected"{/if}>{translate('Default')}</option>
        <option value="text-center"{if $options.stextalign && $options.stextalign == 'text-center'} selected="selected"{/if}>{translate('Align Centered')}</option>
        <option value="text-right"{if $options.stextalign && $options.stextalign == 'text-right'} selected="selected"{/if}>{translate('Align Right')}</option>
    </select>
	</p>
	<p>
	<label for="shead_{$section_id}" class="cc_In200px">{translate('Section Headline')}:</label><br />
	<input id="shead_{$section_id}" type="text" class="cc_In300px" name="shead"  placeholder="{translate('Headline')}" value="{if $options.shead}{$options.shead}{/if}" />
	&nbsp;&nbsp;
	<label for="sheadlevel_{$section_id}" class="cc_In50px">{translate('Size')}:</label>
	<select id="sheadlevel_{$section_id}" name="sheadlevel">
		<option value="1"{if $options.sheadlevel && 1 == $options.sheadlevel} selected="selected"{/if}>Level 1</option>
		<option value="2"{if $options.sheadlevel && 2 == $options.sheadlevel} selected="selected"{/if}>Level 2</option>
		<option value="3"{if $options.sheadlevel && 3 == $options.sheadlevel} selected="selected"{/if}>Level 3</option>
		<option value="4"{if $options.sheadlevel && 4 == $options.sheadlevel} selected="selected"{/if}>Level 4</option>
	</select>
	&nbsp;&nbsp;
	<label for="stextstyle_{$section_id}" class="cc_In50px">{translate('Style')}:</label>
	<select id="stextstyle_{$section_id}" name="stextstyle">
		<option value=""{if $options.stextstyle && $options.stextstyle == ''} selected="selected"{/if}>{translate('Default')}</option>
		<option value="text-uppercase"{if $options.stextstyle && $options.stextstyle == 'text-uppercase'} selected="selected"{/if}>{translate('Uppercase')}</option>
    </select>
	</p>
	<p>
	<input id="sdivider_{$section_id}" class="fc_checkbox_jq" type="checkbox" name="sdivider" value="1"{if $options.sdivider != 0} checked="checked"{/if} /> <label for="sdivider_{$section_id}" class="cc_In300px">{translate('Divider')}:</label>
	</p>
	<p>
	<label for="sdicon_{$section_id}" class="cc_In200px">{translate('Divider Icon')}:</label>
	<input id="sdicon_{$section_id}" class="cc_In100px" type="text" name="sdicon" placeholder="{translate('star')}" value="{if $options.sdicon}{$options.sdicon}{/if}" />
	</p>
	<p>
	<label for="sdcolor_{$section_id}" class="cc_In200px">{translate('Divider Color')}:</label>
    <select id="sdcolor_{$section_id}" name="sdcolor" class="cc_In100px">
		<option value="white"{if $options.sdcolor && $options.sdcolor == 'white'} selected="selected"{/if}>{translate('White')}</option>
		<option value="primary"{if $options.sdcolor && $options.sdcolor == 'primary'} selected="selected"{/if}>{translate('Primary')}</option>
		<option value="secondary"{if $options.sdcolor && $options.sdcolor == 'secondary'} selected="selected"{/if}>{translate('Secondary')}</option>
		<option value="success"{if $options.sdcolor && $options.sdcolor == 'success'} selected="selected"{/if}>{translate('Success')}</option>
		<option value="danger"{if $options.sdcolor && $options.sdcolor == 'danger'} selected="selected"{/if}>{translate('Danger')}</option>
		<option value="warning"{if $options.sdcolor && $options.sdcolor == 'warning'} selected="selected"{/if}>{translate('Warning')}</option>
		<option value="info"{if $options.sdcolor && $options.sdcolor == 'info'} selected="selected"{/if}>{translate('Info')}</option>
		<option value="light"{if $options.sdcolor && $options.sdcolor == 'light'} selected="selected"{/if}>{translate('Light')}</option>
		<option value="dark"{if $options.sdcolor && $options.sdcolor == 'dark'} selected="selected"{/if}>{translate('Dark')}</option>
    </select>
	</p>
	<p>
    <label for="sleadtext_{$section_id}" class="cc_In200px">{translate('Section Lead Text')}:</label><br />
    <textarea id="sleadtext_{$section_id}" class="cc_In300px" name="sleadtext">{if $options.sleadtext}{$options.sleadtext}{/if}</textarea><br />
	</p>
	<input type="submit" name="speichern" value="{translate('Save')}" />
</form>