<?php
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

// include class.secure.php to protect this file and the whole CMS!
if (defined('CAT_PATH')) {	
	include(CAT_PATH.'/framework/class.secure.php'); 
} else {
	$oneback = "../";
	$root = $oneback;
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= $oneback;
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) {
		include($root.'/framework/class.secure.php'); 
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}
// end include class.secure.php

if ( CAT_Helper_Page::getPagePermission( $page_id, 'admin' ) !== true )
{
	$backend->print_error( 'You do not have permissions to modify this page!' );
}

// ============================= 
// ! Get the current gallery_id 
// ============================= 
if ( $val->sanitizePost( 'gallery_id','numeric' ) && is_object($catGallery) )
{
	$imgID	= $val->sanitizePost( 'imgID','numeric' );
	$action	= $val->sanitizePost( 'action' );
	// ====================================== 
	// ! Upload images and save to database
	// ====================================== 
	switch ( $action )
	{
		case 'uploadIMG':
			if ( isset( $_FILES['new_image']['name'] ) && $_FILES['new_image']['name'] != '' )
			{
				$success	= $catGallery->saveImages( $_FILES );

				$ajax_return	= array(
					'message'	=> $lang->translate( 'Image uploaded successfully!' ),
					'newIMG'	=> $success,
					'success'	=> is_array($success) ? true : false
				);
			} else {
				$ajax_return	= array(
					'message'	=> $lang->translate( 'No images to upload' ),
					'success'	=> false
				);
			}
			break;
		case 'removeIMG':
			$deleted	= $catGallery->removeImage( $imgID );
			$ajax_return	= array(
				'message'	=> $deleted === true
					? $lang->translate( 'Image deleted successfully!' )
					: $lang->translate( 'An error occoured!' ),
				'success'	=> $deleted
			);
			break;
		case 'getContent':
			$ajax_return	= array(
				'image'		=> $catGallery->getImage( $imgID ),
				'message'	=> $lang->translate( 'Content loaded' ),
				'success'	=> true
			);
			break;
		case 'saveContent':
				$catGallery->saveContent( $imgID, $val->sanitizePost('wysiwyg_' . $section_id, false, true  ) );
				$ajax_return	= array(
					'message'	=> $lang->translate( 'Content saved successfully' ),
					'success'	=> true
				);
				break;
		case 'saveIMG':
			$image_options	= $val->sanitizePost('image_options');
			// =========================== 
			// ! save options for images   
			// =========================== 
			if ( $image_options != '' )
			{
				foreach( array_filter( explode(',', $image_options) ) as $option )
				{
					if( !$catGallery->saveImgOptions( $imgID, $option, $val->sanitizePost( $option ) ) )
						$error = true;
				}
			}

			$ajax_return	= array(
				'message'	=> $lang->translate( 'Image saved successfully' ),
				'success'	=> true
			);
			break;
		case 'reorder':
			// =========================== 
			// ! save options for images   
			// =========================== 
			$success	= $catGallery->reorderImg( $val->sanitizePost('positions') );

			$ajax_return	= array(
				'message'	=> $success === true ?
						$lang->translate( 'Image reordered successfully' )
						: $lang->translate( 'Reorder failed' ),
				'success'	=> $success
			);
			break;
		case 'saveOptions':
			$options		= $val->sanitizePost('options');

			// =========================== 
			// ! save options for gallery   
			// =========================== 
			if ( $options != '' )
			{
				foreach( array_filter( explode(',', $options) ) as $option )
				{
					if( $option == 'wysiwygContent' )
						$catGallery->saveOptions( $option, $val->sanitizePost('wysiwygContent_' . $section_id, false, true) );
					elseif( !$catGallery->saveOptions( $option, $val->sanitizePost( $option ) ))
						$error = true;
				}
			}
			$ajax_return	= array(
				'message'	=> $lang->translate( 'Options saved successfully!' ),
				'success'	=> true
			);
			break;
		case 'publishIMG':
			// =========================== 
			// ! save options for gallery   
			// =========================== 
			$success		= $catGallery->publishImg( $imgID );
			$ajax_return	= array(
				'message'	=> $success	? $lang->translate( 'Image published successfully!' ) : $lang->translate( 'Image unpublished successfully!' ),
				'published'	=> $success,
				'success'	=> true
			);
			break;
		default:
			// =========================== 
			// ! save variant of images   
			// =========================== 
			$catGallery->saveOptions( 'variant', $val->sanitizePost('variant') );

			// =========================== 
			// ! save optional frontend options
			// =========================== 
			$catGallery->saveOptions( 'auto_play', '1' );

			$ajax_return	= array(
				'message'	=> $lang->translate( 'Variant saved successfully!' ),
				'success'	=> true
			);

			break;
	}
} else {
	$backend->print_error(
		$lang->translate( 'You sent an invalid ID' ),
		CAT_ADMIN_URL . '/pages/modify.php?page_id=' . $page_id
	);
}



?>