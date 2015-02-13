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
if (typeof ceckIMG !== 'function')
{
	function ceckIMG( $ul )
	{
		var	$par	= $ul.closest('div'),
			$yes	= $par.children('.catG_IMG_y'),
			$no		= $par.children('.catG_IMG_n'),
			size	= $ul.children('li').not('.prevTemp').size();
		if( size == 0 )
		{
			$yes.hide();
			$no.show();
			
		} else {
			$yes.show();
			$no.hide();
		}
	}
}


$(document).ready(function()
{
	if (typeof catGalIDs !== 'undefined' && typeof catGalLoaded === 'undefined')
	{
		// This is a workaround if backend.js is loaded twice
		catGalLoaded	= true;
		$.each( catGalIDs, function( index, cGID )
		{
			var $catGal		= $('#cc_catG_' + cGID.gallery_id),
				$imgUL		= $catGal.children('#cc_catG_imgs_'  + cGID.gallery_id),
				$prevTemp	= $('.prevTemp_' + cGID.gallery_id).clone().removeClass('prevTemp')[0].outerHTML,
				$WYSIWYG	= $('#catG_WYSIWYG_' + cGID.gallery_id),
				$catNav		= $('#cc_catG_nav_' + cGID.gallery_id);
		
			$('#cc_dropzone_' + cGID.gallery_id).dropzone(
			{
				url:				CAT_URL + '/modules/cc_catgallery/save.php',
				paramName:			'new_image',
				thumbnailWidth:		300,
				thumbnailHeight:	200,
				sending:			function(file, xhr, formData)
				{
					formData.append('page_id', cGID.page_id);
					formData.append('section_id', cGID.section_id);
					formData.append('gallery_id', cGID.gallery_id);
					formData.append('action', 'uploadIMG');
					formData.append('_cat_ajax', 1);
				},
				previewsContainer:	'#cc_catG_imgs_' + cGID.gallery_id,
				previewTemplate:	$prevTemp,
				success:			function(file, xhr, formData)
				{
					var $newIMG	= $(file.previewElement),
						xhr		= JSON.parse(xhr),
						newID	= $newIMG.attr('id') + xhr.newIMG.image_id;
			
					$imgUL.sortable( "refresh" );

					$newIMG.find('.dz-progress').remove();
					$newIMG.find('.dz-filename span').text(xhr.newIMG.picture);
					$newIMG.find('input[name=imgID]').val(xhr.newIMG.image_id);
					$newIMG.find('.cc_catG_image img').attr('src',xhr.newIMG.thumb);
					$newIMG.find('input, button, textarea').prop('disabled',false);
					$newIMG.find('.cc_catG_disabled').removeClass('cc_catG_disabled');

					/*$newIMG.html(function(index,html){
						return html.replace(/__section_id__/g,xhr.newIMG.section_id);
					});
					$newIMG.html(function(index,html){
						return html.replace(/__gallery_id__/g,xhr.newIMG.image_id);
					});*/
					$newIMG.html(function(index,html){
						return html.replace(/__image_id__/g,xhr.newIMG.image_id);
					});

					dialog_form( $newIMG.find('.ajaxForm') );
			
					ceckIMG( $imgUL );
				}
			});
		
			ceckIMG( $imgUL );
		
			$catGal.find('.cc_toggle_set').next('form').hide();
			$catGal.find('.cc_toggle_set, .cc_catG_skin input:reset').unbind().click(function()
			{
				$(this).closest('.cc_catG_skin').children('form').slideToggle(200);
			});
		
			/**/
			$imgUL.on( 'click',
				'.icon-remove',
			function()
			{
				$(this).closest('div').children('p').slideToggle(100);
			});
		
			$imgUL.on( 'click',
				'.cc_catG_del_conf',
			function()
			{
				var	$cur		= $(this),
					$li			= $cur.closest('li'),
					$inputs		= $li.find('input'),
					ajaxData	= {
						page_id		: cGID.page_id,
						section_id	: cGID.section_id,
						gallery_id	: cGID.gallery_id,
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
								ceckIMG( $imgUL );
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
		
			$imgUL.on( 'click',
				'.cc_catG_del_res',
			function()
			{
				$(this).closest('div').children('p').slideUp(100);
			});
			
			$imgUL.on( 'click',
				'.toggleWYSIWYG',
			function(e)
			{
				e.preventDefault();
			
				var $par		= $(this).closest('li');
			
				$WYSIWYG.hide();
			
				if ( $par.hasClass('cc_catG_WYSIWYG') )
				{
					$par.removeClass('cc_catG_WYSIWYG fc_gradient1');
				} else {
					$imgUL.children('li').removeClass('cc_catG_WYSIWYG fc_gradient1');
			
					var	pos			= $par.position(),
						widthImg	= $par.find('.cc_catG_left').outerWidth()
						widthLi		= $par.outerWidth(),
						widthWY		= $WYSIWYG.outerWidth(),
						heightLi	= $par.outerHeight(),
						posLeft		= ( pos.left - ( widthLi / 2 ) ) < 0 ? 0 : ( pos.left - ( widthLi / 2 ) ),
						ajaxData	= {
							page_id		: cGID.page_id,
							section_id	: cGID.section_id,
							gallery_id	: cGID.gallery_id,
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
			
			$WYSIWYG.on( 'click',
				'input:reset',
			function(e)
			{
				e.preventDefault();
				$imgUL.children('li').removeClass('cc_catG_WYSIWYG fc_gradient1');
				$WYSIWYG.hide();
			});
		
			dialog_form(
				$WYSIWYG,
				false,
				function()
				{
					$imgUL.children('li').removeClass('cc_catG_WYSIWYG fc_gradient1');
					$WYSIWYG.hide();
				},
				'JSON',
				function( $form, options )
				{
					var	catGal		='wysiwyg_' + cGID.section_id;
					CKEDITOR.instances[catGal].updateElement();
				}
			);
		
			$imgUL.sortable(
			{
				handle:			'.drag_corner',
				update:			function(event, ui)
				{
					var current			= $(this),
						ajaxData			= {
							'positions':		current.sortable('toArray'),
							'section_id':		cGID.section_id,
							'page_id':			cGID.page_id,
							'gallery_id': 		cGID.gallery_id,
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
	
			$catNav.children('li').click( function()
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
	}
});