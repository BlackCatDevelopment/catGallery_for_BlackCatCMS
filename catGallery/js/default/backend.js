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
 *   @copyright			2014, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 */

$(document).ready(function()
{
	$('.cc_cat_gallery_option_content').not('.show_on_startup').hide(0);
	$('.cc_cat_gallery_option .cc_cat_gallery_show').unbind().click(function()
	{
		var current		= $(this).closest('.cc_cat_gallery_option');
		current.next('div.cc_cat_gallery_option_content').toggle(200);
		current.toggleClass('active');
	});

	$('.upload').unbind().click( function(e)
	{
		e.preventDefault();
		var field	= $(this).closest('.cc_cat_gallery_option_content').find('input[name=upload_counter]'),
			counter	= parseInt( field.val() ) + 1;
		field.val( counter )
		$('.new_image:last').after('<br/><input type="file" size="32" class="new_image" name="new_image_' + counter + '" />');
	});
});