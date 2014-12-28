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
	$('.cc_catgallery_option .cc_catgallery_show').unbind().click(function()
	{
		var current		= $(this).closest('.cc_catgallery_option');
		current.next('div.cc_catgallery_option_content').toggle(200);
		current.toggleClass('active');
	});

	$('.cc_toggle_set').next('div').hide();

	$('.cc_catG_del .fc_close').unbind().click(function()
	{
		$(this).closest('p').children('.cc_catG_del_conf, .cc_catG_del_res, .cc_catG_del strong').slideToggle(100);
	});

	$('.cc_catG_del_conf').unbind().click(function()
	{
		
	});
	$('.cc_catG_del_res').unbind().click(function()
	{
		$(this).closest('p').children('.cc_catG_del_conf, .cc_catG_del_res, .cc_catG_del strong').slideUp(100);
	});


	$('.toggleWYSIWYG').click(function(e)
	{
		e.preventDefault();
		$(this).closest('li').toggleClass('cc_catG_WYSIWYG');
	});






	$('.cc_toggle_set, .cc_catG_skin input:reset').unbind().click(function()
	{
		$(this).closest('.cc_catG_skin').children('div').slideToggle(200);
	});

	$('.cc_catG_nav').children('li').unbind().click( function()
	{
		var $curr	= $(this),
			cur_ind	= $curr.index(),
			$nav	= $curr.closest('ul'),
			$tabs	= $nav.next('ul'),
			$currT	= $tabs.children('li').eq(cur_ind);
		$nav.children('li').removeClass('active').filter($curr).addClass('active');
		$tabs.children('li').removeClass('active').filter($currT).addClass('active');
	});
});