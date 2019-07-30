/**
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
 */

$(document).ready(function()
{
	if (typeof catGalIDs !== 'undefined' && typeof catGaleG === 'undefined')
	{
		// This is a workaround if backend.js is loaded twice
		catGaleG	= true;
		$.each( catGalIDs, function( index, cGID )
		{
			$WYSIWYG	= $('#catG_eG_WYSIWYG_'+cGID.gallery_id);
			dialog_form(
				$WYSIWYG,
				false,
				false,
				'JSON',
				function( $form, options )
				{
					var	catGal		='wysiwyg_' + cGID.section_id;
					CKEDITOR.instances[catGal].updateElement();
				}
			);
		});
	}
});