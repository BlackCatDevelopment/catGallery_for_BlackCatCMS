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

if (defined('CAT_PATH')) {	
	if (defined('CAT_VERSION')) include(CAT_PATH.'/framework/class.secure.php');
} elseif (file_exists($_SERVER['DOCUMENT_ROOT'].'/framework/class.secure.php')) {
	include($_SERVER['DOCUMENT_ROOT'].'/framework/class.secure.php');
} else {
	$subs = explode('/', dirname($_SERVER['SCRIPT_NAME']));	$dir = $_SERVER['DOCUMENT_ROOT'];
	$inc = false;
	foreach ($subs as $sub) {
		if (empty($sub)) continue; $dir .= '/'.$sub;
		if (file_exists($dir.'/framework/class.secure.php')) {
			include($dir.'/framework/class.secure.php'); $inc = true;	break;
	}
	}
	if (!$inc) trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
}

if ( CAT_Helper_Page::getPagePermission( $page_id, 'admin' ) !== true )
{
	$backend->print_error( 'You do not have permissions to modify this page!' );
}

// ============================= 
// ! Get the current gallery_id 
// ============================= 
if ( $gallery_id = $val->sanitizePost( 'gallery_id','numeric' ) )
{

	$options		= $val->sanitizePost('options');
	$image_options	= $val->sanitizePost('image_options');
	$image_ids		= array_map('intval', $val->sanitizePost( 'image_ids','array') );
	$deleted		= false;

	if ( $options != '' )
	{
		foreach( array_filter( explode(',', $options) ) as $option )
		{
			if( !$catGallery->saveOptions( $option, $val->sanitizePost( $option ) )) $error = true;
		}
	}

	if ( $image_options != '' )
	{
		foreach( array_filter( explode(',', $image_options) ) as $option )
		{
			foreach( $image_ids as $img_id )
				if( !$catGallery->saveImgOptions( $img_id, $option, $val->sanitizePost( $option . '_' . $img_id ) ) ) $error = true;
		}
	}


	// =========================== 
	// ! save content of columns   
	// =========================== 
	foreach( $image_ids as $img_id )
	{
		if ( $val->sanitizePost( 'delete_' . $img_id ) )
		{
			$deleted	= $catGallery->removeImage( $img_id );
		}
		else {
			$contentname	= sprintf( "content_%s_%s", $section_id, $img_id );
			$content		= $val->sanitizePost( $contentname, false, true );
			$catGallery->saveContent( $img_id, $content );
		}
	}


	// Upload images and save to database
	if ( isset( $_FILES['new_image_1']['name'] ) && $_FILES['new_image_1']['name'] != '' )
	{
		$catGallery->saveImages(
			$val->sanitizePost( 'upload_counter', 'numeric' ),
			$_FILES
		);
	}
	$update_when_modified = true;
	CAT_Backend::getInstance()->updateWhenModified();
	$backend->print_success('Seite erfolgreich gespeichert', CAT_ADMIN_URL . '/pages/modify.php?page_id=' . $page_id);
} else {
	$backend->print_error('Es wurde keine gültige ID übermittelt.', CAT_ADMIN_URL . '/pages/modify.php?page_id=' . $page_id);
}



?>