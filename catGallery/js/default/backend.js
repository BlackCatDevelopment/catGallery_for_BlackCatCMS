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
		'.icon-remove',
	function()
	{
			$(this).closest('div').children('p').slideToggle(100);
	});

	$('.cc_catG_imgs').on( 'click',
		'.cc_catG_del_conf',
	function()
	{
		var	$cur		= $(this),
			$li			= $cur.closest('li'),
			$inputs		= $li.find('input'),
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
		$(this).closest('div').children('p').slideUp(100);
	});

	$('.cc_catG_imgs').on( 'click',
		'.toggleWYSIWYG',
	function(e)
	{
		e.preventDefault();

		var $par		= $(this).closest('li'),
			$WYSIWYG	= $(".catG_WYSIWYG").hide();

		if ( $par.hasClass('cc_catG_WYSIWYG') )
		{
			$par.removeClass('cc_catG_WYSIWYG fc_gradient1');
		} else {
			$('.cc_catG_imgs').children('li').removeClass('cc_catG_WYSIWYG fc_gradient1');

			var	pos			= $par.position(),
				widthImg	= $par.find('.cc_catG_left').outerWidth()
				widthLi		= $par.outerWidth(),
				widthWY		= $WYSIWYG.outerWidth(),
				heightLi	= $par.outerHeight(),
				posLeft		= ( pos.left - ( widthLi / 2 ) ) < 0 ? 0 : ( pos.left - ( widthLi / 2 ) ),
				ajaxData	= {
					section_id	: $par.find('input[name=section_id]').val(),
					page_id		: $par.find('input[name=page_id]').val(),
					gallery_id	: $par.find('input[name=gallery_id]').val(),
					imgID		: $par.find('input[name=imgID]').val(),
					action		: 'getContent',
					_cat_ajax	: 1
				};

			$WYSIWYG.css({
				top:	( pos.top + heightLi - 20 ) + "px"
			}).find('input[name=imgID]').val(ajaxData.imgID);

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
						$(this).addClass('fc_gradient1');
						$WYSIWYG.fadeIn(400);
						CKEDITOR.instances['wysiwyg_' + ajaxData.section_id].setData( data.image.image_content );
						CKEDITOR.instances['wysiwyg_' + ajaxData.section_id].updateElement();
						return_success( jqXHR.process , data.message );
					}
					else {
						$par.removeClass('cc_catG_WYSIWYG ');
						// return error
						return_error( jqXHR.process , data.message );
					}
				},
				error:		function( data, textStatus, jqXHR )
				{
					$par.removeClass('cc_catG_WYSIWYG ');
					return_error( jqXHR.process , data.message );
				}
			});
		}
	});

	$('.catG_WYSIWYG').on( 'click',
		'input:reset',
	function(e)
	{
		e.preventDefault();
		$('.cc_catG_imgs').children('li').removeClass('cc_catG_WYSIWYG fc_gradient1');
		$(".catG_WYSIWYG").hide();
	});



	dialog_form(
		$('.catG_WYSIWYG'),
		false,
		function()
		{
			$('.cc_catG_imgs').children('li').removeClass('cc_catG_WYSIWYG fc_gradient1');
			$(".catG_WYSIWYG").hide();
		},
		'JSON',
		function( $form, options )
		{
			var	section_id	= $form.find('input[name=section_id]').val(),
				catGal		='wysiwyg_' + section_id;

			CKEDITOR.instances[catGal].updateElement();
		}
	);




	$('.cc_catG_imgs').sortable(
	{
		handle:			'.drag_corner',
		update:			function(event, ui)
		{
			var current			= $(this),
				ajaxData			= {
					'positions':		current.sortable('toArray'),
					'section_id':		current.find('input[name=section_id]').val(),
					'page_id':			current.find('input[name=page_id]').val(),
					'gallery_id': 		current.find('input[name=gallery_id]').val(),
					'action':		 	'reorder',
					'_cat_ajax':		1
			};
			console.log(ajaxData);
			$.ajax(
			{
				type:		'POST',
				url:		CAT_URL + '/modules/cc_catgallery/save.php',
				dataType:	'json',
				data:		ajaxData,
				cache:		false,
				beforeSend:	function( data )
				{
					data.process	= set_activity( 'Sort entries' );
				},
				success:	function( data, textStatus, jqXHR	)
				{
					console.log(data);
					if ( data.success === true )
					{
						return_success( jqXHR.process, data.message );
					}
					else {
						return_error( jqXHR.process , data.message );
					}
				},
				error:		function(jqXHR, textStatus, errorThrown)
				{
					return_error( jqXHR.process , errorThrown.message);
				}
			});
		}
	});
	$( ".sortable" ).disableSelection();


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