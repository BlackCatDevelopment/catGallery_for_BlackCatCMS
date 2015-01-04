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

	$('.cc_toggle_set').next('form').hide();


	/**/
	$('.cc_catG_imgs').on( 'click',
		'.fc_close',
	function()
	{
			$(this).closest('p').children('.cc_catG_del_conf, .cc_catG_del_res, .cc_catG_del strong').slideToggle(100);
	});

	$('.cc_catG_imgs').on( 'click',
		'.cc_catG_del_conf',
	function()
	{
		var	$cur		= $(this),
			$li			= $cur.closest('li'),
			$inputs		= $li.children('input'),
			ajaxData	= {
				page_id		: $inputs.filter('input[name=page_id]').val(),
				section_id	: $inputs.filter('input[name=section_id]').val(),
				gallery_id	: $inputs.filter('input[name=gallery_id]').val(),
				imgID		: $inputs.filter('input[name=imgID]').val(),
				action		: 'removeIMG',
				_cat_ajax	: 1
			};

			$.ajax(
			{
				type:		'POST',
				context:	$li,
				url:		CAT_URL + '/modules/cc_catgallery/save.php',
				dataType:	'JSON',
				data:		ajaxData,
				cache:		false,
				beforeSend:	function( data )
				{
					// Set activity and store in a variable to use it later
					data.process	= set_activity( 'Deleting image' );
				},
				success:	function( data, textStatus, jqXHR )
				{
					if ( data.success === true )
					{
						$(this).slideUp(300,function(){
							$(this).remove();
						});
						return_success( jqXHR.process , data.message );
					}
					else {
						// return error
						return_error( jqXHR.process , data.message );
					}
				},
				error:		function( data, textStatus, jqXHR )
				{
					return_error( jqXHR.process , data.message );
				}
			});

	});
	$('.cc_catG_imgs').on( 'click',
		'.cc_catG_del_res',
	function()
	{
		$(this).closest('p').children('.cc_catG_del_conf, .cc_catG_del_res, .cc_catG_del strong').slideUp(100);
	});

	$('.cc_catG_imgs').on( 'click',
		'.toggleWYSIWYG',
	function(e)
	{
		e.preventDefault();

		var $par		= $(this).closest('li'),
			$WYSIWYG	= $(".catG_WYSIWYG");

		if ( $par.hasClass('cc_catG_WYSIWYG') )
		{
			$par.removeClass('cc_catG_WYSIWYG').css({height: 'auto'});
			$WYSIWYG.hide();
			$('.catG_over').hide();
		} else {
			$('.cc_catG_imgs').children('li').removeClass('cc_catG_WYSIWYG').css({height: 'auto'});

			var	pos			= $par.position(),
				widthImg	= $par.find('.cc_catG_left').outerWidth()
				widthLi		= $par.outerWidth(),
				widthWin	= $('#fc_main_content').innerWidth();
				heightLi	= $par.outerHeight(),
				heightWin	= $('#fc_main_content').outerHeight();
				ajaxData	= {
					section_id	: $par.find('input[name=section_id]').val(),
					page_id		: $par.find('input[name=page_id]').val(),
					gallery_id	: $par.find('input[name=gallery_id]').val(),
					imgID		: $par.find('input[name=imgID]').val(),
					action		: 'getContent',
					_cat_ajax	: 1
				};

			$WYSIWYG.css({
			    top:	( heightLi ) + "px",
			    right:	( widthLi/ 2 ) + "px",
			}).fadeIn(400);
			/*$('.catG_over').fadeIn(400);*/
			$par.addClass('cc_catG_WYSIWYG');
			$.ajax(
			{
				type:		'POST',
				context:	$par,
				url:		CAT_URL + '/modules/cc_catgallery/save.php',
				dataType:	'JSON',
				data:		ajaxData,
				cache:		false,
				beforeSend:	function( data )
				{
					// Set activity and store in a variable to use it later
					data.process	= set_activity( 'Loading content' );
				},
				success:	function( data, textStatus, jqXHR )
				{
					if ( data.success === true )
					{
						console.log(data.content);
						CKEDITOR.instances['wysiwyg_' + ajaxData.section_id].setData( data.content );
						return_success( jqXHR.process , data.message );
					}
					else {
						// return error
						return_error( jqXHR.process , data.message );
					}
				},
				error:		function( data, textStatus, jqXHR )
				{
					return_error( jqXHR.process , data.message );
				}
			});

			$par.css({height: ( $WYSIWYG.outerHeight() ) + 'px' });
		}
	});



	$('.cc_toggle_set, .cc_catG_skin input:reset').unbind().click(function()
	{
		$(this).closest('.cc_catG_skin').children('form').slideToggle(200);
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