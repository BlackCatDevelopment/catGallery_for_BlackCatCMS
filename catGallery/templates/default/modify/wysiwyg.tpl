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
 *   @author			Matthias Glienke, letima
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}

<form action="{$CAT_URL}/modules/catGallery/save.php" method="post" class="catG_WYSIWYG fc_br_all fc_gradient2 fc_shadow_big" id="catG_WYSIWYG_{$gallery_id}">
	<input type="hidden" name="page_id" value="{$page_id}" />
	<input type="hidden" name="section_id" value="{$section_id}" />
	<input type="hidden" name="gallery_id" value="{$gallery_id}" />
	<input type="hidden" name="imgID" value="" />
	<input type="hidden" name="action" value="saveContent" />
	<input type="hidden" name="_cat_ajax" value="1" />
	{show_wysiwyg_editor($catG_WYSIWYG,$catG_WYSIWYG,'','100%','150px')}
	<p>
		<br>
		<input type="submit" value="{translate('Save & Close')}" class="left">
		<input type="reset" value="{translate('Close without saving')}" class="right">
	</p>
</form>