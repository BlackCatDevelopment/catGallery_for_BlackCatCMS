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
 *   @copyright			2014, Black Cat Development
 *   @link				http://blackcat-cms.org
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
if ( $gallery_id = $val->sanitizePost( 'gallery_id','numeric' ) )
{
	// ====================================== 
	// ! Upload images and save to database
	// ====================================== 
	if ( isset( $_FILES['new_image']['name'] ) && $_FILES['new_image']['name'] != '' )
	{

		$success	= $catGallery->saveImages(
			1,
			$_FILES
		);
		$ajax_return	= array(
			'message'	=> $backend->lang()->translate( 'Image upload successful!' ),
			'newIMG'	=> $success,
			'success'	=> is_array($success) ? true : false
		);
	} elseif ( $removeID = $val->sanitizePost( 'removeID','numeric' ) )
	{
		$deleted	= $catGallery->removeImage( $removeID );
		$ajax_return	= array(
			'message'	=> $deleted === true
				? $backend->lang()->translate( 'Image deleted successfully!' )
				: $backend->lang()->translate( 'An error occoured!' ),
			'success'	=> $deleted
		);
	} else {

		$options		= $val->sanitizePost('options');
		$image_options	= $val->sanitizePost('image_options');
		$image_ids		= is_array( $val->sanitizePost( 'image_ids','array') ) ?
							array_map('intval', $val->sanitizePost( 'image_ids','array') ) : NULL;
		$deleted		= false;
		
		// =========================== 
		// ! save variant of images   
		// =========================== 
		$catGallery->saveOptions( 'variant', $val->sanitizePost('variant') );
		
		
		// =========================== 
		// ! save options for gallery   
		// =========================== 
		if ( $options != '' )
		{
			foreach( array_filter( explode(',', $options) ) as $option )
			{
				if( !$catGallery->saveOptions( $option, $val->sanitizePost( $option ) )) $error = true;
			}
		}
		
		// =========================== 
		// ! save options for images   
		// =========================== 
		if ( $image_options != ''
			&& is_array($image_ids)
			&& count( $image_ids ) > 0
		) {
			foreach( array_filter( explode(',', $image_options) ) as $option )
			{
				foreach( $image_ids as $img_id )
					if( !$catGallery->saveImgOptions( $img_id, $option, $val->sanitizePost( $option . '_' . $img_id ) ) ) $error = true;
			}
		}

		$ajax_return	= array(
			'message'	=> $backend->lang()->translate( 'Options saved successfully!' ),
			'success'	=> true
		);
		
		// =========================== 
		// ! save content of images   
		// =========================== 
		if ( is_array($image_ids)
			&& count( $image_ids ) > 0
		) {
			foreach( $image_ids as $img_id )
			{
					$contentname	= sprintf( "image_content_%s", $img_id );
					if ( isset($_POST[$contentname]) )
					{
						$content		= $val->sanitizePost( $contentname, false, true );
						$catGallery->saveContent( $img_id, $content );
					}
			}
		}
	}
} else {
	$backend->print_error('Es wurde keine gültige ID übermittelt.', CAT_ADMIN_URL . '/pages/modify.php?page_id=' . $page_id);
}



?>