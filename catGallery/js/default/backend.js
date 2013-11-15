/**
 * This file is part of an ADDON for use with Black Cat CMS Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module			cc_cat_gallery
 * @version			see info.php of this module
 * @author			Matthias Glienke, creativecat
 * @copyright		2013, Black Cat Development
 * @link			http://blackcat-cms.org
 * @license			http://www.gnu.org/licenses/gpl.html
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